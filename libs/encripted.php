
        <?php
        $var = "password";
        $salt = "5487984636kjhas"; // cadena que se concatena al password y lo encripta para mas seguridad
        echo $var . " <-- contrasenia real <br/> encriptada seria: <br/>";
        echo sha1($salt.md5($var));
        ?>


