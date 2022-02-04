<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatabile" content="IE=edge">
    <meta name="author" content="Igor Djurdjic">
    <meta name="description" content="Blog application development community social network build for sharing programmer experiance">
    <meta name="keywords" content="Blog, community social network, programming, sharing experiance, socializing">
    <title>Blog Community | <?php echo !isset($data->title)? $_ENV['APP_TITLE'] : $data->title ?> </title>
    <!-- Default CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo  isset($data->css) ? $_ENV['APP_SRC'] . $data->css : $_ENV['APP_SRC'] . 'public/css/app.css' ?>">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo $_ENV['APP_SRC'] ?>public/bootstrap/css/bootstrap.min.css">
    <!-- Box Icons-->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/e97e5215ef.js" crossorigin="anonymous"></script>
    <!-- Google Fonts | Nunito -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&family=Nunito:wght@300&display=swap" rel="stylesheet"> 
</head>
<body id="main-body">


    <?php App\Tools\Template::navbar('users', 'templates/navbar') ?>
    <?php echo $content ?>
    
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>