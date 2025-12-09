<form method="POST">
    Username: <input type="text" name="u"><br>
    Password: <input type="password" name="p"><br>
    <button type="submit">Login</button>
</form>

<?php
if (isset($_POST['u'])) {
    if ($_POST['u'] === "admin" && $_POST['p'] === "1234@admin") {
        echo "Welcome Admin";
    } else {
        echo "Invalid credentials";
    }
}
?>
