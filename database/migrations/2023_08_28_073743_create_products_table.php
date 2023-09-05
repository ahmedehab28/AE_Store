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
        // if u want a table to be created before another just change the timestamp of creation
        // after u are done with making the migrations, run php artisan migrate
        // php artisan migrate:fresh vs php artisan migrate:refresh
        // php artisan migrate:rollback (default steps for how many rollbacks is 1)
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->float('price')->default(0);
            $table->string('picture')->nullable();
            $table->unsignedInteger('quantity'); // Unsigned integer column
            $table->foreignId('category_id'); //foregin key
            $table->foreign('category_id')->references('id')->on('categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
