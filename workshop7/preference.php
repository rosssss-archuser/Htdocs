<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $theme = in_array($_POST['theme'] ?? '', ['light', 'dark']) ? $_POST['theme'] : 'light';
    setcookie('theme', $theme, time() + 86400 * 30, '/');
    $_COOKIE['theme'] = $theme;
    $message = 'Theme preference saved.';
} else {
    $theme = $_COOKIE['theme'] ?? 'light';
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Preferences - Student Grade Portal</title>
    <style>
        body.light { background: #fff; color: #000; }
        body.dark { background: #111; color: #eee; }
    </style>
</head>
<body class="<?php echo ($theme === 'dark' ? 'dark' : 'light'); ?>">
    <div style="max-width:700px;margin:20px auto;">
        <nav>
            <a href="dashboard.php">Home</a>
            <a href="logout.php">Logout</a>
        </nav>

        <h1>Preferences</h1>

        <?php if ($message): ?>
            <p style="color:green"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <form method="post" action="preference.php">
            <label><input type="radio" name="theme" value="light" <?php echo $theme === 'light' ? 'checked' : ''; ?>> Light Mode</label><br>
            <label><input type="radio" name="theme" value="dark" <?php echo $theme === 'dark' ? 'checked' : ''; ?>> Dark Mode</label><br>
            <button type="submit">Save Preference</button>
        </form>

    </div>
</body>
</html>