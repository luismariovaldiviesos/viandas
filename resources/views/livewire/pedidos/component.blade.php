
 <div class="pos intro-y grid grid-cols-12 gap-5 mt-5">
        <div class="intro-y col-span-12 lg:col-span-9">

            <div class="post intro-y overflow-hidden box">
                <div class="post__tabs nav nav-tabs flex-col sm:flex-row bg-gray-300 dark:bg-dark-2 text-gray-600" role="tablist">



                    <a wire:click="setTabActive('tabDiario')"
                    title="Seleccionar Extra"
                    data-toggle="tab" data-target="#tabExtras"
                    href="javascript:;"
                    class="tooltip w-full sm:w-40 py-4 text-center flex justify-center items-center {{$tabDiario ? 'active' : '' }}"
                    id="meta-title-tab" role="tab" aria-selected="false">
                    <i class="fas fa-th-large mr-2"></i>PEDIDOS HOY
                    </a>

                    <a wire:click="setTabActive('tabProducts')"
                    title="Productos Agregados"
                    data-toggle="tab"
                    data-target="#tabProducts"
                    href="javascript:;"
                    class="tooltip w-full sm:w-40 py-4 text-center flex justify-center items-center {{$tabProducts ? 'active' : '' }}"
                    id="content-tab"
                    role="tab" >
                    <i class="fas fa-list mr-2"></i> DETALLE PEDIDO
                    </a>

                    <a wire:click="setTabActive('tabCategories')"
                    title="Seleccionar Categoría"
                    data-toggle="tab"
                    data-target="#tabCategory"
                    href="javascript:;"
                    class="tooltip w-full sm:w-40 py-4 text-center flex justify-center items-center {{$tabCategories ? 'active' : '' }}"
                    id="meta-title-tab" role="tab" aria-selected="false">
                        <i class="fas fa-th-large mr-2"></i> MENUS
                    </a>



               </div>

                <div class="post__content tab-content">

                    <div id="tabDiario" class="tab-pane {{$tabDiario ? 'active' : '' }}" role="tabpanel" aria-labelledby="content-tab">
                        <div class="p-5" id="striped-rows-table">
                            <div class="preview">
                                <div class="overflow-x-auto">
                                    <table class="table">
                                        <thead>
                                            <tr class="text-theme-1">
                                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap" >NOMBRE</th>
                                                 <th class="border-b-2 dark:border-dark-5 whitespace-nowrap" >DETALLE PEDIDO</th>
                                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap" >CANTIDAD</th>
                                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap" >TOTAL</th>
                                               <th class="border-b-2 dark:border-dark-5 whitespace-nowrap" >PRECIO</th>
                                               <th class="border-b-2 dark:border-dark-5 whitespace-nowrap" >DESPACHO</th>
                                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap text-center" >ACCIONES</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($pedidos as $pedido )
                                                <tr class=" dark:bg-dark-1 {{ $loop->index % 2> 0 ? 'bg-gray-200' : '' }}">

                                                    <td class="dark:border-dark-5">
                                                        <h6 class="mb-1 font-medium">{{ $pedido->customer->businame }}</h6>
                                                    </td>
                                                     <td class="dark:border-dark-5">
                                                        @foreach ($pedido->detalles  as $detalle )
                                                            <h6 class="mb-1 font-medium">{{ $detalle->menu->base }}</h6>
                                                        @endforeach
                                                    </td>
                                                   <td class="dark:border-dark-5">
                                                        @foreach ($pedido->detalles  as $detalle )
                                                            <h6 class="mb-1 font-medium">{{ $detalle->cantidad }}</h6>
                                                         @endforeach
                                                    </td>
                                                     <td class="dark:border-dark-5">
                                                        <h6 class="mb-1 font-medium">{{ $pedido->items }}</h6>
                                                    </td>
                                                   <td class="dark:border-dark-5">
                                                        <h6 class="mb-1 font-medium">{{ $pedido->total }}</h6>
                                                    </td>
                                                    <td class="dark:border-dark-5">
                                                        <h6 class="mb-1 font-medium">{{ $pedido->estado }}</h6>
                                                    </td>

                                                    <td class="dark:border-dark-5 text-center">
                                                        <div class="d-flex justify-content-center">
                                                                <button class="btn btn-danger text-white border-0"
                                                                onclick="destroy('pedidos','Destroy', {{ $pedido->id }})"
                                                                type="button">
                                                                    <i class=" fas fa-trash f-2x"></i>
                                                                </button>

                                                                <button class="btn btn-warning text-white border-0 ml-3"
                                                                wire:click.prevent="Edit({{ $pedido->id }})"
                                                                type="button">

                                                                    <small>despachar</small>
                                                                </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr class="bg-gray-200 dark:bg-dark-1">
                                                    <td colspan="2">
                                                        <h6 class="text-center">    NO HAY CLIENTES  </h6>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>



                    {{-- PEDIDOS --}}
                    <div id="tabProducts" class="tab-pane {{$tabProducts ? 'active' : '' }}" role="tabpanel" aria-labelledby="content-tab">
                        <div class="p-5" id="striped-rows-table">
                            <div class="preview">
                                <div class="overflow-x-auto">
                                    <table class="table">
                                        <thead>
                                            <tr class="text-theme-6">
                                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap font-bold text-center" width="15%">CANT</th>
                                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap font-bold" width="60%">MENU</th>
                                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap font-bold">P. UNITARIO</th>
                                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap font-bold">SUBTOTAL</th>

                                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap font-bold"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($contentCart as $item)
                                            <tr class="bg-gray-200 dark:bg-dark-1 text-lg">


                                                {{-- CANTIDAD --}}

                                                <td class="border-b dark:border-dark-5 text-center">
                                                    <div class="input-group mt-2">
                                                        <input wire:keydown.enter="updateQty({{$item->id}}, $event.target.value )"
                                                        {{-- data-type qty es para que se active el teclado tactil en la cantidad
                                                        el evento esta en el archivo scripts de sales  --}}
                                                        data-type="qty"
                                                        value="{{$item->qty}}" data-kioskboard-type="numpad" data-type="qty" type="text" class="form-control text-center kioskboard" id="r{{$item->id}}">
                                                        <div wire:click="updateQty({{$item->id}}, document.getElementById('r'+ {{$item->id}} ).value )" class="input-group-text {{$item->livestock > 0 ? '' : 'hidden'}} ">
                                                            <i class="fas fa-redo fa-lg"></i>
                                                        </div>
                                                    </div>
                                                    {{-- <div><small class="text-xs text-theme-1">{{$item->livestock}}</small></div> --}}
                                                </td>

                                                   {{--  FIN CANTIDAD --}}

                                                      {{-- DESCRIPCION --}}
                                                    <td class="border-b dark:border-dark-5 ">
                                                        <button onclick="openModal({{$item->id}},'{{$item->changes}}','{{$item->name}}')" class="btn btn-outline-secondary text-theme-1">{{$item->base}}</button>
                                                        <div>
                                                            <small>{{$item->changes}}</small>
                                                        </div>
                                                    </td>

                                                   {{-- FIN DESCRIPCION  --}}

                                                   {{-- PRECIO UNITARIO  --}}

                                                <td class="border-b dark:border-dark-5 text-center">{{number_format($item->precio,2)}}</td>

                                                {{-- FIN PRECIO UNITARIO  --}}



                                                  {{-- TOTAL --}}
                                                <td class="border-b dark:border-dark-5 text-center">
                                                {{number_format($item->precio * $item->qty,2)}}
                                                {{-- <small>{{$this->subTotSinImpuesto}}</small> --}}
                                                </td>
                                                  {{-- FIN TOTAL --}}
                                                <td>
                                                    <div class="inline-flex" role="group" style="font-size: 1.6em!important;">
                                                        <button  wire:click.prevent="removeFromCart({{$item->id}})" class=" btn btn-danger"><i class="fas fa-trash "></i></button>
                                                        <button  wire:click.prevent="decreaseQty({{$item->id}})" class="btn btn-warning ml-4"><i class="fas fa-minus "></i></button>
                                                        <button  wire:click.prevent="increaseQty({{$item->id}})"
                                                        class="btn btn-success ml-4 " >
                                                        <i class="fas fa-plus"></i>
                                                        </button>


                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">AGREGA MENUS AL CARRITO</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                      {{-- FIN PEDIDOS --}}


                {{-- MENUS --}}
                <div id="tabCategory" class="tab-pane p-5 {{$tabCategories ? 'active' : '' }}" role="tabpanel" aria-labelledby="content-tab">
                        <div class="intro-y grid grid-cols-12 gap-3 sm:gap-4 mt-2">
                            @if(!$showListProducts)
                                @if (count($menus) > 0)
                                    @foreach ($menus as $menu )
                                    <div class="intro-y col-span-6 sm:col-span-4 md:col-span-3 xxl:col-span-2">
                                        <div wire:click="add2Cart({{$menu->id}})" class="file box rounded-md p-5 relative zoom-in">

                                            <a href="javascript:;" class="block font-medium text-center">{{$menu->base}}</a>

                                        </div>
                                    </div>
                                    @endforeach
                                    @else  {{-- Si no hay elementos, muestra este mensaje --}}
                                    <div class="intro-y col-span-6 sm:col-span-4 md:col-span-3 xxl:col-span-2">
                                        <div class="file box rounded-md px-5 pt-8 pb-5 px-3 sm:px-5 relative zoom-in">
                                            <a href="{{ route('menus') }}" class="block font-medium text-center">CONFIGURAR MENÚ DIA</a>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>






            </div>

        </div>
    <!-- END: Post Content -->
    <!-- BEGIN: Post Info -->
        <div class="col-span-12 lg:col-span-3">
            <div class="intro-y box p-5">
                @include('livewire.pedidos.fechas')
                <div>

                    <h2 class="text-2xl mb-3">Resumen del Pedido</h2>
                    <button onclick="openModalCustomer()" class="btn btn-outline-dark w-full mb-3">{{$customerSelected}}</button>
                    <button onclick="openModalProduct()" class="btn btn-outline-dark w-full mb-3">{{$menuSelected}}</button>


                </div>
                <div class="mt-3">
                    <h2 class="text-2xl  mb-3">ITEMS</h2>
                    <h2 class="text-2xl  mb-3">{{$itemsCart}}</h2>
                </div>


                <div class="mt-3">
                    <h2 class="text-2xl  mb-3">TOTAL</h2>
                    <h2 class="text-2xl  mb-3">${{number_format($totalCart,2)}}</h2>
                </div>
                <div class="mt-8">
                    @if($totalCart > 0 && ($fechaPedido != null) && ($customerSelected !="Seleccionar Cliente"))
                        {{-- <button wire:loading.attr="disabled" wire:target="storeSale" wire:click.prevent="storeSale" class="btn btn-primary w-full"><i class="fas fa-database mr-2"></i> Guardar Venta</button> --}}
                        <button wire:loading.attr="disabled" wire:target="storeSale" wire:click.prevent="storeSale(true)"
                         class="btn btn-outline-primary w-full mt-5"><i class="fas fa-receipt mr-2"></i> Guardar Pedido</button>
                    @endif

                    @if($totalCart >0)
                        <button onclick="Cancel()" class="btn btn-danger w-full mt-5">
                        <i class="fas fa-trash mr-2"> </i>
                        Cancelar Pedido</button>
                    @endif

                </div>

            </div>
        </div>
    <!-- END: Post Info -->
    @include('livewire.pedidos.modal-changes')
    @include('livewire.pedidos.modal-customers')
    @include('livewire.pedidos.modal-products')
    @include('livewire.pedidos.script')
    @include('livewire.pedidos.keyboard')

</div>


