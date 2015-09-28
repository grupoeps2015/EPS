<section id="" style="background-color: beige;">
    <div class="header">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Unidades Acad&eacute;micas</h2>
                <h4 class="section-heading text-warning"><?php if(isset($this->nombreCentro)) echo '-' . $this->nombreCentro . '-';?></h4>
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
                            <a href="<?php echo BASE_URL?>gestionCentroUnidad/agregarUnidad/<?php echo $this->id;?>">
                                Crear Nueva Unidad
                            </a>
                        </i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    
    <div class="container">
        <div class="row" style="display:none">
            <div class="col-md-4 col-md-offset-2">
                <form id="frUnidad" method="post" action="<?php echo BASE_URL; ?>gestionCentroUnidad/agregarExistente">
                    <table class="text-primary" style="width: 100%;">
                        <tr>
                            <td colspan="3" class="text-info">
                                <span><b>Agregar Unidades existentes</b></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <select id="slExistentes" name="slExistentes" class="form-control input-lg">
                                    <?php if(isset($this->lsExistentes) && count($this->lsExistentes)): ?>
                                        <option value="NULL">(Unidad Acad&eacutemica)</option>
                                        <?php for($i =0; $i < count($this->lsExistentes); $i++) : ?>
                                        <option value="<?php echo $this->lsExistentes[$i]['codigo'];?>">
                                            <?php echo $this->lsExistentes[$i]['nombre']; ?>
                                        </option>
                                        <?php endfor;?>
                                    <?php else : ?>
                                        <option value="NULL">- No hay informaci&oacute;n disponible -</option>
                                    <?php endif;?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" align="center"><br/>
                                <input type="submit" id="btnAgregar" name="btnAgregar" value="Agregar" class="btn btn-warning" style="width: 60%" disabled>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"><hr class="hr1"/></td>
                        </tr>
                    </table>
                    <input type="hidden" name="hdEnvio" value="1">
                    <input type="hidden" name="hdCentro" value="<?php echo $this->id;?>">
                </form>
            </div>
            
            <div class="col-md-4">
                <form id="frUnidadBaja" method="post" action="<?php echo BASE_URL; ?>gestionCentroUnidad/quitarExistente">
                    <table class="text-primary" style="width: 100%;">
                        <tr>
                            <td colspan="3" class="text-info">
                                <span><b>Descartar Unidad Acad&eacute;mica</b></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <select id="slPropias" name="slPropias" class="form-control input-lg">
                                    <?php if(isset($this->lsPropias) && count($this->lsPropias)): ?>
                                        <option value="NULL">(Unidad Acad&eacutemica)</option>
                                        <?php for($i =0; $i < count($this->lsPropias); $i++) : ?>
                                        <option value="<?php echo $this->lsPropias[$i]['unidad'];?>">
                                            <?php echo $this->lsPropias[$i]['nombre']; ?>
                                        </option>
                                        <?php endfor;?>
                                    <?php else : ?>
                                        <option value="NULL">- No hay informaci&oacute;n disponible -</option>
                                    <?php endif;?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" align="center"><br/>
                                <input type="submit" id="btnQuitar" name="btnQuitar" value="Remover" class="btn btn-danger" style="width: 60%" disabled>
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" name="hdEnvio" value="1"/>
                    <input type="hidden" name="hdCentro" value="<?php echo $this->id;?>"/>
                </form>
            </div> 
        </div>
        <div class ="row">
            <div class="col-md-10 col-md-offset-1">
                <table id="tbUnidadesAcademicas" border="2" style="width: 100%;">
                    <thead>
                        <tr>
                            <th style="text-align:center;">No.</th>
                            <th style="text-align:center;">Nombre</th>
                            <th style="text-align:center;">Unidad Superior</th>
                            <th style="text-align:center;">Tipo Unidad</th>
                            <th style="text-align:center;">Estado</th>
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
                            <td style="text-align: center;"><?php echo $this->lstUnidades[$i]['estado']; ?></td>
                            <td style="text-align: center;">
                                <?php if(strcmp($this->lstUnidades[$i]['estado'], 'Activado') == 0): ?>
                                <a href="<?php echo BASE_URL . 'gestionCentroUnidad/estadoNuevo/-1/' . $this->id . '/' . $this->lstUnidades[$i]['unidad'];?>">Desactivar</a>
                                <?php else : ?>
                                <a href="<?php echo BASE_URL . 'gestionCentroUnidad/estadoNuevo/1/' . $this->id . '/' . $this->lstUnidades[$i]['unidad'];?>">Activar</a>
                                <?php endif;?>
                            </td>
                            <td style="text-align: center;">
                                <?php if(strcmp($this->lstUnidades[$i]['estado'], 'Activado') == 0): ?>
                                <a href="<?php echo BASE_URL . 'gestionCentroUnidad/' . $this->lstUnidades[$i]['unidad'];?>">Ver Carreras</a>
                                <?php else : ?>
                                &nbsp;
                                <?php endif;?>
                            </td>
                        </tr>
                        <?php endfor;?>
                    <?php endif;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>