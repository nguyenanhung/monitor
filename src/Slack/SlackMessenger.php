<?php
/**
 * Project monitor.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 11/26/18
 * Time: 00:48
 */

namespace nguyenanhung\Monitor\Slack;

use nguyenanhung\Slack\SlackSimpleMessenger;
use nguyenanhung\Monitor\ProjectInterface;
use nguyenanhung\Monitor\Version;

/**
 * Class SlackMessenger
 *
 * Hàm này dùng gửi tin tới 1 workspace qua incoming web hooks
 *
 * @package   nguyenanhung\Monitor\Slack
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class SlackMessenger extends SlackSimpleMessenger implements ProjectInterface
{
    use Version;
}
