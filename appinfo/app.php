<?php

$sync = new \OCA\KeycloakSync\KeycloakSync();
if (!class_exists('OCA\SocialLogin\AppInfo\Application')) {
    $sync->getContainer()
        ->query('ServerContainer')
        ->getLogger()
        ->error('SocialLogin App is not present in the current environment, wont start keycloaksync', array('app' => 'keycloaksync'));
}
else {
    $sync->getContainer()->query('OCA\KeycloakSync\UserHooks')->register();
}
