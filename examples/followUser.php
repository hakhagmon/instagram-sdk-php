<?php

require '../vendor/autoload.php';

try {
    $instagram = new \Instagram\Instagram();
    $instagram->login('username', 'password');
    var_dump($instagram->followUser('userId'));
} catch (\Exception $e) {
    echo $e->getMessage();
}
