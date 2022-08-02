<div class="intro-y col-span-12">
    <div class="intro-y box">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">
                {{ $componentName  }} | <span class="font-normal">{{ $action }}</span>
            </h2>
        </div>

        <div class="p-5 ">
            <div class="preview">
                <div x-data="{}" x-init="setTimeout(() => { refs.first.focus() }, 900  )">
                    <label class="form-label" >Nombre Caja</label>
                    <input type="text" wire:model="nombre" x-ref="first"
                    class="form-control kioskboard {{ $errors->first('nombre') ?  "border-theme-6" : "" }}"
                    placeholder="ingresa la descripción"
                    >
                    @error('nombre')
                        <x-alert msg="{{ $message }}" />
                    @enderror
                </div>

                <br>
                <div>
                    <label  class="form-label">Asignar usuario</label>
                    <select wire:model='user_id' id="user_id" class="form-control form-control-lg border-start-0 kioskboard">
                        <option selected>Elegir</option>
                            @foreach ($users as $user )
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                    </select>
                    @error('user_id')
                        <x-alert msg="{{ $message }}" />
                    @enderror
                </div>


                <div class="mt-5">

                    {{-- COMPONENTES DE BLADE PARA GUARDAR Y VOLVER --}}
                    <x-back />

                    <x-save />
                </div>

            </div>
        </div>

    </div>


    <script>
        KioskBoard.run('#categoryName', {})
        const inputCatName = document.getElementById('categoryName')
        if(inputCatName){
            inputCatName.addEventListener('change', ()=> {
                @this.name = e.target.value
            })
        }
    </script>

</div>
