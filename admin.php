<?php
// Start session and check if user is logged in
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: /ZVPRJKT/login.php");
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
    $nadpis = mysqli_real_escape_string($conn, $_POST["nadpis"]);
    $text = mysqli_real_escape_string($conn, $_POST["text"]);
    $obrazok = mysqli_real_escape_string($conn, $_POST["obrazok"]);
    $datum = date("Y-m-d");

    // Insert data into posts table
    $sql = "INSERT INTO posts (nadpis, popis, obrazok, datum) VALUES ('$nadpis', '$text', '$obrazok', '$datum')";

    // Execute query
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully.";
        header("refresh:3;url=/ZVPRJKT/index.php"); // redirect to homepage after 3 seconds
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin</title>
</head>
<body>

    <h2>Vytvoriť nový príspevok</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="nadpis">Nadpis:</label><br>
        <input type="text" id="nadpis" name="nadpis"><br>

        <label for="text">Text:</label><br>
        <textarea id="text" name="text"></textarea><br>

        <label for="obrazok">Obrázok:</label><br>
        <input type="text" id="obrazok" name="obrazok"><br>

        <input type="submit" value="Odoslať">
    </form>

</body>
</html>
