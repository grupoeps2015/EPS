<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title><?php if(isset($this->titulo)) echo $this->titulo; ?></title>
        <link href="<?php echo $_layoutParams['ruta_css']?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo $_layoutParams['ruta_css']?>bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo $_layoutParams['ruta_css']?>animate.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo $_layoutParams['ruta_css']?>creative.css" rel="stylesheet" type="text/css"/>
        
<?php if(isset($_layoutParams['css']) && count($_layoutParams['css'])):?>
    <?php for($i = 0; $i<count($_layoutParams['css']); $i++): ?>
    <link href="<?php echo $_layoutParams['css'][$i]?>" rel="stylesheet" type="text/css" />
    <?php endfor; ?>
<?php endif; ?> 
        
        <script src="<?php echo $_layoutParams['ruta_js']?>jquery.js" type="text/javascript"></script>
        <script src="<?php echo $_layoutParams['ruta_js']?>bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo $_layoutParams['ruta_js']?>jquery.easing.min.js" type="text/javascript"></script>
        <script src="<?php echo $_layoutParams['ruta_js']?>jquery.fittext.js" type="text/javascript"></script>
        <script src="<?php echo $_layoutParams['ruta_js']?>wow.min.js" type="text/javascript"></script>
        <script src="<?php echo $_layoutParams['ruta_js']?>creative.js" type="text/javascript"></script>
             
<?php if(isset($_layoutParams['js']) && count($_layoutParams['js'])):?>
    <?php for($i = 0; $i<count($_layoutParams['js']); $i++): ?>
    <script src="<?php echo $_layoutParams['js'][$i]?>" type="text/javascript"></script>    
    <?php endfor; ?>
<?php endif; ?> 
        
    </head>
    <body id="page-top">
        <!--BARRA SUPERIOR Y MENU-->
        <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <img src="<?php echo $_layoutParams['ruta_img']?>img10.png" width="100px" height="50px" align="left" />
                </div>

                <!-- Menu superior lateral derecho -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a class="page-scroll" href="<?php echo BASE_URL?>admLogin/salir">
                                <font color="black">Salir</font>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- FIN BARRA SUPERIOR Y MENU -->