<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plat extends Model
{
    use HasFactory;
    protected $primaryKey ='idPlat';
    protected $fillable = ['titlePlat',	'prixPlat',	'imgPlat'];
   
}
