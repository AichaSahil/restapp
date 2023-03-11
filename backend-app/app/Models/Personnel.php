<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    use HasFactory;
    protected $primaryKey ='numPersonnel';
    protected $fillable = ['numPersonnel',	'nomPersonnel',	'prenomPersonnel',	'age'];
}
