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
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['created', 'deleted']);
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('cascade');
            $table->json('ingredients_id')->nullable();
            $table->json('tags_id');
            $table->timestamps();
        });

        DB::statement('ALTER TABLE meals ADD CHECK (json_length(tags_id) > 0)');
        DB::statement('ALTER TABLE meals ADD CHECK (json_length(ingredients_id) > 0)');

        Schema::create('meal_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meal_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('locale')->index();

            $table->unique(['meal_id', 'locale']);
            $table->foreign('meal_id')->references('id')->on('meals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_translations');
        Schema::dropIfExists('meals');
    }
};
