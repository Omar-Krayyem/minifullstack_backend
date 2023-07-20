<?php

include('connection.php');

// $username = "omar33";
// $password = "1234567";
// $first_name = "omar";
// $last_name = "kr";



$username = $_POST['username'];
$password = $_POST['password'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];

$check_username = $mysqli->prepare('select username from users where username=?');
$check_username->bind_param('s', $username);
$check_username->execute();
$check_username->store_result();
$username_exists = $check_username->num_rows();

if ($username_exists == 0) {
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $query = $mysqli->prepare('insert into users(username,password,first_name,last_name) values(?,?,?,?)');
    $query->bind_param('ssss', $username, $hashed_password, $first_name, $last_name);
    $query->execute();

    $response['status'] = "success";
    $response['message'] = "another message in success";
    $response['name'] = $username;
} else {
    $response['status'] = "failed";
    $response['message'] = "another message in fail";
}

echo json_encode($response);

// types of http request : POST,GET,PUT,DELETE 