<?php
session_start();

$user = $_SESSION['user'];

if($user == 'admin'){
    echo '{
        "message" : "this is a message vor admin only "
        "success": true;"
    }';

}else {
    echo'{
        "message" : "unauthorized "
        "success": false;"
    }'
}
?>