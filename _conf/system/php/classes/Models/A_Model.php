<?php
require "../../../../config.php";

abstract class A_Model
{

    //Model für alle Klassen, die mit einer Relation arbeiten

    abstract static function create();
    abstract static function delete();

}