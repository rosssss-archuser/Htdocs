<?php

$usersFile = __DIR__ . DIRECTORY_SEPARATOR . 'users.json';

$errors = ['name' => '', 'email' => '', 'password' => '', 'confirm_password' => '', 'file' => ''];
$old = ['name' => '', 'email' => ''];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	$name = trim($_POST['name'] ?? '');
	$email = trim($_POST['email'] ?? '');
	$password = $_POST['password'] ?? '';
	$confirm = $_POST['confirm_password'] ?? '';

	$old['name'] = $name;
	$old['email'] = $email;

	
	if ($name === '') {
		$errors['name'] = 'Name is required.';
	}

	
	if ($email === '') {
		$errors['email'] = 'Email is required.';
	} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors['email'] = 'Please enter a valid email address.';
	}

	
	if ($password === '') {
		$errors['password'] = 'Password is required.';
	} else {
		if (strlen($password) < 8) {
			$errors['password'] = 'Password must be at least 8 characters.';
		}
		
		if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[^A-Za-z0-9]/', $password)) {
			$errors['password'] = ($errors['password'] ? $errors['password'] . ' ' : '') . 'Password must include letters, numbers and special characters.';
		}
	}

	
	if ($confirm === '') {
		$errors['confirm_password'] = 'Please confirm your password.';
	} elseif ($password !== $confirm) {
		$errors['confirm_password'] = 'Passwords do not match.';
	}

	
	$hasErrors = false;
	foreach ($errors as $e) {
		if ($e !== '') { $hasErrors = true; break; }
	}

	if (!$hasErrors) {
		if (!file_exists($usersFile)) {
			$created = @file_put_contents($usersFile, json_encode([], JSON_PRETTY_PRINT), LOCK_EX);
			if ($created === false) {
				$errors['file'] = 'Could not create users data file. Check directory permissions.';
			}
		}

		if ($errors['file'] === '') {
			$raw = @file_get_contents($usersFile);
			if ($raw === false) {
				$errors['file'] = 'Could not read users data file.';
			} else {
				$users = json_decode($raw, true);
				if (!is_array($users)) {
					$users = [];
				}

				$duplicate = false;
				foreach ($users as $u) {
					if (isset($u['email']) && strtolower($u['email']) === strtolower($email)) {
						$duplicate = true;
						break;
					}
				}

				if ($duplicate) {
					$errors['email'] = 'An account with that email already exists.';
				} else {
					$hashed = password_hash($password, PASSWORD_DEFAULT);
					$newUser = [
						'name' => $name,
						'email' => $email,
						'password' => $hashed,
						'created_at' => date('c')
					];
					$users[] = $newUser;

					$json = json_encode($users, JSON_PRETTY_PRINT);
					if ($json === false) {
						$errors['file'] = 'Could not encode users data to JSON.';
					} else {
						$written = @file_put_contents($usersFile, $json, LOCK_EX);
						if ($written === false) {
							$errors['file'] = 'Could not write to users data file. Check permissions.';
						} else {
							$success = 'Registration successful! You can now log in.';
							$old = ['name' => '', 'email' => ''];
						}
					}
				}
			}
		}
	}
}

function old($key, $oldArr) {
	return htmlspecialchars($oldArr[$key] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function e($s) {
	return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Register</title>
	<style>
		body { font-family: Arial, sans-serif; padding: 20px; }
		form { max-width: 480px; }
		.field { margin-bottom: 12px; }
		label { display:block; font-weight:600; margin-bottom:4px; }
		input[type="text"], input[type="email"], input[type="password"] { width:100%; padding:8px; box-sizing:border-box; }
		.error { color: #b00020; font-size:0.9em; }
		.success { background:#e6ffed; border:1px solid #a6f0b0; padding:10px; margin-bottom:12px; }
	</style>
</head>
<body>
	<h1>User Registration</h1>

	<?php if ($success): ?>
		<div class="success"><?= e($success) ?></div>
	<?php endif; ?>

	<?php if ($errors['file']): ?>
		<div class="error"><?= e($errors['file']) ?></div>
	<?php endif; ?>

	<form method="post" action="<?= e($_SERVER['PHP_SELF']) ?>" novalidate>
		<div class="field">
			<label for="name">Name</label>
			<input id="name" name="name" type="text" value="<?= old('name', $old) ?>">
			<?php if ($errors['name']): ?><div class="error"><?= e($errors['name']) ?></div><?php endif; ?>
		</div>

		<div class="field">
			<label for="email">Email address</label>
			<input id="email" name="email" type="email" value="<?= old('email', $old) ?>">
			<?php if ($errors['email']): ?><div class="error"><?= e($errors['email']) ?></div><?php endif; ?>
		</div>

		<div class="field">
			<label for="password">Password</label>
			<input id="password" name="password" type="password">
			<?php if ($errors['password']): ?><div class="error"><?= e($errors['password']) ?></div><?php endif; ?>
		</div>

		<div class="field">
			<label for="confirm_password">Confirm Password</label>
			<input id="confirm_password" name="confirm_password" type="password">
			<?php if ($errors['confirm_password']): ?><div class="error"><?= e($errors['confirm_password']) ?></div><?php endif; ?>
		</div>

		<div class="field">
			<button type="submit">Register</button>
		</div>
	</form>

	<hr>
	<p><small>Users are stored in <code>users.json</code> as an array. Passwords are hashed using PHP's <code>password_hash()</code>.</small></p>
</body>
</html>

