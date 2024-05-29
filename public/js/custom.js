/*////////////////////////////////////////////////////
JS de mi vista files.index 
///////////////////////////////////////////////////*/

document.addEventListener('Fixedtextarea1', function() {
    const textarea = document.getElementById('descriptionTextarea');

    if (textarea) {
        // Función para ajustar la altura del textarea
        function adjustTextareaHeight(element) {
            element.style.height = 'auto'; // Restablece la altura para calcular el scrollHeight
            element.style.height = (element.scrollHeight) + 'px'; // Ajusta la altura al scrollHeight
        }

        // Ajustar la altura cuando se carga la página
        adjustTextareaHeight(textarea);
    }
});

