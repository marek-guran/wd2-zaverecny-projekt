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
    $id = $_POST["id"];

    // Update data in posts table
    $sql = "UPDATE posts SET id='$id', nadpis='$nadpis', popis='$text', obrazok='$obrazok' WHERE id=$id";

    // Execute query
    if (mysqli_query($conn, $sql)) {
        echo "Record updated successfully.";
        header("refresh:3;url=/ZVPRJKT/index.php"); // redirect to homepage after 3 seconds
        exit;
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

// Set default value for $id
$id = intval($_GET['id']);


// Check if $id is set
if ($id !== null) {
    // Retrieve post data from database using the $id variable
    $sql = "SELECT * FROM posts WHERE id=$id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Post not found.";
        exit;
    }
} else {
    echo "Post ID not specified.";
    exit;
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Post</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php include 'php/nav.php'; ?>

    <div class="container" style= "padding-top: 70px!important;">
        <h2 class="text-center">Upraviť</h2>
        <form method="post" id="myForm">
            <div class="form-group">
                <label for="id">
                </label>
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            </div>
            <div class="form-group">
                <label for="nadpis">
                    <h5>Nadpis:</h5>
                </label>
                <input type="text" class="form-control rounded-pill" id="nadpis" name="nadpis"
                    value="<?php echo $row['nadpis']; ?>" style="border-radius: 20px;">
            </div>
            <div class="form-group">
                <label for="text">
                    <h5>Text:</h5>
                </label>
                <textarea class="form-control rounded" id="text" name="text"
                    style="border-radius: 20px;"><?php echo $row['popis']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="obrazok">
                    <h5>Obrázok:</h5>
                </label>
                <input type="text" class="form-control rounded-pill" id="obrazok" name="obrazok"
                    value="<?php echo $row['obrazok']; ?>" style="border-radius: 20px;">
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-bg btn-outline-primary rounded-pill open-btn" style= "margin-top: 10px!important;" onclick="submitForm()">
                    <h5>Uložiť</h5>
                </button>
            </div>
        </form>

    </div>

    <?php include 'php/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        function submitForm() {
            var formData = new FormData(document.getElementById("myForm"));
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "/edit.php");
            xhr.send(formData);
        }
    </script>
</body>

</html>