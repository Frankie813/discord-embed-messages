<?php

namespace Frankie813\DiscordEmbedMessages\Actions;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class EmbedMessage
{
    protected Client $httpClient;
    protected string $botToken;
    protected array $embedOptions = [];
    protected array $mentionedRoles = [];
    protected array $buttons = [];
    protected array $selectMenus = [];

    public function __construct($botToken = null)
    {
        $this->botToken = $botToken ?? config('discord-embeds.bot_token');

        $this->httpClient = new Client(['base_uri' => 'https://discord.com/api/v9/']);
    }

    public function addTitle(string $title)
    {
        $this->embedOptions['title'] = $title;
        return $this;
    }

    public function addDescription(string $description)
    {
        $this->embedOptions['description'] = $description;
        return $this;
    }

    public function addColor(string $color)
    {
        $this->embedOptions['color'] = hexdec($color);
        return $this;
    }

    public function addAuthor(string $name, string $url = null, string $icon_url = null)
    {
        $this->embedOptions['author'] = [
            'name' => $name,
            'url' => $url,
            'icon_url' => $icon_url,
        ];
        return $this;
    }

    public function addTimestamp(string $timestamp = null)
    {
        $this->embedOptions['timestamp'] = $timestamp ? $timestamp : date('c');
        return $this;
    }

    public function addImage(string $url)
    {
        $this->embedOptions['image'] = [
            'url' => $url,
        ];
        return $this;
    }

    public function addField(string $name, string $value, bool $inline = false)
    {
        $this->embedOptions['fields'][] = [
            'name' => $name,
            'value' => $value,
            'inline' => $inline,
        ];
        return $this;
    }

    public function addFooter(string $text, string $icon_url = null)
    {
        $this->embedOptions['footer'] = [
            'text' => $text,
            'icon_url' => $icon_url,
        ];
        return $this;
    }

    public function addThumbnail(string $url)
    {
        $this->embedOptions['thumbnail'] = [
            'url' => $url,
        ];
        return $this;
    }

    public function addMentionRole(int $roleId)
    {
        $this->mentionedRoles[] = $roleId;
        return $this;
    }

    public function addButton(string $label, int $style = 1, string $custom_id = null, string $url = null, bool $disabled = false)
    {
        $this->buttons[] = [
            'label' => $label,
            'style' => $style,
            'custom_id' => $custom_id,
            'url' => $url,
            'disabled' => $disabled,
        ];

        return $this;
    }

    public function addSelectMenu(string $custom_id, array $options, string $placeholder = null, int $min_values = 1, int $max_values = 1)
    {
        $this->selectMenus[] = [
            'custom_id' => $custom_id,
            'options' => $options,
            'placeholder' => $placeholder,
            'min_values' => $min_values,
            'max_values' => $max_values,
        ];

        return $this;
    }

    public function sendEmbed(int $channelId)
    {
        // Prepare the embed fields
        $embedFields = [];
        if (isset($this->embedOptions['fields'])) {
            foreach ($this->embedOptions['fields'] as $field) {
                $embedFields[] = [
                    'name' => $field['name'],
                    'value' => $field['value'],
                    'inline' => $field['inline'] ?? false,
                ];
            }
        }

        // Build the embed data
        $embed = [
            'title' => $this->embedOptions['title'] ?? null,
            'description' => $this->embedOptions['description'] ?? null,
            'color' => $this->embedOptions['color'] ?? null,
            'fields' => $embedFields,
            'footer' => $this->embedOptions['footer'] ?? null,
            'thumbnail' => $this->embedOptions['thumbnail'] ?? null,
            'author' => $this->embedOptions['author'] ?? null,
            'timestamp' => $this->embedOptions['timestamp'] ?? null,
            'image' => $this->embedOptions['image'] ?? null,
        ];

        // Create a string with role mentions using the role IDs in the $mentionedRoles property
        $roleMentions = '';
        foreach ($this->mentionedRoles as $roleId) {
            $roleMentions .= "<@&{$roleId}> ";
        }

        // Initialize the components array
        $components = [];

        // Loop through the buttons and create the component structure
        if (count($this->buttons) > 0) {
            $buttonComponents = [];

            foreach ($this->buttons as $button) {
                $buttonComponents[] = [
                    'type' => 2, // Button type
                    'label' => $button['label'],
                    'style' => $button['style'],
                    'custom_id' => $button['custom_id'],
                    'url' => $button['url'],
                    'disabled' => $button['disabled'],
                ];
            }

            $components[] = [
                'type' => 1, // Action row type
                'components' => $buttonComponents,
            ];
        }

        // Add select menus to the components
        if (count($this->selectMenus) > 0) {
            $selectMenuComponents = [];

            foreach ($this->selectMenus as $selectMenu) {
                $selectMenuComponents[] = [
                    'type' => 3, // Select Menu type
                    'custom_id' => $selectMenu['custom_id'],
                    'options' => $selectMenu['options'],
                    'placeholder' => $selectMenu['placeholder'],
                    'min_values' => $selectMenu['min_values'],
                    'max_values' => $selectMenu['max_values'],
                ];
            }

            $components[] = [
                'type' => 1, // Action row type
                'components' => $selectMenuComponents,
            ];
        }

        // Prepare the request data with the embed and role mentions
        $data = [
            'content' => $roleMentions,
            'embed' => $embed,
            'components' => $components,
        ];

        // Send the embed message to the specified channel
        try {
            $response = $this->httpClient->post("channels/{$channelId}/messages", [
                'headers' => [
                    'Authorization' => "Bot {$this->botToken}",
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($data),
            ]);

            return json_decode($response->getBody(), true);
        } catch (ClientException $e) {
            return response()->json([$e], 404);
        }
    }
}
