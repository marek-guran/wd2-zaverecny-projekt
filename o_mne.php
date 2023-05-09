<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="ikona.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>O mne</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include 'php/nav.php'; ?>

    <div class="container mt-5" style="padding-top: 70px!important;">
        <div class="row mx-auto">
            <div class="col">
                <img src="https://via.placeholder.com/300x400" alt="" style="border-radius:20px;">
            </div>
            <div class="col">
                <div class="header">
                    <h1>O mne</h1>
                </div>
                <div class="content">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed commodo lacus quis ipsum aliquet, id
                        lobortis magna tempor. Duis a felis eget est aliquet pellentesque. Sed venenatis eros nisi, vel
                        scelerisque est luctus vel. Curabitur dapibus sapien quis augue vehicula, quis convallis velit
                        pulvinar. Ut nec urna eu quam sollicitudin congue. Sed vel dui a massa tempor mattis ac sed
                        risus. Nunc vel risus vel quam sodales feugiat. In ac aliquam mauris.</p>
                </div>
            </div>
            <div class="col">
                <div class="header" style="text-align: center;">
                    <h1 style="font-size: 10rem; position: relative;">
                        <?php echo date('H:i'); ?>
                    </h1>
                </div>
                <div class="header" style="text-align: center;">
                    <h1>
                        <?php echo date('j.n.Y'); ?>
                    </h1>
                </div>
            </div>
        </div>
    </div>



    <?php include 'php/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>

</html>