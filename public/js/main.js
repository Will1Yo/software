

document.getElementById('showMoreBtn').addEventListener('click', function() {
    // Selecciona todos los elementos con la clase Repo_hidden
    var hiddenElements = document.querySelectorAll('.Repo_hidden');
    const initialDiv = document.getElementById('showMoreBtn');
    initialDiv.setAttribute('hidden', 'true');

    // Verifica y muestra los atributos de cada elemento en la consola
    hiddenElements.forEach(function(element) {
        console.log('Antes de eliminar el atributo hidden:', element.outerHTML);
        if (element.hasAttribute('hidden')) {
            element.removeAttribute('hidden');
        } else {
           
        }
    });
});

