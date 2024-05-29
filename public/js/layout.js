/*////////////////////////////////////////////////////
JS de mi vista repositories.index 
///////////////////////////////////////////////////*/
document.addEventListener('InputFileValidated', function() {
    const fileInput = document.getElementById('inputGroupFile02');

    fileInput.addEventListener('change', function(event) {
        const file = fileInput.files[0];
        if (file) {
            const fileName = file.name;
            const fileExtension = fileName.split('.').pop().toLowerCase();

            if (fileExtension !== 'zip') {
                alert('Solo se permiten archivos con extensión .zip.');
                fileInput.value = ''; // Limpia el campo de entrada
            }
        }
    });
});

/*////////////////////////////////////////////////////
JS de mi vista repositories.create
///////////////////////////////////////////////////*/

// public/js/autoResizeTextarea.js

document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('floatingTextarea2');

    textarea.addEventListener('input', function() {
        // Resetea la altura para calcular el scrollHeight correcto
        textarea.style.height = 'auto';
        // Establece la altura del textarea a su scrollHeight
        textarea.style.height = `${textarea.scrollHeight}px`;
    });

    // Opcional: Ajustar la altura inicial si ya hay texto cargado
    textarea.style.height = 'auto';
    textarea.style.height = `${textarea.scrollHeight}px`;
});

// public/js/checkRepoName.js

document.addEventListener('DOMContentLoaded', function() {
    const nameRepoInput = document.querySelector('input[name="name_repo"]');
    const messageDiv = document.querySelector('#error-message');
    const repoForm = document.querySelector('#repo-form');
    let isNameValid = false;

    nameRepoInput.addEventListener('input', function() {
        const nameRepo = nameRepoInput.value;

        if (nameRepo.length > 0) {
            fetch(`/check-repo-name?name_repo=${nameRepo}`)
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        messageDiv.style.color = 'red';
                        messageDiv.textContent = 'Repositorio existente.';
                        messageDiv.style.display = 'block';
                        nameRepoInput.classList.add('input-error');
                        nameRepoInput.classList.remove('input-valid');
                        isNameValid = false;
                    } else {
                        messageDiv.style.color = 'green';
                        messageDiv.textContent = 'Repositorio disponible';
                        messageDiv.style.display = 'block';
                        nameRepoInput.classList.add('input-valid');
                        nameRepoInput.classList.remove('input-error');
                        isNameValid = true;
                    }
                });
        } else {
            messageDiv.textContent = '';
            messageDiv.style.display = 'none';
            nameRepoInput.classList.remove('input-error');
            nameRepoInput.classList.remove('input-valid');
            isNameValid = false;
        }
    });

    repoForm.addEventListener('submit', function(event) {
        if (!isNameValid) {
            event.preventDefault();
            alert('El nombre del repositorio no es válido o ya existe. Por favor, elija otro nombre.');
        }
    });
});
