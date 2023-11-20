<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Country;
use App\Models\Employee;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Admin\Employee\AddStorePostRequest;
use App\Http\Requests\Admin\Employee\EditStorePostRequest;
use App\Mail\WelcomeEmployeeEmail;

class AdminController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.dashboard');
    }

    public function create() {

        return view('admin.employee.create');
    }


    public function store(AddStorePostRequest $request) {
        
        $validated = $request->validated();

        $user = User::create([
            "employee_id" => $validated['employeeId'],
            "name" => $validated['name'],
            "email" => $validated['email'],
            "password" => $validated['password'],
        ]);

        $user->assignRole('Employee');
        
        UserAddress::create([
            "user_id" => $user->id,
            "building_no" => $validated['buildingNo'],
            "street_name" => $validated['streetName'],
            "city" => $validated['city'],
            "state" => $validated['state'],
            "country" => $validated['country'],
            "pincode" => $validated['pincode'],
        ]);

        Mail::to($validated['email'])->queue(new WelcomeEmployeeEmail($validated['employeeId'], $validated['name']));

        return response()->json(['success' => true]);
    }

    public function edit(Request $request) {

        $employee_id = $request->employee_id;

        $data = User::whereHas(
            'roles',
            function ($q) {
                $q->where('name', 'Employee');
            }
        )->where("id", $employee_id)
        ->with(["userAddress", "userAddress.cityFunc", 'userAddress.stateFunc', 'userAddress.countryFunc'])
        ->first();

        return view('admin.employee.edit', compact("data"));
    }

    public function update(EditStorePostRequest $request) {

        $validated = $request->validated();

        if($request->has("uid")) {

            User::where("id", $request->uid)->update([
                "name" => $validated['name'],
            ]);
            
        }

        if($request->has("uaid")) {

            UserAddress::where("id", $request->uaid)->update([
                "building_no" => $validated['buildingNo'],
                "street_name" => $validated['streetName'],
                "city" => $validated['city'],
                "state" => $validated['state'],
                "country" => $validated['country'],
                "pincode" => $validated['pincode'],
            ]);
            
        }

        return response()->json(['success' => true]);
    }

    public function destory($id) {

        User::findOrFail($id)->delete();
        //UserAddress::where("user_id", $id)->delete();

        return response()->json(['success' => true]);
    }

    public function city(Request $request) {

        if ($request->ajax()) {
            
            $cities = City::where("state_id", $request->state_id)->get();

            return response()->json($cities);
        }

        return response()->json();

        return view('admin.employee.create');
    }


    public function state(Request $request) {

        if ($request->ajax()) {
            
            $states = State::where("country_id", $request->country_id)->get();

            return response()->json($states);
        }

        return response()->json();
    }

    public function country(Request $request) {

        if ($request->ajax()) {
            
            $countries = Country::get();

            return response()->json($countries);
        }

        return response()->json();
    }
}
