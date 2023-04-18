<?php

namespace Frankie813\DiscordEmbedMessages;

use Illuminate\Support\ServiceProvider;

class DiscordEmbedsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Publish the config file.
        $this->publishes([
            __DIR__.'/../config/discord-embeds.php' => config_path('discord-embeds.php'),
        ], 'discord-embeds-config');
    }
}
