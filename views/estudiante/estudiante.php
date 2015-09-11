<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">
                    Actualizar Informacion Personal<br/>
                    - Estudiante -
                </h2>
                <?php if (isset($this->query)) echo $this->query; ?>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>gestionUsuario/actualizarUsuario/<?php echo $this->id;?>">
                                Regresar
                            </a>
                        </i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center">
                </div>
            </div>
        </div>
    </div>

    <div class="header-content">
        <div class="header-content-inner">
            <div class="row">                
                <div>
                    <div class="col-md-6 col-md-offset-3">
                        <table align="center">
                            <?php if(isset($this->infoGeneral) && count($this->infoGeneral)): ?>

                            <!-- Datos Estudiante -->
                            <tr class="text-primary">
                                <th style="width: 20%">&nbsp;</th>
                                <th style="width: 40%; text-align:center">Nombre Completo</th>
                                <th style="width: 40%; text-align:center">Carnet</th>                                    
                            </tr>
                            <tr>
                                <td class="text-primary" style="width: 20%; text-align:right">Estudiante:&nbsp;</td>
                                <td style="width: 40%; text-align:center"><?php echo $this->infoGeneral[0]['nombre'] ?></td>
                                <td style="width: 40%; text-align:center"><?php echo $this->infoGeneral[0]['carnet'] ?></td>
                            </tr>
                            <tr>
                                <td colspan="3"><hr class="hr1"/></td>
                            </tr>

                            <!-- Informacion General del Estudiante -->
                            <tr class="text-primary">
                                <th style="width: 20%">&nbsp;</th>
                                <th colspan="2" style="text-align:center">Informacion general</th>
                            </tr>
                            <tr>
                                <td class="text-primary" style="width: 20%; text-align:right">Direccion:&nbsp;</td>
                                <td style="width: 40%; text-align:center"><?php echo $this->infoGeneral[0]['direccion'] ?></td>
                                <td style="width: 40%; text-align:center" rowspan="3">
                                    <a id="btnGenerales" href="#" class="upload" data-toggle="modal" data-target="#ModalGenerales">
                                        <div class="fileUpload btn btn-warning">
                                            <span>&nbsp;Modificar&nbsp;</span>
                                        </div>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-primary" style="width: 20%; text-align:right">Telefono:&nbsp;</td>
                                <td style="width: 40%; text-align:center"><?php echo $this->infoGeneral[0]['telefono'] ?></td>
                            </tr>
                            <tr>
                                <td class="text-primary" style="width: 20%; text-align:right">Nacionalidad:&nbsp;</td>
                                <td style="width: 40%; text-align:center"><?php echo $this->infoGeneral[0]['pais'] ?></td>
                            </tr>
                            <tr>
                                <td colspan="3"><hr class="hr1"/></td>
                            </tr>

                            <!-- Informacion por Emergencia del Estudiante -->
                            <tr class="text-primary">
                                <th style="width: 20%">&nbsp;</th>
                                <th colspan="2" style="text-align:center">Informacion en caso de emergencia</th>
                            </tr>
                            <tr>
                                <td class="text-primary" style="width: 40%; text-align:right">Por emergencias llamar al:&nbsp;</td>
                                <td style="width: 20%; text-align:center"><?php echo $this->infoGeneral[0]['emergencia'] ?></td>
                                <td style="width: 40%; text-align:center" rowspan="5">
                                    <a id="btnEmergencias" href="#" class="upload" data-toggle="modal" data-target="#ModalEmergencias">
                                        <div class="fileUpload btn btn-warning">
                                            <span>&nbsp;Modificar&nbsp;</span>
                                        </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-primary" style="width: 40%; text-align:right">Tipo de sangre:&nbsp;</td>
                                <td style="width: 20%; text-align:center"><?php echo $this->infoGeneral[0]['sangre'] ?></td>
                            </tr>
                            <tr>
                                <td class="text-primary" style="width: 40%; text-align:right">Alergias:&nbsp;</td>
                                <td style="width: 20%; text-align:center"><?php echo $this->infoGeneral[0]['alergias'] ?></td>
                            </tr>
                            <tr>
                                <td class="text-primary" style="width: 40%; text-align:right">¿Posee seguro m&eacute;dico?:&nbsp;</td>
                                <td style="width: 20%; text-align:center">
                                    <?php if($this->infoGeneral[0]['seguro']){
                                            echo "Si";
                                          }else{ 
                                            echo "No";
                                          }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-primary" style="width: 40%; text-align:right">Por emergencias trasladarlo a:&nbsp;</td>
                                <td style="width: 20%; text-align:center">
                                    <?php echo $this->infoGeneral[0]['hospital'] ?>
                                </td>
                            </tr>
                            <?php else : ?>
                            <tr>
                                <td>- No se encontro informacion asociada al estudiante-</td>
                            </tr>
                            <?php endif;?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <br />
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 text-center"></div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-book wow bounceIn text-primary"></i>
                    <a href="#moduloAsignacion"><h3>Asignaci&oacute;n de cursos</h3></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-ban wow bounceIn text-primary" data-wow-delay=".1s"></i>
                    <a href="#moduloDesasignacion"><h3>Desasignaciones</h3></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center"></div>
        </div>
    </div>
</section>

<!-- Div Informacion General -->
<div id="ModalGenerales" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                <h2 class="text-center">Informacion General</h2>
            </div>
            <div class="modal-body row">
                <form id="frmGenerales" class="col-md-10 col-md-offset-1 col-xs-12 col-xs-offset-0" method="post" action="<?php echo BASE_URL; ?>estudiante/infoEstudiante/<?php echo $this->id;?>">
                    <div class="form-group">
                        <table align="center">
                            <tr>
                                <td tyle="width: 45%">
                                    <?php if(isset($this->deptos) && count($this->deptos)): ?>
                                    <select id="slDeptos" name="slDeptos" class="form-control input-lg">
                                        <option value="">- Departamentos -</option>
                                        <?php for($i =0; $i < count($this->deptos); $i++) : ?>
                                        <option value="<?php echo $this->deptos[$i]['codigo'];?>">
                                            <?php echo $this->deptos[$i]['nombre']; ?>
                                        </option>
                                        <?php endfor;?>
                                    </select>
                                    <?php else : ?>
                                    &nbsp;
                                    <?php endif;?>
                                </td>
                                <td>&nbsp;</td>
                                <td>
                                    <select id="slMunis" name="slMunis" class="form-control input-lg">
                                        <option value="" disabled>- Municipios -</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 45%"><br />Direccion:<br />
                                <input id="txtDireccion" name="txtDireccion" type="text" class="form-control input-lg" value="<?php echo $this->infoGeneral[0]['dircorta'] ?>">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><br />Zona:&nbsp;<br />
                                <input id="txtZona" name="txtZona" type="number" min="0" max="27" class="form-control input-lg" value="<?php echo $this->infoGeneral[0]['zona'] ?>">&nbsp;</td>
                            </tr>
                            <tr>
                                <td tyle="width: 45%">Telefono:&nbsp;<br />
                                    <input id="txtTelefono" name="txtTelefono" type="number" min="22000000" max="99999999" class="form-control input-lg" value="<?php echo $this->infoGeneral[0]['telefono'] ?>"></td>
                                <td>&nbsp;</td>
                                <td><br/>
                                    <?php if(isset($this->paises) && count($this->paises)): ?>
                                    <select id="slPaises" name="slPaises" class="form-control input-lg">
                                        <option value="">- Nacionalidad -</option>
                                        <?php for($i =0; $i < count($this->paises); $i++) : ?>
                                        <option value="<?php echo $this->paises[$i]['codigo'];?>">
                                            <?php echo $this->paises[$i]['nombre']; ?>
                                        </option>
                                        <?php endfor;?>
                                    </select>
                                    <?php else : ?>
                                    &nbsp;
                                    <?php endif;?>
                                </td>
                            </tr>
                            <tr>
                                <td tyle="width: 45%">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><br/>
                                    <input type="submit" id="btnGenerales" name="btnGenerales" value="Guardar Cambios" class="btn btn-danger btn-lg btn-block">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <input type="hidden" name="hdEnvio" value="1">
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Div Informacion Emergencia -->
<div id="ModalEmergencias" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                <h2 class="text-center">En caso de emergencia</h2>
            </div>
            <div class="modal-body row">
                <form class="col-md-10 col-md-offset-1 col-xs-12 col-xs-offset-0" id="frEmergencias" method="post" action="<?php echo BASE_URL; ?>estudiante/infoEstudiante/<?php echo $this->id;?>">
                    <div class="form-group">
                        <table align="center">
                            <tr>
                                <td style="width: 45%">Telefono:<br/>
                                    <input id="txtTelefonoE" name="txtTelefonoE" type="number" min="22000000" max="99999999" class="form-control input-lg" value="<?php echo $this->infoGeneral[0]['emergencia']?>"></td>
                                </td>
                                <td>&nbsp;</td>
                                <td rowspan="2">Alergias:<br/>
                                    <textarea id="txtAlergias" name="txtAlergias" rows="5" class="form-control input-lg" style="resize: none;"><?php echo $this->infoGeneral[0]['alergias']?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 45%"><br/>Tipo de sangre:<br/>
                                    <input id="txtTipoSangre" name="txtTipoSangre" type="text" class="form-control input-lg" value="<?php echo $this->infoGeneral[0]['sangre']?>" />
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="width: 45%"><br/>Centro Asistencial:<br/>
                                    <input id="txtHospital" name="txtHospital" type="text" class="form-control input-lg" value="<?php echo $this->infoGeneral[0]['hospital']?>"/>
                                </td>
                                <td>&nbsp;</td>
                                <td style="text-align:center">
                                    <br/><span>¿Posee seguro m&eacute;dico?</span><br/>
                                    <?php if($this->infoGeneral[0]['seguro']):?>
                                        <input type="radio" id="rbSeguro" name="rbSeguro" value="1" checked>Si&nbsp;&nbsp;
                                        <input type="radio" id="rbSeguro" name="rbSeguro" value="0">No
                                    <?php else:?>
                                        <input type="radio" id="rbSeguro" name="rbSeguro" value="1">Si&nbsp;&nbsp;
                                        <input type="radio" id="rbSeguro" name="rbSeguro" value="0" checked>No
                                    <?php endif?>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><br/>
                                    <input type="submit" id="btnEmergencia" name="btnEmergencia" value="Guardar Cambios" class="btn btn-danger btn-lg btn-block">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <input type="hidden" name="hdEnvio" value="2">
                </form>
            </div>
        </div>
    </div>
</div>