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
        echo "Invalid username or password.";
    }
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Prihlásenie</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Centers the form horizontally and adds some spacing between the top of the screen and the form */
        form {
            margin: auto;
            margin-top: 50px;
            max-width: 400px;
            /* Limits the maximum width of the form */
        }
    </style>
</head>

<body>
    <?php include 'php/nav.php'; ?>
    <div class="container" style= "padding-top: 70px!important;">
        <h2 class="text-center">Prihlásenie</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group row">
                <label for="username" class="col-sm-2 col-form-label">
                    <h5>Meno:</h5>
                </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control rounded-pill" id="username" name="username"
                        style="border-radius: 20px;">
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-sm-2 col-form-label">
                    <h5>Heslo:</h5>
                </label>
                <div class="col-sm-10">
                    <input type="password" class="form-control rounded-pill" id="password" name="password"
                        style="border-radius: 20px;">
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-bg btn-outline-secondary rounded-pill open-btn">
                    <h4>Prihlásiť sa</h4>
                </button>
            </div>
        </form>
    </div>


    <style>
        .btn {
            margin-top: 20px;
        }
    </style>



    <?php include 'php/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"
        integrity="sha384-7hSmB3YK0rLPMiJGJewvt9Upi6fM3/9l+HheS/KZrY1lS4ImqIj7vV7OidOeXp5B" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>