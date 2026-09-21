<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskEmailNotification extends Model
{
    protected $fillable = ['task_id', 'type', 'notified_for'];

    protected function casts(): array
    {
        return ['notified_for' => 'date'];
    }
}
