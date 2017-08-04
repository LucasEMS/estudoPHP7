<?php
namespace Application\Filter;

class Messages
{
    const MESSAGE_UNKNOWN = 'Unknown';
    public static $messages;
    public static function setMessages(array $messages)
    {
        self::$messages = $messages;
    }
    public static function setMessage($key, $message)
    {
        self::$messages[$key] = $message;
    }
    public static function getMessages($key)
    {
        return self::$messages[$key] ?? self::MESSAGE_UNKNOWN;
    }
}