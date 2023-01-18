# Example Config

```php
<?php
// Sample Config Array
return [
    // Slack Messenger
    'slack_messages'            => [
        'incoming_url'      => 'xxx',
        'target_channel'    => '#xxx',
        'client_attributes' => [
            'username'       => 'HungNa @ Slack Bot',
            'channel'        => '#xxx',
            'link_names'     => TRUE,
            'allow_markdown' => TRUE,
            'icon'           => ':bomb:'
        ]
    ],
    // Telegram Messenger
    'telegram_messages'         => [
        'bot_name'        => 'xxx',
        'bot_api_key'     => 'xxx',
        'default_chat_id' => 1234,
    ],
    'microsoft_teams_connector' => '',
    // Email Preferences
    'email_preferences'         => [
        'notifyIsEnabled' => FALSE,
        'sender_config'   => [
            'hostname' => 'xxx',
            'port'     => 25,
            'username' => 'xxx',
            'password' => 'xxx',
            'from'     => 'xxx',
        ],
        'email_report'    => [
            'from' => ['xxx'],
            'to'   => ['xxx'],
            'cc'   => [],
            'bcc'  => []
        ]
    ],
];

```

### Contact

| STT | Name        | Email                | Skype            |
|-----|-------------|----------------------|------------------|
| 1   | Hung Nguyen | dev@nguyenanhung.com | nguyenanhung5891 |

