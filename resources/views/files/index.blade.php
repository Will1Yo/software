@section('title')
    Index
@endsection

@section('custom-css')
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <!-- Puedes agregar más archivos CSS específicos aquí -->
@endsection

<x-header-footer>
    <div class="row justify-content-center mt-5">
        <div class="col-8">
            <h2 style="color: white">Vista de Repositorios</h2><br>
            <div class="input-group">
                <span class="input-group-text text_description">Descripción</span>
                <textarea id="descriptionTextarea" class="form-control text_description" aria-label="With textarea" disabled>{{$description = $repository_description->description}}</textarea>
                @if (($restriction = $repository_description->restriction) == 0)
                    <button type="button" class="btn btn-success">Publico</button>
                @else
                    <button type="button" class="btn btn-danger">Privado</button>
                @endif
            </div>
            <br>
            <ul class="list-group">
                @php
                    $array_paths_clear = array();
                    foreach ($files as $array_path) {
                        $paths = $array_path->ruta;      
                        $lastSlashPos = strrpos($paths, '/');
                        if ($lastSlashPos !== false) {
                            $path_clear = substr($paths, 0, $lastSlashPos);
                            $lastpath = strrpos($path_clear, '/');
                            if ($lastpath === false) {
                                if (!in_array($path_clear, $array_paths_clear, false)) {
                                    foreach ($array_commnets as $comment) {
                                        if ($comment['path'] == $path_clear) {
                                            $folder = "Folder";
                                            echo "<a href='/files/view/{$id_repo}/{$folder}' style='text-decoration: none;'>";
                                            echo "<li class='list-group-item color_index_folder li_responsive'>";
                                            echo "<i class='fa-solid fa-folder color_folder '></i>&nbsp;&nbsp;{$path_clear}";
                                            echo "<i class='i_file'>{$comment['update_comment']}</i>";
                                            echo "<i class='fa-solid fa-caret-right i_folder'></i>";
                                            echo "<i class='i_update'>{$comment['updated_at']}</i>&nbsp;&nbsp;";
                                            echo "</li></a>";
                                            $array_paths_clear[] = $path_clear;
                                        }
                                    }
                                } 
                            }
                        }
                    }
                @endphp
            </ul>
            <ul class="list-group">
                @foreach($commits_and_files as $commit_and_file)
                        @php
                            echo "<a href='/files/view/{$id_repo}/{$commit_and_file['id']}' style='text-decoration: none;'>";
                            echo "<li class='list-group-item color_index_file li_responsive'>";
                            echo "<i class='fa-solid fa-file  color_file'></i >&nbsp;&nbsp;{$commit_and_file['file']}";
                            echo "<i class='i_file'>{$commit_and_file['update_comment']}</i>";
                            echo "<i class='fa-solid fa-caret-right i_folder'></i>";
                            echo "<i class='i_update'>{$commit_and_file['updated_at']}</i>&nbsp;&nbsp;";
                            echo "</li></a>";
                        @endphp
                @endforeach
            </ul>
            <div class="button-container mt-3">
                <a href="/" class="btn btn-primary" tabindex="-1" role="button"><i class="fa-solid fa-chevron-left"></i>&nbsp;&nbsp;Regresar</a>
                <a  href="/files/update/{{$id_repo}}" class="btn btn-warning" tabindex="-1" role="button"><i class="fa-solid fa-book"></i>&nbsp;&nbsp;Actualizar Repositorio&nbsp;&nbsp;</a>
            </div>  
        </div>
    </div>

    @section('custom-js')
        <script src="{{ asset('js/custom.js') }}"></script>
        <!-- Puedes agregar más archivos JS específicos aquí -->
    @endsection
</x-header-footer>
