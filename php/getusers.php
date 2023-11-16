<?php
/**
 * Returns the list of sensors.
 */
require 'connect.php';
    
$users = [];
$sql = "SELECT username , first_name , last_name , token FROM Users";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $users[$cr]['username'] = $row['username'];
    $users[$cr]['first_name'] = $row['first_name'];
    $users[$cr]['last_name'] = $row['last_name'];
    $users[$cr]['token'] = $row['token'];
    
    $cr++;
  }
    
  echo json_encode(['data'=>$users]);
}
else
{
  http_response_code(404);
}


