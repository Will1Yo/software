@section('title')
    View
@endsection
<x-header-footer>
    <div class="main-container">
        <div class="list-group container-right">
            @foreach ($non_repeated_routes as $file)
                <ul class="list-group">
                    <li class="list-group-item list-group-item-secondary"><i class="fa-solid fa-folder"></i></i>&nbsp;&nbsp;{{ $file}}  <i style="text-align: left; float:right;" class="fa-solid fa-caret-down"></i></li>
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
                                            <a href="/files/view/{{$files_repo}}/{{$files_id}}" style="text-decoration: none;"><li class="list-group-item list-group-item-light"><i class="fa-solid fa-file"></i>&nbsp;&nbsp;{{ $files_show}}</li></a>
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
                                <a href="/files/view/{{$files_repo}}/{{$files_id}}" style="text-decoration: none;"><li class="list-group-item list-group-item-light"><i class="fa-solid fa-file"></i>&nbsp;&nbsp;{{ $file_path}}</li></a>
                            @endif
                        </ul>  
                    @endforeach
                @endif
            @endforeach
            <div class="mt-3">
                <a href="/" class="btn btn-primary" tabindex="-1" role="button" ><i class="fa-solid fa-chevron-left"></i>&nbsp;&nbsp;Página de Inicio</a>
            </div>
        </div>
        <div class="container-center container-lg file-container text-left">
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
        </div>
        
    </div>
</x-header-footer>
