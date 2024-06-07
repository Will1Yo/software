@section('title')
    Commits
@endsection

@section('custom-css')
    <link href="{{ asset('css/commts.css') }}" rel="stylesheet">
    <!-- Puedes agregar más archivos CSS específicos aquí -->
@endsection

<x-header-footer>
   <div class="row mt-5 justify-content-center">
        <div class="col-8">
            <div>
                <h3>Commits</h3>
                <hr style="color: white">
            </div>
            <div class="flex flex-col items-center w-full max-w-4xl mx-auto space-y-8 py-12 md:py-16">
                @php
                    // Ordenar los commits por fecha más reciente
                    $sortedCommits = collect($commits)->sortByDesc('created_at');
                @endphp
                
                @foreach ($sortedCommits as $commit)
                    @php
                        // Cadena timestamp
                        $cadena = $commit['created_at'];

                        // Dividir la cadena en dos partes usando el espacio como delimitador
                        list($fecha, $hora) = explode(" ", $cadena);

                        // Combinar fecha y hora en un solo string para crear un objeto DateTime
                        $datetime = new DateTime($fecha . ' ' . $hora);

                        // Obtener el tiempo actual
                        $now = new DateTime();

                        // Calcular la diferencia
                        $interval = $now->diff($datetime);

                        // Mostrar los resultados
                        if ($interval->d > 0) {
                            $tiempo = "Hace " . $interval->d . " días";
                        } elseif ($interval->h > 0) {
                            $tiempo = "Hace " . $interval->h . " horas";
                        } elseif ($interval->i > 0) {
                            $tiempo = "Hace " . $interval->i . " minutos";
                        } else {
                            $tiempo = "Hace unos segundos";
                        }

                        list($fecha, $hora) = explode(" ", $cadena);

                        // Crear un objeto DateTime con la fecha
                        $datetime_fecha = new DateTime($fecha);

                        // Definir los nombres de los meses en español
                        $meses = array(
                            1 => 'enero',
                            2 => 'febrero',
                            3 => 'marzo',
                            4 => 'abril',
                            5 => 'mayo',
                            6 => 'junio',
                            7 => 'julio',
                            8 => 'agosto',
                            9 => 'septiembre',
                            10 => 'octubre',
                            11 => 'noviembre',
                            12 => 'diciembre'
                        );

                        // Obtener el día, mes y año de la fecha
                        $dia = $datetime->format('d');
                        $mes = $meses[(int)$datetime_fecha->format('m')];
                        $año = $datetime_fecha->format('Y');

                        // Formatear la fecha en el formato deseado
                        $fechaFormateada = $dia . " de " . $mes . " de " . $año;

                        // Mostrar el resultado
                        $fecha = "Se realizó el: " . $fechaFormateada; // Resultado: 3 de junio de 2024
                    @endphp 

                    <div class="chain-container">
                        <span class="chain-icon"></span>
                        <i style="color: white">{{$fecha}}</i>&nbsp;&nbsp; <a href="/commits/delete/{{$id_repo}}/{{$commit['commit']}}"><i class="fa-solid fa-trash" style="color: rgb(209, 31, 31)"></i></a>
                    </div>
                    <div class="w-full container">
                        <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover custom-link" href="/commits/view/{{$id_repo}}/{{$commit['commit']}}">
                            <h4 class="text-2xl font-bold link-text">{{$commit['update_comment']}} </h4>
                        </a>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">{{$tiempo}} </p>
                    </div>
                @endforeach
                <div class="mt-5">
                    <a href="/files/index/{{$id_repo}}" class="btn btn-primary" tabindex="-1" role="button">
                        <i class="fa-solid fa-chevron-left"></i>&nbsp;&nbsp;Regresar
                    </a>
                </div>
            </div>       
        </div>
   </div>

   @section('custom-js')
   <script src="{{ asset('js/commts.js') }}"></script>
   <!-- Puedes agregar más archivos JS específicos aquí -->
    @endsection 

</x-header-footer>
