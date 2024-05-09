<?php


namespace App\Services;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class Extra {

    protected Collection $extra;


    // constructor del extra
    public function __construct()
    {
        if (session()->has('extra')) {
            $this->extra =  session('extra');
        }else{
            $this->extra = new Collection;
        }

    }


     // obtener contenido del extra
     public function getContent(): Collection
     {
         return $this->extra->sortBy(['descripcion', ['descripcion','asc']]); //ordenar
     }

        // guardar el extra en sesion
    protected  function save() : void
    {
        session()->put('extra', $this->extra);
        session()->save();
    }

      // agregar un extra al carrito
      public function addExtra($extra, $cant = 1, $changes = 0 ) : void
      {
          $pre = Arr::add($extra, 'qty', $cant);
          $this->validate($pre);
          $this->extra->push($pre);
          $this->save();
      }
      // agregar cambios a un producto / platillo
    // public function addChanges($id, $changes)
    // {
    //     $myextra =  $this->getContent();
    //     $oldItem =  $mycart->where('id', $id)->first();
    //     $newItem = $oldItem;
    //     $newItem->changes =  $changes;
    //     $this->removeMenu($id);
    //     $this->addMenu($newItem);
    // }

        // validar si existe X producto en extra
        public function existsInExtra($id) : bool
        {
            $myextra =  $this->getContent();
            $cont = $myextra->where('id', $id)->count();
            $res =  $cont > 0 ? true : false;
            return $res;
        }

        // cantidad de X producto agregada al extra
        public function  countInExtra($id) : int
        {
            $myextra =  $this->getContent();
            $cont = $myextra->where('id', $id)->sum('qty');
            return $cont;

        }

          // incrementar cantidad de X extra en carrito
    public function updateQuantity($id, $cant = 1)
    {
        $myextra =  $this->getContent();
        $oldItem = $myextra->where('id', $id)->first();
        $newItem = $oldItem;
        $newItem->qty += $cant;
        //$iva =  $this->totalIVA();

        $this->removeExtra($id);
        $this->addExtra($newItem);
    }

      // decrementar cantidad de X producto en carrito
      public function decreaseQuantity($id, $cant=1)
      {
        $myextra =  $this->getContent();
        $oldItem = $myextra->where('id', $id)->first();
        $newItem = $oldItem;
        $newItem->qty -= $cant;
        //$iva =  $this->totalIVA();

        $this->removeExtra($id);
        $this->addExtra($newItem);
      }

      // reemplazar cantidad de X extra
    public function replaceQuantity($id , $cant = 1): void
    {
        $myextra =  $this->getContent();
        $oldItem = $myextra->where('id', $id)->first();
        $newItem = $oldItem;
        $newItem->qty = $cant;
        $this->validate($newItem);
        $this->removeExtra($id);
        $this->addExtra($newItem);

    }


      // eliminar producto del extra
      public function  removeExtra($id): void
      {
          $this->extra = $this->extra->reject(function (Extra $extra) use ($id){
              return $extra->id === $id;
          });
          $this->save();
      }

         // obtenemos total en carrito
    public function totalAmount()
    {
        $amount = $this->extra->sum(function ($extra){
            return ($extra->precio * $extra->qty);
        });
        return $amount;
    }

    // obtenemos la cantidad de filas en el carrito
    public function hasExtras(): int
    {
        return $this->extra->count();
    }
        // obtenemos sumatoria de productos en carrito
        public function totalItems(): int
        {
            $items =  $this->extra->sum(function($extra){
                return $extra->qty;
            });
            return $items;
        }

            // vaciar extra
    public function clear()
    {
        $this->extra = new Collection;
        $this->save();
    }

      // validación antes de agregar item al carrito
      protected function validate($item)
      {
          $validator = Validator::make($item->toArray(), [
              'id' => 'required',
              'precio' => 'required|numeric',
              'qty' => 'required|numeric|min:1',
              'descripcion' => 'required',
          ]);

          if ($validator->fails()) {
              throw new \ErrorException($validator->messages());
          }

          return $item;
      }






}
