<script>


function openModalEntrada() { //modal entrada
        var modal = document.getElementById("modalEntrada")
		modal.classList.add("overflow-y-auto", "show")
		modal.style.cssText = "margin-top: 0px; margin-left: -100px;  z-index: 1000;"
	}

    function openModalPP() { //modal plato principal
        var modal = document.getElementById("modalPP")
		modal.classList.add("overflow-y-auto", "show")
		modal.style.cssText = "margin-top: 0px; margin-left: -100px;  z-index: 1000;"
	}
    function openModalPostre() { //modal plato principal
        var modal = document.getElementById("modalPostre")
		modal.classList.add("overflow-y-auto", "show")
		modal.style.cssText = "margin-top: 0px; margin-left: -100px;  z-index: 1000;"
	}

    window.addEventListener('close-usuario-modal', event => {
        closeModalEntrada()
    })
    window.addEventListener('close-pp-modal', event => {
        closeModalPP()
    })
    window.addEventListener('close-postre-modal', event => {
        closeModalPostre()
    })


    function closeModalEntrada() { //modal usuario
		var modal = document.getElementById("modalEntrada")
		modal.classList.remove("overflow-y-auto", "show")
		modal.style.cssText = ""
	}

    function closeModalPP() { //modal usuario
		var modal = document.getElementById("modalPP")
		modal.classList.remove("overflow-y-auto", "show")
		modal.style.cssText = ""
	}
    function closeModalPostre() { //modal usuario
		var modal = document.getElementById("modalPostre")
		modal.classList.remove("overflow-y-auto", "show")
		modal.style.cssText = ""
	}



</script>
