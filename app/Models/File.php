<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'slug',
        'user_id'
    ];

    /**
     *The Relation Many to Many User table
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'histories')->withPivot('date', 'status');
    }

    /**
     * The Relation Many File To Oe group
     *
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    /**
     * get key route name
     */

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Asset Path Storage File
     */
    public function getPathAttribute($value)
    {
        return asset("storage/{$value}");
    }
}