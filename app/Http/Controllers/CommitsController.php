<?php

namespace App\Http\Controllers;

use App\Models\Commits;
use App\Models\Files;
use Illuminate\Http\Request;

class CommitsController extends Controller
{
    public function index($id_repo)
    {
        // Código de tu función index aquí...
    }

    public function store($id_repo, $commit, $id_files = null)
    {
        // Obtener los IDs de los archivos del commit
        $commit_ids = Commits::select('id_files')
            ->where('id_repo', $id_repo)
            ->where('commit', $commit)
            ->get();

        $files = [];
        $array_paths_clear = [];

        foreach ($commit_ids as $commit_id) {
            $commit_files = Files::select('id', 'files', 'ruta')
                ->where('id_repo', $id_repo)
                ->where('id', $commit_id->id_files)
                ->first();

            $files[] = [
                'id' => $commit_files->id,
                'file' => $commit_files->files,
                'ruta' => $commit_files->ruta,
            ];
        }

        foreach ($files as $file) {
            $paths = $file['ruta'];
            $lastSlashPos = strrpos($paths, '/');
            if ($lastSlashPos !== false) {
                $path_clear = substr($paths, 0, $lastSlashPos);
                $array_paths_clear[] = $path_clear;
            }
        }

        $path_filtered1 = 'Wilson/Aurelio1/PracticaBD/conexion.php';
        $path_filtered2 = 'Wilson/Aurelio2/PracticaBD/conexion.php';

        $filePath1 = public_path($path_filtered1);
        $filePath2 = public_path($path_filtered2);

        $rendered_diff = '';

        if (file_exists($filePath1) && file_exists($filePath2)) {
            $fileContent1 = file_get_contents($filePath1);
            $fileContent2 = file_get_contents($filePath2);

            // Obtener todas las líneas de ambos archivos
            $linesFile1 = explode("\n", htmlspecialchars($fileContent1));
            $linesFile2 = explode("\n", htmlspecialchars($fileContent2));

            // Obtener el número total de líneas en ambos archivos
            $totalLinesFile1 = count($linesFile1);
            $totalLinesFile2 = count($linesFile2);

            // Asegurarse de que ambos archivos tengan el mismo número de líneas para comparar
            $maxLines = max($totalLinesFile1, $totalLinesFile2);

            // Inicializar el string de diferencia formateado
           // Inicializar el string de diferencia formateado
           // Inicializar los strings de diferencia formateados para líneas rojas y verdes
            // Inicializar los strings de diferencia formateados para líneas rojas y verdes
            $formattedDiffRed = '';
            $formattedDiffGreen = '';
            $formattedDiffWhiteStart = '';
            $formattedDiffWhiteEnd = '';

            // Variable para indicar si ya pasamos las líneas rojas y verdes
            $passedRedGreen = false;

            // Recorrer todas las líneas de los archivos
            for ($lineNumber = 1; $lineNumber <= $maxLines; $lineNumber++) {
                $lineFile1 = isset($linesFile1[$lineNumber - 1]) ? $linesFile1[$lineNumber - 1] : '';
                $lineFile2 = isset($linesFile2[$lineNumber - 1]) ? $linesFile2[$lineNumber - 1] : '';

                // Verificar si ambas líneas no están vacías
                if (!empty(trim($lineFile1)) || !empty(trim($lineFile2))) {
                    // Comparar las líneas de ambos archivos y resaltar las diferencias
                    if ($lineFile1 !== $lineFile2) {
                        // Si ya pasamos las líneas rojas y verdes, entonces estamos en la sección de líneas blancas
                        $passedRedGreen = true;
                        $formattedDiffRed .= '<span class="line-diff line-diff-red"><span class="line-number">' . $lineNumber . '</span>- ' . $lineFile1 . "</span>\n";
                        $formattedDiffGreen .= '<span class="line-diff line-diff-green"><span class="line-number">' . $lineNumber . '</span>+ ' . $lineFile2 . "</span>\n";
                    } else {
                        // Si las líneas son iguales y aún no pasamos las líneas rojas y verdes
                        if (!$passedRedGreen) {
                            // Solo agregamos las líneas blancas al principio
                            $formattedDiffWhiteStart .= '<span class="line-diff line-diff-white"><span class="line-number">' . $lineNumber . '</span>  ' . $lineFile1 . "</span>\n";
                        } else {
                            // Si las líneas son iguales y ya pasamos las líneas rojas y verdes
                            // Solo agregamos las líneas blancas al final
                            $formattedDiffWhiteEnd .= '<span class="line-diff line-diff-white"><span class="line-number">' . $lineNumber . '</span>  ' . $lineFile1 . "</span>\n";
                        }
                    }
                }
            }

            // Combina las líneas rojas y verdes
            $formattedDiff = $formattedDiffRed . $formattedDiffGreen;

            // Agrega las líneas blancas que están al principio
            $formattedDiff = $formattedDiffWhiteStart . $formattedDiff;

            // Agrega las líneas blancas que están al final
            $formattedDiff .= $formattedDiffWhiteEnd;

            // Renderizar la diferencia con el contenido original
            $rendered_diff = "<pre class='diff-container'>$formattedDiff</pre>";
        }

        $non_repeated_routes = array_unique($array_paths_clear);

        return view('commits.view', compact('files', 'non_repeated_routes', 'id_repo', 'id_files', 'rendered_diff'));
    }
}

