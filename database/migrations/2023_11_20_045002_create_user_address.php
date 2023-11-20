<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            //user_id, building_no, street_name, city, state, country, pincode
            $table->id();
            $table->foreignId("user_id")->constrained("users", "id")->onUpdate('cascade')->onDelete('cascade');
            $table->string("building_no", 10);
            $table->string("street_name", 40);
            $table->string("city", 25)->constrained("cities", "id")->onUpdate('cascade')->onDelete('cascade');
            $table->string("state", 25)->constrained("states", "id")->onUpdate('cascade')->onDelete('cascade');
            $table->string("country", 25)->constrained("countries", "id")->onUpdate('cascade')->onDelete('cascade');
            $table->string("pincode", 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
        
    }
};
