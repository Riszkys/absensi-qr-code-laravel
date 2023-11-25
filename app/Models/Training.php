<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $table = 'training';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    use HasFactory;
}
