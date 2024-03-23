<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    public const FORMAT_EMPLOYEE_ID = "%02d%02d%02d";

    public const KEPALA = 1;
    public const WAKIL  = 2;
    public const STAF   = 3;


    public function employeedetails(): HasMany {
        return $this->hasMany(EmployeeDetail::class, 'employee_id', 'id');
    }

    /**
     * Get the head that owns the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assessor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assessor_id');
    }

    /**
     * Get the division that owns the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    /**
     * Get all of the assessments for the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class, 'employee_id');
    }

    public static function levelUser()
    {
        return [
            self::KEPALA => 'Kepala',
            self::WAKIL  => 'Wakil Kepala',
            self::STAF   => 'Staf'
        ];
    }

    public static function levelUserDropdown() {
        $dropdown = [];
        foreach (self::levelUser() as $key => $value) {
            $dropdown[] = (object) [
                'value' => $key,
                'label' => $value
            ];
        }
        return $dropdown;
    }

    public function getLevelString(){
        return $this->levelUser()[$this->level];
    }
}
