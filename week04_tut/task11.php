<?php
$users = [
  ["email" => "ram@gmail.com"],
  ["email" => "sita@gmail.com"],
  ["email" => "hari@gmail.com"]
];

$newEmail = "ram@gmail.com";
$exists = false;

foreach ($users as $u) {
    if ($u["email"] == $newEmail) {
        $exists = true;
        break;
    }
}

echo $exists ? "Email already exists" : "Email available";
?>
