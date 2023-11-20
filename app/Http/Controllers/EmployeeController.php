<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('employee.dashboard');
    }

    public function show(Request $request)
    {
        $is_admin = auth()->user()->roles->first()->name == "Admin";
        if ($request->ajax()) {
            
            $data = User::whereHas(
                'roles',
                function ($q) {
                    $q->where('name', 'Employee');
                }
            )->select('*');

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row) use ($is_admin) {
                        $btn = '';

                        if($is_admin) {
                            $btn = '<a href="/admin/employee/'. $row->id .'/edit" class="edit btn btn-primary btn-sm">Edit</a>';
                            $btn .= ' <button class="delete btn btn-danger btn-sm" data-id="' . $row->id . '">Delete</button>';
                        }
      
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
          
        return view('employee.index', compact('is_admin'));
    }
}
