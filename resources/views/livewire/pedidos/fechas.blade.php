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
{{-- <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml:0">
    <h2 class="text-2xl text-center mb-3">fecha pedido</h2>
    <label class="new-control new-checkbox checkbox-primary h5">
        <button onclick="date()" class="btn btn-outline-dark w-full mb-3">{{$hoy}}</button>
        <button onclick="openModalProduct()" class="btn btn-outline-dark w-full mb-3">{{$manana}}</button>
    </label>
</div> --}}

<div class="col-span-12 sm:col-span-6 xl:col-span-3 ">
    <div class="relative ">
        <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-gray-100 border text-gray-600 dark:bg-dark-1 dark:border-dark-4">
            <i class="fas fa-calendar fa-2x" class="w-5 h-5"></i>
        </div>
        <input wire:model="fechaPedido" id="f2" type="text" class="form-control form-control-lg text-center mydp">
    </div>
    <div class="font-normal">Fecha Final</div>
</div>


<script>

document.querySelectorAll('.mydp').forEach( function (el) {
    const today = new Date()

    const myDatePicker = MCDatepicker.create({

      el: '#' + el.getAttribute('id'),
      autoClose: true,
      customOkBTN: 'ACEPTAR',
      customClearBTN: 'BORRAR',
      customCancelBTN: 'CANCELAR',
      dateFormat: 'YYYY-MM-DD',
      minDate: today,
      customWeekDays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
      customMonths: [
      'Enero',
      'Febrero',
      'Marzo',
      'Abril',
      'Mayo',
      'Junio',
      'Julio',
      'Agosto',
      'Septiembre',
      'Octubre',
      'Noviembre',
      'Diciembre'
      ]

  })

  myDatePicker.onSelect((date, formatedDate) => {
        if(myDatePicker.el == '#f2')
           @this.fechaPedido = formatedDate;


        })

    })

</script>
