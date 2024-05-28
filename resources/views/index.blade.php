@section('title')
    Home
@endsection
<x-header-footer>
    <h1>Repositories</h1>
    <a href="/repositories/create" class="btn btn-primary" tabindex="-1" role="button" >Crear Repositorio</a>
    <br><br>
    <div class="list-group">
        @foreach ($repositories as $repositories)
            <a href="/files/index/{{$repositories->id}}" class="list-group-item list-group-item-action list-group-item-secondary"><i class="fa-solid fa-book-bookmark"></i>&nbsp;&nbsp;{{$repositories->name_repo}}</a>
        @endforeach
    </div>
</x-header-footer>