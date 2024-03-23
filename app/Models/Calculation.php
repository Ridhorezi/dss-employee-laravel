<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Calculation extends Model
{
    use HasFactory;

    public function kriteria() : HasOne {
        return $this->hasOne(Criteria::class, 'criteria_id', 'id');
    }
}
