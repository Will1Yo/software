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
        <div class="container-left">
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
                            <a href="/files/index/{{$repository->id}}" class="list-group-item color_index">
                                <i class="fa-solid fa-book-bookmark"></i>&nbsp;&nbsp;
                                <span>{{$repository->name_repo}}</span>
                            </a>
                            @else
                            <a href="/files/index/{{$repository->id}}" class="list-group-item Repo_hidden color_index" hidden="true"><i class="fa-solid fa-book-bookmark"></i>&nbsp;&nbsp;{{$repository->name_repo}}</a>
                            @endif
                        @endforeach
                    </ul>
                    <ul id="results" class="list-group list-group-flush"></ul>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <button type="button" class="btn-text-only" id="showMoreBtn"> Mostrar más</button>
                </div>
            </div>
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
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card color_index" style="width: 18rem;">
                        <div class="card-body">
                          <h5 class="card-title">Card title</h5>
                          <h6 class="card-subtitle mb-2 text-body-secondary">Card subtitle</h6>
                          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                          <a href="#" class="card-link">Card link</a>
                          <a href="#" class="card-link">Another link</a>
                        </div>
                      </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card color_index" style="width: 18rem;">
                        <div class="card-body">
                          <h5 class="card-title">Card title</h5>
                          <h6 class="card-subtitle mb-2 text-body-secondary">Card subtitle</h6>
                          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                          <a href="#" class="card-link">Card link</a>
                          <a href="#" class="card-link">Another link</a>
                        </div>
                      </div>
                </div>
            </div>
        </div>
    </div>
    @section('custom-js')
        <script src="{{ asset('js/main.js') }}"></script>
    @endsection
</x-header-footer>