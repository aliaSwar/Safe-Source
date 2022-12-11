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
     *The Relation user can reserve one ore more file and the file can be reserved just to one user .
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The Relation Many File To One group
     *
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    /**
     *The Relation histories table store all updates file .
     */
    public function histories()
    {
        return $this->hasMany(History::class);
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