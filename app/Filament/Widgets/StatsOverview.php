<?php

namespace App\Filament\Widgets;

use App\Models\Message;
use App\Models\Player;
use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $publishedPlayers = Player::published()->count();
        $publishedPosts = Post::published()->count();
        $unreadMessages = Message::unread()->count();

        return [
            Stat::make('Squad players', Player::count())
                ->description("{$publishedPlayers} published")
                ->icon('heroicon-o-user-group')
                ->color('success')
                ->url(route('filament.admin.resources.players.index')),

            Stat::make('Blog posts', Post::count())
                ->description("{$publishedPosts} published")
                ->icon('heroicon-o-newspaper')
                ->color('info')
                ->url(route('filament.admin.resources.posts.index')),

            Stat::make('Inbox messages', Message::count())
                ->description($unreadMessages > 0 ? "{$unreadMessages} unread" : 'All caught up')
                ->icon('heroicon-o-envelope')
                ->color($unreadMessages > 0 ? 'warning' : 'gray')
                ->url(route('filament.admin.resources.messages.index')),
        ];
    }
}
