<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\DetallePedido;
use App\Models\Entrada;
use App\Models\Menu;
use App\Models\Pedido;
use App\Models\Postre;
use App\Models\Pp;
use App\Traits\CartTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Pedidos extends Component
{


    use WithPagination;
    use CartTrait;

    public $search, $cash, $searchCustomer, $searchMenu, $customer_id =null,
    $changes,  $customerSelected ="Seleccionar Cliente", $menuSelected = "Buscar Menú";

    // mostrar y activar panels
    //public $tabMenus = true, $tabPedidos =  false, $tabExtras = false;
    public $showListProducts = false, $tabProducts =  false, $tabCategories = false, $tabDiario =  true;

    //collections
    public $menusList =[], $customers =[], $hoy, $manana, $fechaPedido =  null;
     //info del carrito
     public $totalCart = 0, $itemsCart= 0, $contentCart=[];

     //totales
     public $subTotSinImpuesto =0;
     // producto seleccionado
     public $menuIdSelected, $menuChangesSelected, $menuNameSelected, $changesMenu;


     protected $paginationTheme = 'tailwind';
     private $pagination = 10;

     public function mount()
     {
         $date =  Carbon::now();
         $this->fechaPedido = $date->format('Y-m-d');
         //$this->manana = now()->addDay()->format('Y-m-d');

        // dd($hoy, $mañana);
     }



    public function render()
    {
        $menus = Menu::activos();
        $from = Carbon::now()->format('Y-m-d'). ' 00:00:00';
        $to = Carbon::now()->format('Y-m-d'). ' 23:59:59';
        $pedidos =  Pedido::whereBetween('fechapedido', [$from, $to])
            ->where('estado','Pendiente') ->orderBy('id', 'desc')
            ->paginate($this->pagination);


        if(strlen($this->searchCustomer) > 0)
            $this->customers =  Customer::where('businame','like',"%{$this->searchCustomer}%")
             ->orderBy('businame','asc')->get()->take(5); //primeros 5 clientes
        else
            $this->customers =  Customer::orderBy('businame','asc')->get()->take(5); //primeros 5 clientes

            $this->totalCart = $this->getTotalCart();
            $this->itemsCart = $this->getItemsCart();
            $this->contentCart = $this->getContentCart();

            if(strlen($this->searchMenu) > 0)
            $this->menusList = Menu::where('base','like',"%{$this->searchMenu}%")
            ->orderBy('base','asc')->get()->take(5);
        else
        $this->menusList =  Menu::orderBy('base','asc')->get()->take(5); //primeros 5 clientes
        return view('livewire.pedidos.component', ['menus' => $menus, 'pedidos' => $pedidos]) ->layout('layouts.theme.app');;
    }


    public function setTabActive($tabName)
    {
        if ($tabName == 'tabProducts') {
            $this->tabProducts = true;
            $this->tabCategories = false;
            $this->tabDiario = false;
        }
        elseif($tabName == 'tabDiario')
        {

            $this->tabProducts = false;
            $this->tabCategories = false;
            $this->tabDiario = true;

        }
        else{
            $this->tabProducts = false;
            $this->showListProducts = false;
            $this->tabDiario = false;
            $this->tabCategories = true;
        }
    }


    public function noty($msg, $eventName= 'noty', )
    {
        $this->dispatchBrowserEvent($eventName, ['msg' => $msg, 'type' => 'success']);
    }

     public function add2Cart(Menu $menu)
    {

       $this->addMenuCart($menu, 1, $this->changes);
       $this->changes = '';
       //$this->subTotSinImpuesto = $this->subTotSinImpuesto + $product->price;
       //dd($this->subTotSinImpuesto);
    }
    public function increaseQty(Menu $menu, $cant=1)
    {
        $this->updateQtyCart($menu, $cant);
    }

    public function decreaseQty($menu_id)
    {
        $this->decreaseQtyCart($menu_id);
    }

    public function removeFromCart($id)
    {
        $this->removeMenuCart($id);
    }

    public function updateQty(Menu $product, $cant=1)
    {
        //para validar si hay las suficientes existencias en bbd y poder vender
        if($cant  + $this->countInCart($product->id) > $product->stock){
            $this->noty('STOCK INSUFICIENTE','noty','error');
            return;
        }
        if ($cant <= 0)
            $this->removeProductCart($product->id);
        else
            $this->replaceQuantityCart($product->id, $cant);
    }
    // para los cambios en el modal
    public function removeChanges()
    {
        $this->clearChanges($this->productIdSelected);
        $this->dispatchBrowserEvent('close-modal-changes'); // evento que va al front para cerrar el modal (a traves de JS)

    }

    public function addChanges($changes)
    {
        $this->addChanges2Product($this->productIdSelected, $changes);
        $this->dispatchBrowserEvent('close-modal-changes');
    }


    public function updatedCustomerSelected()
    {
        $this->dispatchBrowserEvent('close-customer-modal');
    }

    public function searchManualProduct(Menu $menu)
    {
        //dd($id);
        $this->add2Cart($menu);
        $this->dispatchBrowserEvent('close-product-modal');
        //$this->resetUI();

    }

    public function resetUI()
    {
        // $this->reset('tabProducts', 'cash', 'showListProducts', 'tabCategories', 'search', 'searchCustomer',
        // 'searchMenu', 'customer_id', 'customerSelected', 'totalCart', 'itemsCart',
        // 'menuIdSelected', 'productChangesSelected', 'productNameSelected', 'changesProduct');

        $this->reset('showListProducts','tabProducts','tabCategories','search','cash','searchCustomer',
                    'searchMenu','customer_id','changes','customerSelected','menuSelected','menusList',
                    'customers','totalCart','itemsCart','contentCart','menuIdSelected','menuChangesSelected',
                    'menuNameSelected','changesMenu','tabDiario'
            );
    }

    // SAVE SALE //
    public function storeSale($print = false)
    {
        //**********  validamos que haya productos  en la venta */
        if ($this->getTotalCart() <= 0) {
            $this->noty('AGREGA PRODUCTOS A LA VENTA', 'noty', 'error');
            return;
        }


        DB::beginTransaction();

        try {

            // si no se escige cliente , va consumidor final

            if ($this->customerSelected !=  'Seleccionar Cliente') {
                $this->customer_id = Customer::where('businame', $this->customerSelected)->first()->id;
            } else{
                $this->customer_id = Customer::where('businame', 'consumidor final')->first()->id;
            }
                //dd($this->customer_id);

            //**********  se graba primero la venta */
            $pedido = Pedido::create([
                'total' => $this->getTotalCart(),
                'items' => $this->getItemsCart(),
                'descuento' => 0,
                'estado' => 'Pendiente',
                'fechapedido' => $this->fechaPedido,
                'user_id' => Auth()->user()->id,
                'customer_id' =>  $this->customer_id
            ]);

            //**********  si hay venta se guarda detalle venta */
            if ($pedido) {
                $items = $this->getContentCart();
                //dd($items);
                foreach ($items as  $menu) {
                    DetallePedido::create([
                        'pedido_id' => $pedido->id,  //pedido id
                        'menu_id' => $menu->id, // menu
                        'cantidad' => $menu->qty,  //menu
                        'precio' => $menu->precio  //menu
                    ]);

                    //**********  actualizamos stock */
                    // $product = Product::find($item->id);
                    // $product->stock = $product->stock - $item->qty;
                    // $product->save();
                }
            }


            DB::commit();
            $this->clearCart();
            $this->resetUI();

            //if ($print) $this->PrintTicket($sale->id);

            $this->noty('VENTA REGISTRADA CON EXITO');


        } catch (\Throwable $e) {
            DB::rollback();
            $this->noty('Error al guardar el pedido: ' . $e->getMessage(), 'noty', 'error');
        }
    }


    public  function Edit(Pedido $pedido){
        $pedido->estado = 'Despachado';
        $pedido->save();
        $this->noty('PEDIDO DESPACHADO');
    }

    public function Destroy(Pedido $pedido)
    {
        $pedido->delete();
        $this->noty('Se eliminó el pedido');
    }


    public $listeners = ['cancelSale', 'Destroy'];

    public function cancelSale()
    {
        $this->clearCart();
        $this->resetUI();
        $this->noty('PEDIDO CANCELADO');
    }

}
