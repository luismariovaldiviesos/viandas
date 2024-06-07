{{-- <div wire:ignore.self id="modalUsuario" class="modal" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
             <div class="modal-body grid gap-4">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="p-5" id="striped-rows-table">
                            <div class="preview">
                                <div class="overflow-x-auto">
                                    <table class="table">
                                        <thead>
                                            <tr class="text-theme-1">
                                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap" >fecha pago</th>
                                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap" >total pagado</th>
                                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap" >forma de pago</th>
                                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap" >docuemneto</th>
                                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap" >period</th>
                                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap text-center" >ACCIONES</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pagos as $pago)

                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer text-right">
                <button onclick="closeModalUsuario()" class="btn btn-outline-secondary mr-5">Cerrar Ventana</button>
            </div>

        </div>
    </div>
</div> --}}

<div wire:ignore.self id="modalUsuario" class="modal fade" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body grid gap-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5" id="striped-rows-table">
                            <div class="preview">
                                <div class="overflow-x-auto">
                                    <table class="table">
                                        <h3 class="text-xl font-bold text-red-600">{{ $customer->businame }}</h3>
                                        {{-- <h3 class="text-xl font-bold text-red-600">Saldo pendiente: ${{ $totalPendientes }}</h3> --}}
                                        <thead>
                                            <tr class="text-theme-6">
                                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap font-bold">Fecha Pago</th>
                                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap font-bold">Total</th>
                                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap font-bold">Forma</th>
                                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap font-bold">Documento</th>
                                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap font-bold">Periodo</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cliente->pagos as  $pago )
                                            <tr class="dark:bg-dark-1 text-lg {{$loop->index % 2 > 0 ? 'bg-gray-200' : ''}}">
                                                <td class="border-b dark:border-dark-5 ">
                                                    {{ \Carbon\Carbon::parse($pago->fechapago)->isoFormat('LL') }}
                                                </td>
                                                <td class="border-b dark:border-dark-5 ">
                                                    {{ $pago->totalpago }}
                                                </td>
                                            </tr>
                                            @endforeach

                                        </tbody>

                                        <div class="p-5 ">
                                            <div class="preview">


                                            </div>
                                        </div>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <div class="modal-footer text-right">
                <button onclick="closeModalUsuario()" class="btn btn-outline-secondary mr-5">Cerrar Ventana</button>
            </div>
        </div>


    </div>
    <script>



    </script>
</div>

