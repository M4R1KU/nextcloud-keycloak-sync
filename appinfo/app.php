<?php


if (!class_exists('OCA\SocialLogin\AppInfo')) {
    throw new Exception('SocialLogin App is not present in the current environment, cannot start keycloaksync');
}

$sync = new \OCA\KeycloakSync\KeycloakSync();
$sync->getContainer()->query('OCA\KeycloakSync\UserHooks')->register();
