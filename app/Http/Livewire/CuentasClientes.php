<?php

namespace App\Http\Livewire;
use Livewire\WithPagination;
use App\Models\Customer;
use App\Models\Pago;
use App\Models\Pedido;
//use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;


class CuentasClientes extends Component
{

    use WithPagination;
    use WithFileUploads;
    public $action = 'Listado', $componentName = 'CUENTAS POR COBRAR', $search = '', $searchCustomer;
    private $pagination =10;
    protected $paginationTheme = 'tailwind';
    public  $pendientes = [];
    public $customer, $customer_id, $totalPendientes, $fpago ='efectivo', $dtransferencia;








    public function render()
    {

        if(strlen($this->search) > 0)
            $pedidos = Pedido::join('customers as c', 'c.id', '=', 'pedidos.customer_id')
            ->select('c.id as id_cliente', 'c.businame as cliente', 'c.phone as telefono', 'c.email as mail', DB::raw("sum(pedidos.total) as total_sum"))
            ->whereNull('pedidos.fechapago')
            ->where('c.businame','like',"%{$this->search}%")
            ->groupBy('c.id', 'c.businame', 'c.phone', 'c.email')
            ->paginate($this->pagination);
        else
        $pedidos = Pedido::join('customers as c', 'c.id', '=', 'pedidos.customer_id')
        ->select('c.id as id_cliente', 'c.businame as cliente', 'c.phone as telefono', 'c.email as mail', DB::raw("sum(pedidos.total) as total_sum"))
        ->whereNull('pedidos.fechapago')
        ->groupBy('c.id', 'c.businame', 'c.phone', 'c.email')
        ->paginate($this->pagination);


        //dd($pedidos);

        return view('livewire.cuentasclientes.component', [
            'pedidos' => $pedidos
        ])
        ->layout('layouts.theme.app');
    }

    public function noty($msg, $eventName = 'noty', $reset = true, $action =""){
        $this->dispatchBrowserEvent($eventName, ['msg'=>$msg, 'type' => 'success', 'action' => $action ]);

    }


    public function  Edit(Customer $customer){
        $this->pendientes =  Pedido::where('customer_id','=',$customer->id)
                            ->where('fechapago','=',null)
                            ->get();

        $this->totalPendientes = $this->pendientes->sum('total');

        $this->customer =  $customer->businame;
        $this->customer_id = $customer->id;
        $this->noty('','open-modal-pendientes', false);
     }

     public function Pagar(){
        $this->noty('','open-modal-pagar', false);
     }

     public  $listeners = ['cancelaPendientes' => 'CancelaSaldos'];

     public function resetUI()
     {
        $this->resetPage();
        $this->resetValidation();
        $this->reset('customer','customer_id','totalPendientes','fpago','dtransferencia','search');

     }

     public function CancelaSaldos(){

            $pendientes = Pedido::join('customers as c', 'c.id', '=', 'pedidos.customer_id')
            ->select(
            'pedidos.*',
            'c.businame as cliente',
            'c.phone as telefono',
            'c.email as mail',
            DB::raw("SUM(pedidos.total) OVER (PARTITION BY pedidos.customer_id) AS total_sum"),
            DB::raw("MIN(pedidos.fechapedido) OVER (PARTITION BY pedidos.customer_id) AS min_fecha_pedido"),
            DB::raw("MAX(pedidos.fechapedido) OVER (PARTITION BY pedidos.customer_id) AS max_fecha_pedido")
        )
        ->where('pedidos.customer_id', $this->customer_id)
        ->whereNull('pedidos.fechapago')
        ->get();
        //dd($pendientes);
         session()->put('pendientes',$pendientes);
         $fechaActual = Carbon::now();
         $desde = $pendientes[0]->min_fecha_pedido;
         $hasta = $pendientes[0]->max_fecha_pedido;
         $documentPath = $this->dtransferencia ? $this->dtransferencia->store('documentos_pago','public') :  null;
         //dd($this->customer_id, $fechaActual, $this->totalPendientes, $this->fpago, $documentPath, $desde, $hasta );
        foreach ($pendientes as $pedido) {
            $pedido->fechapago = $fechaActual;
             $pedido->save();
           }
        Pago::create([
            'customer_id' => $this->customer_id,
            'fechapago' => $fechaActual,
            'totalpago' => $this->totalPendientes,
            'formapago' => $this->fpago,
            'documentopago' => $documentPath,
            'desde' =>$desde,
            'hasta' =>$hasta,

        ]);
        $this->noty('PAGOS GENERADOS CORRECTAMENTE');
        $this->noty('','close-modal-pagar', false);
        $this->noty('','close-modal-cuentas', false);
        $this->resetUI();
        return redirect()->to('/download-pdf');
     }

    //  public function pagarPendientes($id){

    //     dd('lelgamos');
    //     $pendientes = Pedido::join('customers as c', 'c.id', '=', 'pedidos.customer_id')
    //     ->select('pedidos.*', 'c.businame as cliente', 'c.phone as telefono', 'c.email as mail', DB::raw("sum(pedidos.total) over (partition by pedidos.customer_id) as total_sum"))
    //     ->where('pedidos.customer_id', $id)
    //     ->whereNull('pedidos.fechapago')
    //     ->get();

    //      session()->put('pendientes',$pendientes);
    //      $fechaActual = Carbon::now();

    //     //  foreach ($pendientes as $pedido) {
    //     //     $pedido->fechapago = $fechaActual;
    //     //      $pedido->save();
    //     //  }
    //     $this->noty('PAGOS GENERADOS CORRECTAMENTE');
    //     $this->resetUI();
    //     return redirect()->to('/download-pdf');

    //  }













}
