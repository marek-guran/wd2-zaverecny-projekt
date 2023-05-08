<?php
// Start session and check if user is logged in
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: /ZVPRJKT/login.php");
    exit;
}


// Check if logout button was pressed
if (isset($_POST["logout"])) {
    session_unset();
    session_destroy();
    header("location: login.php");
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

// Check if form was submitted to create a new post
if (isset($_POST["create_post"])) {
    // Sanitize user input to prevent SQL injection
    $nadpis = mysqli_real_escape_string($conn, $_POST["nadpis"]);
    $text = mysqli_real_escape_string($conn, $_POST["text"]);
    $obrazok = mysqli_real_escape_string($conn, $_POST["obrazok"]);
    $datum = date("Y-m-d");

    // Insert data into posts table
    $sql = "INSERT INTO posts (nadpis, popis, obrazok, datum) VALUES ('$nadpis', '$text', '$obrazok', '$datum')";

    // Execute query
    if (mysqli_query($conn, $sql)) {
        echo "Článok bol pridaný.";
        header("refresh:3;url=/ZVPRJKT/admin.php"); // redirect to homepage after 3 seconds
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Check if delete button was pressed
if (isset($_POST["delete_post"])) {
    $post_id = $_POST["delete_post"];
    $sql = "DELETE FROM posts WHERE id = '$post_id'";

    if (mysqli_query($conn, $sql)) {
        echo "Článok bol vymazaný.";
        header("refresh:3;url=/ZVPRJKT/admin.php"); // redirect to homepage after 3 seconds
        exit;
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

// Get all posts from database
$sql = "SELECT * FROM posts";
$result = mysqli_query($conn, $sql);

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php include 'php/nav.php'; ?>

    <form method="post">
        <input type="submit" name="logout" value="Odhlásiť" class="btn btn-danger rounded-pill"
            style="position: fixed;  right: 1rem; margin-top: 20px; width: 90px !important;">
    </form>

    <div class="container mt-5" style="padding-top: 70px!important;">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h2 class="mb-3 text-center">Vytvoriť nový príspevok</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                    class="border rounded p-3" style="border-radius: 20px!important;">
                    <div class="mb-3">
                        <label for="nadpis" class="form-label">Nadpis:</label>
                        <input type="text" id="nadpis" name="nadpis" class="form-control"
                            style="border-radius: 20px!important;">
                    </div>
                    <div class="mb-3">
                        <label for="text" class="form-label">Text:</label>
                        <textarea id="text" name="text" class="form-control"
                            style="border-radius: 20px!important;"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="obrazok" class="form-label">Obrázok:</label>
                        <input type="text" id="obrazok" name="obrazok" class="form-control"
                            style="border-radius: 20px!important;">
                    </div>
                    <div class="text-center">
                        <input type="hidden" name="create_post" value="1">
                        <button type="submit" class="btn btn-primary rounded-pill">Odoslať</button>
                    </div>
                </form>
            </div>
        </div>


        <div class="row mt-5">
            <div class="col-md-12">
                <h2 class="text-center">Zoznam príspevkov</h2>
                <table class="table table-striped table-hover table-bordered">
                    <thead class= "table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nadpis</th>
                            <th scope="col">Dátum</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Connect to database
                        $conn = mysqli_connect($host, $user, $password, $dbname);
                        if (!$conn) {
                            die("Connection failed: " . mysqli_connect_error());
                        }

                        // Retrieve posts from database
                        $sql = "SELECT * FROM posts ORDER BY id DESC";
                        $result = mysqli_query($conn, $sql);

                        // Display posts in table
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<th scope='row'>" . $row["id"] . "</th>";
                                echo "<td>" . $row["nadpis"] . "</td>";
                                echo "<td>" . $row["datum"] . "</td>";
                                echo "<td><a href='edit.php?id=" . $row["id"] . "' class='btn btn-primary rounded-pill'>Upraviť</a> ";
                                echo "<form method='post' style='display: inline;'>";
                                echo "<input type='hidden' name='delete_post' value='" . $row["id"] . "'>";
                                echo "<button type='submit' class='btn btn-danger rounded-pill'>Odstrániť</button>";
                                echo "</form></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>Žiadne príspevky.</td></tr>";
                        }

                        // Close database connection
                        mysqli_close($conn);
                        ?>
                    </tbody>
                </table>


                <?php include 'php/footer.php'; ?>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>

</html>