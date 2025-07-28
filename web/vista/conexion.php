<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>enlace</title>
</head>
<body>
    <?php
        $servidor='localhost';
        $usuario='root';
        $password= '';
        $base= 'clinica_dental';


        $enlace = new mysqli($servidor,$usuario, $password, $base);

        if(!$enlace){
            echo "no se pudo realizar la conexion:(". $enlace->connect_errno. ")".$enlace->connect_errno;
        }else{
            echo "";
        }


    ?>

</body>
</html>