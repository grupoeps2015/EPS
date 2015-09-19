<section id="" style="background-color: beige;">
    <div class="header">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Unidades Acad&eacute;micas</h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>gestionCentroUnidad">
                                Regresar
                            </a>
                        </i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-book wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>gestionCentroUnidad/agregarUnidad">
                                Agregar Unidad
                            </a>
                        </i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    
    <div class="container">
        <div style="margin-left: 10%; margin-right: 10%">
            <table id="tbUnidadesAcademicas" border="2" align="center">
                <thead>
                    <tr>
                        <th style="text-align:center;">No.</th>
                        <th style="text-align:center;">Nombre</th>
                        <th style="text-align:center;">Unidad Superior</th>
                        <th style="text-align:center;">Tipo Unidad</th>
                        <th style="text-align:center;">&nbsp;</th>
                        <th style="text-align:center;">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(isset($this->lstUnidades) && count($this->lstUnidades)): ?>
                    <?php for($i =0; $i < count($this->lstUnidades); $i++) : ?>
                    <tr>
                        <td style="text-align: center;"><?php echo $this->lstUnidades[$i]['unidad']; ?></td>
                        <td style="text-align: center;"><?php echo $this->lstUnidades[$i]['nombre']; ?></td>
                        <td style="text-align: center;">
                            <?php echo $this->lstUnidades[$i]['nombrepadre']; ?>
                            <input type="hidden" nombre="idPadre<?php echo $this->lstUnidades[$i]['idpadre']; ?>" value="<?php echo $this->lstCentros[$i]['idpadre'];?>"/>
                        </td>
                        <td style="text-align: center;"><?php echo $this->lstUnidades[$i]['tipo']; ?></td>
                        <td style="text-align: center;">
                            <a href="<?php echo BASE_URL . 'gestionCentroUnidad/' . $this->lstUnidades[$i]['unidad'];?>">Modificar</a>
                        </td>
                        <td style="text-align: center;">
                            <a href="<?php echo BASE_URL . 'gestionCentroUnidad/' . $this->lstUnidades[$i]['unidad'];?>">Gestionar Carreras</a>
                        </td>
                    </tr>
                    <?php endfor;?>
                <?php endif;?>
                </tbody>
            </table>
        </div>   
    </div>
</section>