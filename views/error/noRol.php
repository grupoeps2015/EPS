<section id="" style="background-color: beige;">
    <div class="header-content">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading"><?php if(isset($this->mensaje)) echo $this->mensaje;?></h2>
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
                    <a href="javascript:window.history.go(-1)">
                        Volver
                    </a>
                </h3>
                <p class="text-muted">a la p&aacute;gina de inicio</p>
            </div>
            
            <!-- Menu Opcion 2 -->
            <div class="col-lg-6 col-md-8 text-center">
                <div class="service-box">
                    <h3 class="text-danger">
                        <?php if(isset($this->detalle)) echo $this->detalle;?>
                    </h3>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-8 text-center"></div>
        </div>
    </div>
</section>