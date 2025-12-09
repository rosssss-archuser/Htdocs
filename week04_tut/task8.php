<form method="POST">
    Enter email: <input type="text" name="email">
    <button type="submit">Check</button>
</form>

<?php
if (isset($_POST['email'])) {
    $e = $_POST['email'];

    if (strpos($e, "@") !== false &&
        strpos($e, ".") !== false &&
        strpos($e, "@") > 0) {
        echo "Email looks valid (basic check)";
    } else {
        echo "Email format incorrect (basic check)";
    }
}
?>
