<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capsule extends Model
{
    /** @use HasFactory<\Database\Factories\CapsuleFactory> */
    use HasFactory;

    protected $fillable = ['title', 'user_id', 'location_id', 'message', 'private', 'surprise', 'color', 'image_path', 'audio_path', 'revealed_at'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'capsule_tags');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
