<div wire:ignore.self id="modalPendientes" class="modal fade" data-backdrop="static" tabindex="-1">
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
                                        <h3 class="text-xl font-bold text-red-600">{{ $customer }}</h3>
                                        <h3 class="text-xl font-bold text-red-600">Saldo pendiente: ${{ $totalPendientes }}</h3>
                                        <thead>
                                            <tr class="text-theme-6">
                                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap font-bold">Fecha Pedido</th>
                                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap font-bold">Detalle</th>
                                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap font-bold">Total</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($pendientes as $pendiente)
                                            <tr class="dark:bg-dark-1 text-lg {{$loop->index % 2 > 0 ? 'bg-gray-200' : ''}}">
                                                <td class="border-b dark:border-dark-5 ">
                                                    {{ \Carbon\Carbon::parse($pendiente->fechapedido)->isoFormat('LL') }}
                                                </td>
                                                <td>
                                                    @foreach ($pendiente->detalles as $detalle)
                                                    <h6 class="mb-1 font-medium">{{ $detalle->menu->base }}</h6>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    {{ $pendiente->total }}
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="3" class="text-center">NO HAY CLIENTES REGISTRADOS</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                      </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer text-right">
                <button onclick="closeModal()" class="btn btn-primary mr-5">Cerrar Ventana</button>
                <button class="btn btn-warning text-white border-0 ml-3"
                wire:click="Pagar()"
                type="button">
                   Cancelar Saldos
                </button>

            </div>

        </div>
    </div>
</div>


