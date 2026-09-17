<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('players', function (Blueprint $table) {
            $table->string('sport')->nullable()->after('position');
            $table->string('city')->nullable()->after('nationality');
            $table->string('level', 30)->nullable()->after('city');
            $table->string('status_badge', 20)->default('unverified')->after('status'); // unverified, verified, featured
            $table->json('achievements')->nullable()->after('honours');
            $table->json('media')->nullable()->after('achievements');
            $table->json('press_mentions')->nullable()->after('media');
            $table->string('cover_image')->nullable()->after('photo');
        });
    }

    public function down(): void
    {
        Schema::table('players', function (Blueprint $table) {
            $table->dropColumn([
                'sport', 'city', 'level', 'status_badge',
                'achievements', 'media', 'press_mentions', 'cover_image',
            ]);
        });
    }
};
