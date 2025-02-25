<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>base page</title>
</head>
<body>
    <nav>
    <a href="/webserver/php/login.php" class="navbutton">Log in</a>

    </nav>
        
        <h2>Add a New user</h2>
        <form method="post">
            First name: <input type="text" name="first_name" required> <br>
            Last name: <input type="text" name="last_name" required> <br>
            Email: <input type="text" name="email" required> <br>
            <input type="submit" value="Submit">
        </form>

        <h3>Delete user</h3>
        <form method="post">
        Which id do you want to delete? <br>
        <input type="text" name="id" required>
        <input type="submit" Value="Submit">
        </form>


        <form method="post">
            <input type="submit" name="logout" id="logoutbutton" Value="Log out">
        </form>

        
</body>
</html>


<?php 

        session_start();

        if(!isset($_SESSION['userid']) || !isset($_SESSION['username'])) {
            header("Location: login.php");
            exit;
        }

        echo date('d.m.Y');

        require_once "../.gitignore/config.php";
        
        $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT id, first_name, last_name, email FROM users";
        $result = $conn->query($sql);

        if($result->num_rows > 0) {
            echo "<h1>User List</h1><table border='1'><tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["id"] . "</td><td>" . $row["first_name"] . "</td><td>" . $row["last_name"] . "</td><td>" . $row["email"] . "</td></tr>"; 
            }
            echo "</table>";
        } else {
            echo "No rows";
        }


        if($_SERVER["REQUEST_METHOD"] === "POST") {

            if(isset($_POST['logout'])) {
                session_destroy();
                session_unset();
                header("refresh:1;url=login.php");
                exit;
            }


            if (isset($_POST["first_name"]) && isset($_POST["last_name"]) && isset($_POST["email"])) {
                $first_name = $_POST["first_name"];
                $last_name = $_POST["last_name"];
                $email = $_POST["email"];
            
    
                $sql = "INSERT INTO users (first_name, last_name, email) VALUES ('$first_name', '$last_name', '$email')";
                if($conn->query($sql) === TRUE) {
                    echo "New user created successfully";
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit();
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }

        if($_SERVER['REQUEST_METHOD'] === "POST") {
            if (isset($_POST["id"])) {
                $id = $_POST['id'];
                $sql = "DELETE FROM users WHERE id = $id";
                if ($conn->query($sql)) {
                    echo "student deleted";
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit();
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }

        $conn->close();


        ?>