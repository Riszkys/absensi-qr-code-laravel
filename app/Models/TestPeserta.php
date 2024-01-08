<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestPeserta extends Model
{
    use HasFactory;
    protected $table = 'test_pesertas';
    public function test()
    {
        return $this->belongsTo(Test::class, 'id_test', 'id');
    }

}
