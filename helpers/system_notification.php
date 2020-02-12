<?php
/**
 * Project monitor
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 2/12/20
 * Time: 11:00
 */
if (!function_exists('system_notification_to_mantis')) {
    /**
     * Hàm gửi thông báo, cảnh báo hệ thống tới Mantis Bug Tracker
     *
     * @param array  $sdkConfig   Cấu hình SDK
     * @param string $module      Tên Module cần báo lỗi / cảnh báo
     * @param string $title       Tiêu đề lỗi / Cảnh báo
     * @param string $description Mô tả chi tiết
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 2/12/20 02:29
     */
    function system_notification_to_mantis($sdkConfig = array(), $module = '', $title = 'Bug', $description = 'Bug')
    {
        return nguyenanhung\Monitor\SystemNotification::mantis($sdkConfig, $module, $title, $description);
    }
}
if (!function_exists('system_notification_to_slack')) {
    /**
     * Hàm gửi thông báo, cảnh báo hệ thống bằng Slack
     *
     * @param array  $sdkConfig     Cấu hình SDK
     * @param string $module        Tên Module cần báo lỗi / cảnh báo
     * @param string $message       Nội dung Cảnh báo / Lỗi
     * @param array  $attachMessage Thông tin đính kèm
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 2/12/20 03:38
     */
    function system_notification_to_slack($sdkConfig = array(), $module = '', $message = '', $attachMessage = array())
    {
        return nguyenanhung\Monitor\SystemNotification::slack($sdkConfig, $module, $message, $attachMessage);
    }
}
if (!function_exists('system_notification_to_telegram')) {
    /**
     * Hàm gửi thông báo, cảnh báo hệ thống bằng Telegram
     *
     * @param array  $sdkConfig Cấu hình SDK
     * @param string $module    Tên Module cần báo lỗi / cảnh báo
     * @param string $message   Nội dung cảnh báo / Lỗi
     * @param null   $roomId    ID của phòng chat / người nhận
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 2/12/20 04:37
     */
    function system_notification_to_telegram($sdkConfig = array(), $module = '', $message = '', $roomId = NULL)
    {
        return nguyenanhung\Monitor\SystemNotification::telegram($sdkConfig, $module, $message, $roomId);
    }
}
