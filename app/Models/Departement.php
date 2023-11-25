<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    protected $table = 'departement';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
    public function test()
    {
        return $this->hasOne(test::class);
    }

    use HasFactory;
}
