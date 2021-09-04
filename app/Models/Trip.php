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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getParticipantsAttribute($value)
    {
        return json_decode($value, true);
    }
}