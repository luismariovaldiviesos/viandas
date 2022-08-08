<?php

namespace App\Http\Livewire;

use App\Models\Arqueo;
use Livewire\Component;
use Livewire\WithPagination;

class Arqueos extends Component
{
    use WithPagination;

    public $caja_id='', $user_id ='', $monto_inicial=0, $monto_final=0, $total=0, $obervaciones='',$selected_id=0;
    public $action = 'Listado', $componentName='LISTADO DE ARQUEOS DE CAJA', $search, $form = false;
    private $pagination =15;
    protected $paginationTheme='tailwind';


    public function render()
    {
        if(strlen($this->search) > 0){
            $arqueos = Arqueo::join('users as u','u.id','arqueos.user_id')
            ->select('arqueos.*','u.name as usuario')
            ->where('arqueos.created_at','like',"%{$this->search}%")
            ->orderBy('created_at','asc')
            ->paginate($this->pagination);
        }
        else{
            $arqueos = Arqueo::join('users as u','u.id','arqueos.user_id')
            ->select('arqueos.*','u.name as usuario')
            ->orderBy('created_at','asc')
            ->paginate($this->pagination);
        }
        return view('livewire.arqueos.component', [
            'arqueos' => $arqueos
        ]
        )->layout('layouts.theme.app');;
    }
}
