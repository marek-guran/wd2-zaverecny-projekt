<?php
// Start session
session_start();

// Check if user is already logged in
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: /ZVPRJKT/admin.php");
    exit;
}

// Set database credentials
$host = "localhost";
$user = "admin";
$password = "admin";
$dbname = "web";

// Connect to database
$conn = mysqli_connect($host, $user, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user input to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    // Retrieve user data from database
    $sql = "SELECT * FROM users WHERE id='1' AND username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    // Check if user exists and credentials are correct
    if (mysqli_num_rows($result) == 1) {
        // Start session and redirect to homepage
        $_SESSION["loggedin"] = true;
        header("location: /ZVPRJKT/admin.php");
        exit;
    } else {
        // Display error message
        echo "Query: ".$sql;

        echo "Invalid username or password.";
    }
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Please log in</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username"><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br>

        <input type="submit" value="Log in">
    </form>
</body>
</html>
