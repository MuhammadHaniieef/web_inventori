<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserGuide extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'file_path',
    ];
}
