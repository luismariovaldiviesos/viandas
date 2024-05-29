<?php

namespace App\Http\Livewire;
use Livewire\WithPagination;
use App\Models\Customer;
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
    public $action = 'Listado', $componentName = 'CUENTAS POR COBRAR', $search = '';
    private $pagination =10;
    protected $paginationTheme = 'tailwind';
    public  $pendientes = [];
    public $customer, $customer_id, $totalPendientes, $fpago ='efectivo', $dtransferencia;






    public function render()
    {
        // $pedido =  Pedido::join('customers as c', 'c.id', 'pedidos.customer_id')
        //                     //->select('pedidos.*','c.businame as cliente')
        //                     ->select(DB::raw("c.businame as cliente, sum(pedidos.total)  as total"))
        //                     ->where('pedidos.fechapago','=',null)->paginate($this->pagination);
        // dd($pedido);

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

     public  $listeners = ['cancelaPendientes' => 'pagarPendientes'];
     public function resetUI()
     {
         $this->resetPage();
        //  $this->resetValidation();
        //  $this->reset('businame','typeidenti','valueidenti','address','email','phone','notes','selected_id','search','form');
     }

     public function CancelaSaldos(){
        //dd($this->customer_id, $this->customer, $this->totalPendientes);
        // $pendientes = Pedido::join('customers as c', 'c.id', '=', 'pedidos.customer_id')
        // ->select('pedidos.*', 'c.businame as cliente', 'c.phone as telefono', 'c.email as mail', DB::raw("sum(pedidos.total) over (partition by pedidos.customer_id) as total_sum"))
        // ->where('pedidos.customer_id', $this->customer_id)
        // ->whereNull('pedidos.fechapago')
        // ->get();
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
         $periodo =  $desde .' '. 'al'.' ' . $hasta;
         dd($periodo);

          foreach ($pendientes as $pedido) {
            // foreach($pedido->detalles as $detalle){

            //     dd($detalle->menu->base);

            // }
            //dd($pedido->detalles->menu);
            //  $pedido->fechapago = $fechaActual;
            //   $pedido->save();
          }
        $this->noty('PAGOS GENERADOS CORRECTAMENTE');
        $this->resetUI();
        return redirect()->to('/download-pdf');
     }

     public function pagarPendientes($id){

        dd('lelgamos');
        $pendientes = Pedido::join('customers as c', 'c.id', '=', 'pedidos.customer_id')
        ->select('pedidos.*', 'c.businame as cliente', 'c.phone as telefono', 'c.email as mail', DB::raw("sum(pedidos.total) over (partition by pedidos.customer_id) as total_sum"))
        ->where('pedidos.customer_id', $id)
        ->whereNull('pedidos.fechapago')
        ->get();

         session()->put('pendientes',$pendientes);
         $fechaActual = Carbon::now();

        //  foreach ($pendientes as $pedido) {
        //     $pedido->fechapago = $fechaActual;
        //      $pedido->save();
        //  }
        $this->noty('PAGOS GENERADOS CORRECTAMENTE');
        $this->resetUI();
        return redirect()->to('/download-pdf');

     }













}
