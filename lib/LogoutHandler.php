<?php
namespace OCA\KeycloakSync;

use OCP\ILogger;
use OCP\IConfig;
use OCP\IRequest;

class LogoutHandler {
    const LOGOUT_URL_KEY = 'keycloak_logout_url';

    private $config;
    private $request;
    private $logger;
    private $appName;

    public function __construct($appName,
                                ILogger $logger,
                                IConfig $config,
                                IRequest $request) {
        $this->config = $config;
        $this->request = $request;
        $this->logger = $logger;
        $this->appName = $appName;
    }

    public function logout() {
        $logoutUrl = $this->config->getSystemValue(LogoutHandler::LOGOUT_URL_KEY);
        if ($logoutUrl !== '') {
            $redirectUri = $this->request->getServerProtocol() . '://' . $this->request->getServerHost();
            $this->logger->info('Trying to redirect to "' . $logoutUrl . '" on logout', array('app' => $this->appName));

            header('Location: ' . $logoutUrl . '?redirect_uri=' . $redirectUri);
            exit;
        }
    }
}