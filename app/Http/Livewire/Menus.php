<?php

namespace App\Http\Livewire;

use App\Models\Entrada;
use App\Models\Extra;
use App\Models\Menu;
use App\Models\Postre;
use App\Models\Pp;
use GuzzleHttp\Psr7\Request;
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

    //precios
    public $precio_entrada, $precio_pp, $precio_postre;

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

        $this->selected_id = $menu->id;
        $this->base = $menu->base;
        $this->precio = $menu->precio;
        $this->entrada_id = $menu->entrada_id;
        $this->pp_id = $menu->pp_id;
        $this->postre_id = $menu->postre_id;
        $this->entradaSelected  = Entrada::where('id',$this->entrada_id)->first()->descripcion;
        $this->ppSelected  = Pp::where('id',$this->pp_id)->first()->descripcion;
        $this->postreSelected  = Postre::where('id',$this->postre_id)->first()->descripcion;
        $this->action = 'Editar';
        $this->form = true;

    }

    public function Store()
    {
        $base =  $this->ppSelected . ' '. 'Y '.' ' . $this->entradaSelected;
        $this->precio  =  $this->precio_entrada+$this->precio_pp+$this->precio_postre;
        //dd($this->precio);
          if(Menu::where('entrada_id', $this->entrada_id)
                        ->where('pp_id', $this->pp_id)
                        ->where('postre_id', $this->postre_id)
                        ->where('id', '!=' , $this->selected_id)
                        ->exists()
                        ){
                            $this->noty('la combinación del menú ya existe', 'noty', 'false');
                            return;
                        }
        Menu::updateOrCreate(
            ['id' => $this->selected_id],
                [
                    'base' => $base,
                    'precio' => $this->precio,
                     'entrada_id' => $this->entrada_id,
                     'pp_id' => $this->pp_id,
                     'postre_id' => $this->postre_id
                ]
         );
        $this->noty($this->selected_id < 1 ? 'Menú Registrado' : 'Menú Actualizado', 'noty', false, 'close-modal');
        $this->resetUI();
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
        $this->precio_entrada =  $entrada->precio;
        $this->dispatchBrowserEvent('close-usuario-modal');
    }
    public function searchManualPP(Pp $pp){
        //dd($entrada);
        $this->ppSelected =  $pp->descripcion;
        $this->pp_id = $pp->id;
        $this->precio_pp =  $pp->precio;
        $this->dispatchBrowserEvent('close-pp-modal');
    }

    public function searchManualPostre(Postre $postre)
    {
        $this->postreSelected = $postre->descripcion;
        $this->postre_id = $postre->id;
        $this->precio_postre =  $postre->precio;
        $this->dispatchBrowserEvent('close-postre-modal');
    }


    public function syncPermiso($state, $idmenu)
    {
            $menu = Menu::find($idmenu);
            //dd($menu->entrada->descripcion, $menu->pp->descripcion, $menu->postre->descripcion);
            //dd($menu->entrada->precio, $menu->pp->precio, $menu->postre->precio);
            if ($state) {
                $menu->activo =  true;
                $menu->save();
                //aqui debe ir el registro de extras
                //obtiene el conteo actual de extras
                $extrasCount = Extra::count();
                $maxExtras = 6;
                 // Si ya hay  o más, solo borra los extras más antiguos que excedan de 6
                 if ($extrasCount >= $maxExtras) {
                    Extra::oldest()->take($extrasCount - $maxExtras + 3)->delete();  // Asegura espacio para 3 nuevos extras
                }

                //Extra::query()->delete();
                Extra::create([
                    'descripcion' => $menu->entrada->descripcion,
                    'precio' => $menu->entrada->precio,
                ]);
                Extra::create([
                    'descripcion' => $menu->pp->descripcion,
                    'precio' => $menu->pp->precio,
                ]);
                Extra::create([
                    'descripcion' => $menu->postre->descripcion,
                    'precio' => $menu->postre->precio,
                ]);
                $this->noty("Menú $menu->base ES EL MENÚ DEL DIA", 'noty', false);
            }else {
                $menu->activo =  false;
                $menu->save();
                $this->noty("Menú $menu->base YA NO ES EL MENÚ DEL DIA", 'noty', false);
            }

    }


    public function Destroy(Menu $menu)
    {
        dd('validar si se elimina o no cuadno tenga pedidos');
        $menu->delete();
        $this->noty('Se eliminó la Categoría');
    }

}
