<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $attributes = [
        'participants' => '{}'
    ];

    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->hasOne(Room::class);
    }

    public function getParticipantsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getEventDataAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getIsPublicAttribute($value)
    {
        if ($value) {
            return 'public';
        }

        return 'private';
    }
}
