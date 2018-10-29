<?php

$stmt = $conn->prepare("SELECT type, username FROM users WHERE id = :userid");
$stmt->bindParam(':userid', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();

$userinfo = $stmt->fetch(); // $userinfo['type'], $userinfo['username'] 
if($userinfo['type'] == 1) $userinfo['typename'] = "basic";

?>