<?php 



 $password_text = 'abcdefg0123';

$new_password = password_hash($password_text, PASSWORD_BCRYPT);

// echo $new_password;

$password_input = 'abcdefg01231';

$result = password_verify($password_input, $new_password);

echo gettype($result);