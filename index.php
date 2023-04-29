<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Môj Blog</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- Navigation Menu -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand " href="#">Môj Blog</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Domov<span class="visually-hidden">(current)</span></a>
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
        <h1 class="display-4 ">Vitajte na mojom blogu!</h1>
        <p class="lead ">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et felis elit. Nunc ornare est
            justo, vel viverra nisi convallis ut.</p>
        <hr class="my-4">
        <p class="">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et felis elit. Nunc ornare est justo,
            vel
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

                $nadpis = '';
                
                // Query database for data
                $sql = "SELECT obrazok, nadpis, datum, popis FROM posts ORDER BY id DESC";
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
                        echo '                  <button type="button" class="btn btn-sm btn-outline-secondary open-btn" data-bs-toggle="modal" data-bs-target="#myModal" data-desc="' . $row["popis"] . '">Otvoriť</button>';
                        echo '              </div>';
                        echo '              <small class="text-muted">Vytvorené ' . $row["datum"] . '</small>';
                        echo '          </div>';
                        echo '      </div>';
                        echo '  </div>';
                        echo '</div>';

                        if (empty($nadpis)) {
                            $nadpis = $row['nadpis'];
                        }
                    }
                } else {
                    echo "No data found in database.";
                }

                // Close connection
                mysqli_close($conn);
                ?>
            </div>
        </section>
    </div>

    <!-- Modal Popup -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"><?php echo $nadpis; ?></h5> <!-- Replace 'Article Description' with $nadpis variable -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="articleDesc"></p>
                </div>
            </div>
        </div>
    </div>

    <footer class="container mt-5">
        <p class="float-end"><a href="#">Späť na začiatok</a></p>
        <p>&copy;
            <?php echo date("Y"); ?> Marek Guráň.
        </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let openBtns = document.querySelectorAll('.open-btn');

        openBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                let desc = btn.dataset.desc;
                let articleDescEl = document.querySelector('#articleDesc');
                articleDescEl.innerHTML = desc;
            })
        });
    </script>
    <style>
        .modal-content{
            border-radius: 16px;
        }
    </style>
</body>

</html>
