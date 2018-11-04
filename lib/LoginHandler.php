<?php
namespace OCA\KeycloakSync;

use OCP\ILogger;

class LoginHandler {

    private $logger;

    public function __construct(ILogger $logger) {
        $this->logger = $logger;
    }

    public function synchronizeUser($user) {
        $this->logger->info($user);
    }
}