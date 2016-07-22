<?php

require '../vendor/autoload.php';

try {
    $instagram = new \Instagram\Instagram();
    $instagram->login('username', 'password');

    $session = $instagram->saveSession();
    $instagram->initFromSession($session);
} catch (\Exception $e) {
    echo $e->getMessage();
}
