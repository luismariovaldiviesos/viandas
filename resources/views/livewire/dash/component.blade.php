<div>

    <div class="intro-y grid grid-cols-12 gap-6 mt-5">
        <div class="col-span-12 md:col-span-3">
            <div class="intro-y box">
                <h6 class="text-center font-bold">Elige el Año de Consulta</h6>
                <select wire:model="year" class="form-select form-select-lg">
                    @foreach($listYears as $y)
                    <option value="{{$y}}">{{$y}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="intro-y grid grid-cols-12 pt-5">
        <div class="col-span-12 ">
            <div class="intro-y box ">
                <h4 class="p-3 text-center text-theme-1 font-bold"> PEDIDOS DE HOY {{$dia}}</h4>
                <div id="">
                    <table class="table">
                        <thead>
                            <tr class="text-theme-1">
                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap" >NOMBRE</th>
                                 <th class="border-b-2 dark:border-dark-5 whitespace-nowrap" >DETALLE PEDIDO</th>
                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap" >CANTIDAD</th>
                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap" >TOTAL</th>
                               <th class="border-b-2 dark:border-dark-5 whitespace-nowrap" >PRECIO</th>
                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap text-center" >ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @forelse ($pedidos as $pedido )
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

                                    <td class="dark:border-dark-5 text-center">
                                        <div class="d-flex justify-content-center">
                                                <button class="btn btn-danger text-white border-0"
                                                onclick="destroy('dashboard','Destroy', {{ $pedido->id }})"
                                                type="button">
                                                    <i class=" fas fa-trash f-2x"></i>
                                                </button>

                                            <button class="btn btn-warning text-white border-0 ml-3"
                                                wire:click.prevent="Edit({{ $pedido->id }})"
                                                type="button">
                                                    <i class=" fas fa-edit f-2x"></i>
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
                            @endforelse --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="intro-y grid grid-cols-12 gap-6 mt-5">


        <div class="col-span-12 lg:col-span-6">
            <div class="intro-y box">
                <h4 class="p-3 text-center text-theme-1 font-bold">TOP 5 MAS VENDIDOS</h4>
                <div id="chartTop5">
                </div>
            </div>
        </div>

        <div class="col-span-12 lg:col-span-6">
            <div class="intro-y box ">
                <h4 class="p-3 text-center text-theme-1 font-bold">VENTAS DE LA SEMANA</h4>
                <div id="chartArea">
                </div>
            </div>
        </div>

    </div>

    <div class="intro-y grid grid-cols-12 pt-5">
        <div class="col-span-12 ">
            <div class="intro-y box ">
                <h4 class="p-3 text-center text-theme-1 font-bold"> VENTAS ANUALES {{$year}}</h4>
                <div id="chartMonth">
                </div>
            </div>
        </div>
    </div>

    @include('livewire.dash.scripts')

</div>
