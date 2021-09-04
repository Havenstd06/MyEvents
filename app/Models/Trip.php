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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'event_data' => 'array',
    ];

    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getParticipantsAttribute($value)
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
