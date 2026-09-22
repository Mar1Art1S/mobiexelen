<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactRequest extends Model
{
    protected $fillable = [
        'type',
        'name',
        'phone',
        'email',
        'message',
        'status',
    ];
}
