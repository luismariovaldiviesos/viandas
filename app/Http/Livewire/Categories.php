<?php

namespace App\Http\Livewire;

use App\Models\Category;
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

        return view('livewire.categories.component', [
            'categories' => $info
        ])
        ->layout('layouts.theme.app');
    }

    public function Edit(Category  $category)
    {
        $this->selected_id = $category->id;
        $this->name = $category->name;
    }
}
