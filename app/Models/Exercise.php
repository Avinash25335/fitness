<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $fillable = [
        'name',
        'body_part',
        'sets',
        'reps',
        'duration_seconds',
        'media_url',
    ];

    public function workoutPlans()
    {
        return $this->belongsToMany(WorkoutPlan::class, 'workout_exercise')
                    ->withPivot('order')
                    ->withTimestamps();
    }
}
