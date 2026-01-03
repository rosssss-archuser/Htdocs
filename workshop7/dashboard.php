<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$theme = $_COOKIE['theme'] ?? 'light';
$name = htmlspecialchars($_SESSION['name'] ?? $_SESSION['student_id']);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard - Student Grade Portal</title>
    <style>
        body.light { background: #ffffff; color: #000; }
        body.dark { background: #111; color: #eee; }
        nav a { margin-right: 12px; }
        .container { max-width: 800px; margin: 20px auto; }
    </style>
</head>
<body class="<?php echo ($theme === 'dark' ? 'dark' : 'light'); ?>">
    <div class="container">
        <nav>
            <a href="dashboard.php">Home</a>
            <a href="preference.php">Preferences</a>
            <a href="logout.php">Logout</a>
        </nav>

        <h1>Welcome, <?php echo $name; ?>!</h1>
        <p>This is your dashboard. Current theme is <strong><?php echo htmlspecialchars($theme); ?></strong>.</p>

        <hr>

        <h2>Student Grades</h2>
        <p>(This part is left as an exercise — you can add grade storage & display here.)</p>

    </div>
</body>
</html>