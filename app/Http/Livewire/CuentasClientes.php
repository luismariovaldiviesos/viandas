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


class CuentasClientes extends Component
{

    use WithPagination;
    public $action = 'Listado', $componentName = 'CUENTAS POR COBRAR', $search = '';
    private $pagination =10;
    protected $paginationTheme = 'tailwind';
    public  $pendientes = [];
    public $customer;






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
        $this->pendientes =  Pedido::where('customer_id','=',$customer->id)->where('fechapago','=',null)->get();
        $this->customer =  $customer->businame;//dd($customer->businame);
       //$this->emit('abreDetalleCliente', $this->pendientes);
         // dd($this->pendientes, $this->customer);
        //$this->noty('','open-modal',false);
        $this->noty('','open-modal-pendientes', false);
     }

     public  $listeners = ['cancelaPendientes' => 'pagarPendientes'];

     public function pagarPendientes($id){

        $pendientes = Pedido::join('customers as c', 'c.id', '=', 'pedidos.customer_id')
        ->select('pedidos.*', 'c.businame as cliente', 'c.phone as telefono', 'c.email as mail', DB::raw("sum(pedidos.total) over (partition by pedidos.customer_id) as total_sum"))
        ->where('pedidos.customer_id', $id)
        ->whereNull('pedidos.fechapago')
        ->get();

        // $fechaActual = Carbon::now();
        // foreach ($pendientes as $pedido) {
        //     $pedido->fechapago = $fechaActual;
        //     $pedido->save();
        // }
            $this->noty('PAGOS GENERADOS CORRECTAMENTE');




     }













}
