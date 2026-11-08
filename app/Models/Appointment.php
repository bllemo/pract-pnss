<?php

namespace Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';

    public $timestamps = false;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'created_by',
        'visit_timestamp',
        'status',
        'created_at',
        'cancelled_at',
    ];

    //Пациент записи
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    //Врач записи
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    //Сотрудник, создавший запись
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
