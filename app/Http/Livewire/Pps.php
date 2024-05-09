<?php

namespace App\Http\Livewire;

use App\Models\Image;
use App\Models\Pp;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

use Livewire\Component;

class Pps extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $descripcion = '', $precio = 0, $selected_id = 0, $photo = '';
    public $action = 'Listado', $componentName = 'Platos Principales', $search, $form = false;
    private $pagination = 10;
    protected $paginationTheme = 'tailwind';

    public function render()
    {
        if (strlen($this->search) > 0)
            $info = Pp::where('descripcion', 'like', "%{$this->search}%")->paginate($this->pagination);
        else
            $info = Pp::paginate($this->pagination);
            return view('livewire.pps.component', ['pps' => $info])
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
        $this->reset('descripcion','precio' ,'selected_id', 'search', 'action', 'componentName', 'photo', 'form');
    }

    public function Edit(Pp $pp)
    {
        $this->selected_id = $pp->id;
        $this->descripcion = $pp->descripcion;
        $this->precio = $pp->precio;
        $this->action = 'Editar';
        $this->form = true;

    }

    public function Store()
    {
        sleep(1);

        $this->validate(Pp::rules($this->selected_id), Pp::$messages);

        $pp = Pp::updateOrCreate(
            ['id' => $this->selected_id],
            [
                'descripcion' => $this->descripcion,
                'precio' => $this->precio
            ]
        );

        // image
        if (!empty($this->photo)) {
            // delete all images in drive
            $tempImg = $pp->image->file;
            if ($tempImg != null && file_exists('storage/pps/' . $tempImg)) {
                unlink('storage/pps/' . $tempImg);
            }
            // delete relationship image from db
            $pp->image()->delete();

            // generate random file name
            $customFileName = uniqid() . '_.' . $this->photo->extension();
            $this->photo->storeAs('public/pps', $customFileName);

            // save image record
            $img = Image::create([
                'model_id' => $pp->id,
                'model_type' => 'App\Models\Pp',
                'file' => $customFileName
            ]);

            // save relationship
            $pp->image()->save($img);
        }
        $this->noty($this->selected_id < 1 ? 'Plato principal Registrado' : 'Plato principal Actualizado', 'noty', false, 'close-modal');
        $this->resetUI();
    }

    public function Destroy(Pp $pp)
    {
        $pp->delete();
        $this->noty('Se eliminó el plato');
    }

}
