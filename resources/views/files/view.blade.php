@section('title')
    View
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
                            @if (strpos($array->ruta, '/') !== false)
                                @php
                                $lastSlashPos = strrpos($array->ruta, '/');
                                if ($lastSlashPos !== false) {
                                    $path_clear = substr($array->ruta, 0, $lastSlashPos);
                                    $path_file = substr($array->ruta, $lastSlashPos+1);
                                }
                                @endphp
                                @if ($file == $path_clear)
                                    @foreach ($files as $route_filtering)
                                        @php
                                            $files_show = $route_filtering->files;
                                            $files_path = $route_filtering->ruta;
                                            $files_id = $route_filtering->id;
                                            $files_repo = $route_filtering->id_repo;
                                        @endphp
                                        @if (strpos($files_path, $array->ruta) !== false)
                                            @if($files_show== $path_file)
                                                @if ($id_files == $files_id)
                                                    <a href="/files/view/{{$files_repo}}/{{$files_id}}" id="view" style="text-decoration: none;"><li class="list-group-item color_index_file"><i class="fa-solid fa-file color_file"></i>&nbsp;&nbsp;{{ $files_show}}</li></a>
                                                @else
                                                    <a href="/files/view/{{$files_repo}}/{{$files_id}}" style="text-decoration: none;"><li class="list-group-item color_index_file"><i class="fa-solid fa-file color_file "></i>&nbsp;&nbsp;{{ $files_show}}</li></a>
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
                @if (strpos($array->ruta, '/') == false)
                    @foreach ($files as $route_filtering)
                        @php
                            $file_path = $route_filtering->ruta;
                            $files_id = $route_filtering->id;
                            $files_repo = $route_filtering->id_repo;
                        @endphp
                        <ul class="list-group">
                            @if ($array->files == $file_path)
                                @if ($id_files == $files_id)
                                <a href="/files/view/{{$files_repo}}/{{$files_id}}" id="view" style="text-decoration: none;"><li class="list-group-item color_index_file" id="view"><i class="fa-solid fa-file color_file" ></i>&nbsp;&nbsp;{{ $file_path}}</li></a>
                                @else
                                <a href="/files/view/{{$files_repo}}/{{$files_id}}" style="text-decoration: none;"><li class="list-group-item color_index_file"><i class="fa-solid fa-file color_file"></i>&nbsp;&nbsp;{{ $file_path}}</li></a>
                                @endif
                            @endif
                        </ul>  
                    @endforeach
                @endif
            @endforeach
            <div class="mt-3">
                <a href="/files/index/{{$id_repo}}" class="btn btn-primary" tabindex="-1" role="button" ><i class="fa-solid fa-chevron-left"></i>&nbsp;&nbsp;Atrás</a>
                &nbsp;&nbsp;
                <a href="/" class="btn btn-primary" tabindex="-1" role="button" ><i class="fa-solid fa-house"></i>&nbsp;&nbsp;Página de Inicio</a>
            </div>
        </div>
        <div class="container-center container-lg file-container text-left">
            @if ($files_open == "Folder")
                <h1 style="text-align: center; color: white">Visualización de Repositorio {{$repository_description->name_repo}}</h1>
            @else
                @php
                    // Obtener la ruta del archivo de manera segura
                    $path_filtered = str_replace("public\\", "", $files_open->path);
                    $filePath = public_path($path_filtered);
                    
            
                    // Función para verificar si el archivo es una imagen
                    function isImage($filePath) {
                        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg'];
                        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                        return in_array($extension, $imageExtensions);
                    }
            
                    // Verificar si el archivo existe
                    if (file_exists($filePath)) {
                        // Si el archivo es una imagen, mostrar la imagen
                        if (isImage($filePath)) {
                            $imageUrl = asset($path_filtered); // Obtener la URL pública de la imagen
                            echo '<img src="'.$imageUrl.'" alt="Imagen" class="img-fluid responsive-img">';
                        } else {
                            // Obtener el contenido del archivo
                            $fileContent = file_get_contents($filePath);
            
                            // Separar el contenido por líneas y eliminar espacios en blanco al inicio y fin de cada línea
                            $lines = explode("\n", htmlspecialchars($fileContent));
                            $lines = array_map('trim', $lines);
            
                            // Mostrar cada línea con numeración
                            echo '<pre class="line-numbers">';
                            foreach ($lines as $lineNumber => $lineContent) {
                                echo '<span class="line"><span class="line-number">' . ($lineNumber + 1) . '</span> ' . $lineContent . '</span>';
                            }
                            echo '</pre>';
                        }
                    } else {
                        echo "<p>El archivo no existe o la ruta es incorrecta.</p>";
                    }
                @endphp
            @endif
        </div>
    </div>
    @section('custom-js')
        <script src="{{ asset('js/custom.js') }}"></script>
        <!-- Puedes agregar más archivos JS específicos aquí -->
    @endsection
</x-header-footer>
