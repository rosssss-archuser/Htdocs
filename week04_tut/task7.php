<form method="POST">
    Full Name: <input type="text" name="fname"><br>
    Email: <input type="email" name="email"><br>
    <button type="submit">Submit</button>
</form>

<?php
if (isset($_POST['fname'])) {
    if (empty($_POST['fname']) || empty($_POST['email'])) {
        echo "<p style='color:red;'>Error: All fields are required.</p>";
    } else {
        echo "<p style='color:green;'>All good!</p>";
    }
}
?>
