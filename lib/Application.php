<?php

namespace OCA\KeycloakSync;

use \OCP\AppFramework\App;

class KeycloakSync extends App {
    public function __construct(array $urlParams= array()) {
        parent::__construct('keycloak-sync', $urlParams);

        $container = $this->getContainer();

        $container->registerService('LoginHandler', function ($c) {
            return new LoginHandler(
                $c->query('ServerContainer')->getLogger()
            );
        });

        $container->registerService('UserHooks', function ($c) {
            return new UserHooks(
                $c->query('ServerContainer')->getUserManager(),
                $c->query('LoginHandler')
            );
        });
    }
}