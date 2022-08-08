<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= env('APP_NAME') ?></title>
<!--    TODO: Fix the URL, the script considers it as a route. -->
    <link rel="icon" type="image/x-icon" href="<?= env('APP_URL') ?>/images/favicon.ico">
    <link rel="stylesheet" href="https://unpkg.com/bulma@0.9.4/css/bulma.min.css">
</head>
<body>
    <!--Navbar-->
    <?php include_once parts_path() . '/navbar.php' ?>

    <main class="columns is-multiline is-variable is-5 m-5">{{CONTENT}}</main>
</body>
</html>
