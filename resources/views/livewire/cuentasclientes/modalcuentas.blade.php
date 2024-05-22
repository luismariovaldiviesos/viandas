<div wire:ignore.self id="modalPendientes" class="modal" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">
                    <b class="text-theme-1">Pendientes   {{$customer}}</b>
                </h2>
            </div>

            <div class="modal-body grid gap-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5" id="striped-rows-table">
                            <div class="preview">
                                <div class="overflow-x-auto">
                                    <table class="table">
                                        <thead>
                                            <tr class="text-theme-6">
                                                 <th class="border-b-2 dark:border-dark-5 whitespace-nowrap font-bold">fecha pedido</th>
                                                 <th class="border-b-2 dark:border-dark-5 whitespace-nowrap font-bold">detalle</th>
                                                 <th class="border-b-2 dark:border-dark-5 whitespace-nowrap font-bold">total</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @forelse($pendientes as $pendiente)
                                            <tr class="dark:bg-dark-1 text-lg {{$loop->index % 2 > 0 ? 'bg-gray-200' : ''}}">
                                                <td class="border-b dark:border-dark-5 ">
                                                    {{ $pendiente->fechapedido }}
                                                </td>
                                                <td>
                                                    @foreach ($pendiente->detalles  as $detalle )
                                                    <h6 class="mb-1 font-medium">{{ $detalle->menu->base }}</h6>
                                                @endforeach
                                                </td>
                                                <td>
                                                    {{ $pendiente->total }}
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">NO HAY CLIENTES REGISTRADOS</td>
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
                <button onclick="closeModal()" class="btn btn-outline-secondary mr-5">Cerrar Ventana</button>
            </div>

        </div>
    </div>
</div>
