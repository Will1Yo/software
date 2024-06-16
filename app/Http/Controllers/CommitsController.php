<?php

namespace App\Http\Controllers;

use App\Models\Commits;
use App\Models\Files;
use App\Models\Repositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CommitsController extends Controller
{
    public function index($id_repo){
        $last_commit = Commits::select('commit')
            ->where('id_repo', $id_repo)
            ->orderBy('commit', 'desc')
            ->first();
        $commits = array();

        if ($last_commit) {
            for($i = 1; $i <= $last_commit->commit; $i++ ){
                $commit_description = Commits::select('update_comment', 'created_at', 'commit')
                    ->where('id_repo', $id_repo)
                    ->where('commit', $i)
                    ->first();
                if ($commit_description) {
                    $commits[] = [
                        'update_comment' => $commit_description->update_comment,
                        'created_at' => $commit_description->created_at->format('Y-m-d H:i:s'),
                        'commit' => $commit_description->commit,
                    ];
                }
            }
            $admin = DB::table('users')
            ->join('repositories', 'users.id', '=', 'repositories.user_id')
            ->where('repositories.id', $id_repo)
            ->select('users.id')
            ->first();

        }
        return view('commits.index', compact('commits', 'id_repo', 'admin'));
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
            $commit_files = Files::select('files', 'ruta')
                ->where('id_repo', $id_repo)
                ->where('id', $commit_id->id_files)
                ->first();

            $files[] = [
                'id' => $commit_id->id_files,
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
        if (!is_null($id_files)) {
            $before_commit = $commit -1;
            
            $commit_files = Files::select('path')
            ->where('id', $id_files)
            ->first();

            $name_repo = Repositories::select('name_repo')
            ->where('id', $id_repo)
            ->first();

            $file2 = str_replace("public\\", "", $commit_files->path);
            $usuario = strstr($file2, '\\', true);

            $extractPath = "$usuario\\$name_repo->name_repo$commit";
            $before_extractPath = "$usuario\\$name_repo->name_repo$before_commit";
            

            $file1 = str_replace($extractPath, $before_extractPath, $file2);
            
            $path_filtered1 = $file1;
            $path_filtered2 = $file2;    

            $filePath1 = public_path($path_filtered1);
            $filePath2 = public_path($path_filtered2);

            $rendered_diff = '';
            if ($filePath1 === $filePath2) {
                // Si las rutas de los archivos son iguales, establecer todas las líneas en rojo
                $fileContent1 = file_get_contents($filePath1);
                $linesFile1 = explode("\n", htmlspecialchars($fileContent1));
                $totalLinesFile1 = count($linesFile1);
                $formattedDiff = '';
            
                for ($lineNumber = 1; $lineNumber <= $totalLinesFile1; $lineNumber++) {
                    $lineFile1 = isset($linesFile1[$lineNumber - 1]) ? $linesFile1[$lineNumber - 1] : '';
                    if (!empty(trim($lineFile1))) {
                        $formattedDiff .= '<span class="line-diff line-diff-red"><span class="line-number">' . $lineNumber . '</span>- ' . $lineFile1 . "</span>\n";
                    }
                }
            
                $rendered_diff = "<pre class='diff-container'>$formattedDiff</pre>";
            } else {

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
                    $formattedDiff = '';

                    // Recorrer todas las líneas de los archivos
                    for ($lineNumber = 1; $lineNumber <= $maxLines; $lineNumber++) {
                        $lineFile1 = isset($linesFile1[$lineNumber - 1]) ? $linesFile1[$lineNumber - 1] : '';
                        $lineFile2 = isset($linesFile2[$lineNumber - 1]) ? $linesFile2[$lineNumber - 1] : '';

                        // Verificar si ambas líneas no están vacíasy
                        if (!empty(trim($lineFile1)) || !empty(trim($lineFile2))) {
                            // Comparar las líneas de ambos archivos y resaltar las diferencias
                            if ($lineFile1 !== $lineFile2) {
                                $formattedDiff .= '<span class="line-diff line-diff-red"><span class="line-number">' . $lineNumber . '</span>- ' . $lineFile1 . "</span>\n";
                                $formattedDiff .= '<span class="line-diff line-diff-green"><span class="line-number">' . $lineNumber . '</span>+ ' . $lineFile2 . "</span>\n";
                            } else {
                                // Si las líneas son iguales, mostrarlas sin resaltar
                                $formattedDiff .= '<span class="line-diff line-diff-white"><span class="line-number">' . $lineNumber . '</span>  ' . $lineFile1 . "</span>\n";
                            }
                        }
                    }

                    // Renderizar la diferencia con el contenido original
                    $rendered_diff = "<pre class='diff-container'>$formattedDiff</pre>";

                }else{
                    
                    $fileContent = '';
                    $linesFile = [];
                    $totalLines = 0;
                    if (!file_exists($filePath1)) {
                        $fileContent = file_get_contents($filePath2);
                    } elseif (!file_exists($filePath2)) {
                        $fileContent = file_get_contents($filePath1);
                    }
                    $linesFile = explode("\n", htmlspecialchars($fileContent));
                    $totalLines = count($linesFile);
                    $formattedDiff = '';
                
                    for ($lineNumber = 1; $lineNumber <= $totalLines; $lineNumber++) {
                        $lineFile = isset($linesFile[$lineNumber - 1]) ? $linesFile[$lineNumber - 1] : '';
                        if (!empty(trim($lineFile))) {
                            $formattedDiff .= '<span class="line-diff line-diff-green"><span class="line-number">' . $lineNumber . '</span>+ ' . $lineFile . "</span>\n";
                        }
                    }
                
                    $rendered_diff = "<pre class='diff-container'>$formattedDiff</pre>";
                }
            }

        }else{
            $rendered_diff = null;
        }
          

        $non_repeated_routes = array_unique($array_paths_clear);

        return view('commits.view', compact('files', 'non_repeated_routes', 'id_repo', 'id_files', 'commit', 'rendered_diff'));
    }

    public function delete($id_repo, $commit){

        //borrando repositorios
        Files::where('id_repo', $id_repo)
            ->where('commit', $commit)
            ->delete();

        Commits::where('id_repo', $id_repo)
        ->where('commit', $commit)
        ->delete();

        //capturando nombre de usuario y repositorio 
        $Repository_description = DB::table('repositories')
        ->join('users', 'repositories.user_id', '=', 'users.id')
        ->where('repositories.id', $id_repo)
        ->select('repositories.name_repo', 'users.name')
        ->first();

        //borrando repositorio interno
        $repository = $Repository_description->name_repo;
        $name = $Repository_description->name;
        $position = strpos($name, ' ');
        $user = substr($name, 0, $position);
        $directory = public_path("$user/$repository$commit");
        File::deleteDirectory($directory);
        
        return $this->index($id_repo);
    }   
}
