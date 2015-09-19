<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Listado de Edificios</h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>login/inicio">
                                Regresar
                            </a>
                        </i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-building-o wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>gestionEdificio/agregarEdificio">
                                Agregar Edificio
                            </a>
                        </i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div>
        <form id="frEdificios" method="post" action="<?php echo BASE_URL; ?>gestionEdificio/agregarEdificio">
            <div id="divEdificios" class="form-group" >
                <div style="margin-left: 10%; margin-right: 10%">
                    <table id="tbEdificios" border="2" align="center">
                        <thead>
                            <tr>
                                <th style="text-align:center; width: 250px;">Nombre</th>
                                <th style="text-align:center; width: 250px;">Descripción</th>
                                <th style="text-align:center; width: 100px;">Estado</th>
                                <th style="text-align:center; width: 100px;">&nbsp;</th>
                                <th style="text-align:center; width: 200px;">&nbsp;</th>
                                <th style="text-align:center; width: 200px;">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($this->lstEdif) && count($this->lstEdif)): ?>
                            
                            <?php for($i =0; $i < count($this->lstEdif); $i++) : ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $this->lstEdif[$i]['_nombre']; ?></td>
                                <td style="text-align: center;"><?php echo $this->lstEdif[$i]['_descripcion']; ?></td>
                                <td style="text-align: center;"><?php echo $this->lstEdif[$i]['_estado']; ?></td>
                                <td style="text-align: center; padding-right: 20px;"><a href="<?php echo BASE_URL . 'gestionEdificio/actualizarEdificio/' . $this->lstEdif[$i]['_id']; ?>">Modificar</a></td>
                                <td style="text-align: center;">
                                     <?php if(strcmp($this->lstEdif[$i]['_estado'], 'Activo') == 0): ?>
                                      
                                    <a href="<?php echo BASE_URL . 'gestionEdificio/activarDesactivarEdificio/-1/' . $this->lstEdif[$i]['_id'];?>">Desactivar</a>
                                    <?php else : ?>
                                     
                                    <a href="<?php echo BASE_URL . 'gestionEdificio/activarDesactivarEdificio/1/' . $this->lstEdif[$i]['_id'] ?>">Activar</a>
                                    <?php endif;?>
                                </td>
                                <th style="text-align:center; width: 100px;">
                                    <a href="<?php echo BASE_URL . 'gestionEdificio/gestionEdificio/' . $this->lstEdif[$i]['_id'];?>">Unidades Asignadas</a>
                                </th>
                            </tr>
                            <?php endfor;?>
                        <?php endif;?>
                        </tbody>
                    </table>
                    <br />
                </div>
            </div>
        </form>
    </div>   
</section>