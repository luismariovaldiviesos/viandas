<div wire:ignore.self id="modalPagar" class="modal fade" data-backdrop="static" tabindex="-1">
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

                                        <h3 class="text-xl font-bold text-red-600">{{ $customer }}</h3>
                                        <h3 class="text-xl font-bold text-red-600">Saldo pendiente: ${{ $totalPendientes }}</h3>

                                        <div class="p-5 ">
                                            <div class="preview">
                                                <div class="mt-4">

                                                    <div class="input-group">
                                                        <div class="input-group-text">Forma de pago</div>
                                                        <select wire:model='fpago' class="form-select form-select-lg sm:mr-2" name="" id="">
                                                            <option value="efectivo">Efectivo</option>
                                                            <option value="transferencia">Transferencia</option>
                                                        </select>
                                                    </div>
                                                    @error('fpago')
                                                    <x-alert msg="{{ $message  }}" />
                                                    @enderror
                                                </div>

                                                @if ($fpago == 'transferencia')
                                                <div class="mt-3">
                                                    <label class="form-label">Documento transferencia</label>
                                                    <input type="file"
                                                    wire:model='dtransferencia'
                                                    accept="image/x-png,image/jpeg,image/jpg"
                                                    class="form-control">
                                                </div>
                                                @endif



                                            </div>
                                        </div>


                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer text-right">
                <button onclick="closeModal()" class="btn btn-primary mr-5">Cerrar Ventana</button>
                <button class="btn btn-warning text-white border-0 ml-3"
                wire:click="CancelaSaldos()"
                type="button">
                   Pagar
                </button>

            </div>

        </div>
    </div>
</div>
