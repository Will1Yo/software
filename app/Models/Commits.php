<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commits extends Model
{
    use HasFactory;
     //capturar tabla 'commits de la bd'
     protected $table = 'commits';
}
