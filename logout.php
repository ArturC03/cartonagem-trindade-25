<?php
include('include/config.inc.php');
if(session_destroy())
{
    header("Location: home.php");
}
?>