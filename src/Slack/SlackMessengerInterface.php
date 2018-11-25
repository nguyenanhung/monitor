<?php
/**
 * Project monitor.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 11/26/18
 * Time: 00:54
 */

namespace nguyenanhung\Monitor\Slack;

/**
 * Interface SlackMessengerInterface
 *
 * @package nguyenanhung\Monitor\Slack
 */
interface SlackMessengerInterface
{
    const SLACK_MESSENGER_CONFIG_KEY = 'slack_messages';

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
    public function setSdkConfig($sdkConfig = []);

    /**
     * Function getSdkConfig
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/26/18 00:49
     *
     * @return mixed
     */
    public function getSdkConfig();

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
    public function setClientAttributes($clientAttributes = []);

    /**
     * Function getClientAttributes
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/26/18 00:51
     *
     * @return mixed
     */
    public function getClientAttributes();

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
    public function setTargetChannel($targetChannel = '');

    /**
     * Function getTargetChannel
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/26/18 00:53
     *
     * @return string|null
     */
    public function getTargetChannel();

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
    public function setContentMessage($contentMessage = '');

    /**
     * Function getContentMessage
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/26/18 00:58
     *
     * @return mixed
     */
    public function getContentMessage();

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
    public function setAttachMessage($attachMessage);

    /**
     * Function getAttachMessage
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/26/18 01:01
     *
     * @return mixed
     */
    public function getAttachMessage();

    /**
     * Function send
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/26/18 01:04
     *
     */
    public function send();
}
