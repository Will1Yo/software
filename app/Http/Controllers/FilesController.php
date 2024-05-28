<?php

namespace App\Http\Controllers;

use App\Models\Files;
use App\Models\Repositories;
use Illuminate\Http\Request;
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
            return view('repositories.index', compact('repositories'));
        }
    }

    public function show($id_repo, $id_files = null ,$path = null){
        $files = Files::where('id_repo', $id_repo)->get();
        $repository_description = Repositories::select('description','restriction')->find($id_repo);
        $files_description = Files::select('update_comment')->where('id_repo', $id_repo)->first();
        $files_open = Files::select('path')->find($id_files);
        $array_paths_clear = [];

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
        if($path !== null){
            return view('files.index', compact('files', 'non_repeated_routes','id_repo', 'repository_description'));
        }else{
            return view('files.view', compact('non_repeated_routes','files','files_description', 'files_open'));
        }
    }
    
    public function store(Request $request){   
        $home = "/repositories/view";
        //Extrayecto el nombre del archivo sin su extención .zip
        $file_Path_extraction = $request->file('files')->getClientOriginalName();
        $file_Path_extraction = str_replace(".zip", '', $file_Path_extraction);
        //Capturando archivo enviado y convirtiendolo a un array de tipo File
        $file = $request->file('files');
        if(empty($file)) return redirect("$home?error=No se ha recibido un archivo");

        //Creando la carpeta uploads, moviendo el archivo .zip recibido y reenombrandolo con el nombre del repositorio
        $fileName = $request->name_repo . '.zip';
        $destinationPath = "uploads/$fileName";
        $file->move(public_path('uploads'), $fileName);
        
        //Buscamos la ruta del archivo .zip local
        $extractPath = "Wilson/$request->name_repo";
        $zip = new ZipArchive();
        $path_complete = $extractPath . "/" . $file_Path_extraction;
        //Abrimos el repositorio y lo extramos para pasar a su lectura
        $opened = $zip->open(public_path($destinationPath), ZipArchive::CREATE);
        if ($opened === true) {
            $zip->extractTo(public_path($extractPath));
            $zip->close();
            $files = scandir(public_path("$extractPath"));
            //se realiza la lectura del los archivos dentro del archivo extraido
            foreach($files as $file) {
                // Ignorar "." y ".."
                if ($file != "." && $file != "..") {
                    $file_path = public_path("$extractPath/$file");
                    
                    // Si es un directorio, escanear recursivamente
                    if (is_dir($file_path)) {
                        // Escanear archivos dentro del directorio actual
                        $nested_files = scandir($file_path);
                        foreach ($nested_files as $nested_file) {
                            if ($nested_file != "." && $nested_file != "..") {
                                $nested_file_path = public_path("$extractPath/$file/$nested_file");
                                
                                // Si es un directorio, escanear recursivamente
                                if (is_dir($nested_file_path)) {
                                    // Llamar recursivamente a la función para escanear el directorio
                                    // y guardar los archivos encontrados
                                    $this->scanAndSaveFiles($request->id, $extractPath, "$file/$nested_file", $request, $file_Path_extraction);
                                } else {
                                    // Si es un archivo directamente, guardarlo
                                    $Save_File = new Files();
                                    $Save_File->files = $nested_file;
                                    $route_position= strpos($nested_file_path, $file_Path_extraction);
                                    $route_position = substr($nested_file_path, $route_position + 1);
                                    $path_position = strpos($route_position, '/');
                                    $route_position = substr($route_position, $path_position + 1);
                                    $posicion_path = strpos($nested_file_path, 'public');
                                    $subcadena = substr($nested_file_path, $posicion_path);
                                    $path_con_backslash = str_replace('/', '\\', $subcadena);
                                    $Save_File->ruta = $route_position;
                                    $Save_File->path = $path_con_backslash;
                                    $Save_File->id_repo = $request->id;
                                    $Save_File->update_comment = $request->update_comment;
                                    $Save_File->save();
                                }
                            }
                        }
                    } else {
                        // Si es un archivo directamente, guardarlo
                        $Save_File = new Files();
                        $Save_File->files = $file;
                        $route_position= strpos($file_path, $file_Path_extraction);
                        $route_position = substr($file_path, $file_Path_extraction + 1);
                        $path_position = strpos($route_position, '/');
                        $route_position = substr($route_position, $path_position + 1);
                        $posicion_path = strpos($file_path, 'public');
                        $subcadena = substr($file_path, $posicion_path);
                        $path_con_backslash = str_replace('/', '\\', $subcadena);
                        $Save_File->ruta = $route_position;
                        $Save_File->path = $path_con_backslash;
                        $Save_File->id_repo = $request->id;
                        $Save_File->update_comment = $request->update_comment;
                        $Save_File->save();
                    }
                }
            }
            //retornamos a la vista repositories.view para la visualización del repositorio extraido
            $path_view = scandir(public_path("$extractPath/$file_Path_extraction"));
            return view('repositories.view', ['files' => $path_view]);
        } else {
            return redirect("$home?error=Error al abrir el archivo zip");
        }
    } 
    
    // Función para escanear recursivamente los archivos y guardarlos
    private function scanAndSaveFiles($repo_id, $extractPath, $sub_directory, $request, $file_Path_extraction) {
        $nested_files = scandir(public_path("$extractPath/$sub_directory"));
        foreach ($nested_files as $nested_file) {
            if ($nested_file != "." && $nested_file != "..") {
                $nested_file_path = public_path("$extractPath/$sub_directory/$nested_file");
                if (is_dir($nested_file_path)) {
                    // Si es un directorio, escanear recursivamente
                    $this->scanAndSaveFiles($repo_id, $extractPath, "$sub_directory/$nested_file", $request, $file_Path_extraction);
                } else {
                    // Si es un archivo directamente, guardarlo
                    $Save_File = new Files();
                    $Save_File->files = $nested_file;
                    $route_position= strpos($nested_file_path, $file_Path_extraction);
                    $route_position = substr($nested_file_path, $route_position + 1);
                    $path_position = strpos($route_position, '/');
                    $route_position = substr($route_position, $path_position + 1);
                    $posicion_path = strpos($nested_file_path, 'public');
                    $subcadena = substr($nested_file_path, $posicion_path);
                    $path_con_backslash = str_replace('/', '\\', $subcadena);
                    $Save_File->ruta = $route_position;
                    $Save_File->path = $path_con_backslash;
                    $Save_File->id_repo = $repo_id;
                    $Save_File->update_comment = $request->update_comment;
                    $Save_File->save();
                }
            }
        }
    }

    public function open($id_files){
        $files_open = Files::select('path')->find($id_files);
        return view("files.open", compact("files_open"));
    }

}
