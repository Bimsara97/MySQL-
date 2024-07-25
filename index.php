<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_management";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login (SQL Injection vulnerability)
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        echo "<p style='color: green;'>Logged in as " . htmlspecialchars($username) . "</p>";
    } else {
        echo "<p style='color: red;'>Invalid credentials</p>";
    }
}

// Handle comment (XSS vulnerability)
if (isset($_POST['comment'])) {
    $comment = $_POST['comment'];
    echo "<p>Comment: " . $comment . "</p>"; // no escaping or sanitization
}

// Handle money transfer (CSRF vulnerability)
if (isset($_POST['transfer'])) {
    $amount = $_POST['amount'];
    echo "<p>Transferred $" . htmlspecialchars($amount) . " to another account.</p>";
}

// Handle data (Insecure Deserialization vulnerability)
if (isset($_POST['data'])) {
    $data = $_POST['data'];
    $object = unserialize($data); // potential for deserialization attack
    var_dump($object);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vulnerable PHP Application</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container {
            background: #fff;
            padding: 20px;
            margin: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input, textarea {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px 15px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form method="POST">
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="password" placeholder="Password">
            <input type="submit" name="login" value="Login">
        </form>
    </div>

    <div class="container">
        <h1>Leave a Comment</h1>
        <form method="POST">
            <textarea name="comment" placeholder="Your comment"></textarea>
            <input type="submit" value="Submit">
        </form>
    </div>

    <div class="container">
        <h1>Transfer Money</h1>
        <form method="POST">
            <input type="text" name="amount" placeholder="Amount">
            <input type="submit" name="transfer" value="Transfer">
        </form>
    </div>

    <div class="container">
        <h1>Submit Data</h1>
        <form method="POST">
            <textarea name="data" placeholder="Serialized data"></textarea>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
