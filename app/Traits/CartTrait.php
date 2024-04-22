<?php

namespace App\Traits;

use App\Services\Cart;

trait CartTrait {


    public function  getContentCart()
    {
        $cart = new Cart;
        return $cart->getContent()->sortBy('name');

    }

    public  function getTotalCart()
    {
        $cart = new Cart;
        return $cart->totalAmount();
    }

    // FUNCIONES MIAS PARA SACAR IMPUESTOS

    public  function getTotalSICart()
    {
        $cart = new Cart;
        return $cart->totalSinImpuestos();
    }

    public function getIva12()
    {
        $cart =  new Cart;
        return $cart->total12();
    }

    public function getIva0()
    {
        $cart =  new Cart;
        return $cart->total0();
    }

    //total valor iva
    public function getImpuesto12()
    {
        $cart =  new Cart;
        return $cart->totalImpuesto12();
    }

    public function getIce()
    {
        $cart =  new Cart;
        return $cart->totalIce();
    }

    public function getDscto()
    {
        $cart =  new Cart;
        return $cart->totalDsto();
    }


    // FIMM FUNCIONES MIAS PARA SACAR IMPUESTOS

    public function countInCart($id)
    {
        $cart = new Cart;
        return $cart->countInCart($id);
    }

    public function getItemsCart()
    {
        $cart = new Cart;
        return $cart->totalItems();
    }

    public function  updateQtyCart($product, $cant =1 )
    {
        $cart = new Cart;
        $cart->updateQuantity($product->id, $cant);
        $this->noty('CANTIDAD ACTUALIZADA');
    }

    public function addMenuCart($product, $cant=1, $changes ='')
    {
        $cart = new Cart;
        if($cart->existsInCart($product->id))
        {
            $cart->updateQuantity($product->id, $cant);
            //dd($cart);
            $this->noty('CANTIDAD ACTUALIZADA');
        } else{
            $cart->addMenu($product, $cant, $changes);
            //dd($cart);
            $this->noty('PRODUCTO AGREGADO');
        }
    }

    public function inCart($id)
    {
        $cart = new Cart;
        return $cart->existsInCart($id);
    }

    public function replaceQuantityCart($id, $cant=1)
    {
        $cart = new Cart;
        $cart->replaceQuantity($id, $cant);
    }

    public function decreaseQtyCart($id)
    {
        $cart = new Cart;
        $cart->decreaseQuantity($id);
        $this->noty('CANTIDAD ACTUALIZADA');
    }

    public function removeMenuCart($id)
    {
        $cart = new Cart;
        $cart->removeMenu($id);

    }

    public function addChanges2Product($id, $changes)
    {
        $cart = new Cart;
        $cart->addChanges($id, $changes);
    }

    public function clearChanges($id)
    {
        $cart = new Cart;
        $cart->removeChanges($id);
    }

    public function clearCart()
    {
        $cart = new Cart;
        $cart->clear();
    }

}
