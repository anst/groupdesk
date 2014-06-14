<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/app/api/class/Object.php');

echo "<p>This is a test page.</p>";

$object = Object::fromTable("test");
echo isset($object) ? "<p>yes</p>" : "<p>no</p>";
echo $object->json();

echo "<p>continuing on.</p>";
?>
