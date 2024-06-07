/*////////////////////////////////////////////////////
JS de mi vista commits.index 
///////////////////////////////////////////////////*/
 // Esperamos a que el DOM esté completamente cargado

// Esperamos a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function () {
    // Seleccionamos todos los íconos por su clase
    var iconsDelete = document.querySelectorAll('.icon-delete');

    // Iteramos sobre todos los íconos
    iconsDelete.forEach(function(iconDelete) {
        // Agregamos un evento de clic a cada ícono
        iconDelete.addEventListener('click', function () {
            // Obtenemos los datos del ícono
            var repo = iconDelete.getAttribute('data-repo');
            var commit = iconDelete.getAttribute('data-commit');
            var comment = iconDelete.getAttribute('data-comment');

            // Mostramos el Sweet Alert
            Swal.fire({
                title: "¿Estás seguro?",
                html: "<h4 style = 'color: red'>Una vez lo borres no podrás revertirlo</h4> <p style= 'color:black'> Tu commit contiene: " + comment + "</p>",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, borrarlo",
                cancelButtonText: "No, cancelar",
                reverseButtons: true,
                showCloseButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirigimos a la URL con los datos del ícono
                    window.location.href = "/commits/delete/" + repo + "/" + commit;
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire({
                        title: "Cancelado",
                        text: "Tu commit está seguro :)",
                        icon: "info"
                    });
                }
            });
        });
    });
});

