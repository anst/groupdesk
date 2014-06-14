<?php
require_once 'class/School.php';

//Example /api/MatchingSchools.php?name=Seven Lak
if (!isset($_POST['name']) || strlen($_POST['name']) < 5) {
    return;
}
School::retrieve();
print_r(School::getMatchingSchools($_POST['name']));



