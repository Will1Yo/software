<?php

namespace App\Http\Controllers;

use App\Models\Collaborators;
use App\Models\Commits;
use App\Models\Files;
use App\Models\Repositories;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use function PHPUnit\Framework\isNull;

class RepositoriesController extends Controller
{
    //función que me retorna a la vista principal con un parametro que envía todos los repositorios
    public function index(){
        $repositories = Repositories::where('user_id', session('user_id'))->orderBy('name_repo', 'asc')->get();
        $repositories_colla = DB::table('collaborators')
        ->join('repositories', 'collaborators.id_repo', '=', 'repositories.id')
        ->join('users', 'repositories.user_id', '=', 'users.id')
        ->select('collaborators.confirmation', 'repositories.id as repo_id', 'repositories.name_repo', 'users.id', 'users.name', 'users.email', 'collaborators.id' )
        ->where('collaborators.user_id', session('user_id'))
        ->get();
        $user_id_count = Collaborators::where('user_id', session('user_id'))
        ->where('confirmation', 0)
        ->count();


        return view('index', compact('repositories', 'user_id_count', 'repositories_colla'));
    }
    //función que me retorna a la vista de creación de repositorio 
    public function create(){
        return view('repositories.create');
    }

    public function delete($id){
        $Repositorie_name = Repositories::select('name_repo')
            ->where('id', $id)
            ->first();

        $last_commit = Commits::select('commit')
        ->where('id_repo', $id)
        ->orderBy('commit', 'desc')
        ->first();

        if(!is_null($last_commit)){
            for($i = $last_commit->commit; $i > 0; $i--){
                $name = session('user_name');
                $directory = public_path("$name/{$Repositorie_name->name_repo}$i");
                File::deleteDirectory($directory);
            }

            $fileName = $Repositorie_name->name_repo . $name.'.zip';
            $destinationPath = "uploads/$fileName";
            unlink($destinationPath);
        }
       
        Repositories::where('id', $id)
        ->delete();
        return redirect('/');
    }
    //función create de repositorio
    public function store(Request $request){
        $repositories = new Repositories();
        $repositories->name_repo = $request->name_repo;
        $repositories->description = $request->description;
        $repositories->restriction = $request->restriction;
        $repositories->user_id = session('user_id');
        $repositories->save();
        return redirect('/');
    }
    //función que me retorna a la vista donde se mostrará el contenido del repositorio filtrado con su parámetro de id
    public function show($id_repo){
        $files = Files::where('id_repo', $id_repo)->first();
        if($files){
            return redirect('/files/view/'.$id_repo);

        }else{
            $repositories = Repositories::find($id_repo);

            return view('repositories.index', compact('repositories'));
        }
    }
    public function checkRepoName(Request $request)
    {
        $nameRepo = $request->query('name_repo');
        $exists = Repositories::where('name_repo', $nameRepo)->where('user_id', session('user_id'))->exists();

        return response()->json(['exists' => $exists]);
    }

    public function search(Request $request){
        $nameRepo = $request->query('name_repo');
        $repositories = Repositories::select('name_repo', 'id')
            ->where('name_repo', 'like', '%' . $nameRepo . '%')
            ->where('user_id', session('user_id'))
            ->get();

        return response()->json(['repositories' => $repositories]);
    }

    public function collaborator_confirmation($id_collaborators){
        $collaborator = Collaborators::find($id_collaborators);
        $collaborator->confirmation = true;
        $collaborator->save();
        return redirect('/');
    }

    public function collaborator_decline($id_collaborators){
        Collaborators::where('id', $id_collaborators)
        ->delete();
        return redirect('/');
    }

}
