<?php
/**
 * Project td-viettel-sdk.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 2019-07-07
 * Time: 02:41
 */

namespace nguyenanhung\Monitor;

use Exception;
use nguyenanhung\MantisBT\MantisConnector;
use nguyenanhung\Microsoft\Teams\MicrosoftTeamsConnector;
use nguyenanhung\Monitor\Slack\SlackMessenger;
use nguyenanhung\Monitor\Telegram\TelegramMessenger;
use nguyenanhung\Platform\Notification\GoogleChat\Notifier;

/**
 * Class SystemNotification
 *
 * @package   nguyenanhung\Monitor
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class SystemNotification implements ProjectInterface
{
    use Version;

    /**
     * Hàm gửi thông báo, cảnh báo hệ thống tới Mantis Bug Tracker
     *
     * @param array  $sdkConfig   Cấu hình SDK
     * @param string $module      Tên Module cần báo lỗi / cảnh báo
     * @param string $title       Tiêu đề lỗi / Cảnh báo
     * @param string $description Mô tả chi tiết
     *
     * @return bool
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 10/10/19 09:23
     */
    public static function mantis(array $sdkConfig = array(), string $module = '', string $title = 'Bug', string $description = 'Bug'): bool
    {
        try {
            if (isset($sdkConfig['OPTIONS']) && !empty($sdkConfig['OPTIONS'])) {
                if (isset($sdkConfig['SERVICES']['monitorProjectName'])) {
                    $monitorProjectName = '[' . $sdkConfig['SERVICES']['monitorProjectName'] . '] - ';
                } else {
                    $monitorProjectName = '';
                }
                $options = $sdkConfig['OPTIONS'];
                $handle = new MantisConnector();
                $handle->setMonitorUrl($options['monitorUrl'])
                       ->setMonitorUser($options['monitorUser'])
                       ->setUsername($options['monitorUsername'])
                       ->setMonitorPassword($options['monitorPassword'])
                       ->setProjectId($options['monitorProjectId'])
                       ->mantis($monitorProjectName . $title . ' - ' . $module, $description);

                return true;
            }
        } catch (Exception $e) {
            if (function_exists('log_message')) {
                log_message('error', 'Error Message: ' . $e->getMessage());
                log_message('error', 'Error Trace As String: ' . $e->getTraceAsString());
            }
        }

        return false;
    }

    /**
     * Hàm gửi thông báo, cảnh báo hệ thống bằng Slack
     *
     * @param array  $sdkConfig     Cấu hình SDK
     * @param string $module        Tên Module cần báo lỗi / cảnh báo
     * @param string $message       Nội dung Cảnh báo / Lỗi
     * @param array  $attachMessage Thông tin đính kèm
     *
     * @return bool
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 10/10/19 09:13
     */
    public static function slack(array $sdkConfig = array(), string $module = '', string $message = '', array $attachMessage = array()): bool
    {
        $config_key = 'slack_messages';
        try {
            if (isset($sdkConfig[$config_key]) && !empty($sdkConfig[$config_key])) {
                if (isset($sdkConfig['SERVICES']['monitorProjectName'])) {
                    $monitorProjectName = '[' . $sdkConfig['SERVICES']['monitorProjectName'] . '] - ';
                } else {
                    $monitorProjectName = '';
                }
                $options = $sdkConfig[$config_key];
                $handle = new SlackMessenger();
                $handle->setSdkConfig($sdkConfig)
                       ->setTargetChannel($options['target_channel'])
                       ->setClientAttributes($options['client_attributes'])
                       ->setContentMessage($monitorProjectName . $module . ' - ' . $message);
                if (!empty($attachMessage)) {
                    $handle->setAttachMessage($attachMessage);
                }
                $handle->send();

                return true;
            }
        } catch (Exception $e) {
            if (function_exists('log_message')) {
                log_message('error', 'Error Message: ' . $e->getMessage());
                log_message('error', 'Error Trace As String: ' . $e->getTraceAsString());
            }
        }

        return false;
    }

    /**
     * Hàm gửi thông báo, cảnh báo hệ thống bằng Telegram
     *
     * @param array           $sdkConfig Cấu hình SDK
     * @param string          $module    Tên Module cần báo lỗi / cảnh báo
     * @param string          $message   Nội dung cảnh báo / Lỗi
     * @param null|string|int $roomId    ID của phòng chat / người nhận
     *
     * @return bool
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 10/10/19 08:52
     */
    public static function telegram(array $sdkConfig = array(), string $module = '', string $message = '', $roomId = null): bool
    {
        $config_key = 'telegram_messages';
        try {
            $config = $sdkConfig[$config_key];
            if (isset($sdkConfig[$config_key]) && !empty($sdkConfig[$config_key])) {
                $title = isset($sdkConfig['SERVICES']['monitorProjectName']) ? '[' . $sdkConfig['SERVICES']['monitorProjectName'] . '] - ' : '';
                $message = $title . $module . ' -> ' . $message;
                if (!empty($roomId)) {
                    $chatId = $roomId;
                } else {
                    $chatId = $config['default_chat_id'] ?? null;
                }
                $handle = new TelegramMessenger();
                $handle->setSdkConfig($sdkConfig)
                       ->setChatId($chatId)
                       ->setMessage($message)
                       ->sendMessage();

                return true;
            }
        } catch (Exception $e) {
            if (function_exists('log_message')) {
                log_message('error', 'Error Message: ' . $e->getMessage());
                log_message('error', 'Error Trace As String: ' . $e->getTraceAsString());
            }
        }

        return false;
    }

    /**
     * Hàm gửi thông báo, cảnh báo hệ thống bằng Google Chat
     *
     * @param array           $sdkConfig Cấu hình SDK
     * @param string          $module    Tên Module cần báo lỗi / cảnh báo
     * @param string          $message   Nội dung cảnh báo / Lỗi
     * @param null|string|int $spaceId   ID của phòng chat / người nhận
     *
     * @return bool
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 10/10/19 08:52
     */
    public static function google_chat(array $sdkConfig = array(), string $module = '', string $message = '', $spaceId = null): bool
    {
        $config_key = 'google_chat';
        try {
            $config = $sdkConfig[$config_key];
            if (isset($sdkConfig[$config_key]) && !empty($sdkConfig[$config_key])) {
                $title = isset($sdkConfig['SERVICES']['monitorProjectName']) ? '[' . $sdkConfig['SERVICES']['monitorProjectName'] . '] - ' : '';
                $message = $title . $module . ' -> ' . $message;
                if (!empty($spaceId)) {
                    $chatId = $spaceId;
                } elseif (isset($config['default_space_id'])) {
                    $chatId = $config['default_space_id'];
                } else {
                    $chatId = null;
                }
                $access_key = $config['access_key'] ?? null;
                $access_token = $config['access_token'] ?? null;
                $handle = new Notifier();
                $handle->setSpaceId($chatId)
                       ->setKey($access_key)
                       ->setToken($access_token)
                       ->setMessage($message);

                return $handle->send();
            }
        } catch (Exception $e) {
            if (function_exists('log_message')) {
                log_message('error', 'Error Message: ' . $e->getMessage());
                log_message('error', 'Error Trace As String: ' . $e->getTraceAsString());
            }
        }

        return false;
    }

    /**
     * Hàm gửi thông báo, cảnh báo hệ thống bằng Microsoft Teams
     *
     * @param array  $sdkConfig Cấu hình SDK
     * @param string $module    Tên Module cần báo lỗi / cảnh báo
     * @param string $message   Nội dung cảnh báo / Lỗi
     *
     * @return bool
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/03/2020 52:26
     */
    public static function teams(array $sdkConfig = array(), string $module = '', string $message = ''): bool
    {
        $config_key = 'microsoft_teams_connector';
        try {
            $webhookUrl = $sdkConfig[$config_key];
            if (isset($sdkConfig[$config_key]) && !empty($sdkConfig[$config_key])) {
                if (isset($sdkConfig['SERVICES']['monitorProjectName'])) {
                    $monitorProjectName = '[' . $sdkConfig['SERVICES']['monitorProjectName'] . '] - ';
                } else {
                    $monitorProjectName = '';
                }
                $title = $monitorProjectName . $module;
                $textMessage = $message;
                $teams = new MicrosoftTeamsConnector();
                $teams->setWebHook($webhookUrl)
                      ->simpleMessage($title, $textMessage);

                return true;
            }
        } catch (Exception $e) {
            if (function_exists('log_message')) {
                log_message('error', 'Error Message: ' . $e->getMessage());
                log_message('error', 'Error Trace As String: ' . $e->getTraceAsString());
            }
        }

        return false;
    }
}
