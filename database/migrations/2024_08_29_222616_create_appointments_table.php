<?php

use App\Enums\AppointmentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Pet;
use App\Models\Service;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Employee::class)->nullable()->constrained()->nullOnDelete(); 
            $table->foreignIdFor(Customer::class)->nullable()->constrained()->nullOnDelete(); 
            $table->foreignIdFor(Pet::class)->nullable()->constrained()->nullOnDelete(); 
            $table->foreignIdFor(Service::class)->nullable()->constrained()->nullOnDelete();
            $table->enum('status', AppointmentStatus::values())->default('pending');
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
