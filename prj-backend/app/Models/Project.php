<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Project extends Model
{
    use HasFactory;

    protected $filliable = [
        'project_status_id',
        'maintainer_id',
        'executor_id',
        'title',
        'description',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function projectStatus()
    {
        return $this->belongsTo(ProjectStatus::class);
    }

    public function maintainer()
    {
        return $this->belongsTo(User::class, 'maintainer_id');
    }
    public function executor()
    {
        return $this->belongsTo(User::class, 'executor_id');
    }

    public function getDaysRemainingAttribute(): int
    {
        return $this->end_date->diffInDays();
    }

    public function scopeCompleted(Builder $builder)
    {

        return $builder->where(function ($builder) {
            $builder->projectStatus()->where('name', 'completed');
        });
    }
}
