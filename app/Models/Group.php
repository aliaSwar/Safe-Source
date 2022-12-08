<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'is_public'];
    /**
     *  The reation many to many  with users
     *
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * One to many with files
     *
     */

    public function files()
    {
        return $this->hasMany(File::class);
    }

    /**
     * get key to route name
     *
     */

    public function getRouteKeyName()
    {
        return 'slug';
    }
}