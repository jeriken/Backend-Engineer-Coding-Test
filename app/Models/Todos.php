<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todos extends Model
{
    use HasFactory;

    protected $table = 'todos';
    public $primaryKey = 'todo_id';

    protected $casts = [
        'is_active' => 'boolean'
    ];


    protected $fillable = ['todo_id', 'activity_group_id', 'title', 'is_active', 'priority'];
}
