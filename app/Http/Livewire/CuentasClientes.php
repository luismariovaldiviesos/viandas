<?php

namespace App\Http\Livewire;
use Livewire\WithPagination;
use App\Models\Customer;

use Livewire\Component;

class CuentasClientes extends Component
{

    use WithPagination;
    public $action = 'Listado', $componentName = 'CUENTAS POR PAGAR', $search = '';
    private $pagination =10;
    protected $paginationTheme = 'tailwind';
    public $customers;

    public  function mount(){
        $this->loadClientesConPedidosNoPagados();
    }

    public function loadClientesConPedidosNoPagados()
    {
        $this->customers = Customer::with(['pedidos' => function($query) {
            $query->whereNull('fechapago');
        }])
        ->withSum('pedidos', 'total')
        ->get();
       //  dd($this->customers);
    }

    public function render()
    {

        return view('livewire.cuentasclientes.component', [
            'customers' => $this->customers
        ])
        ->layout('layouts.theme.app');
    }
}
