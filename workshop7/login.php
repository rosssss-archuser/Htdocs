<?php
require_once 'db.php';
session_start();
$errors = [];

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = trim($_POST['student_id'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($student_id === '' || $password === '') {
        $errors[] = 'Both fields are required.';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM students WHERE student_id = :student_id');
        $stmt->execute(['student_id' => $student_id]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['logged_in'] = true;
            $_SESSION['student_id'] = $user['student_id'];
            $_SESSION['name'] = $user['name'];
            header('Location: dashboard.php');
            exit;
        } else {
            $errors[] = 'Invalid student id or password.';
        }
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login - Student Grade Portal</title>
</head>
<body>
    <h1>Login</h1>

    <?php if (isset($_GET['registered'])): ?>
        <p style="color:green;">Registration successful. Please login.</p>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div style="color:red;">
            <?php foreach ($errors as $err): ?>
                <p><?php echo htmlspecialchars($err); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="login.php">
        <label>Student ID: <input type="text" name="student_id" value="<?php echo htmlspecialchars($_POST['student_id'] ?? ''); ?>"></label><br>
        <label>Password: <input type="password" name="password"></label><br>
        <button type="submit">Login</button>
    </form>

    <p>Not registered? <a href="register.php">Register here</a>.</p>
</body>
</html>