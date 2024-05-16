{{-- <div>
    <form wire:submit.prevent="actualizarFecha">
        <label for="fechaPedido">Fecha del Pedido:</label>
        <input type="date" wire:model="fechaPedido" id="fechaPedido">
        <input type="checkbox" id="fechaActual" wire:model="fechaActual"> <label for="fechaActual">Fecha Actual</label>
        <input type="checkbox" id="fechaManana" wire:model="fechaManana"> <label for="fechaManana">Fecha de Mañana</label>
        <button type="submit">Guardar</button>
    </form>
</div> --}}

{{-- <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2 p-4">

    <button wire:click.prevent="$set('form',true)" class="btn btn-primary shadow-md mr-2 w-full sm:w-auto">Agregar</button>

    <div class="hidden md:block mx-auto text-gray-600 "></div>

    <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml:0">
        <div class="relative text-gray-700 dark:text-gray-300">
            <input wire:model="search" id="search" type="text" class="form-control box placeholder-theme-13 kioskboard w-full sm:w-auto"
            placeholder="Buscar...">
            <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 rigth-0 fas fa-search"></i>
        </div>
    </div>

</div> --}}
<div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml:0">
    <h2 class="text-2xl text-center mb-3">fecha pedido</h2>
    <label class="new-control new-checkbox checkbox-primary h5">
        {{-- {{ $hoy }}

        {{ $manana }}
        <input type="checkbox"
        wire:change="FechaHoy()"
        class="new-control-input"
        > --}}
        <button onclick="date()" class="btn btn-outline-dark w-full mb-3">{{$hoy}}</button>
        <button onclick="openModalProduct()" class="btn btn-outline-dark w-full mb-3">{{$manana}}</button>

    </label>

</div>
