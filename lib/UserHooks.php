<?php

namespace OCA\KeycloakSync;

use OCP\Session;

class UserHooks {

    private $session;
    private $loginHandler;

    public function __construct(Session $session, LoginHandler $loginHandler) {
        $this->session = $session;
        $this->loginHandler = $loginHandler;
    }

    public function register() {
        $this->session->listen('\OC\User', 'postLogin', function ($user) {
            $this->loginHandler->synchronizeUser($user);
        });
    }
}