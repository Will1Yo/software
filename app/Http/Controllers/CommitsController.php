<?php

namespace App\Http\Controllers;

use App\Models\Commits;
use App\Models\Files;
use Illuminate\Http\Request;

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
                $commit_description = Commits::select('update_comment', 'created_at')
                    ->where('id_repo', $id_repo)
                    ->where('commit', $i)
                    ->first();
                if ($commit_description) {
                    $commits[] = [
                        'update_comment' => $commit_description->update_comment,
                        'created_at' => $commit_description->created_at->format('Y-m-d H:i:s'),
                    ];
                }
            }
        }
        return view('commits.index', compact('commits', 'id_repo'));
    }
    
}
