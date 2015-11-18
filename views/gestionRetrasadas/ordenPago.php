<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Orden de Pago</h2>
                <p><?php if(isset($this->query)) echo $this->query; ?></p>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL; ?><?php if(isset($_SESSION["rol"])){if($_SESSION["rol"] == ROL_ESTUDIANTE){echo "estudiante";} else{echo "login";}} ;?>/inicio">
                                Regresar
                            </a>
                        </i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
            </div>
        </div>
    </div>
    <br/>
    <div class="container" >
        <div class="col-lg-12">
            <form id="frEstudiantes" method="post" action="<?php echo BASE_URL; ?>asignacion/boletaAsignacion">
                <table style="width:100%; text-align: center" border="1">
                    <tr>
                        <td style="width:70%">
                            <table>
                                <tr>
                                    <td>
                                        Fecha generada: <?php if (isset($this->fecha)) echo $this->fecha?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Orden de Pago
                                    </td>
                                </tr>
                            </table>
                        </td>    
                        <td style="width:30%">
                            <table>
                                <tr>
                                    <td>
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Para uso exclusivo del banco
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </form>
            </div>
    </div>
    <br/>
</section>