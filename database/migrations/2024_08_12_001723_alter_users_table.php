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
		Schema::table('users', function (Blueprint $table) {
            $table->string('cpf')->unique();
			$table->double('salary', 5, 2);
			$table->date('admission_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
			$table->dropColumn(['cpf', 'salary', 'admission_date']);
		});
    }
};
