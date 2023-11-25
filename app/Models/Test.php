<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;
    protected $table = 'test';
    protected $guarded = ['id'];
    public function soal()
    {
        return $this->hasMany(Soal::class, 'id_test');
    }
    public function testpeserta()
    {
        return $this->hasMany(testpeserta::class, 'id_test', 'id');
    }
}