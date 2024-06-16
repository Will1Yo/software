@section('title')
    Home
@endsection
@section('custom-css')
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <!-- Puedes agregar más archivos CSS específicos aquí -->
@endsection
<x-header-footer>
    <!-- Contenedor principal -->
    <div class="second-container">
        <!-- Contenedor izquierdo -->
        <div class="container-left ">
            <!-- Contenido del contenedor izquierdo -->
            <div>
                <div class="row mt-4 justify-content-center" style="text-align: center;">
                    <div class="col-4">
                        <h5 style="color: white">Repositorios</h5>
                    </div>
                    <div class="col-2">
                    </div>
                    <div class="col-6">
                        <a href="/repositories/create" class="btn btn-success btn-full-height" tabindex="-1" role="button">Nuevo <i class="fa-solid fa-book-bookmark" style="float: left"></i></a>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <input type="text" class="form-control color_index" placeholder="Buscar un repositorio..." aria-label="Username" aria-describedby="basic-addon1" id="repository_finder">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <ul class="list-group list-group-flush"  id="inicial">
                        @php
                            $cont = 0;
                        @endphp
                        @foreach ($repositories as $repository)
                            @php
                                $cont = $cont+1;
                            @endphp
                            @if ($cont <= 7)
                            <li class="list-group-item color_index d-flex justify-content-between align-items-center">
                                <a href="/files/index/{{$repository->id}}" class="repo-link">
                                    <i class="fa-solid fa-book-bookmark"></i>&nbsp;&nbsp;
                                    <span>{{$repository->name_repo}}</span>
                                </a>
                               <i class="fa-solid fa-trash trash-icon icon-delete" data-id = "{{$repository->id}}"></i>
                            </li>
                            @else
                            <div class="list-group list-group-flush Repo_hidden" hidden>
                                <li class="list-group-item color_index d-flex justify-content-between align-items-center">
                                    <a href="/files/index/{{$repository->id}}" class="repo-link">
                                        <i class="fa-solid fa-book-bookmark"></i>&nbsp;&nbsp;
                                        <span>{{$repository->name_repo}}</span>
                                    </a>
                                    <i class="fa-solid fa-trash trash-icon icon-delete" data-id = "{{$repository->id}}"></i>
                                </li>
                                <hr class="small-hr">
                            </div>
                            @endif
                        @endforeach
                    </ul>
                    <ul id="results" class="list-group list-group-flush"></ul>
                </div>
            </div>
            @if ($cont <= 7)
                <div class="row mt-2" hidden>
                    <div class="col-12">
                        <button type="button" class="btn-text-only" id="showMoreBtn"> Mostrar más</button>
                    </div>
                </div>
            @else
            <div class="row mt-2">
                <div class="col-12">
                    <button type="button" class="btn-text-only" id="showMoreBtn"> Mostrar más</button>
                </div>
            </div>
            @endif
        </div>
        <!-- Contenedor central -->
        <div class="container-center">
            <h3 style="color: white">
                Home
            </h3>
            <div class="row">
                <div class="col-12">
                    <div class="card color_index" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Cómo aprevechar al máximo AurHub</h5>
                            <p class="card-text">Nuestra plataforma está diseñada para ser una solución integral para la gestión de proyectos de software, facilitando la colaboración en equipo y mejorando la eficiencia en el desarrollo de software. Con características avanzadas de búsqueda, visualización y control de acceso, proporcionamos un entorno seguro y productivo para que los desarrolladores trabajen en conjunto y lleven sus proyectos al siguiente nivel</p>
                            <button type="button" class=" btn-text-only">Leer más</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contenedor derecho -->
        <div class="container-right">
            <!-- Contenido del contenedor izquierdo -->
            <div>
                <div class="row mt-4 justify-content-center" style="text-align: center;">
                    <div class="col-12">
                        <h5 style="color: white">Repositorios Compartidos</h5>
                    </div>
                </div>
                <div class="row justify-content-center" style="text-align: center;">
                    <div class="col-12">
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            Notificaciones: {{$user_id_count}}
                          </button>
                    </div>
                </div>     
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <input type="text" class="form-control color_index" placeholder="Buscar un repositorio..." aria-label="Username" aria-describedby="basic-addon1" id="repository_finder">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <ul class="list-group list-group-flush"  id="inicial">
                        @php
                            $cont = 0;
                        @endphp
                        @foreach ($repositories_colla as $repositories_coll)
                            @php
                                $cont = $cont+1;
                            @endphp
                            @if ($cont <= 7)
                            <li class="list-group-item color_index d-flex justify-content-between align-items-center">
                                <a href="/files/index/{{$repositories_coll->id}}" class="repo-link">
                                    <i class="fa-solid fa-book-bookmark"></i>&nbsp;&nbsp;
                                    <span>{{$repositories_coll->name_repo}}</span>
                                </a>
                               <i class="fa-solid fa-trash trash-icon icon-delete" data-id = "{{$repositories_coll->id}}"></i>
                            </li>
                            @else
                            <div class="list-group list-group-flush Repo_hidden" hidden>
                                <li class="list-group-item color_index d-flex justify-content-between align-items-center">
                                    <a href="/files/index/{{$repositories_coll->id}}" class="repo-link">
                                        <i class="fa-solid fa-book-bookmark"></i>&nbsp;&nbsp;
                                        <span>{{$repositories_coll->name_repo}}</span>
                                    </a>
                                    <i class="fa-solid fa-trash trash-icon icon-delete" data-id = "{{$repositories_coll->id}}"></i>
                                </li>
                                <hr class="small-hr">
                            </div>
                            @endif
                        @endforeach
                    </ul>
                    <ul id="results" class="list-group list-group-flush"></ul>
                </div>
            </div>
            @if ($cont <= 7)
                <div class="row mt-2" hidden>
                    <div class="col-12">
                        <button type="button" class="btn-text-only" id="showMoreBtn"> Mostrar más</button>
                    </div>
                </div>
            @else
            <div class="row mt-2">
                <div class="col-12">
                    <button type="button" class="btn-text-only" id="showMoreBtn"> Mostrar más</button>
                </div>
            </div>
            @endif
        </div>
    </div>
        <!-- Modal -->
        <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            ...
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Understood</button>
            </div>
        </div>
        </div>
    </div>
    @section('custom-js')
        <script src="{{ asset('js/main.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const repositoryFinderInput = document.getElementById('repository_finder');
                const resultsDiv = document.getElementById('results');
                const initialDiv = document.getElementById('inicial');
        
                function addDeleteEvent(iconDelete) {
                    iconDelete.addEventListener('click', function () {
                        var id_repo = iconDelete.getAttribute('data-id');
                        Swal.fire({
                            title: "¿Estás seguro?",
                            html: "<h4 style='color: red'>Una vez lo borres no podrás recuperar los avances de tu proyecto</h4>",
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
                                window.location.href = "/repositories/delete/" + id_repo;
                            } else if (result.dismiss === Swal.DismissReason.cancel) {
                                Swal.fire({
                                    title: "Cancelado",
                                    text: "Tu repositorio está seguro :3",
                                    icon: "info"
                                });
                            }
                        });
                    });
                }
        
                repositoryFinderInput.addEventListener('input', function () {
                    const query = repositoryFinderInput.value;
        
                    if (query.length > 0) {
                        fetch(`/search-repositories?name_repo=${query}`)
                            .then(response => response.json())
                            .then(data => {
                                resultsDiv.innerHTML = ''; // Clear previous results
                                initialDiv.style.display = 'none';
                                data.repositories.forEach(repo => {
                                    // Crear elemento <li>
                                    const repoItem = document.createElement('li');
                                    repoItem.classList.add('list-group-item', 'color_index', 'd-flex', 'justify-content-between', 'align-items-center');
                                    
                                    // Crear elemento <a>
                                    const repoLink = document.createElement('a');
                                    repoLink.href = `/files/index/${repo.id}`;
                                    repoLink.classList.add('repo-link');
                                    repoLink.innerHTML = `<i class="fa-solid fa-book-bookmark"></i>&nbsp;&nbsp;<span>${repo.name_repo}</span>`;
        
                                    // Crear icono de basura
                                    const trashIcon = document.createElement('i');
                                    trashIcon.classList.add('fa-solid', 'fa-trash', 'trash-icon', 'icon-delete');
                                    trashIcon.setAttribute('data-id', repo.id); // Añadir data-id al icono
        
                                    // Añadir <a> y el icono de basura al <li>
                                    repoItem.appendChild(repoLink);
                                    repoItem.appendChild(trashIcon);
        
                                    // Añadir el <li> a resultsDiv
                                    resultsDiv.appendChild(repoItem);
        
                                    // Añadir evento de eliminación al icono
                                    addDeleteEvent(trashIcon);
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
        
                // Añadir evento de eliminación a los íconos existentes en la página inicial
                var iconsDelete = document.querySelectorAll('.icon-delete');
                iconsDelete.forEach(addDeleteEvent);
            });
        </script>
        
    @endsection
</x-header-footer>