<?php

namespace App\Http\Livewire;
use Livewire\WithPagination;
use App\Models\Customer;
use App\Models\Pedido;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CuentasClientes extends Component
{

    use WithPagination;
    public $action = 'Listado', $componentName = 'CUENTAS POR PAGAR', $search = '';
    private $pagination =10;
    protected $paginationTheme = 'tailwind';





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


    public function  Edit(Customer $customer){
        $pendientes =  Pedido::where('customer_id','=',$customer->id)->where('fechapago','=',null)->get();
       //$this->emit('abreDetalleCliente', $this->pendientes);
        dd($pendientes);
     }








}
