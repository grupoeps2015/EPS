<?php
    // put your code here
?>

<nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <img src="<?php echo $_layoutParams['ruta_img']?>img1.png" width="100px" height="50px" align="left" />
            <a class="navbar-brand page-scroll" href="#page-top" style="margin-left: 10px; ">Escuela de Historia</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a class="page-scroll" href="../menu.php">Menú</a>
                </li>
                <li>
                    <a class="page-scroll" href="#about">Acerca de</a>
                </li>
                <li>
                    <a class="page-scroll" href="#services">Servicios</a>
                </li>
                <li>
                    <a class="page-scroll" href="#portfolio">Noticias</a>
                </li>
                <li>
                    <a class="page-scroll" href="#contact">Contacto</a>
                </li>

            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>

<header>
    <div class="header-content">
        <img class="alineado" src="<?php echo $_layoutParams['ruta_img']?>img2.png" width="200px" height="200px"/>
        <div class="header-content-inner">
            <h2>Bienvenido a la Escuela de Historia</h2>
            <center></center>
            <br/>
            <hr>
            <p>Trabajamos en la reestructura de nuestra Escuela, con el propósito de actualizar nuestras carreras a los nuevos tiempos y desarrollos de nuestras disciplinas científicas. Concientes de que la historia real, esa que construimos en nuestra vida cotidiana, se presenta, a los que como profesión escogimos estudiarla, en su complejidad. Una evolución con retrocesos, saltos, cambios de nivel y apertura de caminos. Ello, nos obliga a observar procesos en sus distintos ritmos de duración, con objetividad y rigor científico, características que se obtienen a instancias de una correcta formación académica.</p>
            <a href="#about" class="btn btn-primary btn-xl page-scroll">Acerca de</a>
        </div>
    </div>
</header>

<section class="bg-primary" id="about">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 text-center">
                <h2 class="section-heading">Quienes somos?</h2>
                <hr class="light">
                <p class="text-faded">La Escuela de Historia nació como unidad académica independiente en agosto de 1974, después de su separación del Departamento de Historia de la Facultad de Humanidades.
                    Su creación estuvo ligada a aspiraciones académicas tendientes a superar la enseñanza tradicional de la Historia y las Ciencias Sociales. Ello se percibió con la lección inaugural de febrero de 1975 cuando oficialmente dieron inicio sus labores académicas.
                    En aquel momento, además de la licenciatura en Historia que se impartía desde la Facultad de Humanidades, se implementaron las licenciaturas de Antropología y Arqueología.
                    Aunque ya existía una unidad de investigación, por diversas razones, principalmente por falta de presupuesto, tuvo un largo periodo de inactividad. Fue hasta el año de 1986 cuando se logró el funcionamiento del Instituto de Investigaciones Historicas, Antropológicas y Arqueológicas.</p>
                <a href="#services" class="btn btn-default btn-xl">Accede al Sistema</a>
            </div>
        </div>
    </div>
</section>

<section id="services">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Servicios</h2>
                <hr class="primary">
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <a href="#" class="fa fa-4x fa-sign-in wow bounceIn text-primary" data-toggle="modal" data-target="#myModal"></a>
                    <h3>Estudiantes</h3>
                    <p class="text-muted">Ten Acceso a tus notas y horarios de cursos!</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <a href="" class="fa fa-4x fa-certificate wow bounceIn text-primary" data-wow-delay=".1s" data-toggle="modal" data-target="#myModal"></a>
                    <h3>Catedraticos</h3>
                    <p class="text-muted">Ten acceso a los cursos que impartes y administra las notas de tus alumnos!</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-book wow bounceIn text-primary" data-wow-delay=".2s"></i>
                    <h3>Pensum de Estudios</h3>
                    <p class="text-muted">Ten a la mano el pensum de tu carrera.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-newspaper-o wow bounceIn text-primary" data-wow-delay=".3s"></i>
                    <h3>Noticias</h3>
                    <p class="text-muted">Enterate de las ultimas noticias de la Escuela de Historia!</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="no-padding" id="portfolio">
    <div class="container-fluid">
        <div class="row no-gutter">
            <div class="col-lg-4 col-sm-6">
                <a href="#" class="portfolio-box">
                    <img src="<?php echo $_layoutParams['ruta_img']?>portfolio/1.jpg" class="img-responsive" alt="">

                </a>
            </div>
            <div class="col-lg-4 col-sm-6">
                <a href="#" class="portfolio-box">
                    <img src="<?php echo $_layoutParams['ruta_img']?>portfolio/2.jpg" class="img-responsive" alt="">

                </a>
            </div>
            <div class="col-lg-4 col-sm-6">
                <a href="#" class="portfolio-box">
                    <img src="<?php echo $_layoutParams['ruta_img']?>portfolio/3.jpg" class="img-responsive" alt="">

                </a>
            </div>
            <div class="col-lg-4 col-sm-6">
                <a href="#" class="portfolio-box">
                    <img src="<?php echo $_layoutParams['ruta_img']?>portfolio/4.jpg" class="img-responsive" alt="">

                </a>
            </div>
            <div class="col-lg-4 col-sm-6">
                <a href="#" class="portfolio-box">
                    <img src="<?php echo $_layoutParams['ruta_img']?>portfolio/5.jpg" class="img-responsive" alt="">

                </a>
            </div>
            <div class="col-lg-4 col-sm-6">
                <a href="#" class="portfolio-box">
                    <img src="<?php echo $_layoutParams['ruta_img']?>portfolio/6.jpg" class="img-responsive" alt="">

                </a>
            </div>
        </div>
    </div>
</section>

<section id="contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 text-center">
                <h2 class="section-heading">Contactenos!</h2>
                <hr class="primary">
                <p>Escuela de Historia
                    Universidad de San Carlos de Guatemala  —-USAC-—
                    Centro América
                    Edificio S-1, 2do. Nivel, Ciudad Universitaria, zona 12

                    </p>
            </div>
            <div class="col-lg-4 col-lg-offset-2 text-center">
                <i class="fa fa-phone fa-3x wow bounceIn"></i>
                <p>Tel.           (502) 2418-8802
                    Tel.           (502) 2418-8804
                    Tel./Fax.:  (502) 2418-8800</p>
            </div>
            <div class="col-lg-4 text-center">
                <i class="fa fa-envelope-o fa-3x wow bounceIn" data-wow-delay=".1s"></i>
                <p><a href="mailto:your-email@your-domain.com">Email: eschistoriausac@gmail.com</a></p>
            </div>
        </div>
    </div>
</section>

<!-- LOGIN -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                <h2 class="text-center">Inicia Sesion</h2>
            </div>
            <div class="modal-body row">

                <form class="col-md-10 col-md-offset-1 col-xs-12 col-xs-offset-0">
                    <div class="form-group">
                        <input type="text" class="form-control input-lg" placeholder="Carnet">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control input-lg" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-danger btn-lg btn-block">Entrar</button>
                        <span class="pull-right"><a href="#">Olvidaste tu password?</a></span>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<?php
//        include 'conexion.php';
//        $conexion = pg_connect($cadenaConexion) or die("Error en la Conexión: ".pg_last_error());
//        $query = "select * from adm_funcionmenu";
//
//        $resultado = pg_query($conexion, $query) or die("Error en la Consulta SQL");
//
//        $numReg = pg_num_rows($resultado);
//
//        if($numReg>0){
//
//        while ($fila=pg_fetch_array($resultado)) {
//                echo $fila['funcionmenu'];
//        }
//
//        }
//        else {
//                echo 'hola';
//        }
//        pg_close($conexion);
?>