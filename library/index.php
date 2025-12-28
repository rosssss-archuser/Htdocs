<?php include "db.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Library Management System</title>
    <style>
        body { font-family: Arial; background: #f2f2f2; }
        .container { width: 600px; margin: auto; background: white; padding: 20px; }
        input, button { width: 100%; padding: 8px; margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background: #ddd; }
        a { color: red; text-decoration: none; }
    </style>
</head>
<body>

<div class="container">
<h2>Add Book</h2>
<form action="add_book.php" method="post">
    <input type="text" name="title" placeholder="Book Title" required>
    <input type="text" name="author" placeholder="Author" required>
    <input type="text" name="category" placeholder="Category" required>
    <input type="number" name="quantity" placeholder="Quantity" required>
    <button>Add Book</button>
</form>

<h2>Search by Category</h2>
<form method="get">
    <input type="text" name="search" placeholder="Enter category">
    <button>Search</button>
</form>

<h2>Book List</h2>
<table>
<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Author</th>
    <th>Category</th>
    <th>Qty</th>
    <th>Action</th>
</tr>

<?php
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT * FROM books WHERE category LIKE '%$search%'";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
        <td>{$row['book_id']}</td>
        <td>{$row['title']}</td>
        <td>{$row['author']}</td>
        <td>{$row['category']}</td>
        <td>{$row['quantity']}</td>
        <td><a href='delete.php?id={$row['book_id']}'>Delete</a></td>
    </tr>";
}
?>
</table>
</div>

</body>
</html>
