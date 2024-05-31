@section('title')
    Crear
@endsection
@section('custom-css')
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
    <!-- Puedes agregar más archivos CSS específicos aquí -->
@endsection
<x-header-footer>
    <div class="third_container">
        <div class="row justify-content-center mt-5 third_container ">
            <div class="col-6">
                <form action="/repositories" method="POST" id="repo-form">
                     <table class="table custom-table ">
                        @csrf
                        <thead>
                            <tr>
                                <td colspan="3" class="text_color">
                                    <h2>Crear nuevo repositorio</h2>
                                    <p>Un repositorio contiene todos los archivos del proyecto, incluido el historial de revisiones.</p>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="input-group">
                                        <span class="input-group-text color_index" id="basic-addon1">Usuario</span>
                                        <input type="text" class="form-control color_index" placeholder="Nombre de repositorio" aria-label="Username" aria-describedby="basic-addon1" value="Wilson" disabled>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <span class="input-group-text color_index" id="basic-addon1">Repositorio</span>
                                        <input type="text" class="form-control color_index" placeholder="Nombre de repositorio" aria-label="Username" aria-describedby="basic-addon1" name="name_repo" id="name_Repo" required>
                                    </div>
                                </td>
                                <td>
                                    <p id="error-message" class="error-message"></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">Los grandes nombres de repositorios son breves y fáciles de recordar.</td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <div class="form-floating">
                                        <textarea class="form-control text_description" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" name="description" rows="3"></textarea>
                                        <label for="floatingTextarea2">Descripción (opcional)</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <div class="form-check">
                                        <input class="form-check-input" name="restriction" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="0" checked>
                                        <label class="form-check-label" for="flexRadioDefault1"> &nbsp;<i class="fa-solid fa-book-bookmark"></i>
                                            Publico: cualquier persona en Internet puede ver este repositorio.
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="restriction" type="radio" value="1" name="flexRadioDefault" id="flexRadioDefault2">
                                        <label class="form-check-label" for="flexRadioDefault2"> &nbsp;<i class="fa-solid fa-lock"></i>
                                            Privado: tú eliges quién puede ver y comprometerse con este repositorio.
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        </tbody>                 
                    </table>
                    <div class="button-container mt-3">
                        <a href="/" class="btn btn-primary" tabindex="-1" role="button"><i class="fa-solid fa-chevron-left"></i>&nbsp;&nbsp;Regresar</a>
                        <button type="submit" class="btn btn-success"><i class="fa-solid fa-book"></i>&nbsp;&nbsp;Crear Repositorio&nbsp;&nbsp;</button>
                    </div>   
                </form>
            </div>
        </div>
    </div>
    @section('custom-js')
        <script src="{{ asset('js/layout.js') }}"></script>
        <!-- Puedes agregar más archivos JS específicos aquí -->
    @endsection
</x-header-footer>
