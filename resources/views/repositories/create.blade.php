@section('title')
    Crear
@endsection
<x-header-footer>
    <h1>Create Repositories</h1>
    <form action="/repositories" method="POST">
        @csrf
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Nombre</span>
            <input type="text" class="form-control" placeholder="Nombre de repositorio" aria-label="Username" aria-describedby="basic-addon1"  name="name_repo">
        </div>
        <div class="input-group">
            <span class="input-group-text">Descripción</span>
            <textarea class="form-control" aria-label="With textarea" name="description"></textarea>
        </div>
        <div class="card mt-3" style="width: 18rem;">
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
        <div class="mt-3">
            <button type="submit" class="btn btn-primary btn-lg">Crear Repositorio</button>
        </div>
        <div class="mt-3">
            <a href="/" class="btn btn-primary" tabindex="-1" role="button" ><i class="fa-solid fa-chevron-left"></i>&nbsp;&nbsp;Regresar</a>
        </div>
        
    </form>
</x-header-footer>