<?php
namespace OCA\KeycloakSync;

use \OCP\AppFramework\App;

class KeycloakSync extends App {
    public function __construct(array $urlParams= array()) {
        parent::__construct('keycloaksync', $urlParams);

        $container = $this->getContainer();

        $container->registerService('LoginHandler', function ($c) {
            return new LoginHandler(
                $c->query('Logger')
            );
        });

        $container->registerService('UserHooks', function ($c) {
            return new UserHooks(
                $c->query('ServerContainer')->getUserSession(),
                $c->query('LoginHandler')
            );
        });

        $container->registerService('Logger', function($c) {
            return $c->query('ServerContainer')->getLogger();
        });
    }
}