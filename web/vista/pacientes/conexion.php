
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
