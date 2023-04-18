# Discord Embed Message for Laravel

A Laravel package to create and send embed messages with interactive components like buttons and select menus to Discord channels.

## Installation

Install the package via Composer:

```composer require frankie813/discord-embed-message```

## Usage

To use the package, first create a new instance of the DiscordEmbedMessage class with your bot token:

```
use Frankie813\DiscordEmbedMessage\DiscordEmbedMessage;

// ...

$botToken = 'YOUR_BOT_TOKEN';
$message = new DiscordEmbedMessage($botToken);
```

Then, use the provided methods to customize your embed message and add interactive components:

```
$message->addTitle('Title')
    ->addDescription('Description')
    ->addColor('#FF0000')
    ->addAuthor('Author Name', 'https://author-url.com', 'https://author-icon-url.com')
    ->addTimestamp()
    ->addImage('https://image-url.com')
    ->addField('Field Name', 'Field Value', true)
    ->addFooter('Footer Text', 'https://footer-icon-url.com')
    ->addThumbnail('https://thumbnail-url.com')
    ->addMentionRole('ROLE_ID')
    ->addButton('Button Label', 1, 'custom_id', null, false)
    ->addSelectMenu('select_menu_custom_id', 'Select Menu Placeholder', [['label' => 'Option 1', 'value' => 'option1'], ['label' => 'Option 2', 'value' => 'option2']]);
 ```
 
 Finally, send the embed message to a specific channel using the sendEmbed method:
 
 ```
 $channelId = 'YOUR_CHANNEL_ID';
$response = $message->sendEmbed($channelId);
```

## Methods

Below are the available methods for the DiscordEmbedMessage class:

```
addTitle($title)
addDescription($description)
addColor($color)
addAuthor($name, $url = null, $icon_url = null)
addTimestamp($timestamp = null)
addImage($url)
addField($name, $value, $inline = false)
addFooter($text, $icon_url = null)
addThumbnail($url)
addMentionRole($roleId)
addButton($label, $style, $custom_id, $url = null, $disabled = false)
addSelectMenu($custom_id, $placeholder, $options, $min_values = 1, $max_values = 1, $disabled = false)
sendEmbed($channelId)
```

## License

This package is open-source software licensed under the MIT license.