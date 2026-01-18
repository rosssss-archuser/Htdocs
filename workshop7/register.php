<?php
require_once 'db.php';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = trim($_POST['student_id'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($student_id === '' || $name === '' || $password === '') {
        $errors[] = 'All fields are required.';
    } else {
        $hash = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare('INSERT INTO students (student_id, name, password) VALUES (:student_id, :name, :password)');
        try {
            $stmt->execute(['student_id' => $student_id, 'name' => $name, 'password' => $hash]);
            header('Location: login.php?registered=1');
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { 
                $errors[] = 'Student ID already exists.';
            } else {
                $errors[] = 'Database error: ' . htmlspecialchars($e->getMessage());
            }
        }
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Register - Student Grade Portal</title>
</head>
<body>
    <h1>Register</h1>
    <?php if (!empty($errors)): ?>
        <div style="color:red;">
            <?php foreach ($errors as $err): ?>
                <p><?php echo htmlspecialchars($err); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="register.php">
        <label>Student ID: <input type="text" name="student_id" value="<?php echo htmlspecialchars($_POST['student_id'] ?? ''); ?>"></label><br>
        <label>Name: <input type="text" name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>"></label><br>
        <label>Password: <input type="password" name="password"></label><br>
        <button type="submit">Register</button>
    </form>

    <p>Already registered? <a href="login.php">Login here</a>.</p>
</body>
</html>
