<form method="POST">
    Enter a word: <input type="text" name="word">
    <button type="submit">Reverse</button>
</form>

<?php
if (isset($_POST['word'])) {
    $word = $_POST['word'];
    $rev = "";

    for ($i = strlen($word) - 1; $i >= 0; $i--) {
        $rev .= $word[$i];
    }

    echo "Reversed: $rev";
}
?>
