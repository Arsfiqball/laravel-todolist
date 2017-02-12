<?php

namespace App\Models\Todo;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\User;

class Todo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'title', 'finished', 'privacy'
    ];

    protected $with = 'user';

    /**
     * Get user connected to social account
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope how to list appropriately
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeList($query)
    {
        $query = $query->where('privacy', 'public');

        if (auth()->user()) {
            $query = $query->orWhere('user_id', auth()->user()->id);
        }

        return $query;
    }
}
