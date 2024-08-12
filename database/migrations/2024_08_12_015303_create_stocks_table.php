<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('quantity');
            $table->string('justification')->nullable();
            $table->timestamps();
        });

        DB::unprepared('
            CREATE OR REPLACE FUNCTION update_product_quantity_after_insert() 
            RETURNS TRIGGER AS $$
            BEGIN
                UPDATE products
                SET quantity = quantity + NEW.quantity
                WHERE id = NEW.product_id;
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ');

        DB::unprepared('
            CREATE OR REPLACE FUNCTION update_product_quantity_after_update() 
            RETURNS TRIGGER AS $$
            BEGIN
                UPDATE products
                SET quantity = quantity + (NEW.quantity - OLD.quantity)
                WHERE id = NEW.product_id;
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ');

        DB::unprepared('
            CREATE OR REPLACE FUNCTION update_product_quantity_after_delete() 
            RETURNS TRIGGER AS $$
            BEGIN
                UPDATE products
                SET quantity = quantity - OLD.quantity
                WHERE id = OLD.product_id;
                RETURN OLD;
            END;
            $$ LANGUAGE plpgsql;
        ');

        DB::unprepared('
            CREATE TRIGGER update_product_quantity_after_insert
            AFTER INSERT ON stocks
            FOR EACH ROW
            EXECUTE FUNCTION update_product_quantity_after_insert();
        ');

        DB::unprepared('
            CREATE TRIGGER update_product_quantity_after_update
            AFTER UPDATE ON stocks
            FOR EACH ROW
            EXECUTE FUNCTION update_product_quantity_after_update();
        ');

        DB::unprepared('
            CREATE TRIGGER update_product_quantity_after_delete
            AFTER DELETE ON stocks
            FOR EACH ROW
            EXECUTE FUNCTION update_product_quantity_after_delete();
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');

        DB::unprepared('DROP TRIGGER IF EXISTS update_product_quantity_after_insert ON stocks');
        DB::unprepared('DROP TRIGGER IF EXISTS update_product_quantity_after_update ON stocks');
        DB::unprepared('DROP TRIGGER IF EXISTS update_product_quantity_after_delete ON stocks');

        DB::unprepared('DROP FUNCTION IF EXISTS update_product_quantity_after_insert');
        DB::unprepared('DROP FUNCTION IF EXISTS update_product_quantity_after_update');
        DB::unprepared('DROP FUNCTION IF EXISTS update_product_quantity_after_delete');
    }
};
