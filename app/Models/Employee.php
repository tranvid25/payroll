<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    // Đặt tên bảng là 'employees' thay vì 'employee'
    protected $table = 'employees';

    protected $primaryKey = 'idEmployee'; // Nếu khóa chính không phải là 'id'
    
    protected $fillable = [
        'idEmployee',
        'employeeNumber',
        'firstName',
        'lastName',
        'ssn',
        'vacationDays',
        'payRate'
    ];
}

