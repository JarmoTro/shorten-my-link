<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class URL extends Model
{
    use HasFactory;
    protected $table = 'urls';
    public $timestamps = false;

    protected static function booted()
        {
            static::created(function ($url) {
                $url->created_at = Carbon::now();
            });
        }
}
