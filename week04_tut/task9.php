<form method="POST">
    Password: <input type="password" name="pass">
    <button type="submit">Check</button>
</form>

<?php
if (isset($_POST['pass'])) {
    $p = $_POST['pass'];
    $errors = [];

    if (strlen($p) < 8) $errors[] = "Minimum 8 characters required.";
    if (!preg_match('/[0-9]/', $p)) $errors[] = "Must include a number.";
    if (!preg_match('/[\W]/', $p)) $errors[] = "Must include a special character.";

    if (count($errors) > 0) {
        foreach ($errors as $e) echo $e . "<br>";
    } else {
        echo "Password valid!";
    }
}
?>
