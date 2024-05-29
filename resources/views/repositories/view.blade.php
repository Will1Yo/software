@section('title')
    Visualizar
@endsection
@section('custom-css')
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
    <!-- Puedes agregar más archivos CSS específicos aquí -->
@endsection
<x-header-footer>
    <div class="row justify-content-center">
        <div class="col-8">
            <h1 style="text-align: center"> Vista Previa</h1>
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
                <a href="/" class="btn btn-primary" tabindex="-1" role="button" ><i class="fa-solid fa-house"></i>&nbsp;&nbsp;Página de Inicio</a>
            </div>
        </div>
    </div>
    @section('custom-js')
        <script src="{{ asset('js/layout.js') }}"></script>
        <!-- Puedes agregar más archivos JS específicos aquí -->
    @endsection
</x-header-footer>
