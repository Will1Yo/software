@section('title')
    Repositorio
@endsection
@section('custom-css')
    <link href="{{ asset('css/use.css') }}" rel="stylesheet">
    <!-- Puedes agregar más archivos CSS específicos aquí -->
@endsection
<x-header-footer>
    <div class="row justify-content-center mt-5">
        <div class="col-7">
            <button type="button" class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal" style="float: right;">Agregar Colaborador&nbsp;&nbsp;<i class="fa-solid fa-user-plus"></i></button>
            <h1 class="color_text">Colaboradores </h1>
            <hr class="color_text">
              
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar un Colaborador al <strong>Repositorio</strong></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                        <div class="modal-body">
                            <p class="text_search">Buscar por usuario o correo</p>
                            <input type="text" class="search-input" id="users_finder" placeholder="Buscar Gente" aria-label="Find people" data-repo="{{$id_repo}}">
                            <ul class="list-group list-group-flush mt-3 results"></ul>
                            
                            <!-- Sección para el usuario seleccionado -->
                            <div class="selected-user mt-3" style="display: none; padding-left: 10%">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img src="" alt="" class="rounded-circle selected-user-avatar" width="40" height="40">
                                        <div class="ms-3">
                                            <span class="selected-user-name"></span>
                                            <small class="selected-user-email"></small>
                                        </div>
                                    </div>
                                    &nbsp;&nbsp;<button type="button" class="btn btn-danger btn-sm deselect-user">X</button>
                                </div>
                            </div>
                        </div>
                        <hr class="color_text">
                        <div class="modal-footer justify-content-center">
                            <a class="btn btn-primary add-collaborator-btn disabled" href="#" type="button" >Seleccione un colaborador arriba</a>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-6">
            <table class="table table-bordered table-hover custom-table">
                <tbody>
                    <tr>
                        <td>
                            <div class="input-group mb-3 mt-2">
                                <span class="input-group-text color_index" id="basic-addon1">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </span>
                                <input type="text" class="form-control color_index" placeholder="Buscar Colaborador" aria-label="Username" aria-describedby="basic-addon1" id="usuarios_finder" data-repo="{{$id_repo}}">
                            </div>
                        </td>
                    </tr>
                    @foreach ($collaborators as $collaborator)
                    <tr class="collaborators">
                        <td>
                            <div class="d-flex align-items-center justify-content-between">
                                <a href="#" class="repo-link d-flex align-items-center disabled" style="text-decoration: none; cursor: default">
                                    <img src="{{ asset('img/user_img.png') }}" alt="Nombre del Usuario" class="rounded-circle user-avatar">
                                    <div class="user-info">
                                        <span class="user-name">{{$collaborator->name}}</span>
                                        <small>{{$collaborator->email}}
                                            @if ($collaborator->confirmation == 0)
                                                <small style="color: rgb(202, 102, 102)">* Pendiente de confirmación</small>
                                            @else
                                                <small style="color: rgb(90, 226, 101)">* Colaborador</small>
                                            @endif
                                        </small>
                                    </div>
                                </a>
                                <i class="fa-solid fa-trash icon-delete trash-icon" style="color: rgb(216, 101, 101); cursor: pointer;" data-repo="{{$id_repo}}" data-user="{{$collaborator->id}}" data-name="{{$collaborator->name}}" ></i>
                            </div>
                        </td>
                    </tr>
                    @endforeach  
                </tbody>
            </table>
            
            <a href="/files/update/{{$id_repo}}" class="btn btn-primary" tabindex="-1" role="button"><i class="fa-solid fa-chevron-left"></i>&nbsp;&nbsp;Regresar</a>
        </div>
    </div>

    @section('custom-js')
    <script src="{{ asset('js/use.js') }}"></script>
    @endsection
</x-header-footer>