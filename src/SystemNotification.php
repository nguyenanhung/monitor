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
use nguyenanhung\Monitor\Slack\SlackMessenger;
use nguyenanhung\Monitor\Telegram\TelegramMessenger;

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
     * @param array  $sdkConfig
     * @param string $module
     * @param string $title
     * @param string $description
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 10/10/19 09:23
     */
    public static function mantis($sdkConfig = array(), $module = '', $title = 'Bug', $description = 'Bug')
    {
        try {
            if (isset($sdkConfig['OPTIONS']) && !empty($sdkConfig['OPTIONS'])) {
                if (isset($sdkConfig['SERVICES']) && isset($sdkConfig['SERVICES']['monitorProjectName'])) {
                    $monitorProjectName = '[' . $sdkConfig['SERVICES']['monitorProjectName'] . '] - ';
                } else {
                    $monitorProjectName = '';
                }
                $options = $sdkConfig['OPTIONS'];
                $handle  = new MantisConnector();
                $handle->setMonitorUrl($options['monitorUrl'])
                       ->setMonitorUser($options['monitorUser'])
                       ->setUsername($options['monitorPassword'])
                       ->setProjectId($options['monitorProjectId'])
                       ->setMonitorPassword($options['monitorUsername'])
                       ->mantis($monitorProjectName . $title . ' - ' . $module, $description);
            }
        }
        catch (Exception $e) {
            if (function_exists('log_message')) {
                $message = 'Code: ' . $e->getCode() . ' - File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Message: ' . $e->getMessage();
                log_message('error', $message);
            }
        }
    }

    /**
     * Hàm gửi thông báo, cảnh báo hệ thống bằng Slack
     *
     * @param array  $sdkConfig
     * @param string $module
     * @param string $message
     * @param array  $attachMessage
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 10/10/19 09:13
     */
    public static function slack($sdkConfig = array(), $module = '', $message = '', $attachMessage = array())
    {
        $config_key = 'slack_messages';
        try {
            if (isset($sdkConfig[$config_key]) && !empty($sdkConfig[$config_key])) {
                if (isset($sdkConfig['SERVICES']) && isset($sdkConfig['SERVICES']['monitorProjectName'])) {
                    $monitorProjectName = '[' . $sdkConfig['SERVICES']['monitorProjectName'] . '] - ';
                } else {
                    $monitorProjectName = '';
                }
                $options = $sdkConfig[$config_key];
                $handle  = new SlackMessenger();
                $handle->setSdkConfig($sdkConfig);
                $handle->setTargetChannel($options['target_channel']);
                $handle->setClientAttributes($options['client_attributes']);
                $handle->setContentMessage($monitorProjectName . $module . ' - ' . $message);
                if (!empty($attachMessage)) {
                    $handle->setAttachMessage($attachMessage);
                }
                $handle->send();
            }
        }
        catch (Exception $e) {
            if (function_exists('log_message')) {
                $message = 'Code: ' . $e->getCode() . ' - File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Message: ' . $e->getMessage();
                log_message('error', $message);
            }
        }
    }

    /**
     * Hàm gửi thông báo, cảnh báo hệ thống bằng Telegram
     *
     * @param array  $sdkConfig
     * @param string $module
     * @param string $message
     * @param null   $roomId
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 10/10/19 08:52
     */
    public static function telegram($sdkConfig = array(), $module = '', $message = '', $roomId = NULL)
    {
        $config_key = 'telegram_messages';
        try {
            $config = $sdkConfig[$config_key];
            if (isset($sdkConfig[$config_key]) && !empty($sdkConfig[$config_key])) {
                $title   = isset($sdkConfig['SERVICES']) && isset($sdkConfig['SERVICES']['monitorProjectName']) ? '[' . $sdkConfig['SERVICES']['monitorProjectName'] . '] - ' : '';
                $message = $title . $module . ' -> ' . $message;
                $chatId  = !empty($roomId) && $roomId != NULL ? $roomId : (isset($config['default_chat_id']) ? $config['default_chat_id'] : NULL);
                $handle  = new TelegramMessenger();
                $handle->setSdkConfig($sdkConfig);
                $handle->setChatId($chatId);
                $handle->setMessage($message);
                $handle->sendMessage();
            }
        }
        catch (Exception $e) {
            if (function_exists('log_message')) {
            $message = 'Code: ' . $e->getCode() . ' - File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Message: ' . $e->getMessage();
                log_message('error', $message);
            }
        }
    }

    /**
     * Hàm gửi thông báo, cảnh báo hệ thống bằng SMS
     *
     * @param array  $sdkConfig
     * @param string $module
     * @param string $message
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 10/10/19 08:40
     */
    public static function sms($sdkConfig = array(), $module = '', $message = '')
    {
    }

    /**
     * Hàm gửi thông báo, cảnh báo hệ thống bằng Email
     *
     * @param array  $sdkConfig
     * @param string $module
     * @param string $message
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 10/10/19 08:35
     */
    public static function email($sdkConfig = array(), $module = '', $message = '')
    {
    }
}
