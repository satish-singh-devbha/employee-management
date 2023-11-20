<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\CityStateCountrySeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeFeatureTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {

        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_can_create_employee()
    {
        $this->seed(CityStateCountrySeeder::class);
        $this->seed(RoleAndPermissionSeeder::class);

        // Assuming you have a User model with authentication implemented
        $user = User::create([
            "name" => "test",
            "email" => "test@admin.com",
            "password" => Hash::make(12345678),
            "employee_id" => "emp_300"
        ]);

        // Authenticate the user
        $this->actingAs($user);

        $response = $this->post('/employees', $this->getEmployeeData());


        $response->assertStatus(201); // Check if the employee was created successfully

        // You might want to assert additional details based on your application's behavior
        // For example, check if the employee's details are in the database
        $this->assertDatabaseHas('employees', $this->getEmployeeData());
    }

    // public function test_can_edit_employee()
    // {

    //     $this->seed(CityStateCountrySeeder::class);
    //     $this->seed(RoleAndPermissionSeeder::class);

    //     // Assume you have an existing employee in the database
    //     $employee = UserAddress::factory()->create();

    //     $newData = $this->getEmployeeData();

    //     $response = $this->put("/employees/{$employee->id}", $newData);

    //     $response->assertStatus(200); // Check if the employee was updated successfully

    //     // You might want to assert additional details based on your application's behavior
    //     // For example, check if the employee's details are updated in the database
    //     $this->assertDatabaseHas('employees', $newData);
    // }

    // Helper method to generate sample employee data
    private function getEmployeeData()
    {

        return [
            'id' => $this->faker->randomDigitNotNull,
            'employee_id' => $this->faker->randomDigitNotNull      ,
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            // Add other employee fields as needed
        ];
    }
}
