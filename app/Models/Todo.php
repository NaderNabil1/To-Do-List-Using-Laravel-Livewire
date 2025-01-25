<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;
    protected $table = 'todos';
    protected $primarykey = 'id';
    protected $fillable = [
        'id',
        'user_id',
        'task',
        'description',
        'status',
        'due_date',
        'priority'
    ];

    public function User(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
