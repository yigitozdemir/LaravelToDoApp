<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoItem extends Model
{
    use HasFactory;

    protected $table = 'items';

    protected $fillable = [
        'project_id',
        'item_title',
        'item_description',
        'item_status'
    ];
}
