<?php

namespace Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $table = 'positions';

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    //Врачи на этой должности
    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }
}
