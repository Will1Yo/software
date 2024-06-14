<?php

namespace App\Http\Controllers;

use App\Models\Commits;
use App\Models\Files;
use App\Models\Repositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ZipArchive;


class FilesController extends Controller
{
    public function index($id_repo){
        $files = Files::where('id_repo', $id_repo)->first();
        if($files){
            $redirect = $this->show($id_repo, "",1);
            return $redirect;
        }else{
            $repositories = Repositories::find($id_repo);
            $type = "create";
            return view('repositories.index', compact('repositories','type'));
        }
    }

    public function show($id_repo, $id_files = null ,$path = null){
        $last_commit = Files::select('commit')
        ->where('id_repo', $id_repo)
        ->orderBy('commit', 'desc')
        ->first();

        $latest_files = Files::select('id', 'files', 'ruta')
        ->where('id_repo', $id_repo)
        ->where('commit', $last_commit->commit)
        ->get();

        $commits_and_files = array();

        foreach($latest_files as $last_file){
            if  (strpos($last_file->ruta, '/') == false){
                $files_description = Commits::select('update_comment', 'updated_at', 'commit', 'id_files')
                ->where('id_repo', $id_repo)
                ->where('ruta', $last_file->ruta)
                ->orderBy('commit', 'desc')
                ->first();
                
                $commits_and_files[] = [
                    'id' => $last_file->id,
                    'file' => $last_file->files,
                    'ruta' => $last_file->ruta,
                    'update_comment' => $files_description->update_comment,
                    'updated_at' => $files_description->updated_at,
                    'commit' => $files_description->commit,
                    'id_files' => $files_description->id_files,
                ];
            }
           
        }

        $files = Files::where('id_repo', $id_repo)->where('commit', $last_commit->commit)->get();
        $repository_description = Repositories::select('description','restriction', 'name_repo')->find($id_repo);
        $array_commnets = array();
        $array_paths_clear = [];

        if($id_files == "Folder"){
            $files_open = "Folder";
        }else{
            $files_open = Files::select('path')->find($id_files);
        }

        foreach($files as $array_path){
            $paths = $array_path->ruta;
            $lastSlashPos = strrpos($paths, '/');
            if ($lastSlashPos !== false) {
                $path_clear = substr($paths, 0, $lastSlashPos);
                if($path !== null){
                    $lastpath = strrpos($path_clear, '/');
                    if ($lastpath == false) {
                        $array_paths_clear[] = $path_clear;
                    }
                }else{
                    $array_paths_clear[] = $path_clear;
                }
            }  
        }
        $non_repeated_routes =  array_unique($array_paths_clear);

        $array_commnets = array();
        foreach($non_repeated_routes as $files_description_array){
            $folder_description = Commits::select('update_comment', 'updated_at', 'commit')
            ->where('id_repo', $id_repo)
            ->where('ruta', 'like', $files_description_array . '/%')
            ->orderBy('commit', 'desc')
            ->first();
            if ($folder_description) {
                // Acceder a las propiedades del modelo y guardar en el array
                $array_commnets[] = [
                    'path' => $files_description_array,
                    'update_comment' => $folder_description->update_comment,
                    'updated_at' => $folder_description->updated_at,
                    'commit' => $folder_description->commit,
                ];
            }
        }

        if($path !== null){
            return view('files.index', compact('files', 'non_repeated_routes','id_repo', 'repository_description', 'array_commnets', 'commits_and_files', 'last_commit'));
        }else{
            return view('files.view', compact('non_repeated_routes','files', 'files_open','repository_description', 'id_files', 'id_repo'));
        }
    }
    
    public function store(Request $request){   
        $files_find = Files::select('commit')
            ->where('id_repo', $request->id)
            ->orderBy('commit', 'desc')
            ->first();
        $usuario = DB::table('repositories')
        ->join('users', 'repositories.user_id', '=', 'users.id')
        ->where('repositories.id', $request->id)
        ->select('users.name')
        ->first();
        $position = strpos($usuario->name, ' ');
        $user = substr($usuario->name, 0, $position);
    
        if(is_null($files_find)){
            $num_commit = 1;
            $num = "1";
        } else {
            $num_commit_intervalo = $files_find->commit + 1;
            $num_commit = $num_commit_intervalo;
            $num = "$num_commit_intervalo";
        }
        $home = "/repositories/view";
        
        $file = $request->file('files');
        if(empty($file)) return redirect("$home?error=No se ha recibido un archivo");
    
        $fileName = $request->name_repo .$user. '.zip';
        $destinationPath = "uploads/$fileName";
        if (file_exists($destinationPath)) {
            unlink($destinationPath);
        }
        $file->move(public_path('uploads'), $fileName);
    
        $extractPath = "$user/$request->name_repo$num";
        $zip = new ZipArchive();
        $empty_insert = [];
        $opened = $zip->open(public_path($destinationPath), ZipArchive::CREATE);
        if ($opened === true) {
            $zip->extractTo(public_path($extractPath));
            $zip->close();
            $files = scandir(public_path("$extractPath"));
            
            foreach($files as $file) {
                if ($file != "." && $file != "..") {
                    $file_Path_extraction = $file;
                }
            }
    
            if($num_commit > 1){
                $before_num_commit = $num_commit - 1;
            } else {
                $before_num_commit = 1;
            }
    
            foreach($files as $file) {
                if ($file != "." && $file != "..") {
                    $file_path = public_path("$extractPath/$file");
                    
                    if (is_dir($file_path)) {
                        $nested_files = scandir($file_path);
                        foreach ($nested_files as $nested_file) {
                            if ($nested_file != "." && $nested_file != "..") {
                                $nested_file_path = public_path("$extractPath/$file/$nested_file");
                                
                                if (is_dir($nested_file_path)) {
                                    $this->scanAndSaveFiles($request->id, $extractPath, "$file/$nested_file", $request, $file_Path_extraction, $num_commit, $before_num_commit, $empty_insert);
                                } else {
                                    $this->insert($nested_file, $nested_file_path, $file_Path_extraction, $request, $num_commit, $before_num_commit, $empty_insert);
                                }
                            }
                        }
                    } else {
                        $this->insert($file, $file_path, $file_Path_extraction, $request, $num_commit, $before_num_commit, $empty_insert, $direct_file = 1);
                    }
                }
            }
    
            if((is_null($files_find)) == false){
                $this->update($request->id, $num_commit_intervalo, $request->update_comment, $empty_insert);
                if (!in_array(true, $empty_insert, true)) {
                    Files::where('id_repo', $request->id)->where('commit', $num_commit_intervalo)->delete();
                    $redirect = $this->show($request->id, "",1);
                    return $redirect;
                }else{
                    $path_view = scandir(public_path("$extractPath/$file_Path_extraction"));
                    return view('repositories.view', ['files' => $path_view, 'id_repo' => $request->id]);
                }
                
            }else{
                $path_view = scandir(public_path("$extractPath/$file_Path_extraction"));    
                return view('repositories.view', ['files' => $path_view, 'id_repo' => $request->id]);
            }
            
            
        } 
    }
    
    private function scanAndSaveFiles($repo_id, $extractPath, $sub_directory, $request, $file_Path_extraction, $num_commit, $before_num_commit, &$empty_insert) {
        $nested_files = scandir(public_path("$extractPath/$sub_directory"));
        foreach ($nested_files as $nested_file) {
            if ($nested_file != "." && $nested_file != "..") {
                $nested_file_path = public_path("$extractPath/$sub_directory/$nested_file");
                if (is_dir($nested_file_path)) {
                    $this->scanAndSaveFiles($repo_id, $extractPath, "$sub_directory/$nested_file", $request, $file_Path_extraction, $num_commit, $before_num_commit, $empty_insert);
                } else {
                    $this->insert($nested_file, $nested_file_path, $file_Path_extraction, $request, $num_commit, $before_num_commit, $empty_insert);
                }
            }
        }
    }
    
    public function insert($nested_file, $file_path, $file_Path_extraction, $request, $num_commit, $before_num_commit, &$empty_insert, $direct_file = null){
        $Save_File = new Files();
        $Save_File->files = $nested_file;
    
        if($direct_file !== null){
            $route_position = strpos($file_path, $file_Path_extraction);
            $route_position = substr($file_path, $file_Path_extraction + 1);
        } else {
            $route_position = strpos($file_path, $file_Path_extraction);
            $route_position = substr($file_path, $route_position + 1);
        }
    
        $path_position = strpos($route_position, '/');
        $route_position = substr($route_position, $path_position + 1);
        $posicion_path = strpos($file_path, 'public');
        $subcadena = substr($file_path, $posicion_path); 
        $path_con_backslash = str_replace('/', '\\', $subcadena);
        $Save_File->ruta = $route_position;
        $Save_File->path = $path_con_backslash;
        $Save_File->id_repo = $request->id;
        $Save_File->commit = $num_commit;
        $Save_File->save();
    
        if($num_commit == 1){
            $file_id = Files::select('id')
                ->where('path', $path_con_backslash)
                ->first();
            $Save_Commit = new Commits();
            $Save_Commit->update_comment = $request->update_comment;
            $Save_Commit->commit = $num_commit;
            $Save_Commit->ruta = $route_position;
            $Save_Commit->id_files = $file_id->id;
            $Save_Commit->id_repo = $request->id;
            $Save_Commit->save();
        } else {
            $validate_commit = $this->validate_commit($request, $num_commit, $before_num_commit, $file_path);
            $empty_insert[] = $validate_commit;
            if($validate_commit == true){
                $file_id = Files::select('id')
                    ->where('path', $path_con_backslash)
                    ->first();
                $Save_Commit = new Commits();
                $Save_Commit->update_comment = $request->update_comment;
                $Save_Commit->commit = $num_commit;
                $Save_Commit->ruta = $route_position;
                $Save_Commit->id_files = $file_id->id;
                $Save_Commit->id_repo = $request->id;
                $Save_Commit->save();
            }
        }
    }
    
    public function validate_commit($request,  $num_commit, $before_num_commit, $file1){
        $usuario = DB::table('repositories')
        ->join('users', 'repositories.user_id', '=', 'users.id')
        ->where('repositories.id', $request->id)
        ->select('users.name')
        ->first();
        $position = strpos($usuario->name, ' ');
        $user = substr($usuario->name, 0, $position);
    
        $extractPath = "$user/$request->name_repo$num_commit";
        $before_extractPath = "$user/$request->name_repo$before_num_commit";
        $file2 = str_replace($extractPath, $before_extractPath, $file1);


        if (file_exists($file1) && file_exists($file2)) {
            // Leer contenido de los archivos;
            $content1 = file_get_contents($file1);
            $content2 = file_get_contents($file2);
            if ($content1 === $content2) {
                return  false;
            } else {
                return  true;
            }
        }
        return  true;     
    }    
       
    public function open($id_files){
        $files_open = Files::select('path')->find($id_files);
        return view("files.open", compact("files_open"));
    }

    public function update($id_repo, $last_commit = null, $update_comment = null, &$empty_insert = null){
        if($last_commit == null){
            $repositories = Repositories::find($id_repo);
            $type = "update";
            return view('repositories.index', compact('repositories', 'type'));
        }else{

            // Paso 1: Obtener todos los registros completos de files_new
                // Paso 1: Obtener todos los registros completos de files_new
            $files_new = Files::select('id', 'ruta')
            ->where('id_repo', $id_repo)
            ->where('commit', $last_commit)
            ->get();

            // Paso 2: Obtener todas las rutas del commit anterior
            $before_commit = $last_commit - 1;
            $files_old = Files::select('ruta')
            ->where('id_repo', $id_repo)
            ->where('commit', $before_commit)
            ->get();

            // Lógica adicional: Encontrar archivos que estaban en el commit anterior pero no en el nuevo
            $old_missing_files = [];

            $files_new_rutas = $files_new->pluck('ruta')->toArray();

            // Paso 3: Recorrer los archivos en files_old y comparar las rutas
            foreach ($files_old as $file_old) {
                // Limpiar espacios en blanco adicionales de la ruta
                $ruta_old = trim($file_old->ruta);

                // Verificar si la ruta del archivo en files_old no está presente en files_new_rutas
                if (!in_array($ruta_old, array_map('trim', $files_new_rutas))) {
                    // Almacenar la ruta en el array
                    $old_missing_files[] = $ruta_old;
                }
            }

            // Paso 5: Guardar los commits si el array old_missing_files no está vacío
            // Verificar si el array old_missing_files no está vacío
            if (!empty($old_missing_files)) {
                foreach ($old_missing_files as $ruta) {
                    
                    $files_old = Files::select('id')
                    ->where('id_repo', $id_repo)
                    ->where('commit', $before_commit)
                    ->where('ruta', $ruta)
                    ->first();

                    $Save_Commit = new Commits();
                    $Save_Commit->update_comment = $update_comment;
                    $Save_Commit->commit = $last_commit;
                    $Save_Commit->ruta = $ruta; // Accediendo directamente a la ruta
                    $Save_Commit->id_files = $files_old->id;; // No hay ID correspondiente en el nuevo commit
                    $Save_Commit->id_repo = $id_repo;
                    $Save_Commit->save();
                    $empty_insert[] = true;

                    // Intentar guardar y capturar cualquier excepción
                   
                }
            }

        }
    
    }
}
