<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Player portfolios managed from the admin panel.
     */
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('position', 20)->index();
            $table->unsignedTinyInteger('jersey_number')->nullable();
            $table->string('nationality')->nullable()->index();
            $table->date('date_of_birth')->nullable();
            $table->unsignedSmallInteger('height_cm')->nullable();
            $table->unsignedSmallInteger('weight_kg')->nullable();
            $table->string('preferred_foot', 10)->nullable();
            $table->string('current_club')->nullable();
            $table->string('photo')->nullable();
            $table->string('short_description', 255)->nullable();
            $table->longText('bio')->nullable();
            $table->unsignedInteger('appearances')->default(0);
            $table->unsignedInteger('goals')->default(0);
            $table->unsignedInteger('assists')->default(0);
            $table->unsignedInteger('clean_sheets')->default(0);
            $table->json('honours')->nullable();
            $table->json('social_links')->nullable();
            $table->string('status', 20)->default('draft')->index();
            $table->boolean('is_featured')->default(false)->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
