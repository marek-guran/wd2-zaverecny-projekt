<!DOCTYPE html>
<html>

<head>
    <title>Môj Blog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>

    <!-- Navigation Menu -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Môj Blog</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Domov<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">O mne</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Kontakt</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin.php">Admin</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Banner -->
    <div class="jumbotron">
        <h1 class="display-4">Vitajte na mojom blogu!</h1>
        <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et felis elit. Nunc ornare est
            justo, vel viverra nisi convallis ut.</p>
        <hr class="my-4">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et felis elit. Nunc ornare est justo, vel
            viverra nisi convallis ut.</p>
    </div>

    <div class="container">
        <!-- Posts Section -->
        <section>
            <h2>Články</h2>
            <div class="row">
                <?php
                $servername = "localhost";
                $username = "admin";
                $password = "admin";
                $dbname = "web";

                // Create connection
                $conn = mysqli_connect($servername, $username, $password, $dbname);

                // Check connection
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                // Query database for data
                $sql = "SELECT obrazok, nadpis, datum FROM posts ORDER BY id DESC";
                $result = mysqli_query($conn, $sql);

                // Check if query executed successfully
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="col-md-4">';
                        echo '  <div class="card mb-4 box-shadow">';
                        echo '      <img class="card-img-top" src="' . $row["obrazok"] . '" alt="Card image cap">';
                        echo '      <div class="card-body">';
                        echo '          <h5 class="card-title">' . $row["nadpis"] . '</h5>';
                        echo '          <div class="d-flex justify-content-between align-items-center">';
                        echo '              <div class="btn-group">';
                        echo '                  <button type="button" class="btn btn-sm btn-outline-secondary">Otvoriť</button>';
                        echo '              </div>';
                        echo '              <small class="text-muted">Vytvorené ' . $row["datum"] . '</small>';
                        echo '          </div>';
                        echo '      </div>';
                        echo '  </div>';
                        echo '</div>';
                    }
                } else {
                    echo "No data found in database.";
                }

                // Close connection
                mysqli_close($conn);
                ?>

                <!-- Footer -->
                <footer class="container mt-5">
                    <p class="float-right"><a href="#">Späť na začiatok</a></p>
                    <p>&copy;
                        <?php echo date("Y"); ?> Marek Guráň.
                    </p>
                </footer>


                <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/bundle.min.js"></script>
                <script src="https://unpkg.com/@popperjs/core@2.9.3"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"></script>
</body>

</html>