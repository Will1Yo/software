@section('title')
    Crear
@endsection
@section('custom-css')
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
    <!-- Puedes agregar más archivos CSS específicos aquí -->
@endsection
<x-header-footer>
    <div class="row justify-content-center">
        <div class="col-8">
            <h1 style="text-align: center">Create Repositories</h1>
            <table class="table table-bordered">
                <form action="/repositories" method="POST" id="repo-form">
                    @csrf
                    <tbody>
                        <tr>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">Usuario</span>
                                    <input type="text" class="form-control" placeholder="Nombre de repositorio" aria-label="Username" aria-describedby="basic-addon1"  value="Wilson"  disabled>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">Repositorio</span>
                                    <input type="text" class="form-control" placeholder="Nombre de repositorio" aria-label="Username" aria-describedby="basic-addon1"  name="name_repo" id="name_Repo" required>
                                    <p id="error-message" class="error-message"></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 20%">
                                <div class="card" style="width: 18rem;">
                                    <div class="card-body">
                                        <h5 class="card-title">Privacidad</h5>
                                        <p class="card-text">Publico: cualquier persona en Internet puede ver este repositorio. </p>
                                        <p class="card-text">Privado: tú eliges quién puede ver y comprometerse con este repositorio.. </p>
                                        <input type="radio" class="btn-check" name="restriction" id="success-outlined" autocomplete="off" value="0" checked>
                                        <label class="btn btn-outline-success" for="success-outlined">Publico</label>
                                        <input type="radio" class="btn-check" name="restriction" id="danger-outlined" autocomplete="off" value="1"> 
                                        <label class="btn btn-outline-danger" for="danger-outlined">Privado</label>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-floating">
                                    <textarea class="form-control text_description" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" name="description" rows="11" ></textarea>
                                    <label for="floatingTextarea2">Descripción</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-success ">Crear Repositorio&nbsp;&nbsp;<i class="fa-solid fa-folder-plus"></i></button>
                                  </div>
                            </td>
                        </tr>
                    </tbody>                    
                </form>
            </table>
            <div class="mt-3">
                <a href="/" class="btn btn-primary" tabindex="-1" role="button" ><i class="fa-solid fa-chevron-left"></i>&nbsp;&nbsp;Regresar</a>
            </div>
        </div>
    </div>
    @section('custom-js')
        <script src="{{ asset('js/layout.js') }}"></script>
        <!-- Puedes agregar más archivos JS específicos aquí -->
    @endsection
</x-header-footer>
