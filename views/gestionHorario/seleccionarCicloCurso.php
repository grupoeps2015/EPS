<section id="" style="background-color: beige;">
    <div class="header-content">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Selecci&oacute;n de Ciclo</h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>general/seleccionarCentroUnidad/gestionHorario/seleccionarCicloCurso">
                                Regresar
                            </a>
                        </i>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 text-center"></div>
                <div class="col-lg-4 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-copy wow bounceIn text-primary" data-wow-delay=".2s">
                            <a id="linkCopiaHor" href="#" class="h2" data-wow-delay=".1s" data-toggle="modal" data-target="#myModal2">Copiar Horario</a>
                        </i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-spinner wow bounceIn text-primary" data-wow-delay=".2s">
                            <a id="linkNuevoCic" href="#" class="h2" data-wow-delay=".1s" data-toggle="modal" data-target="#myModal">Agregar Ciclo</a>
                        </i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>

    <div class="container" >
        <div class="col-md-6 col-md-offset-3">
            <form id="frEstudiantes" method="post" action="<?php echo BASE_URL; ?>gestionHorario">
                <table>
                    <tr>
                        <td style="width: 10%">
                            <h4>A&ntilde;o: </h4>
                            <br/>
                        </td>
                        <td style="width:38%;">
                            <select id="slAnio" name="slAnio" class="form-control input-lg">
                                <?php if (isset($this->lstAnios) && count($this->lstAnios)): ?>
                                    <option value="">-- A&ntilde;o --</option>
                                    <?php for ($i = 0; $i < count($this->lstAnios); $i++) : ?>
                                        <option value="<?php echo $this->lstAnios[$i]['anio']; ?>"><?php echo $this->lstAnios[$i]['anio']; ?></option>
                                    <?php endfor; ?>
                                <?php else : ?>
                                    <option value="">-- No existen a&ntilde;os registrados --</option>
                                <?php endif; ?>
                            </select>
                            <br />
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 10%">
                            <h4>Ciclo: </h4>
                            <br/>
                        </td>
                        <td style="width:38%;">
                            <select id="slCiclo" name="slCiclo" class="form-control input-lg">
                                <option value="" disabled>-- Ciclo --</option>
                            </select>
                            <br />
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 10%">
                            <h4>Sección: </h4>
                            <br/>
                        </td>
                        <td style="width: 38%">
                                
                            <select id="slSec" name="slSec" class="form-control input-lg">
                            <?php if (isset($this->lstSec) && count($this->lstSec)): ?>
                                    <option value=""></option>
                                    <?php for ($i = 0; $i < count($this->lstSec); $i++) : ?>
                                        <option value="<?php echo $this->lstSec[$i]['id']; ?>"><?php echo trim($this->lstSec[$i]['nombre']." - ".$this->lstSec[$i]['tiposeccion']." - ".$this->lstSec[$i]['curso']); ?></option>
                                    <?php endfor; ?>
                            <?php else : ?>
                                <option value="">-- No existen secciones registradas --</option>
                            <?php endif; ?>
                            </select>
                            <br />
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td style="text-align:right;">
                            <input type="submit" id="btnConsultar" value="Consultar" class="btn btn-danger btn-lg btn-warning" disabled>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5"><hr class="hr1"/></td>
                    </tr>
                </table>
                <input type="hidden" name='slTipos' id='slTipos' value="<?php echo $this->idTipoCiclo;?>"/>
            </form>
        </div>
    </div>
</section>

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                <h2 class="text-center">Nuevo Ciclo</h2>
            </div>
            <div class="modal-body row">
                <form id="frmGenerales" class="col-md-10 col-md-offset-1 col-xs-12 col-xs-offset-0" method="post" action="<?php echo BASE_URL; ?>gestionHorario/agregarCiclo">
                    <div class="form-group">
                        <table align="center">
                            <tr>
                                <td style="width: 45%"><br />A&ntilde;o:<br />
                                <input id="txtAnio" name="txtAnio" type="number" min="0" class="form-control input-lg" value="<?php /*echo $this->infoGeneral[0]['dircorta']*/ ?>">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><br />N&uacute;mero Ciclo:&nbsp;<br />
                                <input id="txtCiclo" name="txtCiclo" type="number" min="0" class="form-control input-lg" value="<?php /*echo $this->infoGeneral[0]['zona']*/ ?>">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="width: 45%">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><br/>
                                    <input type="submit" id="btnGenerales" name="btnGenerales" value="Crear Ciclo" class="btn btn-danger btn-lg btn-block">
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

<div id="myModal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                <h2 class="text-center">Copiar Horario</h2>
            </div>
            <div class="modal-body row">
                <form id="frmGenerales" class="col-md-10 col-md-offset-1 col-xs-12 col-xs-offset-0" method="post" action="<?php echo BASE_URL; ?>gestionHorario/copiarHorario">
                    <div class="form-group">
                        <table align="center" style="border-spacing:5px; border-collapse:separate;">
                            <tr>
                                <td colspan="2" align="center"><h3>Ciclo origen</h3><br/></td>
                                <td colspan="2" align="center"><h3>Ciclo destino</h3><br/></td>
                            </tr>
                            <tr>
                                <td style="width: 5%">
                                    <h4>A&ntilde;o: </h4>
                                    <br/>
                                </td>
                                <td style="width: 45%;">
                                    <select id="slAnioO" name="slAnioO" class="form-control input-lg">
                                        <?php if (isset($this->lstAnios) && count($this->lstAnios)): ?>
                                            <option value="">-- A&ntilde;o --</option>
                                            <?php for ($i = 0; $i < count($this->lstAnios); $i++) : ?>
                                                <option value="<?php echo $this->lstAnios[$i]['anio']; ?>"><?php echo $this->lstAnios[$i]['anio']; ?></option>
                                            <?php endfor; ?>
                                        <?php else : ?>
                                            <option value="">-- No existen a&ntilde;os registrados --</option>
                                        <?php endif; ?>
                                    </select>
                                    <br />
                                </td>
                                <td style="width: 5%">
                                    <h4>A&ntilde;o: </h4>
                                    <br/>
                                </td>
                                <td style="width: 45%;">
                                    <select id="slAnioD" name="slAnioD" class="form-control input-lg">
                                        <?php if (isset($this->lstAnios) && count($this->lstAnios)): ?>
                                            <option value="">-- A&ntilde;o --</option>
                                            <?php for ($i = 0; $i < count($this->lstAnios); $i++) : ?>
                                                <option value="<?php echo $this->lstAnios[$i]['anio']; ?>"><?php echo $this->lstAnios[$i]['anio']; ?></option>
                                            <?php endfor; ?>
                                        <?php else : ?>
                                            <option value="">-- No existen a&ntilde;os registrados --</option>
                                        <?php endif; ?>
                                    </select>
                                    <br />
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 5%">
                                    <h4>Ciclo: </h4>
                                    <br/>
                                </td>
                                <td style="width: 45%;">
                                    <select id="slCicloO" name="slCicloO" class="form-control input-lg">
                                        <option value="" disabled>-- Ciclo --</option>
                                    </select>
                                    <br />
                                </td>
                                <td style="width: 5%">
                                    <h4>Ciclo: </h4>
                                    <br/>
                                </td>
                                <td style="width: 45%;">
                                    <select id="slCicloD" name="slCicloD" class="form-control input-lg">
                                        <option value="" disabled>-- Ciclo --</option>
                                    </select>
                                    <br />
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td colspan="2"><br/>
                                    <input type="submit" id="btnCopia" name="btnCopia" value="Copiar Horario" class="btn btn-danger btn-lg btn-block" onClick="return confirm('ADVERTENCIA: No podrá deshacer esta acción. ¿Está seguro que desea copiar el horario del ciclo: '+$('#slCicloO option:selected').text()+' '+$('#slAnioO option:selected').text()+' al ciclo: '+$('#slCicloD option:selected').text()+' '+$('#slAnioD option:selected').text());+'?'" disabled>
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