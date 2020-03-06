<?php
/**
 * Project monitor.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 11/26/18
 * Time: 00:48
 */

namespace nguyenanhung\Monitor\Slack;

use nguyenanhung\Slack\Client;
use nguyenanhung\Slack\Message;
use nguyenanhung\Monitor\ProjectInterface;
use nguyenanhung\Monitor\Version;
use nguyenanhung\Monitor\Config;

/**
 * Class SlackMessenger
 *
 * Hàm này dùng gửi tin tới 1 workspace qua incoming web hooks
 *
 * @package   nguyenanhung\Monitor\Slack
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class SlackMessenger implements ProjectInterface
{
    use Version, Config;

    const SLACK_MESSENGER_CONFIG_KEY = 'slack_messages';

    /** @var array|null SDK Config */
    private $sdkConfig;
    /** @var array|null Setup Client Attributes */
    private $clientAttributes;
    /** @var string|null Incoming WebHooks URL received Message */
    private $incomingUrl;
    /** @var string|null Target Channel received Message */
    private $targetChannel;
    /** @var mixed Content Message */
    private $contentMessage;
    /** @var mixed Attach Message */
    private $attachMessage;
    /** @var bool Cấu hình Message sử dụng Markdown */
    private $useMarkdown;

    /**
     * SlackMessenger constructor.
     */
    public function __construct()
    {
    }

    /**
     * Function setClientAttributes
     *
     * @param array $clientAttributes
     *
     * @return $this
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/26/18 00:50
     *
     */
    public function setClientAttributes($clientAttributes = array())
    {
        $this->clientAttributes = $clientAttributes;

        return $this;
    }

    /**
     * Function getClientAttributes
     *
     * @return mixed
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/26/18 00:51
     *
     */
    public function getClientAttributes()
    {
        return $this->clientAttributes;
    }

    /**
     * Function setIncomingUrl
     *
     * @param string $incomingUrl
     *
     * @return $this
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 2019-04-12 09:13
     *
     */
    public function setIncomingUrl($incomingUrl = '')
    {
        $this->incomingUrl = $incomingUrl;

        return $this;
    }

    /**
     * Function getIncomingUrl
     *
     * @return string|null
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 2019-04-12 09:14
     *
     */
    public function getIncomingUrl()
    {
        return $this->incomingUrl;
    }

    /**
     * Function setTargetChannel
     *
     * @param string $targetChannel
     *
     * @return $this
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/26/18 00:53
     *
     */
    public function setTargetChannel($targetChannel = '')
    {
        $this->targetChannel = $targetChannel;

        return $this;
    }

    /**
     * Function getTargetChannel
     *
     * @return string|null
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/26/18 00:53
     *
     */
    public function getTargetChannel()
    {
        return $this->targetChannel;
    }

    /**
     * Function setContentMessage
     *
     * @param mixed $contentMessage
     *
     * @return $this
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/26/18 00:58
     *
     */
    public function setContentMessage($contentMessage = '')
    {
        $this->contentMessage = $contentMessage;

        return $this;
    }

    /**
     * Function getContentMessage
     *
     * @return mixed
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/26/18 00:58
     *
     */
    public function getContentMessage()
    {
        return $this->contentMessage;
    }

    /**
     * Function setAttachMessage
     *
     * @param mixed $attachMessage
     *
     * @return $this
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/26/18 01:01
     *
     */
    public function setAttachMessage($attachMessage)
    {
        $this->attachMessage = $attachMessage;

        return $this;
    }

    /**
     * Function getAttachMessage
     *
     * @return mixed
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/26/18 01:01
     *
     */
    public function getAttachMessage()
    {
        return $this->attachMessage;
    }

    /**
     * Function setUseMarkdown
     *
     * @param bool $useMarkdown
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 2/17/20 30:11
     */
    public function setUseMarkdown($useMarkdown = FALSE)
    {
        $this->useMarkdown = $useMarkdown;

        return $this;
    }

    /**
     * Function send
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/26/18 01:04
     *
     */
    public function send()
    {
        $incomingUrl      = !empty($this->incomingUrl) ? $this->incomingUrl : $this->sdkConfig[self::SLACK_MESSENGER_CONFIG_KEY]['incoming_url'];
        $clientAttributes = is_array($this->clientAttributes) ? $this->clientAttributes : array();
        $client           = new Client($incomingUrl, $clientAttributes);
        $message          = new Message($client);
        $message->to($this->targetChannel);
        if (!empty($this->attachMessage)) {
            $message->attach($this->attachMessage);
        }
        if (!empty($this->contentMessage)) {
            $message->setText($this->contentMessage);
        }
        if ($this->useMarkdown === TRUE) {
            $message->enableMarkdown();
        }
        $message->send();
    }
}
