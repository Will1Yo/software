@section('title')
    Repositorio
@endsection
@section('custom-css')
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
    <!-- Puedes agregar más archivos CSS específicos aquí -->
@endsection
<x-header-footer>
    <div class="row justify-content-center">
        <div class="col-8">
            <h1 style="text-align: center">Subir Repositorio</h1>
            <table class="table table-bordered">
                <form action="/repositories/view" method="POST" enctype="multipart/form-data">
                    @csrf
                <tbody>
                    <tr>
                        <td>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Repositorio</span>
                                <input type="text" class="form-control" placeholder="Nombre de repositorio" aria-label="Username" aria-describedby="basic-addon1"  value="{{$repositories->name_repo}}"  disabled>
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <input type="file" class="form-control" id="inputGroupFile02" name="files" accept=".zip" required>
                                <label class="input-group-text" for="inputGroupFile02">.zip</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="form-floating">
                                <textarea class="form-control text_description" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" name="update_comment" rows="2" required></textarea>
                                <label for="floatingTextarea2">Comentario de inserción</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-warning ">Subir Repositorio&nbsp;&nbsp;<i class="fa-solid fa-folder-plus"></i></button>
                              </div>
                        </td>
                    </tr>
                </tbody>
                    <input type="text" name="id" value="{{$repositories->id}}" hidden>
                    <input type="text" name="name_repo" value="{{$repositories->name_repo}}" hidden>
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