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