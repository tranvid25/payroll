<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function index(){
        $employees=Employee::all();
        return response()->json($employees);
    }
    public function destroyByEmployeeNumber($employee_number)
    {
        $employee = Employee::where('Employee_Number', $employee_number)->first();
    
        if (!$employee) {
            return response()->json([
                'message' => 'Employee not found'
            ], 404);
        }
    
        $employee->delete();
    
        return response()->json([
            'message' => 'Employee deleted successfully'
        ], 200);
    }
}
