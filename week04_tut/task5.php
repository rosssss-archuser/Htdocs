<form method="POST">
    Enter a sentence: <input type="text" name="sentence">
    <button type="submit">Count</button>
</form>

<?php
if (isset($_POST['sentence'])) {
    $text = strtolower($_POST['sentence']);
    $count = 0;
    $vowels = ['a','e','i','o','u'];

    for ($i = 0; $i < strlen($text); $i++) {
        if (in_array($text[$i], $vowels)) {
            $count++;
        }
    }

    echo "Number of vowels: $count";
}
?>
