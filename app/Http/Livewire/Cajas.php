<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\User;
use Livewire\Component;

class Cajas extends Component
{

    public $nombre = '', $status = false, $user_id = null , $selected_id = 0;
    public $action = 'Listado', $componentName = 'Cajas', $form = false;
    private $pagination = 10;
    protected $paginationTheme = 'tailwind';

    public function render()
    {
        $cajas = Caja::paginate($this->pagination);
        $users =  User::all();
        return view('livewire.cajas.component', compact('cajas', $cajas, 'users', $users))->layout('layouts.theme.app');;
    }
    public function Store()
    {
        sleep(1);

        $this->validate(Caja::rules($this->selected_id), Caja::$messages);

        $caja = Caja::updateOrCreate(
            ['id' => $this->selected_id],
            [
                'nombre' => $this->nombre,
                'status' => false,
                'user_id' => $this->user_id
            ]
        );

        $this->noty($this->selected_id > 0 ? 'Caja actualizada ' : 'Caja registrada', 'noty', false, 'close-modal' );
        $this->resetUI();
    }


    public  function noty($msg, $eventName = 'noty', $reset =  true, $action ="" ){

        $this->dispatchBrowserEvent($eventName, ['msg'=>$msg, 'type' => 'success', 'action' => $action ]);
        if($reset) $this->resetUI();
    }
}
