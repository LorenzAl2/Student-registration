<?php
include 'db.php';

// ---- Insert new user ----
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    
    mysqli_query($conn, "INSERT INTO user (name, email) VALUES ('$name', '$email')");
    header("Location: index.php");
    exit();
}

// ---- Update user ----
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    
    mysqli_query($conn, "UPDATE user SET name='$name', email='$email' WHERE id=$id");
    header("Location: index.php");
    exit();
}

// ---- Delete user ----
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM user WHERE id=$id");
    header("Location: index.php");
    exit();
}

// ---- Get user for edit form ----
$editUser = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM user WHERE id=$id");
    $editUser = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple PHP CRUD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <h1>PHP CRUD</h1>

        <!-- Form -->
        <form method="post" action="index.php">
            <input type="hidden" name="id" value="<?php echo $editUser['id'] ?? ''; ?>">
            
            <div class="input-group">
                <label>Name</label>
                <input type="text" name="name" required value="<?php echo $editUser['name'] ?? ''; ?>">
            </div>
            
            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" required value="<?php echo $editUser['email'] ?? ''; ?>">
            </div>
            
            <button type="submit" name="<?php echo $editUser ? 'update' : 'add'; ?>">
                <?php echo $editUser ? 'Update' : 'Add'; ?>
            </button>
        </form>

        <!-- Table -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($conn, "SELECT * FROM user");
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td class='actions'>";
                    echo "  <a href='index.php?edit=" . $row['id'] . "' class='btn-edit'>Edit</a>";
                    echo "  <a href='index.php?delete=" . $row['id'] . "' class='btn-delete' onclick=\"return confirm('Delete user?');\">Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
