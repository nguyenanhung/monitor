<?php
/**
 * Project monitor.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 11/26/18
 * Time: 00:48
 */

namespace nguyenanhung\Monitor\Telegram;

use nguyenanhung\TelegramMessenger\TelegramMessenger as TelegramMessengerMaster;

/**
 * Class TelegramMessenger
 *
 * Class này chỉ phục vụ tính năng gửi tin nhắn đến 1 group hoặc 1 user nhất đinh
 * không phải bot xử lý đa chức năng
 *
 * @package   nguyenanhung\Monitor\Telegram
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class TelegramMessenger extends TelegramMessengerMaster
{
}
