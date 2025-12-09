<form method="POST">
    Name: <input type="text" name="name"><br>
    Email: <input type="text" name="email"><br>
    Password: <input type="password" name="pass"><br>
    Confirm Password: <input type="password" name="cpass"><br>
    <button type="submit">Preview</button>
</form>

<?php
if (isset($_POST['name'])) {
    if (empty($_POST['name']) || empty($_POST['email']) ||
        empty($_POST['pass']) || empty($_POST['cpass'])) {
        echo "All fields required.";
    } elseif ($_POST['pass'] != $_POST['cpass']) {
        echo "Passwords do not match.";
    } else {
        echo "<h3>Registration Preview:</h3>";
        echo "Name: " . $_POST['name'] . "<br>";
        echo "Email: " . $_POST['email'] . "<br>";

        $strength = (strlen($_POST['pass']) >= 8) ? "Strong" : "Weak";
        echo "Password Strength: $strength";
    }
}
?>
