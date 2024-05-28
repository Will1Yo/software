@section('title')
    Index
@endsection
<x-header-footer>
    <h1>Vista de Repositories</h1>
    <div class="input-group">
        <span class="input-group-text">Descripción</span>
        <textarea class="form-control" aria-label="With textarea" disabled>{{$description = $repository_description->description}}
        </textarea>
        @if (($restriction = $repository_description->restriction) == 0)
            <button type="button" class="btn btn-success">Publico</button>
        @else
            <button type="button" class="btn btn-danger">Privado</button>
        @endif
    </div>
    <br>
    <ul class="list-group">
        @foreach ($non_repeated_routes as $file)
            <a href="/files/view/{{$id_repo}}/{{$file}}" style="text-decoration: none;"><li class="list-group-item list-group-item-secondary"><i class="fa-solid fa-folder"></i></i>&nbsp;&nbsp;{{ $file}}<i class="fa-solid fa-caret-right" style="text-align: left; float:right;"></i></li></a>
        @endforeach
    </ul>
    <ul class="list-group">
            @foreach($files as $file)
                @if (strpos($file->ruta, '/') == false)
                    <a href="/files/view/{{$file->id_repo}}/{{$file->id}}" style="text-decoration: none;"><li class="list-group-item list-group-item-light"><i class="fa-solid fa-file"></i>&nbsp;&nbsp;{{ $file->files}}<i class="fa-solid fa-square-up-right" style="text-align: left; float:right;"></i></li></a>
                @endif
            @endforeach
        </ul>
    </div>
    <br>
    <div class="mt-3">
        <a href="/" class="btn btn-primary" tabindex="-1" role="button" ><i class="fa-solid fa-chevron-left"></i>&nbsp;&nbsp;Página de Inicio</a>
    </div>
</x-header-footer>