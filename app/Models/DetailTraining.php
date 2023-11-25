<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTraining extends Model
{
    use HasFactory;
    protected $table = 'detail_trainings';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
