<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Cajas extends Component
{

    use WithPagination;

    public $nombre='', $status='elegir', $user_id='elegir', $selected_id ='', $search ='';
    public $componentName = 'Cajas', $form  = false;

    public $action = 'Listado';
    protected $paginationTheme = 'tailwind';
    private $pagination = 100;


    public function render()
    {

        if(strlen($this->search) > 0)
        {
            $cajas = Caja::join('users as u','u.id','cajas.user_id')
                            ->select('cajas.*','u.name as usuario')
                            ->where('cajas.nombre','like',"%{$this->search}%")
                            ->paginate($this->pagination);
        }
        else
        {
            $cajas = Caja::join('users as u','u.id','cajas.user_id')
            ->select('cajas.*','u.name as usuario')
            ->paginate($this->pagination);
        }
        return view('livewire.cajas.component',
        [
            'cajas' => $cajas,
            'usuarios' => User::all()
        ])
        ->layout('layouts.theme.app');
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

    public  function resetUI()
    {
        $this->resetValidation();
        $this->resetPage();
        $this->reset('nombre','selected_id','status','search','componentName', 'user_id','form');
    }

    public function Edit(Caja $caja)
    {
        $this->selected_id = $caja->id;
        $this->nombre = $caja->nombre;
        $this->status = $caja->status;
        $this->user_id = $caja->user_id;
        $this->form = true;
        $this->action = 'Editar';
    }


    public $listeners = ['resetUI','Destroy'];

    public function Store()
    {
        $this->validate(Caja::rules($this->selected_id), Caja::$messages);

        Caja::updateOrCreate(
            ['id' => $this->selected_id],
            [
                'nombre' =>  $this->nombre,
                'status' =>  $this->status,
                'user_id' =>  $this->user_id

            ]
        );

        $this->noty($this->selected_id > 0 ? 'Caja actualizada' : 'Caja registrada');
        $this->resetUI();
    }


    public function Destroy(Caja $caja)
    {

            $caja->delete();
            $this->noty("La caja <b>$caja->nombre</b> fue eliminada del sistema");

    }
}
