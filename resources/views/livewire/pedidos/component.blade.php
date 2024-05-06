
 <div class="pos intro-y grid grid-cols-12 gap-5 mt-5">
        <div class="intro-y col-span-12 lg:col-span-9">

            <div class="post intro-y overflow-hidden box">
                <div class="post__tabs nav nav-tabs flex-col sm:flex-row bg-gray-300 dark:bg-dark-2 text-gray-600" role="tablist">

                    <a wire:click="setTabActive('tabProducts')"
                    title="Productos Agregados"
                    data-toggle="tab"
                    data-target="#tabProducts"
                    href="javascript:;"
                    class="tooltip w-full sm:w-40 py-4 text-center flex justify-center items-center {{$tabProducts ? 'active' : '' }}"
                    id="content-tab"
                    role="tab" >
                    <i class="fas fa-list mr-2"></i> DETALLE DE VENTA
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

                    <a wire:click="setTabActive('tabExtras')"
                    title="Seleccionar Extra"
                    data-toggle="tab" data-target="#tabExtras"
                    href="javascript:;"
                    class="tooltip w-full sm:w-40 py-4 text-center flex justify-center items-center {{$tabExtras ? 'active' : '' }}"
                    id="meta-title-tab" role="tab" aria-selected="false">
                    <i class="fas fa-th-large mr-2"></i> EXTRAS {{ $tabExtras }}
                    </a>
               </div>

                <div class="post__content tab-content">
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

                                                {{-- iva --}}

                                                {{-- <td class="border-b dark:border-dark-5 text-center">{{number_format($item->iva,2)}}</td> --}}
                                                {{-- FIN iva --}}
                                                 {{-- ICE --}}

                                                 {{-- <td class="border-b dark:border-dark-5 text-center">{{ number_format($item->ice,2) }}</td> --}}
                                                 {{-- FIN ICE --}}

                                                     {{-- DESCUENTO --}}

                                                     {{-- <td class="border-b dark:border-dark-5 text-center">%{{ number_format(  $item->descuento) }}</td> --}}
                                                     {{-- FIN DESCUENTO --}}

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
                                         <h1 class="text-center">CONFIGURAR MENU DEL DIA</h1>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                {{-- FIN MENUS --}}



                 {{-- EXTRAS --}}

                 <div id="tabExtras" class="tab-pane  {{$tabExtras ? 'active' : '' }}" role="tabpanel" aria-labelledby="content-tab">
                    @if ($tabExtras)
                        <div class="intro-y grid grid-cols-12 gap-3 sm:gap-4 mt-2">
                             nos quedamos aqui
                        </div>
                    @endif
                 </div>

                 {{-- FIN EXTRAS --}}



            </div>

        </div>
    <!-- END: Post Content -->
    <!-- BEGIN: Post Info -->
        <div class="col-span-12 lg:col-span-3">
            <div class="intro-y box p-5">
                <div>
                    <h2 class="text-2xl text-center mb-3">Resumen de Venta</h2>

                    <button onclick="openModalCustomer()" class="btn btn-outline-dark w-full mb-3">{{$customerSelected}}</button>
                    <button onclick="openModalProduct()" class="btn btn-outline-dark w-full mb-3">{{$menuSelected}}</button>


                </div>
                <div class="mt-3">
                    <h1 class="text-2x1 font-bold">ITEMS</h1>
                    <h4 class="text-2x5">{{$itemsCart}}</h4>
                </div>
                <div class="mt-3">
                    <h1 class="text-2x1 font-bold">SUBTOTAL</h1>
                    <h4 class="text-2x1">${{number_format($this->subTotSinImpuesto,2)}}</h4>
                </div>
                {{-- <div class="mt-3">
                    <h1 class="text-2x1 font-bold"> sub total TARIFA 12</h1>
                    <h4 class="text-2x1"> ${{number_format($this->iva12,2)}}</h4>
                </div>
                <div class="mt-3">
                    <h1 class="text-2x1 font-bold">sub total TARIFA 0</h1>
                    <h4 class="text-2x1"> ${{number_format($this->iva0,2)}}</h4>
                </div>
                <div class="mt-3">
                    <h1 class="text-2x1 font-bold">TOTAL descuento</h1>
                    <h3 class="text-2x1">${{number_format($this->totalDscto,2)}}</h3>
                </div>
                <div class="mt-3">
                    <h1 class="text-2x1 font-bold">ICE</h1>
                    <h4 class="text-2x1"> ${{number_format($this->totalIce,2)}}</h4>
                </div>
                <div class="mt-3">
                    <h1 class="text-2x1 font-bold">12 % IVA</h1>
                    <h4 class="text-2x1"> ${{number_format($this->totalImpuesto12,2)}}</h4>
                </div> --}}
                <div class="mt-3">
                    <h1 class="text-2x1 font-bold">TOTAL</h1>
                    <h3 class="text-2x1">${{number_format($totalCart,2)}}</h3>
                </div>

                <div class="mt-6">
                    <div class="input-group">
                        <div id="input-group-3" class="input-group-text"><i class="fas fa-dollar-sign fa-2x"></i></div>
                        <input wire:model="cash" id="cash" type="number" data-kioskboard-type="numpad"  class="form-control form-control-lg kioskboard" placeholder="0.00">
                    </div>
                    <h1>Ingresar el Efectivo</h1>
                </div>
                <div class="mt-8">
                    @if($totalCart > 0 && ($cash >= $totalCart))
                        {{-- <button wire:loading.attr="disabled" wire:target="storeSale" wire:click.prevent="storeSale" class="btn btn-primary w-full"><i class="fas fa-database mr-2"></i> Guardar Venta</button> --}}
                        <button wire:loading.attr="disabled" wire:target="storeSale" wire:click.prevent="storeSale(true)" class="btn btn-outline-primary w-full mt-5"><i class="fas fa-receipt mr-2"></i> Guardar e Imprimir</button>
                    @endif

                    @if($totalCart >0)
                        <button onclick="Cancel()" class="btn btn-danger w-full mt-5">
                        <i class="fas fa-trash mr-2"> </i>
                        Cancelar Venta</button>
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


