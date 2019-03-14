<?php

namespace OCA\KeycloakSync;

use OCP\ILogger;
use OCP\IUserManager;
use OCP\IGroupManager;
use OCP\ISession;

class LoginHandler {
    private $appName;
    private $logger;
    private $userManager;
    private $session;
    private $groupManager;


    public function __construct($appName,
                                ILogger $logger,
                                IUserManager $userManager,
                                ISession $session,
                                IGroupManager $groupManager) {
        $this->logger = $logger;
        $this->userManager = $userManager;
        $this->session = $session;
        $this->groupManager = $groupManager;
        $this->appName = $appName;
    }

    public function synchronizeUser($user) {
        $this->logger->info('Synchronizing user "' . $user->getDisplayName(), array('app' => $this->appName));

        $token = $this->getToken();
        $this->logger->debug('Token "' . print_r($token, true), array('app' => $this->appName));

        // read Authorized Party from token
        $clientId = $token['azp'];

        $roles = $this->getClientRolesFromToken($token, $clientId);

        if (empty($roles)) {
            return;
        }

        $userEntity = $this->userManager->get($user->getUID());
        if ($userEntity == null) {
            $this->logger->warn('User "' . $user->getDisplayName() . '" not found in database', array('app' => $this->appName));
            return;
        }

        $userGroups = $this->groupManager->getUserGroupIds($userEntity);
        $this->logger->debug('Current User groups: ' . print_r($userGroups, true), array('app' => $this->appName));

        foreach ($roles as $role) {
            if (($key = array_search($role, $userGroups)) !== false) {
                $this->logger->debug('Group "' . $role . '" associated with user => skipping', array('app' => $this->appName));
                unset($userGroups[$key]);
                continue;
            }

            $group = $this->groupManager->groupExists($role) ?
                $this->groupManager->get($role) :
                $this->groupManager->createGroup($role);

            $this->logger->debug('Adding user to group "' . $role . '"', array('app' => $this->appName));
            $group->addUser($userEntity);
        }

        if (count($userGroups) > 0) {
            $this->logger->debug('Removed groups ' . print_r($userGroups, true) . '  from user', array('app' => $this->appName));
            foreach ($userGroups as $group) {
                $this->groupManager->get($group)->removeUser($user);
            }
        }
    }

    private function getToken() {
        $encoded = $this->session->get($this->getProviderShortName() . '.access_token');
        $payload = explode('.', $encoded)[1];

        return json_decode(base64_decode($payload), true);
    }

    private function getClientRolesFromToken($token, $clientId) {
        if (!array_key_exists('resource_access', $token)) {
            return array();
        }
        $resource_access = $token['resource_access'];
        if (!array_key_exists($clientId, $resource_access)) {
            return array();
        }

        return $resource_access[$clientId]['roles'];
    }

    private function getProviderShortName() {
        return (new \ReflectionClass('\OCA\SocialLogin\Provider\CustomOpenIDConnect'))->getShortName();
    }
}
