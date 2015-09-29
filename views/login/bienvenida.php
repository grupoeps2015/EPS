<section id="" style="background-color: beige;">
    <div class="header-content">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading text-primary">Sus datos han sido actualizados con &eacute;xito</h2>
                <hr class="primary">
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="row">
            <!-- Menu Opcion 1 -->
            <div class="col-lg-3 col-md-8 text-center">
                <i class="fa fa-4x fa-home wow bounceIn text-primary" data-wow-delay=".1s"></i>
                <h3>
                    <?php if($_SESSION['rol']==0 || $_SESSION['rol']==3): ?>
                    <a href="<?php echo BASE_URL; ?>login/inicio">Ir a la p&aacute;gina</a>
                    <?php elseif($_SESSION['rol']==2):?>
                    <a href="<?php echo BASE_URL; ?>catedratico/inicio">Ir a la p&aacute;gina</a>
                    <?php elseif($_SESSION['rol']==1):?>
                    <a href="<?php echo BASE_URL; ?>estudiante/inicio">Ir a la p&aacute;gina</a>
                    <?php endif;?>
                </h3>
                <p class="text-muted">de inicio</p>
            </div>
            
            <!-- Menu Opcion 2 -->
            <div class="col-lg-6 col-md-8 text-center">
                <div class="service-box">
                    <h3 class="text-success">
                        Puede ingresar a las distintas opciones desde el mun&uacute; localizado en la barra superior
                        o dando clic en el link de Inicio.
                    </h3>
                </div>
            </div>
            
            <!-- Menu Opcion 3 -->
            <div class="col-lg-3 col-md-8 text-center"></div>
        </div>
    </div>
</section>