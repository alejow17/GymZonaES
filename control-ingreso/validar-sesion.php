<?php

if(!isset($_SESSION['user']) || !isset($_SESSION['document']) || !isset($_SESSION['roles']))
{
    header("location:../../../index.html");
    exit;
}
?>