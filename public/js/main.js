document.addEventListener('DOMContentLoaded', function() {
    const repositoryFinderInput = document.getElementById('repository_finder');
    const resultsDiv = document.getElementById('results');
    const initialDiv = document.getElementById('inicial');

    repositoryFinderInput.addEventListener('input', function() {
        const query = repositoryFinderInput.value;

        if (query.length > 0) {
            fetch(`/search-repositories?name_repo=${query}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data); 
                    resultsDiv.innerHTML = ''; // Clear previous results
                    initialDiv.style.display = 'none';
                    data.repositories.forEach(repo => {
                        const repoItem = document.createElement('a');
                        repoItem.href = `/files/index/${repo.id}`; // Establecer el atributo href con la URL deseada
                        repoItem.classList.add('list-group-item', 'color_index'); // Agregar las clases necesarias
                        repoItem.innerHTML = `<i class="fa-solid fa-book-bookmark"></i>&nbsp;&nbsp;<span>${repo.name_repo}</span>`; // Envolver el nombre del repositorio en un <span>

                        // Asegúrate de agregar el elemento creado al DOM, por ejemplo:
                        document.body.appendChild(repoItem);
                        resultsDiv.appendChild(repoItem);
                    });
                })
                .catch(error => {
                    console.error('Error fetching repositories:', error);
                });
        } else {
            resultsDiv.innerHTML = ''; // Clear results if query is empty
            initialDiv.style.display = 'block';
        }
    });
});

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

