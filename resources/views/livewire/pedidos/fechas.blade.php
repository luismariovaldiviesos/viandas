
<div class="col-span-12 sm:col-span-6 xl:col-span-3 ">
    <div class="font-normal"><h2 class="text-2xl  mb-3">Fecha Pedido</h2></div>
    <div class="relative ">
        <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-gray-100 border text-gray-600 dark:bg-dark-1 dark:border-dark-4">
            <i class="fas fa-calendar fa-2x" class="w-5 h-5"></i>
        </div>
        <input wire:model="fechaPedido" id="f2" type="text" class="form-control form-control-lg text-center mydp">
    </div>

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
