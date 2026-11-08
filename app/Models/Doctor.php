<?php

namespace Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'doctors';

    public $timestamps = false;

    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name',
        'birth_date',
        'position_id',
        'specification_id',
        'deleted'
    ];

    //Врач принадлежит должности
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    //Врач принадлежит специализации
    public function specification()
    {
        return $this->belongsTo(Specification::class);
    }

    //Записи врача
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
