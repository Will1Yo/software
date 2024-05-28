@section('title')
    Repositorio
@endsection
<x-header-footer>
    <h1>Subir Repositorio</h1>
    <form action="/repositories/view" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Repositorio</span>
            <input type="text" class="form-control" placeholder="Nombre de repositorio" aria-label="Username" aria-describedby="basic-addon1"  value="{{$repositories->name_repo}}"  disabled>
        </div>
        <div class="input-group mb-3">
            <input type="file" class="form-control" id="inputGroupFile02" name="files">
            <label class="input-group-text" for="inputGroupFile02">.zip</label>
        </div>
        <input type="text" name="id" value="{{$repositories->id}}" hidden>
        <input type="text" name="name_repo" value="{{$repositories->name_repo}}" hidden>
        <div class="form-floating">
            <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" name="update_comment"></textarea>
            <label for="floatingTextarea2">Comentario</label>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary btn-lg">Subir Repositorio</button>
        </div>
    </form>
    <div class="mt-3">
        <a href="/" class="btn btn-primary" tabindex="-1" role="button" ><i class="fa-solid fa-chevron-left"></i>&nbsp;&nbsp;Regresar</a>
    </div>
</x-header-footer>