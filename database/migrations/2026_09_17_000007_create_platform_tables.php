<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── Team members ──
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('designation');
            $table->string('photo')->nullable();
            $table->text('bio')->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 30)->nullable();
            $table->json('social_links')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // ── Tournaments ──
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sport')->nullable();
            $table->string('city')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('status', 20)->default('upcoming')->index(); // upcoming, ongoing, completed
            $table->string('cover_image')->nullable();
            $table->longText('description')->nullable();
            $table->json('fixtures')->nullable();
            $table->json('results')->nullable();
            $table->json('participating_player_ids')->nullable();
            $table->json('gallery')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // ── Gallery items ──
        Schema::create('gallery_items', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('type', 10)->default('photo'); // photo, video
            $table->string('file_path');
            $table->string('album')->nullable();
            $table->string('tournament')->nullable();
            $table->text('caption')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });

        // ── Sponsors ──
        Schema::create('sponsors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('logo')->nullable();
            $table->string('website')->nullable();
            $table->string('category')->nullable(); // title, gold, silver, partner
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // ── Podcast episodes ──
        Schema::create('podcast_episodes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('guest_name')->nullable();
            $table->foreignId('guest_player_id')->nullable()->constrained('players')->nullOnDelete();
            $table->string('youtube_url')->nullable();
            $table->string('spotify_url')->nullable();
            $table->string('apple_url')->nullable();
            $table->date('published_at')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });

        // ── Podcast applications ──
        Schema::create('podcast_applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone', 30)->nullable();
            $table->string('sport')->nullable();
            $table->string('category')->nullable();
            $table->text('pitch');
            $table->text('achievements')->nullable();
            $table->string('availability')->nullable();
            $table->foreignId('player_id')->nullable()->constrained()->nullOnDelete();
            $table->string('status', 20)->default('pending');
            $table->timestamps();
        });

        // ── Player applications (Join as Player) ──
        Schema::create('player_applications', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('cnic')->nullable();
            $table->string('phone');
            $table->date('date_of_birth')->nullable();
            $table->unsignedSmallInteger('height_cm')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('level')->nullable(); // International, National, Domestic, University, College, School
            $table->string('club_name')->nullable();
            $table->string('institution_name')->nullable();
            $table->string('sport');
            $table->json('sport_details')->nullable();
            $table->json('achievements')->nullable();
            $table->text('bio')->nullable();
            $table->json('images')->nullable();
            $table->json('video_links')->nullable();
            $table->json('press_mentions')->nullable();
            $table->string('parent_guardian_contact')->nullable();
            $table->boolean('consent_given')->default(false);
            $table->string('status', 20)->default('pending')->index(); // pending, approved, rejected
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('player_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });

        // ── Brand applications (Join as Brand) ──
        Schema::create('brand_applications', function (Blueprint $table) {
            $table->id();
            $table->string('brand_name');
            $table->string('contact_person');
            $table->string('email');
            $table->string('phone', 30)->nullable();
            $table->string('website')->nullable();
            $table->text('details')->nullable();
            $table->string('interest')->nullable(); // Sponsorship, Partnership, Advertising
            $table->text('message')->nullable();
            $table->string('status', 20)->default('pending')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brand_applications');
        Schema::dropIfExists('player_applications');
        Schema::dropIfExists('podcast_applications');
        Schema::dropIfExists('podcast_episodes');
        Schema::dropIfExists('sponsors');
        Schema::dropIfExists('gallery_items');
        Schema::dropIfExists('tournaments');
        Schema::dropIfExists('team_members');
    }
};
