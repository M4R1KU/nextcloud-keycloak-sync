<?php

namespace OCA\KeycloakSync;

use OC\User\Session;

class UserHooks {

    private $session;
    private $loginHandler;

    public function __construct(Session $session, LoginHandler $loginHandler) {
        $this->session = $session;
        $this->loginHandler = $loginHandler;
    }

    public function register() {
        $callback = function ($user) {
            $this->loginHandler->synchronizeUser($user);
        };
        $this->session->listen('\OC\User', 'postLogin', $callback);
    }
}