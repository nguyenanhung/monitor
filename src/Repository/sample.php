<?php
/**
 * Project monitor.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 2019-08-04
 * Time: 02:33
 */
return array(
    // Slack Messenger
    'slack_messages'            => array(
        'incoming_url'      => 'xxx',
        'target_channel'    => '#xxx',
        'client_attributes' => array(
            'username'       => 'HungNa @ Slack Bot',
            'channel'        => '#xxx',
            'link_names'     => TRUE,
            'allow_markdown' => TRUE,
            'icon'           => ':bomb:'
        )
    ),
    // Telegram Messenger
    'telegram_messages'         => array(
        'bot_name'        => 'xxx',
        'bot_api_key'     => 'xxx',
        'default_chat_id' => 1234,
    ),
    'microsoft_teams_connector' => '',
    // Email Preferences
    'email_preferences'         => array(
        'notifyIsEnabled' => FALSE,
        'sender_config'   => array(
            'hostname' => 'xxx',
            'port'     => 25,
            'username' => 'xxx',
            'password' => 'xxx',
            'from'     => 'xxx',
        ),
        'email_report'    => array(
            'from' => array('xxx'),
            'to'   => array('xxx'),
            'cc'   => array(),
            'bcc'  => array()
        )
    ),
);
