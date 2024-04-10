<?php

namespace App\Http\Livewire;

use App\Models\Image;
use App\Models\Postre;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

use Livewire\Component;

class Postres extends Component
{

    use WithPagination;
    use WithFileUploads;
    public $descripcion = '', $selected_id = 0, $photo = '';
    public $action = 'Listado', $componentName = 'Postres', $search, $form = false;
    private $pagination = 10;
    protected $paginationTheme = 'tailwind';


    public function render()
    {
        if (strlen($this->search) > 0)
            $info = Postre::where('descripcion', 'like', "%{$this->search}%")->paginate($this->pagination);
        else
            $info = Postre::paginate($this->pagination);
            return view('livewire.postres.component', ['postres' => $info])
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
        $this->reset('descripcion', 'selected_id', 'search', 'action', 'componentName', 'photo', 'form');
    }

    public function Edit(Postre $postre)
    {
        $this->selected_id = $postre->id;
        $this->descripcion = $postre->descripcion;
        $this->action = 'Editar';
        $this->form = true;

    }

    public function Store()
    {
        sleep(1);

        $this->validate(Postre::rules($this->selected_id), Postre::$messages);

        $postre = Postre::updateOrCreate(
            ['id' => $this->selected_id],
            ['descripcion' => $this->descripcion]
        );

        // image
        if (!empty($this->photo)) {
            // delete all images in drive
            $tempImg = $postre->image->file;
            if ($tempImg != null && file_exists('storage/postres/' . $tempImg)) {
                unlink('storage/postres/' . $tempImg);
            }
            // delete relationship image from db
            $postre->image()->delete();

            // generate random file name
            $customFileName = uniqid() . '_.' . $this->photo->extension();
            $this->photo->storeAs('public/postres', $customFileName);

            // save image record
            $img = Image::create([
                'model_id' => $postre->id,
                'model_type' => 'App\Models\Postre',
                'file' => $customFileName
            ]);

            // save relationship
            $postre->image()->save($img);
        }
        $this->noty($this->selected_id < 1 ? 'Postre Registrado' : 'Postre Actualizado', 'noty', false, 'close-modal');
        $this->resetUI();
    }

    public function Destroy(Postre $postre)
    {
        $postre->delete();
        $this->noty('Se eliminó el plato');
    }
}
