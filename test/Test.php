<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/app/api/class/User.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/app/api/class/Group.php');

echo "<p>This is a test page.</p>";

$object = User::all();
foreach($object as $user) {
    $user->resolve();
    echo '<p>' . $user->json(true) . '</p>';
}

echo "<p>continuing on.</p>";
?>
