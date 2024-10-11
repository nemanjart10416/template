<?php

include_once("../../assets/php/functions.php");

/*
$country = Country::getById(7);

$country->setName("test");
//$country->setCreatedAt("2029-10-11 02:46:37");

$country->save();
*/

$country = new Country("mmm");
$country->insert();


