@section('title')
    Commits
@endsection

@section('custom-css')
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <!-- Puedes agregar más archivos CSS específicos aquí -->
@endsection

<x-header-footer>
    <div class="main-container">
        <div class="list-group container-right">
            @foreach ($non_repeated_routes as $file)
                <ul class="list-group">
                    <li class="list-group-item color_index_folder"><i class="fa-solid fa-folder color_folder"></i></i>&nbsp;&nbsp;{{ $file}}  <i style="text-align: left; float:right;" class="fa-solid fa-caret-down "></i></li>
                    @foreach ($files as $array)
                            @if (strpos($array['ruta'], '/') !== false)
                                @php
                                $lastSlashPos = strrpos($array['ruta'], '/');
                                if ($lastSlashPos !== false) {
                                    $path_clear = substr($array['ruta'], 0, $lastSlashPos);
                                    $path_file = substr($array['ruta'], $lastSlashPos+1);
                                }
                                @endphp
                                @if ($file == $path_clear)
                                    @foreach ($files as $route_filtering)
                                        @php
                                            $files_show = $route_filtering['file'];
                                            $files_path = $route_filtering['ruta'];
                                            $files_id = $route_filtering['id'];
                                            $files_repo = $id_repo;
                                        @endphp
                                        @if (strpos($files_path, $array['ruta']) !== false)
                                            @if($files_show== $path_file)
                                                @if ($id_files == $files_id)
                                                    <a href="/commits/view/{{$files_repo}}/{{$commit}}/{{$files_id}}" id="view" style="text-decoration: none;"><li class="list-group-item color_index_file"><i class="fa-solid fa-file color_file"></i>&nbsp;&nbsp;{{ $files_show}}</li></a>
                                                @else
                                                    <a href="/commits/view/{{$files_repo}}/{{$commit}}/{{$files_id}}" style="text-decoration: none;"><li class="list-group-item color_index_file"><i class="fa-solid fa-file color_file "></i>&nbsp;&nbsp;{{ $files_show}}</li></a>
                                                @endif
                                            @endif 
                                        @endif     
                                    @endforeach
                                @endif
                            @endif
                    @endforeach
                </ul>
            @endforeach
            <br>
            @foreach($files as $array)
                @if (strpos($array['ruta'], '/') == false)
                    @foreach ($files as $route_filtering)
                        @php
                            $file_path = $route_filtering['ruta'];
                            $files_id = $route_filtering['id'];
                            $files_repo = $id_repo;
                        @endphp
                        <ul class="list-group">
                            @if ($array['file'] == $file_path)
                                @if ($id_files == $files_id)
                                <a href="/commits/view/{{$files_repo}}/{{$commit}}/{{$files_id}}" id="view" style="text-decoration: none;"><li class="list-group-item color_index_file" id="view"><i class="fa-solid fa-file color_file" ></i>&nbsp;&nbsp;{{ $file_path}}</li></a>
                                @else
                                <a href="/commits/view/{{$files_repo}}/{{$commit}}/{{$files_id}}" style="text-decoration: none;"><li class="list-group-item color_index_file"><i class="fa-solid fa-file color_file"></i>&nbsp;&nbsp;{{ $file_path}}</li></a>
                                @endif
                            @endif
                        </ul>  
                    @endforeach
                @endif
            @endforeach
            <div class="mt-3">
                <a href="/commits/index/{{$id_repo}}" class="btn btn-primary" tabindex="-1" role="button" ><i class="fa-solid fa-code-commit"></i>&nbsp;&nbsp;Commits</a>
                &nbsp;&nbsp;
                <a href="/files/index/{{$id_repo}}" class="btn btn-primary" tabindex="-1" role="button" ><i class="fa-solid fa-book-open"></i>&nbsp;&nbsp;Repositorio</a>
            </div>
        </div>
    </div>
    <div class="container-center container-lg file-container text-left">
        @if  (is_null($rendered_diff))
                <h1 style="text-align: center; color: white">Visualización de Commit {{$commit}}</h1>

        @else
        {!! $rendered_diff !!}

        @endif

    </div>
    

    @section('custom-js')
    <script src="{{ asset('js/custom.js') }}"></script>
    <!-- Puedes agregar más archivos JS específicos aquí -->
    @endsection 
</x-header-footer>