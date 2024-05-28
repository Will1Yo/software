@section('title')
    Visualizar
@endsection
<x-header-footer>
    <h1>Repositorio</h1>
    <br>
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
                <li class="list-group-item list-group-item-light"><i class="fa-solid fa-file"></i>&nbsp;&nbsp;{{ $file}}</li>
            @else
                <li class="list-group-item list-group-item-secondary"><i class="fa-solid fa-folder"></i></i>&nbsp;&nbsp;{{ $file}}</li>
            @endif
        @endforeach
    </ul>
    <div class="mt-3">
        <a href="/" class="btn btn-primary" tabindex="-1" role="button" ><i class="fa-solid fa-chevron-left"></i>&nbsp;&nbsp;Página de Inicio</a>
    </div>
</x-header-footer>
