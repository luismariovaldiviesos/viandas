<div>


    <div class="intro-y col-span-12">

        <div class="intro-y box">

        <h2 class="text-lg font-medium text-center text-them-1 py-4">
            {{ $componentName }}
        </h2>

        {{-- AQUI LLAMAMOS AL COMPONENTE SEARH --}}
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2 p-4">



            <div class="hidden md:block mx-auto text-gray-600 "></div>

            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml:0">
                <div class="relative text-gray-700 dark:text-gray-300">
                    <input wire:model="search" id="search" type="text" class="form-control box placeholder-theme-13 kioskboard w-full sm:w-auto"
                    placeholder="Buscar...">
                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 rigth-0 fas fa-search"></i>
                </div>
            </div>

        </div>
        {{-- AQUI LLAMAMOS AL COMPONENTE SEARH --}}

        <div class="p-5">
            <div class="preview">
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr class="text-theme-1">
                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap" >NOMBRE</th>
                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap" >TELEFONO</th>
                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap" >EMAIL</th>
                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap" >TOTAL</th>
                                {{-- <th class="border-b-2 dark:border-dark-5 whitespace-nowrap" >id</th> --}}
                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap text-center" >ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pedidos as $pedido )
                                <tr class=" dark:bg-dark-1 {{ $loop->index % 2> 0 ? 'bg-gray-200' : '' }}">

                                    <td class="dark:border-dark-5">
                                        <h6 class="mb-1 font-medium">{{ $pedido->cliente }}</h6>
                                    </td>
                                    <td class="dark:border-dark-5">
                                        <h6 class="mb-1 font-medium">{{ $pedido->telefono }}</h6>
                                    </td>
                                    <td class="dark:border-dark-5">
                                        <h6 class="mb-1 font-medium">{{ $pedido->mail }}</h6>
                                    </td>
                                    <td class="dark:border-dark-5">
                                        <h6 class="mb-1 font-medium">{{ $pedido->total_sum }}</h6>
                                    </td>
                                    {{-- <td class="dark:border-dark-5">
                                        <h6 class="mb-1 font-medium">{{ $pedido->id_cliente }}</h6>
                                    </td> --}}




                                    <td class="dark:border-dark-5 text-center">
                                        <div class="d-flex justify-content-center">

                                            <a href="javascript:void(0)"
                                            wire:click="Edit({{$pedido->id_cliente}})"
                                            class="btn btn-dark mtmobile" title="Detalle">
                                                {{-- <i class="fas fa-list"></i> --}}
                                                <small>Detalle pedidos</small>
                                            </a>
                                            {{-- @if ($customer->orders->count() < 1) --}}

                                            {{-- @endif --}}


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

        <div class="col-spam-12 p-5">
            {{-- {{ $customers->links() }} --}}
        </div>
        </div>
         @include('livewire.cuentasclientes.modalcuentas')
         @include('livewire.cuentasclientes.modalpagar')
    </div>


     <script>

        window.addEventListener('open-modal-pendientes', event => {
            //alert('cttm');
            openModalPendientes()
        })
        window.addEventListener('open-modal-pagar', event => {
            //alert('cttm');
            openModalPagar()
        })
        window.addEventListener('close-modal-pagar', event => {
            //alert('cttm');
            closeModalPagar()
        })

        window.addEventListener('close-modal-cuentas', event => {
            //alert('cttm');
            closeModal()
        })



        function openModalPendientes() {
                var modal = document.getElementById("modalPendientes")
                modal.classList.add("overflow-y-auto", "show")
                modal.style.cssText = "margin-top: 0px; margin-left: -100px;  z-index: 1000;"
        }
        function openModalPagar() {
                var modal = document.getElementById("modalPagar")
                modal.classList.add("overflow-y-auto", "show")
                modal.style.cssText = "margin-top: 0px; margin-left: -100px;  z-index: 1000;"
        }

        function closeModal() {
                var modal = document.getElementById("modalPendientes")
                modal.classList.remove("overflow-y-auto", "show")
                modal.style.cssText = ""
            }

            function closeModalPagar() {
                var modal = document.getElementById("modalPagar")
                modal.classList.remove("overflow-y-auto", "show")
                modal.style.cssText = ""
            }







        </script>

</div>

