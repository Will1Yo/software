@section('title')
    Home
@endsection
@section('custom-css')
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <!-- Puedes agregar más archivos CSS específicos aquí -->
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
    @section('custom-js')
        <script src="{{ asset('js/main.js') }}"></script>
        <!-- Puedes agregar más archivos JS específicos aquí -->
    @endsection
</x-header-footer>