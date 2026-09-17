<?php

namespace App\Filament\Widgets;

use App\Models\BrandApplication;
use App\Models\GalleryItem;
use App\Models\Message;
use App\Models\Player;
use App\Models\PlayerApplication;
use App\Models\PodcastApplication;
use App\Models\PodcastEpisode;
use App\Models\Post;
use App\Models\Sponsor;
use App\Models\TeamMember;
use App\Models\Tournament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $publishedPlayers = Player::published()->count();
        $newsCount = Post::published()->news()->count();
        $blogCount = Post::published()->blog()->count();
        $unreadMessages = Message::unread()->count();
        $pendingPlayerApps = PlayerApplication::pending()->count();
        $pendingBrandApps = BrandApplication::pending()->count();
        $pendingPodcastApps = PodcastApplication::pending()->count();
        $pendingApps = $pendingPlayerApps + $pendingBrandApps + $pendingPodcastApps;

        return [
            Stat::make('Squad players', Player::count())
                ->description("{$publishedPlayers} published")
                ->icon('heroicon-o-user-group')
                ->color('success')
                ->url(route('filament.admin.resources.players.index')),

            Stat::make('News & Blogs', Post::count())
                ->description("{$newsCount} news, {$blogCount} blogs")
                ->icon('heroicon-o-newspaper')
                ->color('info')
                ->url(route('filament.admin.resources.news.index')),

            Stat::make('Tournaments', Tournament::count())
                ->description(Tournament::ongoing()->count() . ' ongoing')
                ->icon('heroicon-o-trophy')
                ->color('warning')
                ->url(route('filament.admin.resources.tournaments.index')),

            Stat::make('Gallery & Media', GalleryItem::count())
                ->description(GalleryItem::featured()->count() . ' featured')
                ->icon('heroicon-o-photo')
                ->color('primary')
                ->url(route('filament.admin.resources.gallery-items.index')),

            Stat::make('Podcast Episodes', PodcastEpisode::count())
                ->description(PodcastEpisode::published()->count() . ' published')
                ->icon('heroicon-o-microphone')
                ->color('info')
                ->url(route('filament.admin.resources.podcast-episodes.index')),

            Stat::make('Inbox messages', Message::count())
                ->description($unreadMessages > 0 ? "{$unreadMessages} unread" : 'All caught up')
                ->icon('heroicon-o-envelope')
                ->color($unreadMessages > 0 ? 'warning' : 'gray')
                ->url(route('filament.admin.resources.messages.index')),

            Stat::make('Pending applications', $pendingApps)
                ->description("{$pendingPlayerApps} player, {$pendingBrandApps} brand, {$pendingPodcastApps} podcast")
                ->icon('heroicon-o-clipboard-document-check')
                ->color($pendingApps > 0 ? 'danger' : 'gray')
                ->url(route('filament.admin.resources.player-applications.index')),

            Stat::make('Team & Sponsors', TeamMember::count() + Sponsor::count())
                ->description(TeamMember::count() . ' members, ' . Sponsor::count() . ' sponsors')
                ->icon('heroicon-o-building-storefront')
                ->color('gray')
                ->url(route('filament.admin.resources.team-members.index')),
        ];
    }
}
