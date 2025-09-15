<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notes extends Model
{

    use HasFactory;

    protected $table = 'notes';
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:00',
        'updated_at' => 'datetime:d-m-Y H:00',
    ];
    protected $fillable = [
                    "title",
                    "content",
                    "note_type",
                    "applies_to_date",
                    "users_id",
                    "status_id"
                ];
    /**
     * Get the User that owns the Notes.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'users_id')->withTrashed();
    }

    /**
     * Get the Status that owns the Notes.
     */
    public function status()
    {
        return $this->belongsTo('App\Models\Status', 'status_id');
    }
}
