<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
