@section('title')
    Visualizar
@endsection
@section('custom-css')
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
    <!-- Puedes agregar más archivos CSS específicos aquí -->
@endsection
<x-header-footer>
    <div class="row justify-content-center mt-5">
        <div class="col-8">
            <h1 style="color: white"> Vista Previa</h1><br>
            <ul class="list-group">
                {{-- Dividir los archivos en dos arrays --}}
                @php
                    $folders = [];
                    $extensions = [];
                    foreach ($files as $file) {
                        if ($file != "." && $file != "..") {
                            if (strpos($file, '.') !== false) {
                                $extensions[] = $file;
                            } else {
                                $folders[] = $file;
                            }
                        }
                    }
                    // Fusionar los dos arrays, poniendo los que contienen "." al final
                    $mergedFiles = array_merge($folders, $extensions);
                @endphp
                {{-- Mostrar los archivos fusionados --}}
                @foreach ($mergedFiles as $file)
                    @if (strpos($file, '.') !== false)
                        <li class="list-group-item color_index_file"><i class="fa-solid fa-file color_file"></i>&nbsp;&nbsp;{{ $file}}</li>
                    @else
                        <li class="list-group-item  color_index_folder"><i class="fa-solid fa-folder color_folder"></i></i>&nbsp;&nbsp;{{ $file}}</li>
                    @endif
                @endforeach
            </ul>
            <div class="mt-3">
                <a href="/" class="btn btn-primary" tabindex="-1" role="button" ><i class="fa-solid fa-house"></i>&nbsp;&nbsp;Página de Inicio</a>
            </div>
        </div>
    </div>
    @section('custom-js')
        <script src="{{ asset('js/layout.js') }}"></script>
        <!-- Puedes agregar más archivos JS específicos aquí -->
    @endsection
</x-header-footer>
