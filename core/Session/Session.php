<?php

namespace Core\Session;

class Session
{
    /**
     * session Instance
     *
     * @var Session $sessionInstance
     */
    public static $sessionInstance;

    /**
     * get Session Instance
     *
     * @return Session self::$sessionInstance
     */
    public static function sessionInstance()
    {
        if (empty(self::$sessionInstance)) {
            self::$sessionInstance = new Session();
        }
        return self::$sessionInstance;
    }

    /**
     * Initialize Session if is not defined
     */
    public function initializeSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Flash Message
     */
    public function addFlash($type = null, $message = null)
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }
}
