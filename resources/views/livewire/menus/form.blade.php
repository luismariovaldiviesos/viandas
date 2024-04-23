<div class="intro-y col-span-12">
    <div class="intro-y box">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">
                {{ $componentName  }} | <span class="font-normal">{{ $action }}</span>
            </h2>
        </div>

        <div class="p-12 ">
            <div class="preview">
                <h2 class="text-2xl text-center mb-3">Armar Menú</h2>
                <div x-data="{}" x-init="setTimeout(() => { refs.first.focus() }, 900  )">
                    <td class="dark:border-dark-5 text-center">
                        <div class="d-flex justify-content-center">
                            @error('entrada_id')
                            <x-alert msg="{{ $message }}" />
                            @enderror
                           <button onclick="openModalEntrada()" class="btn btn-danger w-full mb-3">
                                {{$entradaSelected}}
                            </button>
                            @if ($entradaSelected != 'Seleccionar entrada')
                                <button
                                    wire:click.prevent="agregaComponenteMenu()"
                                    type="button">
                                </button>
                            @endif
                        </div>
                    </td>
                </div>


                <div x-data="{}" x-init="setTimeout(() => { refs.first.focus() }, 900  )">
                    <td class="dark:border-dark-5 text-center">
                        <div class="d-flex justify-content-center">
                            @error('pp_id')
                            <x-alert msg="{{ $message }}" />
                            @enderror
                           <button onclick="openModalPP()" class="btn btn-warning w-full mb-3">
                                {{$ppSelected}}
                            </button>
                            @if ($ppSelected != 'Seleccionar Plato Principal')
                                <button
                                    wire:click.prevent="agregaComponenteMenu()"
                                    type="button">
                                </button>
                            @endif
                        </div>
                    </td>
                </div>


                <div x-data="{}" x-init="setTimeout(() => { refs.first.focus() }, 900  )">
                    <td class="dark:border-dark-5 text-center">
                        <div class="d-flex justify-content-center">
                                @error('postre_id')
                                <x-alert msg="{{ $message }}" />
                                @enderror
                            <button onclick="openModalPostre()" class="btn btn-dark w-full mb-3">
                                    {{$postreSelected}}
                                </button>
                            @if ($postreSelected != 'Seleccionar Postre')
                                <button
                                    wire:click.prevent="agregaComponenteMenu()"
                                    type="button">
                                </button>
                            @endif
                        </div>
                    </td>
                </div>

                {{-- <div>
                    <h2 class="text-2xl text-center mb-3">BASE</h2>
                    <input wire:model='base' id="base" type="button" data-kioskboard-type="numpad"
                    class="btn btn-primary w-full mb-3" readonly {{ $ppSelected }}>
                    @error('base')
                        <x-alert msg="{{ $message }}" />
                    @enderror
                </div> --}}

                {{-- <div>
                    <label  class="form-label">PRECIO MENÚ</label>
                    <input wire:model='precio' class="form-control form-control-m border-start-0 kioskboard" maxlength="250">
                    @error('precio')
                        <x-alert msg="{{ $message }}" />
                    @enderror
                </div> --}}



                <div class="mt-5">

                    {{-- COMPONENTES DE BLADE PARA GUARDAR Y VOLVER --}}
                    <x-back />

                    <x-save />
                </div>

            </div>
        </div>

    </div>


    <script>
        // KioskBoard.run('#categoryName', {})
        // const inputCatName = document.getElementById('categoryName')
        // if(inputCatName){
        //     inputCatName.addEventListener('change', ()=> {
        //         @this.descripcion = e.target.value
        //     })
        // }
    </script>

</div>
