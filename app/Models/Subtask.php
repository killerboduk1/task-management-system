<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;

class Subtask extends Model
{
    use HasFactory;

    protected $table = 'subtask';

    protected $fillable = ['task_id', 'title', 'description', 'status', 'image'];

    public function task()
    {
        $this->belongsTo(Task::class);
    }
}
