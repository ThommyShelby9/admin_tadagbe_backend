<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:00',
        'updated_at' => 'datetime:d-m-Y H:00',
    ];
    protected $fillable = [
        "content",
        "title",
        "subject",
        "status",
        "published_at",
        "image1",
        "image2",
        "image3",
        "school_id"
    ];
}
