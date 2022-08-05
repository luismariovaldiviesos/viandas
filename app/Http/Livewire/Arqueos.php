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
        $arqueos =  Arqueo::orderBy('id','asc')->paginate($this->pagination);
        return view('livewire.arqueos.component', [
            'arqueos' => $arqueos
        ]
        )->layout('layouts.theme.app');;
    }
}
