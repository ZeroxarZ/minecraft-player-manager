<?php

namespace KumaGames\GamePlayerManager\Filament\Server\Resources\PlayerResource\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use KumaGames\GamePlayerManager\Filament\Server\Resources\PlayerResource;
use KumaGames\GamePlayerManager\Services\MinecraftPlayerProvider;
use Illuminate\Database\Eloquent\Model;
use Filament\Facades\Filament;



class ListPlayers extends ListRecords
{
    protected static string $resource = PlayerResource::class;
    private const PLAYERS_CACHE_TTL_SECONDS = 8;
    private ?MinecraftPlayerProvider $provider = null;

    public function getTitle(): string|\Illuminate\Contracts\Support\Htmlable
    {
        return __('minecraft-player-manager::messages.pages.list');
    }

    protected ?array $cachedPlayers = null;
    protected ?int $cachedPlayersAt = null;

    public function refreshPlayersList(): void
    {
        $this->cachedPlayers = null;
        $this->cachedPlayersAt = null;
    }

    protected function getCachedPlayers(): array
    {
        if (
            $this->cachedPlayers !== null
            && $this->cachedPlayersAt !== null
            && (time() - $this->cachedPlayersAt) < self::PLAYERS_CACHE_TTL_SECONDS
        ) {
            return $this->cachedPlayers;
        }

        $server = Filament::getTenant();
        $serverId = $server->uuid ?? 'server-1';

        $this->cachedPlayers = $this->getProvider()->getPlayers($serverId);
        $this->cachedPlayersAt = time();

        return $this->cachedPlayers;
    }

    private function getProvider(): MinecraftPlayerProvider
    {
        if ($this->provider instanceof MinecraftPlayerProvider) {
            return $this->provider;
        }

        $this->provider = app(MinecraftPlayerProvider::class);

        return $this->provider;
    }

    private function isWhitelistModeEnabled(): bool
    {
        return collect($this->getCachedPlayers())
            ->contains(fn ($player) => !empty($player['is_whitelisted']));
    }

    private function getVisiblePlayers(): \Illuminate\Support\Collection
    {
        $players = collect($this->getCachedPlayers());

        if ($this->isWhitelistModeEnabled()) {
            return $players->filter(fn ($player) => !empty($player['is_whitelisted']));
        }

        return $players;
    }

    public function getTabs(): array
    {
        $players = $this->getVisiblePlayers();

        return [
            'all' => \Filament\Schemas\Components\Tabs\Tab::make()
                ->label(__('minecraft-player-manager::messages.filters.all'))
                ->badge($players->count()),
            'online' => \Filament\Schemas\Components\Tabs\Tab::make()
                ->label(__('minecraft-player-manager::messages.filters.online'))
                ->badge($players->where('online', true)->count())
                ->badgeColor('success'),
            'offline' => \Filament\Schemas\Components\Tabs\Tab::make()
                ->label(__('minecraft-player-manager::messages.filters.offline'))
                ->badge($players->where('online', false)->count())
                ->badgeColor('gray'),
            'op' => \Filament\Schemas\Components\Tabs\Tab::make()
                ->label(__('minecraft-player-manager::messages.filters.op'))
                ->badge($players->where('is_op', true)->count())
                ->badgeColor('warning'),
            'banned' => \Filament\Schemas\Components\Tabs\Tab::make()
                ->label(__('minecraft-player-manager::messages.filters.banned'))
                ->badge($players->where('is_banned', true)->count())
                ->badgeColor('danger'),
        ];
    }

    public function getTableRecords(): \Illuminate\Support\Collection|\Illuminate\Contracts\Pagination\Paginator|\Illuminate\Contracts\Pagination\CursorPaginator
    {
        $collection = $this->getVisiblePlayers()
            ->map(fn ($item) => new \KumaGames\GamePlayerManager\Models\Player($item));

        $activeTab = $this->activeTab ?? 'all';

        if ($activeTab === 'online') {
            $collection = $collection->where('online', true);
        } elseif ($activeTab === 'offline') {
            $collection = $collection->where('online', false);
        } elseif ($activeTab === 'op') {
            $collection = $collection->where('is_op', true);
        } elseif ($activeTab === 'banned') {
            $collection = $collection->where('is_banned', true);
        }

        // Apply Search
        $search = $this->getTableSearch();
        if (filled($search)) {
            $collection = $collection->filter(fn ($record) => str_contains(strtolower($record->name), strtolower($search)));
        }

        $collection = $collection->sort(function ($a, $b): int {
            $aOnline = !empty($a->online);
            $bOnline = !empty($b->online);

            if ($aOnline !== $bOnline) {
                return $aOnline ? -1 : 1;
            }

            return strcasecmp((string) $a->name, (string) $b->name);
        })->values();

        return $collection;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('add_to_whitelist')
                ->label('Add to whitelist')
                ->icon('heroicon-m-user-plus')
                ->color('success')
                ->form([
                    \Filament\Forms\Components\TextInput::make('player_name')
                        ->label('Player name')
                        ->required()
                        ->maxLength(32),
                ])
                ->action(function (array $data): void {
                    $server = Filament::getTenant();
                    if (!$server) {
                        return;
                    }

                    $playerName = trim((string) ($data['player_name'] ?? ''));
                    if ($playerName === '') {
                        return;
                    }

                    $this->getProvider()->addToWhitelist($server->uuid, $playerName);

                    $this->cachedPlayers = null;

                    \Filament\Notifications\Notification::make()
                        ->title('Player added to whitelist')
                        ->success()
                        ->send();
                }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \KumaGames\GamePlayerManager\Filament\Server\Widgets\PlayerCountWidget::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [];
    }
    
    public function getTableRecordKey(Model|array $record): string
    {
        return $record['id'];
    }

    public function resolveTableRecord(?string $key): ?Model
    {
        $server = Filament::getTenant();
        $serverId = $server->uuid ?? 'server-1';

        $provider = $this->getProvider();
        $players = $this->getCachedPlayers();
        $recordRaw = collect($players)->firstWhere('id', $key);

        if (!$recordRaw) {
            return null;
        }

        if ($this->isWhitelistModeEnabled() && empty($recordRaw['is_whitelisted'])) {
            return null;
        }

        $details = $provider->getPlayerDetails($serverId, $key);
        $data = array_merge($recordRaw, $details);
        
        return new \KumaGames\GamePlayerManager\Models\Player($data);
    }
}
