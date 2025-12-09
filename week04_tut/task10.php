<form method="POST">
    Num1: <input type="number" name="n1"><br>
    Num2: <input type="number" name="n2"><br>
    Operation (add/sub/mul/div): 
    <input type="text" name="op"><br>
    <button type="submit">Calculate</button>
</form>

<?php
if (isset($_POST['op'])) {
    $a = $_POST['n1'];
    $b = $_POST['n2'];

    switch ($_POST['op']) {
        case "add": echo $a + $b; break;
        case "sub": echo $a - $b; break;
        case "mul": echo $a * $b; break;
        case "div": echo $b != 0 ? $a / $b : "Cannot divide by zero"; break;
        default: echo "Invalid operation";
    }
}
?>
