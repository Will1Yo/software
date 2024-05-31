@section('title')
    Repositorio
@endsection
@section('custom-css')
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
    <!-- Puedes agregar más archivos CSS específicos aquí -->
@endsection
<x-header-footer>
    <div class="row justify-content-center mt-5">
        <div class="col-7">
            <form action="/repositories/view" method="POST" enctype="multipart/form-data">
                <table class="table custom-table">
                        @csrf
                    <tbody>
                        <thead>
                            <tr>
                                <td colspan="2">
                                    <h2 style="color: white">Subir Repositorio</h2>
                                    <p>Al subir un repositorio usted podrá visualizar una vista previa de él.</p>
                                </td>
                            </tr>
                        </thead>
                        <tr>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-text color_index" id="basic-addon1">Repositorio</span>
                                    <input type="text" class="form-control color_index" placeholder="Nombre de repositorio" aria-label="Username" aria-describedby="basic-addon1"  value="{{$repositories->name_repo}}"  disabled>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="file" class="form-control" id="inputGroupFile02" name="files" accept=".zip" required>
                                    <label class="input-group-text color_index" for="inputGroupFile02">.zip</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="form-floating">
                                    <textarea class="form-control text_description" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" name="update_comment" rows="2" required></textarea>
                                    <label for="floatingTextarea2">Comentario de inserción (requerido)</label>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                        <input type="text" name="id" value="{{$repositories->id}}" hidden>
                        <input type="text" name="name_repo" value="{{$repositories->name_repo}}" hidden>
                </table>
                <div class="button-container mt-3">
                    <a href="/" class="btn btn-primary" tabindex="-1" role="button"><i class="fa-solid fa-chevron-left"></i>&nbsp;&nbsp;Regresar</a>
                    <button type="submit" class="btn btn-warning"><i class="fa-solid fa-book"></i>&nbsp;&nbsp;Subir Repositorio&nbsp;&nbsp;</button>
                </div>   
            </form>
        </div>
    </div>
    @section('custom-js')
        <script src="{{ asset('js/layout.js') }}"></script>
        <!-- Puedes agregar más archivos JS específicos aquí -->
    @endsection
</x-header-footer>

