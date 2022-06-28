<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Image;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Categories extends Component
{

    use WithPagination;
    use WithFileUploads;

    // propiedades publicas
    public $form = false, $name ="", $selected_id=0, $photo ='';
    public $action = 'Listado', $componentName = 'CATALOGO DE CATEGORIAS', $search = '';
    private $pagination =4;

    protected $paginationTheme = 'tailwind';

    public function render()
    {
        if(strlen($this->search)> 0)
        $info = Category::where('name','like',"%{$this->search}%")->paginate($this->pagination);
        else
        $info = Category::orderBy('name', 'asc')->paginate($this->pagination);

        //dd($info);

        return view('livewire.categories.component', [
            'categories' => $info
        ])
        ->layout('layouts.theme.app');
    }

    public function Edit(Category  $category)
    {

        $this->selected_id = $category->id;
        $this->name = $category->name;
        $this->action =  'Editar';
        $this->form =  true;
    }

    public function resetUI()
    {
        $this->resetValidation();
        $this->resetPage();
        $this->reset('name','selected_id','search','action','componentName','photo','form');
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

    public function Store()
    {
        sleep(1);
        $this->validate(Category::rules($this->selected_id), Category::$messages);

        $category = Category::updateOrCreate(
            ['id' => $this->selected_id],
            ['name' => $this->name],
        );

        if(!empty($this->photo)){
            // eliminar imagenes del storage (esto es para actualziar, si hay imagenes anteriore las elimina)
            $tempImg =  $category->image->file;

            if($tempImg !=null && file_exists('storage/categories/' . $tempImg)){
                unlink('storage/categories/' . $tempImg);
            }
            // eliminar imagenes de la bbd
            $category->image()->delete();

            $customFileName = uniqid() . '_.' .$this->photo->extension(); // nombre de la imagen
            $this->photo->storeAs('public/categories', $customFileName);

            // guardar imagen en la bbdd
            $img = Image::create([
                'model_id' => $category->id,
                'model_type' => 'App\Models\Category',
                'file' => $customFileName
            ]);

            //guardar la relacion
            $category->image()->save($img);

        }
        $this->noty($this->selected_id < 1 ? 'Categoría registrada' : 'Categoría actualizada', 'noty', false, 'close-modal');
        $this->resetUI();

    }

    public function Destroy(Category $category)
    {
        $category->delete();
        $this->noty('Se elimino la categoría');
    }

    public $listeners  =  [
        'resetUI', 'Destroy'
    ];
}
