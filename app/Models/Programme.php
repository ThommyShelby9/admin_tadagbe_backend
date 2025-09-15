<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\JsonCast;
class Programme extends Model
{
    use HasFactory;
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:00',
        'updated_at' => 'datetime:d-m-Y H:00',
        'courses'=>JsonCast::class
    ];
    protected $fillable = [
        "courses",
        "date",
        "school_id"
        ];
}
