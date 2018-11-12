<?php

//OC::$CLASSPATH['UserHooks'] = 'lib/UserHooks.php';
//OCP\Util::connectHook('OC_User', 'post_login', 'UserHooks', 'synchronizeUser');
$sync = new \OCA\KeycloakSync\KeycloakSync();
$sync->getContainer()->query('OCA\KeycloakSync\UserHooks')->register();
