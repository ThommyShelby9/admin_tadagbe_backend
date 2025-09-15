<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Casts\JsonCast;

class EmailTemplate extends Model
{
    public $table = 'email_template';
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:00',
        'updated_at' => 'datetime:d-m-Y H:00',
        'variables'=>JsonCast::class
    ];
    protected $fillable = [
        "subject",
        "name",
        "content",
        "code",
        "variables"
        ];

}
