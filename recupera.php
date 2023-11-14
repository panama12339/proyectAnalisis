<?php
require('config/config.php');
require('config/database.php');
require('clases/clienteFunciones.php');

$db = new Database();
$con = $db->conectar();

$error = [];

if (!empty($_POST)) {
    $email = trim($_POST['email']);

    if (Nulo([$email])) {
        $error[] = "Debe llenar los campos";
    }
    if (!emailV($email)) {
        $error[] = "Introduzca una direccion de correo valida";
    }
    if (count($error) == 0) {
        if (emailV($email, $con)) {
            $sql = $con->prepare("SELECT FROM usuarios.id, clientes.nombre INNER JOIN clientes ON usuarios.id_cliente=clientes.id WHERE cliente.correo LIKE ? LIMIT 1");
            $sql->execute([$email]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $user_id = $row['id'];
            $nombre = $row['nombres'];

            $token = rpsw($user_id, $con);
            if ($token !== null) {
            }
        }
    }
}



?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>restaurante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">

    <link href="css/estilos.css" rel="stylesheet">



    <!-- for icons  -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- bootstrap  -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- for swiper slider  -->
    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">

    <!-- fancy box  -->
    <link rel="stylesheet" href="assets/css/jquery.fancybox.min.css">
    <!-- custom css  -->
    <link rel="stylesheet" href="style.css">

</head>

<body>

    <header class="header">
        <a href="#" class="logo"> <i class="fas fa-shopping-basket"></i> groco</a>

        <nav class="navbar">
            <a href="#home">inicio</a>
            <a href="nosotros.html">Nosotros</a>
            <a href="menu.html">Menu</a>
            <a href="gallery.html">Galeria</a>
            <a href="blogs.html">Blogs</a>
            <a href="contactanos.html">contactanos</a>
        </nav>
        <div class="shopping-cart">
        </div>

    </header>


    <main>
        <div class="container">
            <h2>recuperar</h2>
            <?php
            Mensajes($error);
            ?>

            <form class="row g-3" action="recupera.php" method="post" autocomplete="off">

                <div class="col-md-6">
                    <label for="email"><span class="text-danger">*</span> Correo electronico</label>
                    <input type="email" name="email" id="email" class="form-control" require>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </div>
            </form>
        </div>
    </main>