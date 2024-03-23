<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EmployeeDetail extends Model
{
    use HasFactory;

    public function alternatif(): HasOne {
        return $this->hasOne(Employee::class, 'employee_id', 'id');
    }

    public function kriteria(): HasOne {
        return $this->hasOne(Employee::class, 'criteria_id', 'id');
    }
}
