<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'FName',
        'LName',
        'Email',
        'phNo',
        'password',
        'DOB'
    ];
}
