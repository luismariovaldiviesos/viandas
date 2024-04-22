<?php

namespace App\Services;

use App\Models\Menu;

use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class Cart {

     // variable de tipo Collection
    protected Collection $cart;

    // constructor del carrito
    public function __construct()
    {
        if (session()->has('cart')) {
            $this->cart =  session('cart');
        }else{
            $this->cart = new Collection;
        }

    }

    // obtener contenido del carrito
    public function getContent(): Collection
    {
        return $this->cart->sortBy(['base', ['base','asc']]);
    }

     // guardar el carrito en sesion
    protected  function save() : void
    {
        session()->put('cart', $this->cart);
        session()->save();
    }

     // agregar un producto al carrito
    public function addMenu($menu, $cant = 1, $changes = 0 ) : void
    {
        $pre = Arr::add($menu, 'qty', $cant);
        $this->validate($pre);
        $this->cart->push($pre);
        $this->save();
    }

    // agregar cambios a un producto / platillo
    public function addChanges($id, $changes)
    {
        $mycart =  $this->getContent();
        $oldItem =  $mycart->where('id', $id)->first();
        $newItem = $oldItem;
        $newItem->changes =  $changes;
        $this->removeMenu($id);
        $this->addMenu($newItem);
    }

      // remover cambios a un producto / platillo
    public function removeChanges($id)
    {
        $mycart = $this->getContent();
        $oldItem = $mycart->where('id', $id)->first();
        $newItem = $oldItem;
        $newItem->changes = '';
        $this->removeMenu($id);
        $this->addMenu($newItem);
    }

      // validar si existe X producto en carrito
    public function existsInCart($id) : bool
    {
        $mycart =  $this->getContent();
        $cont = $mycart->where('id', $id)->count();
        $res =  $cont > 0 ? true : false;
        return $res;
    }

    // cantidad de X producto agregada al carrito
    public function  countInCart($id) : int
    {
        $mycart =  $this->getContent();
        $cont = $mycart->where('id', $id)->sum('qty');
        return $cont;

    }

     // incrementar cantidad de X producto en carrito
    public function updateQuantity($id, $cant = 1)
    {
        $mycart =  $this->getContent();
        $oldItem = $mycart->where('id', $id)->first();
        $newItem = $oldItem;
        $newItem->qty += $cant;
        //$iva =  $this->totalIVA();

        $this->removeMenu($id);
        $this->addMenu($newItem);
    }

     // decrementar cantidad de X producto en carrito
    public function decreaseQuantity($id, $cant=1)
    {
        $mycart =  $this->getContent();
        $oldItem = $mycart->where('id', $id)->first();
        $newItem = $oldItem;
        $newItem->qty -= $cant;

        $this->removeMenu($id);
        if($newItem->qty > 0) $this->addMenu($newItem);
    }

     // reemplazar cantidad de X producto en carrito
    public function replaceQuantity($id , $cant = 1): void
    {
        $mycart =  $this->getContent();
        $oldItem = $mycart->where('id', $id)->first();
        $newItem = $oldItem;
        $newItem->qty = $cant;
        $this->validate($newItem);
        $this->removeMenu($id);
        $this->addMenu($newItem);

    }

      // eliminar producto del carrito
    public function  removeMenu($id): void
    {
        $this->cart = $this->cart->reject(function (Menu $menu) use ($id){
            return $menu->id === $id;
        });
        $this->save();
    }

     // obtenemos total en carrito
    public function totalAmount()
    {
        $amount = $this->cart->sum(function ($product){
            return ($product->price2 * $product->qty);
        });
        return $amount;
    }

    public function totalSinImpuestos()
    {
        $amount = $this->cart->sum(function ($product){
            return ($product->price * $product->qty);
        });
        return $amount;
    }

    // total del valor que grava 12
    public function total12()
    {
        $amount = $this->cart->sum(function ($product){
            if( $product->iva > 0){
                return ($product->price * $product->qty);
            }

        });
        return $amount;
    }

    // total del impuesto 12
    public function totalImpuesto12()
    {
        $amount = $this->cart->sum(function ($product){
            if( $product->iva > 0){
                return ($product->iva * $product->qty);
            }

        });
        return $amount;
    }
    public function totalIce()
    {
        $amount = $this->cart->sum(function ($product){
            if( $product->ice > 0){
                return ($product->ice * $product->qty);
            }

        });
        return $amount;
    }

    // total del valor que grava 0
    public function total0()
    {
        $amount = $this->cart->sum(function ($product){
            if( $product->iva <= 0){
                return ($product->price * $product->qty);
            }

        });
        return $amount;
    }

      // total del DESCUENTO
      public function totalDsto()
      {
          $amount = $this->cart->sum(function ($product){
              if( $product->descuento > 0){
                $desc = ($product->qty * $product->descuento) /100;
                  return $desc;
              }

          });
          return $amount;
      }





    // obtenemos la cantidad de filas en el carrito
    public function hasProducts(): int
    {
        return $this->cart->count();
    }

     // obtenemos sumatoria de productos en carrito
    public function totalItems(): int
    {
        $items =  $this->cart->sum(function($product){
            return $product->qty;
        });
        return $items;
    }


       // vaciar carrito
    public function clear()
    {
        $this->cart = new Collection;
        $this->save();
    }


    // validación antes de agregar item al carrito
    protected function validate($item)
    {
        $validator = Validator::make($item->toArray(), [
            'id' => 'required',
            'precio' => 'required|numeric',
            'qty' => 'required|numeric|min:1',
            'base' => 'required',
        ]);

        if ($validator->fails()) {
            throw new \ErrorException($validator->messages());
        }

        return $item;
    }

}
