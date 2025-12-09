<form method="POST">
    Name: <input type="text" name="name"><br>
    Age: <input type="number" name="age"><br>
    Favorite Language: <input type="text" name="lang"><br>
    <button type="submit">Preview</button>
</form>

<?php
if (isset($_POST['name'])) {
    if (!empty($_POST['name']) && !empty($_POST['age']) && !empty($_POST['lang'])) {
        echo "Preview:<br>";
        echo "Name: " . $_POST['name'] . "<br>";
        echo "Age: " . $_POST['age'] . "<br>";
        echo "Language: " . $_POST['lang'];
    } else {
        echo "All fields are required.";
    }
}
?>
