<?php

namespace OCA\KeycloakSync;

use OC\User\Session;

class UserHooks {

    private $session;
    private $loginHandler;
    private $logoutHandler;

    public function __construct(Session $session,
                                LoginHandler $loginHandler,
                                LogoutHandler $logoutHandler) {
        $this->session = $session;
        $this->loginHandler = $loginHandler;
        $this->logoutHandler = $logoutHandler;
    }

    public function register() {
        $this->session->listen('\OC\User', 'postLogin', function ($user) {
            $this->loginHandler->synchronizeUser($user);
        });

        $this->session->listen('\OC\User', 'postLogout', function () {
            $this->logoutHandler->logout();
        });
    }
}