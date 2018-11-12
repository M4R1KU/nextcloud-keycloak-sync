<?php
namespace OCA\KeycloakSync;

use OCP\AppFramework\App;

class KeycloakSync extends App {
    public function __construct(array $urlParams= array()) {
        parent::__construct('keycloaksync', $urlParams);
    }
}