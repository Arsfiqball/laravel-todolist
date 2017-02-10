<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\User;

class SocialAccount extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'provider', 'provider_id', 'token'
    ];

    /**
     * Get user connected to social account
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
