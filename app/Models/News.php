<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $id = 'id';
    protected $fillable = ['title', 'content', 'id_user'];
    protected $foreignId = 'id_user';
}
