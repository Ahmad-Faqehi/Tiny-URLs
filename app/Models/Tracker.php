<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{
    protected $table = 'tracker';
    protected $fillable = [
        'uri_id',
        'num_click',
    ];
    use HasFactory;
}
