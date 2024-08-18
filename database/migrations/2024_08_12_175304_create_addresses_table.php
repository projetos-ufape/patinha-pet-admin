<?php

use App\Enums\AddressState;
use App\Models\User;
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
        Schema::create('addresses', function (Blueprint $table) {
			$table->enum('state', AddressState::values());
			$table->string('city');
			$table->string('district');
			$table->string('street');
			$table->integer('number');
			$table->string('complement')->nullable();
			$table->string('cep');
			$table->foreignIdFor(User::class)->unique()->constrained()->onDelete('cascade');
            $table->id();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
