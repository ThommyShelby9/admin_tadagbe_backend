<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use HasRoles;
    use HasFactory;
    
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        "email_verified_at",
        'password',
        'id',
        'menuroles',
        "first_name",
        "last_name",
        "phone",
        "birth_date",
        "address",
        "country",
        "city"
        ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime:d-m-Y H:00',
        'created_at' => 'datetime:d-m-Y H:00',
        'updated_at' => 'datetime:d-m-Y H:00',

    ];

    protected $dates = [
        'deleted_at'
    ];

    protected $attributes = [ 
        'menuroles' => 'user',
    ];
}
