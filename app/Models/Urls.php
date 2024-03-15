<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Urls extends Model
{
    protected $table = 'urls';
    protected $fillable = [
        'original_url',
        'uri_token',
        'user_id',
    ];
    use HasFactory;
}
