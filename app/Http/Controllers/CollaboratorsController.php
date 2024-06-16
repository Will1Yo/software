<?php

namespace App\Http\Controllers;

use App\Models\Collaborators;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CollaboratorsController extends Controller
{
    public function index($id_repo)
    {
        $collaborators = DB::table('collaborators')
            ->join('users', 'collaborators.user_id', '=', 'users.id')
            ->select('collaborators.confirmation', 'users.id', 'users.name', 'users.email')
            ->where('id_repo', $id_repo)
            ->get();

        return view('Users.index', compact('id_repo', 'collaborators'));
    }

    public function search(Request $request)
    {
        $user_request = $request->query('user');
        $repo_id = $request->query('repo');
        $validate = $request->query('validar');
        if($validate == "users"){
            $users_id = Collaborators::select('user_id')
            ->where('id_repo', $repo_id)
            ->get();
    
            $users = User::select('name', 'email', 'id')
                ->where(function ($query) use ($user_request) {
                    $query->where('name', 'like', '%' . $user_request . '%')
                        ->orWhere('email', 'like', '%' . $user_request . '%');
                })
                ->where('id', '!=', session('user_id'))
                ->whereNotIn('id', $users_id)           // Excluir los ids capturados en $users_id
                ->get();
        }else{
            $users = DB::table('collaborators')
            ->join('users', 'collaborators.user_id', '=', 'users.id')
            ->select('collaborators.confirmation', 'users.id', 'users.name', 'users.email')
            ->where('id_repo', $repo_id)
            ->where(function($query) use ($user_request) {
                $query->where('users.name', 'like', '%' . $user_request . '%')
                    ->orWhere('users.email', 'like', '%' . $user_request . '%');
            })
            ->get();

        }
       
        return response()->json(['repositories' => $users]);
    }

    public function create($id_repo, $id_user)
    {
        $collaborators = new Collaborators();
        $collaborators->confirmation = false;
        $collaborators->user_id = $id_user;
        $collaborators->id_repo = $id_repo;
        $collaborators->save();
        return $this->index($id_repo);
    }

    public function delete($id_repo, $id_user)
    {
        Collaborators::where('id_repo', $id_repo)
            ->where('user_id', $id_user)
            ->delete();
        return $this->index($id_repo);
    }
}
