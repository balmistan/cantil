<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Songs extends Model
{
    protected $table = 'songs';

    protected $primaryKey = 'id';

    protected $fillable = [
        'numb',
        'title',
        'autor',
        'groups',
        'video',
        'status',
        'position',
        'description',
        'txt',
    ];

    protected $casts = [
        'position' => 'integer',
    ];
}
