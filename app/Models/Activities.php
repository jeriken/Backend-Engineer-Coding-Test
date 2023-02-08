<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activities extends Model
{
    use HasFactory;

    protected $table = 'activities';
    public $primaryKey = 'activity_id';

    protected $fillable = ['activity_id', 'title', 'email'];
}
