<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;

class Customers extends Component
{
    use WithPagination;

    public $businame = "", $typeidenti ="", $valueidenti ="",$address ="",$email ="",$phone ="", $notes='', $selected_id =0;

    public $action = 'Listado', $componentName = 'CLIENTES', $search = '', $form = false;
    private $pagination =10;
    protected $paginationTheme = 'tailwind';

    public function render()
    {
        if (strlen($this->search)> 0) {
            $customers = Customer::where('businame','like',"%{$this->search}%")
            ->orWhere('valueidenti','like',"%{$this->search}%")
            ->orWhere('phone','like',"%{$this->search}%")
            ->orWhere('address','like',"%{$this->search}%")
            ->orderBy('businame', 'asc')
            ->paginate($this->pagination);
        }
        else
        {
            $customers = Customer::orderBy('businame', 'asc')
            ->paginate($this->pagination);
        }
        return view('livewire.customers.component',[
            'customers' => $customers

        ])->layout('layouts.theme.app');;
    }

    public function noty($msg, $eventName = 'noty', $reset = true, $action =""){
        $this->dispatchBrowserEvent($eventName, ['msg'=>$msg, 'type' => 'success', 'action' => $action ]);
        if($reset) $this->resetUI();
    }

    public function  addNew()
    {
        $this->resetUI();
        $this->form = true;
        $this->action = 'Agregar';
    }

    public  function  CloseModal()
    {
        $this->resetUI();
        $this->noty(null, 'close-modal');
    }

    public function resetUi()
    {
        $this->resetPage();
        $this->resetValidation();
        $this->reset('businame','valueidenti','address','email','phone','notes','selected_id','search');
    }
}
