<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repositories extends Model
{
    use HasFactory;
    //capturar tabla 'repositories de la bd'
    protected $table = 'repositories';
}
