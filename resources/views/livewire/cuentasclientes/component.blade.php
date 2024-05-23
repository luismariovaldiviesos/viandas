<div>


    <div class="intro-y col-span-12">

        <div class="intro-y box">

        <h2 class="text-lg font-medium text-center text-them-1 py-4">
            {{ $componentName }}
        </h2>

        {{-- AQUI LLAMAMOS AL COMPONENTE SEARH --}}
            <x-search />
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
                                            <button class="btn btn-danger text-white border-0" onclick="confirmPayment()" type="button">
                                                <small>Cancelar pedidos</small>
                                            </button>
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
    </div>


     <script>

        window.addEventListener('open-modal-pendientes', event => {
            //alert('cttm');
            openModalPendientes()
        })



        function openModalPendientes() {
                var modal = document.getElementById("modalPendientes")
                modal.classList.add("overflow-y-auto", "show")
                modal.style.cssText = "margin-top: 0px; margin-left: -100px;  z-index: 1000;"
        }

        function closeModal() {
                var modal = document.getElementById("modalPendientes")
                modal.classList.remove("overflow-y-auto", "show")
                modal.style.cssText = ""
            }



            function confirmPayment() {
                swal({
                    title: '¿DESEAS pagar las cuentas?',
                    text: "",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Eliminar',
                    confirmButtonColor: '#e7515a',
                    cancelButtonText: 'Cerrar',
                    padding: '2em'
                }).then(function(result) {
                    if (result.value) {
                        window.livewire.emit('cancelaPendientes')  // este evento se emite al back y ahi hay que escuchar
                        swal.close()
                    }
                })
	        }



        </script>

</div>

