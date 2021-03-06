<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class registro extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'temperatura',
        'protocoloCompleto',
        'conMascarilla',
        'sinMascarilla',
        'usoDeGel',
        'foto'
    ];

    protected $dates = ['created_at', 'updated_at'];
}
