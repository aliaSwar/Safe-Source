<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'file_id',
        'status'
    ];

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}