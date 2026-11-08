<?php

namespace Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    use HasFactory;

    protected $table = 'specifications';

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    //Врачи с этой специализацией
    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }
}
