<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student CRUD</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; max-width:900px; margin:20px auto; padding:0 20px; }
        header { display:flex; justify-content:space-between; align-items:center; }
        table { width:100%; border-collapse: collapse; margin-top:10px; }
        table, th, td { border:1px solid #ddd; }
        th, td { padding:8px; text-align:left; }
        a.button { display:inline-block; padding:6px 10px; background:#28a745; color:#fff; text-decoration:none; border-radius:4px; }
        form input[type="text"], form input[type="email"] { width:100%; padding:8px; box-sizing:border-box; }
        .actions a { margin-right:6px; }
    </style>
</head>
<body>
<header>
    <h1>Student List</h1>
    <nav>
        <a class="button" href="/?page=students">Home</a>
        <a class="button" href="/?page=create">Add Student</a>
    </nav>
</header>
<hr>

@yield('content')

</body>
</html>