<form method="POST">
    Enter a number: <input type="number" name="num">
    <button type="submit">Generate</button>
</form>

<?php
if (isset($_POST['num'])) {
    $n = $_POST['num'];

    for ($i = 1; $i <= 10; $i++) {
        echo "$n x $i = " . ($n * $i) . "<br>";
    }
}
?>
