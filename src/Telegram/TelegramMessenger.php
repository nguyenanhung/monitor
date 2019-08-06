<?php
/**
 * Project monitor.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 11/26/18
 * Time: 00:48
 */

namespace nguyenanhung\Monitor\Telegram;

use nguyenanhung\MyRequests\MyRequests;
use nguyenanhung\Monitor\ProjectInterface;
use nguyenanhung\Monitor\Version;
use nguyenanhung\Monitor\Config;

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
class TelegramMessenger implements ProjectInterface, TelegramMessengerInterface
{
    const _CLASS_NAME_ = 'TelegramMessenger';

    use Version, Config;

    /** @var array|null SDK Config */
    private $sdkConfig;
    /** @var object \nguyenanhung\MyRequests\MyRequests */
    private $requests;
    /** @var null|string|int ChatID */
    private $chatId = NULL;
    /** @var null|string Text Message */
    private $message = NULL;
    /** @var null|string File Attachment content */
    private $fileAttachment = NULL;

    /**
     * TelegramMessenger constructor.
     */
    public function __construct()
    {
        $this->requests = new MyRequests();
    }

    /**
     * Function getBotUpdates
     *
     * @return array|mixed
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 2019-08-06 16:50
     *
     */
    public function getBotUpdates()
    {
        $errorResponse = array('error' => TRUE);
        if (!isset($this->sdkConfig[self::TELEGRAM_MESSENGER_CONFIG_KEY])) {
            return $errorResponse;
        }

        // Cấu hình SDK
        $sdkConfig = $this->sdkConfig[self::TELEGRAM_MESSENGER_CONFIG_KEY];

        // Xác định API Key
        if (!isset($sdkConfig['bot_api_key'])) {
            return $errorResponse;
        }

        // Xác định tham số gửi tin đi
        $chatId      = !empty($this->chatId) ? $this->chatId : (isset($sdkConfig['default_chat_id']) ? $sdkConfig['default_chat_id'] : NULL);
        $textMessage = !empty($this->message) ? $this->message : NULL;
        if (empty($chatId) || empty($textMessage)) {
            return $errorResponse;
        }

        // Thiết lập Endpoint và Tham số gửi tin đi
        $endpoint    = self::TELEGRAM_API . $sdkConfig['bot_api_key'] . self::METHOD_GET_UPDATES;
        $sendRequest = $this->requests->sendRequest($endpoint, array(), 'POST');
        $res         = json_decode(trim($sendRequest));

        // Nếu không xác định được nội dung trả về
        if ($res == NULL) {
            return $errorResponse;
        }

        // Trường hợp gửi tin nhắn thành công
        if ((isset($res->ok) && ($res->ok == TRUE)) && isset($res->result)) {
            return $res;
        }

        return $errorResponse;
    }

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ ChatID ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ //

    /**
     * Function setChatId
     *
     * @param string $chatId
     *
     * @return $this|\nguyenanhung\Monitor\Telegram\TelegramMessengerInterface
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 2019-08-04 03:00
     *
     */
    public function setChatId($chatId = NULL)
    {
        $this->chatId = $chatId;

        return $this;
    }

    /**
     * Function getChatId
     *
     * @return int|mixed|string|null
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 2019-08-04 03:00
     *
     */
    public function getChatId()
    {
        return $this->chatId;
    }

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ FileAttachment ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ //

    /**
     * Function setFileAttachment
     *
     * @param null $fileAttachment
     *
     * @return $this
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 2019-08-04 03:37
     *
     */
    public function setFileAttachment($fileAttachment = NULL)
    {
        $this->fileAttachment = $fileAttachment;

        return $this;
    }

    /**
     * Function getFileAttachment
     *
     * @return string|null
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 2019-08-04 03:37
     *
     */
    public function getFileAttachment()
    {
        return $this->fileAttachment;
    }

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Message ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ //

    /**
     * Function setMessage
     *
     * @param string $message
     *
     * @return $this|\nguyenanhung\Monitor\Telegram\TelegramMessengerInterface
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 2019-08-04 03:00
     *
     */
    public function setMessage($message = NULL)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Function getMessage
     *
     * @return string|null
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 2019-08-04 03:00
     *
     */
    public function getMessage()
    {
        return $this->message;
    }

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Sending Method ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ //

    /**
     * Function sendMessage
     *
     * @return bool
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 2019-08-04 02:59
     *
     */
    public function sendMessage()
    {
        if (!isset($this->sdkConfig[self::TELEGRAM_MESSENGER_CONFIG_KEY])) {
            $responseMsg = self::_CLASS_NAME_ . ' -> Không tìm thấy cấu hình Telegram Messenger';
            if (function_exists('log_message')) {
                log_message('error', $responseMsg);
            }

            return FALSE;
        }

        // Cấu hình SDK
        $sdkConfig = $this->sdkConfig[self::TELEGRAM_MESSENGER_CONFIG_KEY];

        // Xác định API Key
        if (!isset($sdkConfig['bot_api_key'])) {
            $responseMsg = self::_CLASS_NAME_ . ' -> Không tìm thấy cấu hình API Key cho việc gửi tin đi Telegram Messenger';
            if (function_exists('log_message')) {
                log_message('error', $responseMsg);
            }

            return FALSE;
        }

        // Xác định tham số gửi tin đi
        $chatId      = !empty($this->chatId) ? $this->chatId : (isset($sdkConfig['default_chat_id']) ? $sdkConfig['default_chat_id'] : NULL);
        $textMessage = !empty($this->message) ? $this->message : NULL;
        if (empty($chatId) || empty($textMessage)) {
            $responseMsg = self::_CLASS_NAME_ . ' -> Không xác định được chủ đề cuộc trò chuyện và nội dung gửi đi. ChatID: ' . $chatId . ' - TextMessage: ' . $textMessage;
            if (function_exists('log_message')) {
                log_message('error', $responseMsg);
            }

            return FALSE;
        }

        // Thiết lập Endpoint và Tham số gửi tin đi
        $endpoint    = self::TELEGRAM_API . $sdkConfig['bot_api_key'] . self::METHOD_SEND_MESSAGE;
        $params      = array('text' => $textMessage, 'chat_id' => $chatId);
        $sendRequest = $this->requests->sendRequest($endpoint, $params, 'POST');
        $res         = json_decode(trim($sendRequest));

        // Nếu không xác định được nội dung trả về
        if ($res == NULL) {
            // Không Decode được mã trả về
            $responseMsg = self::_CLASS_NAME_ . ' -> Không xác định được mã trả về!';
            if (function_exists('log_message')) {
                log_message('error', $responseMsg);
            }

            return FALSE;
        }

        // Trường hợp gửi tin nhắn thành công
        if ((isset($res->ok) && ($res->ok == TRUE)) && isset($res->result)) {
            // Gửi tin nhắn thành công
            $responseMsg = self::_CLASS_NAME_ . ' -> ' . self::METHOD_SEND_MESSAGE . ' Success with Params -> ' . json_encode($params);
            if (function_exists('log_message')) {
                log_message('debug', $responseMsg);
            }

            return TRUE;
        }

        return FALSE;
    }

    /**
     * Function sendPhoto
     *
     * @return bool|mixed
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 2019-08-04 03:23
     *
     */
    public function sendPhoto()
    {
        if (!isset($this->sdkConfig[self::TELEGRAM_MESSENGER_CONFIG_KEY])) {
            $responseMsg = self::_CLASS_NAME_ . ' -> Không tìm thấy cấu hình Telegram Messenger';
            if (function_exists('log_message')) {
                log_message('error', $responseMsg);
            }

            return FALSE;
        }

        // Cấu hình SDK
        $sdkConfig = $this->sdkConfig[self::TELEGRAM_MESSENGER_CONFIG_KEY];

        // Xác định API Key
        if (!isset($sdkConfig['bot_api_key'])) {
            $responseMsg = self::_CLASS_NAME_ . ' -> Không tìm thấy cấu hình API Key cho việc gửi tin đi Telegram Messenger';
            if (function_exists('log_message')) {
                log_message('error', $responseMsg);
            }

            return FALSE;
        }

        // Xác định tham số gửi tin đi
        $chatId  = !empty($this->chatId) ? $this->chatId : (isset($sdkConfig['default_chat_id']) ? $sdkConfig['default_chat_id'] : NULL);
        $caption = !empty($this->message) ? $this->message : 'Photo';
        $photo   = !empty($this->fileAttachment) ? $this->fileAttachment : NULL;
        if (empty($chatId) || empty($photo)) {
            $responseMsg = self::_CLASS_NAME_ . ' -> Không xác định được chủ đề cuộc trò chuyện và nội dung gửi đi. ChatID: ' . $chatId . ' - Caption: ' . $caption . ' - Photo: ' . $photo;
            if (function_exists('log_message')) {
                log_message('error', $responseMsg);
            }

            return FALSE;
        }

        // Thiết lập Endpoint và Tham số gửi tin đi
        $endpoint    = self::TELEGRAM_API . $sdkConfig['bot_api_key'] . self::METHOD_SEND_PHOTO;
        $params      = array('photo' => $photo, 'chat_id' => $chatId, 'caption' => $caption);
        $sendRequest = $this->requests->sendRequest($endpoint, $params, 'POST');
        $res         = json_decode(trim($sendRequest));

        // Nếu không xác định được nội dung trả về
        if ($res == NULL) {
            // Không Decode được mã trả về
            $responseMsg = self::_CLASS_NAME_ . ' -> Không xác định được mã trả về!';
            if (function_exists('log_message')) {
                log_message('error', $responseMsg);
            }

            return FALSE;
        }

        // Trường hợp gửi tin nhắn thành công
        if ((isset($res->ok) && ($res->ok == TRUE)) && isset($res->result)) {
            // Gửi tin nhắn thành công
            $responseMsg = self::_CLASS_NAME_ . ' -> ' . self::METHOD_SEND_PHOTO . ' Success with Params -> ' . json_encode($params);
            if (function_exists('log_message')) {
                log_message('debug', $responseMsg);
            }

            return TRUE;
        }

        return FALSE;
    }

    /**
     * Function sendAudio
     *
     * @return bool|mixed
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 2019-08-04 03:30
     *
     */
    public function sendAudio()
    {
        if (!isset($this->sdkConfig[self::TELEGRAM_MESSENGER_CONFIG_KEY])) {
            $responseMsg = self::_CLASS_NAME_ . ' -> Không tìm thấy cấu hình Telegram Messenger';
            if (function_exists('log_message')) {
                log_message('error', $responseMsg);
            }

            return FALSE;
        }

        // Cấu hình SDK
        $sdkConfig = $this->sdkConfig[self::TELEGRAM_MESSENGER_CONFIG_KEY];

        // Xác định API Key
        if (!isset($sdkConfig['bot_api_key'])) {
            $responseMsg = self::_CLASS_NAME_ . ' -> Không tìm thấy cấu hình API Key cho việc gửi tin đi Telegram Messenger';
            if (function_exists('log_message')) {
                log_message('error', $responseMsg);
            }

            return FALSE;
        }

        // Xác định tham số gửi tin đi
        $chatId  = !empty($this->chatId) ? $this->chatId : (isset($sdkConfig['default_chat_id']) ? $sdkConfig['default_chat_id'] : NULL);
        $caption = !empty($this->message) ? $this->message : 'Audio';
        $audio   = !empty($this->fileAttachment) ? $this->fileAttachment : NULL;
        if (empty($chatId) || empty($audio)) {
            $responseMsg = self::_CLASS_NAME_ . ' -> Không xác định được chủ đề cuộc trò chuyện và nội dung gửi đi. ChatID: ' . $chatId . ' - Caption: ' . $caption . ' - Audio: ' . $audio;
            if (function_exists('log_message')) {
                log_message('error', $responseMsg);
            }

            return FALSE;
        }

        // Thiết lập Endpoint và Tham số gửi tin đi
        $endpoint    = self::TELEGRAM_API . $sdkConfig['bot_api_key'] . self::METHOD_SEND_AUDIO;
        $params      = array('audio' => $audio, 'chat_id' => $chatId, 'caption' => $caption);
        $sendRequest = $this->requests->sendRequest($endpoint, $params, 'POST');
        $res         = json_decode(trim($sendRequest));

        // Nếu không xác định được nội dung trả về
        if ($res == NULL) {
            // Không Decode được mã trả về
            $responseMsg = self::_CLASS_NAME_ . ' -> Không xác định được mã trả về!';
            if (function_exists('log_message')) {
                log_message('error', $responseMsg);
            }

            return FALSE;
        }

        // Trường hợp gửi tin nhắn thành công
        if ((isset($res->ok) && ($res->ok == TRUE)) && isset($res->result)) {
            // Gửi tin nhắn thành công
            $responseMsg = self::_CLASS_NAME_ . ' -> ' . self::METHOD_SEND_AUDIO . ' Success with Params -> ' . json_encode($params);
            if (function_exists('log_message')) {
                log_message('debug', $responseMsg);
            }

            return TRUE;
        }

        return FALSE;
    }

    /**
     * Function sendVideo
     *
     * @return bool|mixed
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 2019-08-04 03:33
     *
     */
    public function sendVideo()
    {
        if (!isset($this->sdkConfig[self::TELEGRAM_MESSENGER_CONFIG_KEY])) {
            $responseMsg = self::_CLASS_NAME_ . ' -> Không tìm thấy cấu hình Telegram Messenger';
            if (function_exists('log_message')) {
                log_message('error', $responseMsg);
            }

            return FALSE;
        }

        // Cấu hình SDK
        $sdkConfig = $this->sdkConfig[self::TELEGRAM_MESSENGER_CONFIG_KEY];

        // Xác định API Key
        if (!isset($sdkConfig['bot_api_key'])) {
            $responseMsg = self::_CLASS_NAME_ . ' -> Không tìm thấy cấu hình API Key cho việc gửi tin đi Telegram Messenger';
            if (function_exists('log_message')) {
                log_message('error', $responseMsg);
            }

            return FALSE;
        }

        // Xác định tham số gửi tin đi
        $chatId  = !empty($this->chatId) ? $this->chatId : (isset($sdkConfig['default_chat_id']) ? $sdkConfig['default_chat_id'] : NULL);
        $caption = !empty($this->message) ? $this->message : 'video';
        $video   = !empty($this->fileAttachment) ? $this->fileAttachment : NULL;
        if (empty($chatId) || empty($video)) {
            $responseMsg = self::_CLASS_NAME_ . ' -> Không xác định được chủ đề cuộc trò chuyện và nội dung gửi đi. ChatID: ' . $chatId . ' - Caption: ' . $caption . ' - Video: ' . $video;
            if (function_exists('log_message')) {
                log_message('error', $responseMsg);
            }

            return FALSE;
        }

        // Thiết lập Endpoint và Tham số gửi tin đi
        $endpoint    = self::TELEGRAM_API . $sdkConfig['bot_api_key'] . self::METHOD_SEND_VIDEO;
        $params      = array('video' => $video, 'chat_id' => $chatId, 'caption' => $caption);
        $sendRequest = $this->requests->sendRequest($endpoint, $params, 'POST');
        $res         = json_decode(trim($sendRequest));

        // Nếu không xác định được nội dung trả về
        if ($res == NULL) {
            // Không Decode được mã trả về
            $responseMsg = self::_CLASS_NAME_ . ' -> Không xác định được mã trả về!';
            if (function_exists('log_message')) {
                log_message('error', $responseMsg);
            }

            return FALSE;
        }

        // Trường hợp gửi tin nhắn thành công
        if ((isset($res->ok) && ($res->ok == TRUE)) && isset($res->result)) {
            // Gửi tin nhắn thành công
            $responseMsg = self::_CLASS_NAME_ . ' -> ' . self::METHOD_SEND_VIDEO . ' Success with Params -> ' . json_encode($params);
            if (function_exists('log_message')) {
                log_message('debug', $responseMsg);
            }

            return TRUE;
        }

        return FALSE;
    }

    /**
     * Function sendDocument
     *
     * @return bool|mixed
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 2019-08-04 03:35
     *
     */
    public function sendDocument()
    {
        if (!isset($this->sdkConfig[self::TELEGRAM_MESSENGER_CONFIG_KEY])) {
            $responseMsg = self::_CLASS_NAME_ . ' -> Không tìm thấy cấu hình Telegram Messenger';
            if (function_exists('log_message')) {
                log_message('error', $responseMsg);
            }

            return FALSE;
        }

        // Cấu hình SDK
        $sdkConfig = $this->sdkConfig[self::TELEGRAM_MESSENGER_CONFIG_KEY];

        // Xác định API Key
        if (!isset($sdkConfig['bot_api_key'])) {
            $responseMsg = self::_CLASS_NAME_ . ' -> Không tìm thấy cấu hình API Key cho việc gửi tin đi Telegram Messenger';
            if (function_exists('log_message')) {
                log_message('error', $responseMsg);
            }

            return FALSE;
        }

        // Xác định tham số gửi tin đi
        $chatId   = !empty($this->chatId) ? $this->chatId : (isset($sdkConfig['default_chat_id']) ? $sdkConfig['default_chat_id'] : NULL);
        $caption  = !empty($this->message) ? $this->message : 'Document';
        $document = !empty($this->fileAttachment) ? $this->fileAttachment : NULL;
        if (empty($chatId) || empty($document)) {
            $responseMsg = self::_CLASS_NAME_ . ' -> Không xác định được chủ đề cuộc trò chuyện và nội dung gửi đi. ChatID: ' . $chatId . ' - Caption: ' . $caption . ' - Document: ' . $document;
            if (function_exists('log_message')) {
                log_message('error', $responseMsg);
            }

            return FALSE;
        }

        // Thiết lập Endpoint và Tham số gửi tin đi
        $endpoint    = self::TELEGRAM_API . $sdkConfig['bot_api_key'] . self::METHOD_SEND_DOCUMENT;
        $params      = array('document' => $document, 'chat_id' => $chatId, 'caption' => $caption);
        $sendRequest = $this->requests->sendRequest($endpoint, $params, 'POST');
        $res         = json_decode(trim($sendRequest));

        // Nếu không xác định được nội dung trả về
        if ($res == NULL) {
            // Không Decode được mã trả về
            $responseMsg = self::_CLASS_NAME_ . ' -> Không xác định được mã trả về!';
            if (function_exists('log_message')) {
                log_message('error', $responseMsg);
            }

            return FALSE;
        }

        // Trường hợp gửi tin nhắn thành công
        if ((isset($res->ok) && ($res->ok == TRUE)) && isset($res->result)) {
            // Gửi tin nhắn thành công
            $responseMsg = self::_CLASS_NAME_ . ' -> ' . self::METHOD_SEND_DOCUMENT . ' Success with Params -> ' . json_encode($params);
            if (function_exists('log_message')) {
                log_message('debug', $responseMsg);
            }

            return TRUE;
        }

        return FALSE;
    }
}
