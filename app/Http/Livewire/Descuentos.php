<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use DB;

class Descuentos extends Component
{
    use WithPagination;

    public $search, $pagination=10, $componentName = 'Productos con Descuentos' ;

    public function render()
    {

        $products = Product::where('descuento','>', 0)
        ->orderBy('id', 'desc')
        ->paginate($this->pagination);

        return view('livewire.descuentos.component', [
            'products' => $products
        ])->layout('layouts.theme.app');
    }


    public function Revoque(Product $product)
    {
        // hacer el mismo metodo create or update
        $desc = ($product->price * $product->descuento)/100;
        $newPrice = $product->price2 + $desc;
        $impuestos =  $product->iva + $product->ice;
        $pvp = $newPrice + $impuestos;
        $newDescuent = 0.00;
        $affectedRows = Product::where('id', '=', $product->id)->update(['price2' => $pvp, 'descuento' => $newDescuent]);
        $this->noty('Se eliminó el descuento');

    }

    public function noty($msg, $eventName='noty', $reset =  true, $action = '')
    {
        $this->dispatchBrowserEvent($eventName, ['msg' => $msg, 'type' => 'success', 'action' => $action]);
        //if($reset) $this->resetUI();
    }

    public $listeners = ['Revoque'];
}
