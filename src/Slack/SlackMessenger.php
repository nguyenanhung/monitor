<?php
/**
 * Project monitor.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 11/26/18
 * Time: 00:48
 */

namespace nguyenanhung\Monitor\Slack;

use Maknz\Slack\Client;
use Maknz\Slack\Message;
use nguyenanhung\Monitor\ProjectInterface;

/**
 * Class SlackMessenger
 *
 * @package   nguyenanhung\Monitor\Slack
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class SlackMessenger implements ProjectInterface, SlackMessengerInterface
{
    /** @var array|null SDK Config */
    private $sdkConfig;
    /** @var array|null Setup Client Attributes */
    private $clientAttributes;
    /** @var string|null Target Channel received Message */
    private $targetChannel;
    /** @var mixed Content Message */
    private $contentMessage;
    /** @var mixed Attach Message */
    private $attachMessage;

    /**
     * SlackMessenger constructor.
     */
    public function __construct()
    {
    }

    /**
     * Function getVersion
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/26/18 00:48
     *
     * @return mixed|string
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * Function setSdkConfig
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/26/18 00:49
     *
     * @param array $sdkConfig
     *
     * @return $this
     */
    public function setSdkConfig($sdkConfig = [])
    {
        $this->sdkConfig = $sdkConfig;

        return $this;
    }

    /**
     * Function getSdkConfig
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/26/18 00:49
     *
     * @return mixed
     */
    public function getSdkConfig()
    {
        return $this->sdkConfig;
    }

    /**
     * Function setClientAttributes
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/26/18 00:50
     *
     * @param array $clientAttributes
     *
     * @return $this
     */
    public function setClientAttributes($clientAttributes = [])
    {
        $this->clientAttributes = $clientAttributes;

        return $this;
    }

    /**
     * Function getClientAttributes
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/26/18 00:51
     *
     * @return mixed
     */
    public function getClientAttributes()
    {
        return $this->clientAttributes;
    }

    /**
     * Function setTargetChannel
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/26/18 00:53
     *
     * @param string $targetChannel
     *
     * @return $this
     */
    public function setTargetChannel($targetChannel = '')
    {
        $this->targetChannel = $targetChannel;

        return $this;
    }

    /**
     * Function getTargetChannel
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/26/18 00:53
     *
     * @return string|null
     */
    public function getTargetChannel()
    {
        return $this->targetChannel;
    }

    /**
     * Function setContentMessage
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/26/18 00:58
     *
     * @param mixed $contentMessage
     *
     * @return $this
     */
    public function setContentMessage($contentMessage = '')
    {
        $this->contentMessage = $contentMessage;

        return $this;
    }

    /**
     * Function getContentMessage
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/26/18 00:58
     *
     * @return mixed
     */
    public function getContentMessage()
    {
        return $this->contentMessage;
    }

    /**
     * Function setAttachMessage
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/26/18 01:01
     *
     * @param mixed $attachMessage
     *
     * @return $this
     */
    public function setAttachMessage($attachMessage)
    {
        $this->attachMessage = $attachMessage;

        return $this;
    }

    /**
     * Function getAttachMessage
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/26/18 01:01
     *
     * @return mixed
     */
    public function getAttachMessage()
    {
        return $this->attachMessage;
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
        $client  = new Client($this->sdkConfig[self::SLACK_MESSENGER_CONFIG_KEY]['incoming_url'], $this->clientAttributes);
        $message = new Message($client);
        $message->to($this->targetChannel);
        if (!empty($this->attachMessage)) {
            $message->attach($this->attachMessage);
        }
        if (!empty($this->contentMessage)) {
            $message->setText($this->contentMessage);
        }
        $message->send();
    }
}
