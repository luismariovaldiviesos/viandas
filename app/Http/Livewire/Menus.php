<?php

namespace App\Http\Livewire;

use App\Models\Entrada;
use App\Models\Menu;
use App\Models\Postre;
use App\Models\Pp;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

use Livewire\Component;

class Menus extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $base = '', $precio = '',$entrada_id = '',$pp_id = '',$postre_id = '', $selected_id = 0;
    public $action = 'Listado', $componentName = 'Menus', $search, $form = false;
    //para los botenes
    public $entradaSelected='Seleccionar entrada';
    public $ppSelected= 'Seleccionar Plato Principal';
    public $postreSelected= 'Seleccionar Postre';
    private $pagination = 10;
    protected $paginationTheme = 'tailwind';

    // para seleccionar entradas, pps y postres
    public $entradas = [], $pps = [], $postres = [];

    public $searchEntrada , $searchPP, $searchPostre;


     public function render()
    {
        if (strlen($this->search) > 0)
            $info = Menu::where('base', 'like', "%{$this->search}%")->paginate($this->pagination);
        else
            $info = Menu::paginate($this->pagination);
            $this->entradas = $this->buscaEntrada();
            $this->pps =  $this->buscaPP();
            $this->postres =  $this->buscaPostre();

            return view('livewire.menus.component', ['menus' => $info, 'entradas'=> $this->entradas , 'pps'=> $this->pps, 'postres'=> $this->postres])
            ->layout('layouts.theme.app');
    }

    public $listeners = [
        'resetUI',
        'Destroy'
    ];
    public function updatedForm()
    {
        if($this->selected_id > 0)
            $this->action ='Editar';
        else
            $this->action ='Agregar';

    }
    public function noty($msg, $eventName = 'noty', $reset = true, $action = '')
    {
        $this->dispatchBrowserEvent($eventName, ['msg' => $msg, 'type' => 'success', 'action' => $action]);
        if ($reset) $this->resetUI();
    }
    public function CloseModal()
    {
        $this->resetUI();
        $this->noty(null, 'close-modal');
    }
    public function resetUI()
    {
        // limpiar mensajes rojos de validación
        $this->resetValidation();
        // regresar a la página inicial del componente
        $this->resetPage();
        // regresar propiedades a su valor por defecto
        $this->reset('base','precio','entrada_id','pp_id','postre_id', 'selected_id', 'search', 'action', 'componentName', 'form',
        'entradaSelected','ppSelected','postreSelected','searchEntrada','searchPP','searchPostre'
        );

    }

    public function Edit(Menu $menu)
    {

        $this->action = 'Editar';
        $this->form = true;

    }

    public function Store()
    {


        //dd($this->entradaSelected, $this->entrada_id, $this->ppSelected, $this->pp_id, $this->postreSelected, $this->postre_id);
        sleep(1);
        $this->validate(Menu::rules($this->selected_id), Menu::$messages);



        // $pp = Pp::updateOrCreate(
        //     ['id' => $this->selected_id],
        //     ['descripcion' => $this->descripcion]
        // );

        // // image
        // if (!empty($this->photo)) {
        //     // delete all images in drive
        //     $tempImg = $pp->image->file;
        //     if ($tempImg != null && file_exists('storage/pps/' . $tempImg)) {
        //         unlink('storage/pps/' . $tempImg);
        //     }
        //     // delete relationship image from db
        //     $pp->image()->delete();

        //     // generate random file name
        //     $customFileName = uniqid() . '_.' . $this->photo->extension();
        //     $this->photo->storeAs('public/pps', $customFileName);

        //     // save image record
        //     $img = Image::create([
        //         'model_id' => $pp->id,
        //         'model_type' => 'App\Models\Pp',
        //         'file' => $customFileName
        //     ]);

        //     // save relationship
        //     $pp->image()->save($img);
        // }
        // $this->noty($this->selected_id < 1 ? 'Plato principal Registrado' : 'Plato principal Actualizado', 'noty', false, 'close-modal');
        // $this->resetUI();
    }



    //para el search de las entradas
    public  function buscaEntrada(){

        if(strlen($this->searchEntrada) > 0){
            $entradas =  Entrada::where('descripcion','like',"%{$this->searchEntrada}%")->orderBy('id','asc')
            ->get()->take(8);
        }
        else
        $entradas =  Entrada::orderBy('id','asc')->get()->take(8); //primeros 8 clientes
        return $entradas;

    }
     //para el search de las pps
     public  function buscaPP(){

        if(strlen($this->searchPP) > 0){
            $pps =  Pp::where('descripcion','like',"%{$this->searchPP}%")->orderBy('id','asc')
            ->get()->take(8);
        }
        else
        $pps =  Pp::orderBy('id','asc')->get()->take(8); //primeros 8 clientes
        return $pps;
    }

       //para el search de las postres
       public  function buscaPostre(){

        if(strlen($this->searchPostre) > 0){
            $postres =  Postre::where('descripcion','like',"%{$this->searchPostre}%")->orderBy('id','asc')
            ->get()->take(8);
        }
        else
        $postres =  Postre::orderBy('id','asc')->get()->take(8); //primeros 8 clientes
        return $postres;



    }


    public function searchManualEntrada(Entrada $entrada){
        //dd($entrada);
        $this->entradaSelected =  $entrada->descripcion;
        $this->entrada_id = $entrada->id;
        $this->dispatchBrowserEvent('close-usuario-modal');
    }
    public function searchManualPP(Pp $pp){
        //dd($entrada);
        $this->ppSelected =  $pp->descripcion;
        $this->pp_id = $pp->id;
        $this->dispatchBrowserEvent('close-pp-modal');
    }

    public function searchManualPostre(Postre $postre)
    {
        $this->postreSelected = $postre->descripcion;
        $this->postre_id = $postre->id;
        $this->dispatchBrowserEvent('close-postre-modal');
    }


}
