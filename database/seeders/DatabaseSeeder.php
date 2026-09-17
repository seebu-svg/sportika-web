<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Message;
use App\Models\Player;
use App\Models\Post;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // ---- Admin user ----
        $admin = User::factory()->admin()->create([
            'name' => 'Sportika Admin',
            'email' => 'admin@sportika.test',
        ]);

        // ---- Site settings ----
        SiteSetting::create([
            'site_name' => 'Sportika',
            'tagline' => 'Player representation, scouting and sports news.',
            'hero_title' => 'Where Talent Meets Opportunity',
            'hero_subtitle' => 'Discover our squad of exceptional athletes, follow the latest news, and get in touch with our team.',
            'about_title' => 'Built for the Beautiful Game',
            'about_body' => '<p>Sportika is a modern player management agency dedicated to developing, promoting and protecting the careers of outstanding footballers around the world.</p><p>With over 15 years of experience in the industry, our team of seasoned agents, scouts and legal advisors works tirelessly to secure the best opportunities for every player we represent.</p><h2>Our Mission</h2><p>To bridge the gap between raw talent and professional success. We believe every player deserves expert guidance, transparent representation and a team that fights for their best interests on and off the pitch.</p>',
            'phone' => '+44 20 7946 0958',
            'email' => 'hello@sportika.test',
            'address' => '14 Kingsway, London WC2B 6AN, United Kingdom',
            'facebook_url' => 'https://facebook.com/sportika',
            'twitter_url' => 'https://x.com/sportika',
            'instagram_url' => 'https://instagram.com/sportika',
        ]);

        // ---- Categories ----
        $categories = collect(['Transfers', 'Match Reports', 'Training', 'Club News', 'Interviews'])
            ->map(fn (string $name) => Category::factory()->create([
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name),
            ]));

        // ---- Players ----
        $players = $this->seedPlayers();

        // ---- Posts ----
        $this->seedPosts($admin, $categories);

        // ---- Messages ----
        Message::factory()->count(6)->create();
        Message::factory()->count(3)->read()->create();
    }

    private function seedPlayers(): void
    {
        $roster = [
            ['name' => 'Marcus Oliveira', 'position' => 'Forward', 'jersey' => 9, 'nationality' => 'Brazil', 'club' => 'FC Dynamo', 'featured' => true],
            ['name' => 'Liam Carter', 'position' => 'Midfielder', 'jersey' => 8, 'nationality' => 'England', 'club' => 'Athletic Kings', 'featured' => true],
            ['name' => 'Kwame Asante', 'position' => 'Defender', 'jersey' => 4, 'nationality' => 'Ghana', 'club' => 'Union Star', 'featured' => true],
            ['name' => 'Tomás Herrera', 'position' => 'Goalkeeper', 'jersey' => 1, 'nationality' => 'Argentina', 'club' => 'Olympic FC', 'featured' => true],
            ['name' => 'Yuki Tanaka', 'position' => 'Midfielder', 'jersey' => 10, 'nationality' => 'Japan', 'club' => 'Real Norte', 'featured' => false],
            ['name' => 'Ethan Walker', 'position' => 'Forward', 'jersey' => 11, 'nationality' => 'Australia', 'club' => 'FC Dynamo', 'featured' => false],
            ['name' => 'Noah Becker', 'position' => 'Defender', 'jersey' => 5, 'nationality' => 'Germany', 'club' => 'Athletic Kings', 'featured' => false],
            ['name' => 'Rafael Santos', 'position' => 'Midfielder', 'jersey' => 6, 'nationality' => 'Portugal', 'club' => 'Olympic FC', 'featured' => false],
            ['name' => 'Ibrahim Diallo', 'position' => 'Forward', 'jersey' => 7, 'nationality' => 'Senegal', 'club' => 'Union Star', 'featured' => false],
            ['name' => 'Lucas Moreau', 'position' => 'Defender', 'jersey' => 3, 'nationality' => 'France', 'club' => 'Real Norte', 'featured' => false],
        ];

        foreach ($roster as $data) {
            $slug = \Illuminate\Support\Str::slug($data['name']);
            $player = Player::factory()
                ->when($data['featured'], fn ($f) => $f->featured())
                ->create([
                    'name' => $data['name'],
                    'slug' => $slug,
                    'position' => $data['position'],
                    'jersey_number' => $data['jersey'],
                    'nationality' => $data['nationality'],
                    'current_club' => $data['club'],
                ]);

            // Generate a unique SVG portrait for each player.
            $this->generatePlayerPhoto($player);
        }
    }

    private function seedPosts(User $admin, \Illuminate\Support\Collection $categories): void
    {
        $articles = [
            ['title' => 'Marcus Oliveira Signs Three-Year Deal with FC Dynamo', 'category' => 'Transfers', 'featured' => true],
            ['title' => 'Match Report: Athletic Kings 2 – 1 Union Star', 'category' => 'Match Reports', 'featured' => false],
            ['title' => 'Inside the Training Camp: Pre-Season Preparations', 'category' => 'Training', 'featured' => false],
            ['title' => 'Kwame Asante on Leadership and the Upcoming Season', 'category' => 'Interviews', 'featured' => false],
            ['title' => 'Sportika Expands Scouting Network Across South America', 'category' => 'Club News', 'featured' => false],
            ['title' => 'Youth Development: Our Pathway to the First Team', 'category' => 'Training', 'featured' => false],
        ];

        foreach ($articles as $i => $article) {
            Post::factory()
                ->when($article['featured'], fn ($f) => $f->featured())
                ->create([
                    'title' => $article['title'],
                    'slug' => \Illuminate\Support\Str::slug($article['title']),
                    'category_id' => $categories->firstWhere('name', $article['category'])?->id,
                    'author_id' => $admin->id,
                    'published_at' => now()->subDays($i * 3 + 1),
                ]);
        }
    }

    /**
     * Generate an SVG portrait with the player's initials and position colour.
     */
    private function generatePlayerPhoto(Player $player): void
    {
        $colors = [
            'Goalkeeper' => ['#f59e0b', '#78350f'],
            'Defender' => ['#0ea5e9', '#0c4a6e'],
            'Midfielder' => ['#10b981', '#064e3b'],
            'Forward' => ['#f43f5e', '#4c0519'],
        ];

        [$accent, $bg] = $colors[$player->position] ?? ['#a3e635', '#1a2740'];
        $initials = collect(explode(' ', $player->name))
            ->map(fn (string $part) => Str::upper(Str::substr($part, 0, 1)))
            ->take(2)
            ->implode('');

        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 500" preserveAspectRatio="xMidYMid slice">
  <defs>
    <linearGradient id="bg" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="{$bg}"/>
      <stop offset="100%" stop-color="#05070c"/>
    </linearGradient>
  </defs>
  <rect width="400" height="500" fill="url(#bg)"/>
  <circle cx="200" cy="180" r="70" fill="{$accent}" opacity="0.25"/>
  <path d="M 130 290 Q 200 240 270 290 L 270 500 L 130 500 Z" fill="{$accent}" opacity="0.15"/>
  <text x="200" y="200" font-family="Arial Black, sans-serif" font-size="72" font-weight="900" fill="{$accent}" text-anchor="middle" opacity="0.9">{$initials}</text>
  <text x="200" y="460" font-family="Arial, sans-serif" font-size="16" fill="#94a3b8" text-anchor="middle">{$player->position} · #{$player->jersey_number}</text>
</svg>
SVG;

        Storage::disk('public')->put("players/{$player->slug}.svg", $svg);
        $player->update(['photo' => "players/{$player->slug}.svg"]);
    }
}
