<?php

namespace App\Http\Livewire;

use App\Models\Entrada;
use App\Models\Image;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

use Livewire\Component;

class Entradas extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $descripcion = '', $precio = 0, $selected_id = 0, $photo = '';
    public $action = 'Listado', $componentName = 'Entradas', $search, $form = false;
    private $pagination = 10;
    protected $paginationTheme = 'tailwind';


    public function render()
    {
        if (strlen($this->search) > 0)
            $info = Entrada::where('descripcion', 'like', "%{$this->search}%")->paginate($this->pagination);
        else
            $info = Entrada::paginate($this->pagination);
            return view('livewire.entradas.component', ['entradas' => $info])
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
        $this->reset('descripcion','precio', 'selected_id', 'search', 'action', 'componentName', 'photo', 'form');
    }

    public function Edit(Entrada $entrada)
    {
        $this->selected_id = $entrada->id;
        $this->descripcion = $entrada->descripcion;
        $this->precio = $entrada->precio;
        $this->action = 'Editar';
        $this->form = true;

    }
    public function Store()
    {
        //sleep(1);
        //dd($this->precio);
        $this->validate(Entrada::rules($this->selected_id), Entrada::$messages);

        $entrada = Entrada::updateOrCreate(
            ['id' => $this->selected_id],
            [
                'descripcion' => $this->descripcion,
                'precio' => $this->precio
            ]

        );

        // image
        if (!empty($this->photo)) {
            // delete all images in drive
            $tempImg = $entrada->image->file;
            if ($tempImg != null && file_exists('storage/entradas/' . $tempImg)) {
                unlink('storage/entradas/' . $tempImg);
            }
            // delete relationship image from db
            $entrada->image()->delete();

            // generate random file name
            $customFileName = uniqid() . '_.' . $this->photo->extension();
            $this->photo->storeAs('public/entradas', $customFileName);

            // save image record
            $img = Image::create([
                'model_id' => $entrada->id,
                'model_type' => 'App\Models\Entrada',
                'file' => $customFileName
            ]);

            // save relationship
            $entrada->image()->save($img);
        }
        $this->noty($this->selected_id < 1 ? 'Entrada Registrada' : 'Entrada Actualizada', 'noty', false, 'close-modal');
        $this->resetUI();
    }
    public function Destroy(Entrada $entrada)
    {
        $entrada->delete();
        $this->noty('Se eliminó la Categoría');
    }
}
