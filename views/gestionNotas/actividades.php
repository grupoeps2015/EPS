<section id="" style="background-color: beige;">
    <div class="header">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Gesti&oacute;n de notas</h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                        <?php if($_SESSION['rol']==2): ?>
                            <a href="<?php echo BASE_URL?>catedratico/inicio">
                                Regresar
                            </a>
                        <?php else: ?>
                            <a href="<?php echo BASE_URL?>gestionNotas/index/<?php echo $this->id?>">
                                Regresar
                            </a>
                        <?php endif;?>
                        </i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <table class="table-hover" style="width:100%">
                    <tr>
                        <td class="text-primary" style="width:10%">Nombre:&nbsp;</td>
                        <td style="width: 1%"></td>
                        <td colspan="2" style="width: 39%"><?php echo $this->datosCat[0][2];?></td>
                        <td style="width: 1%">&nbsp;</td>
                        <td style="width: 24%">&nbsp;</td>
                        <td style="width: 1%"></td>
                        <td style="width: 24%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="text-primary" style="width:10%">Registro:&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan="2"><?php echo $this->datosCat[0][1];?></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="8"><hr class="hr1"/></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan="2">
                            <select id="slTipos" name="slTipos" class="form-control input-lg">
                            <?php if (isset($this->lsTipoCiclo) && count($this->lsTipoCiclo)): ?>
                                    <option value="">-- Tipo Ciclo --</option>
                                    <?php for ($i = 0; $i < count($this->lsTipoCiclo); $i++) : ?>
                                        <option value="<?php echo $this->lsTipoCiclo[$i]['codigo']; ?>">
                                            <?php echo $this->lsTipoCiclo[$i]['nombre']; ?>
                                        </option>
                                    <?php endfor; ?>
                            <?php else : ?>
                                <option value="">-- No existen tipos registrados --</option>
                            <?php endif; ?>
                            </select>
                        </td>
                        <td>&nbsp;</td>
                        <td>
                            <select id="slAnio" name="slAnio" class="form-control input-lg">
                                <option value="" disabled>-- A&ntilde;o --</option>
                            </select>
                        </td>
                        <td>&nbsp;</td>
                        <td colspan="2">
                            <select id="slCiclo" name="slCiclo" class="form-control input-lg">
                                <option value="" disabled>-- Ciclo --</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan="4">&nbsp;<br/>
                            <select id="slSeccion" name="slSeccion" class="form-control input-lg">
                                <option value="" disabled>-- Secci&oacute;n Asignada --</option>
                            </select>
                        </td>
                        <td>&nbsp;</td>
                        <td><br/>
                            <input type="submit" id="btnActividades" name="btnActividades" value="Ver Actividades" class="btn btn-warning btn-lg btn-block" disabled="disabled"/>
                        </td>
                    </tr>
                    <tr style="display:none">
                        <td>&nbsp;</td>
                        <td colspan="4">
                            <select id="slCursoxSeccion" name="slCursoxSeccion" class="form-control input-lg"></select>
                        </td>
                        <td colspan="4">
                            <select id="slCarnetxAsignacion" name="slCarnetxAsignacion" class="form-control input-lg"></select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8"><hr class="hr1"/></td>
                    </tr>
                </table>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h4 align="center"><span id="spanMsg" name="spanMsg" class="text-warning"></span></h4>
                <form id="frActividades" name="frActividades">
                    <table id="tbActividades" name="tbActividades"style="display:none; text-align: center; width:100%">
                        <thead>
                            <tr class="text-primary">
                                <th style="width:19%; text-align:center">Nombre:</th>
                                <th style="width:30%;">&nbsp;</th>
                                <th style="width:1%">&nbsp;</th>
                                <th style="width:24%; text-align:center">Punteo:</th>
                                <th style="width:1%">&nbsp;</th>
                                <th style="width:25%; text-align:center">Agregar Actividad</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyAct" name="tbodyAct">
                            <tr>
                                <td colspan="2"><br/>EXAMEN FINAL<br/>&nbsp;</td>
                                <td style="width:1%">&nbsp;</td>
                                <td style="width:24%"><br/>25 pts.<br/>&nbsp;</td>
                                <td style="width:1%">&nbsp;</td>
                                <td style="width:25%">
                                    <br/>
                                    <input type="hidden" id="hd2" name="hd2" value="25"/>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">ZONA</td>
                                <td style="width:1%">&nbsp;</td>
                                <td style="width:24%">75 pts.</td>
                                <td style="width:1%">&nbsp;</td>
                                <td style="width:25%">
                                    <a href="#" class="upload" data-toggle="modal" data-target="#ModalActividades">
                                        <div class="fileUpload btn btn-success input-sm" style="width: 25%">
                                            <span>+</span>
                                        </div>
                                    </a>
                                    <input type="hidden" id="hd1" name="hd1" value="75"/>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>&nbsp;<br/>
                                    <input type="submit" id="btnGuardar" name="btnGuardar" value="Guardar" class="btn btn-warning btn-sm btn-block"/>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </form>
            </div>
        </div>
    </div>
    <input type="hidden" id="idCatedratico" name="idCatedratico" value="<?php echo $this->datosCat[0][0];?>" >
</section>


<!-- Div Crear Actividades -->
<div id="ModalActividades" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                <h2 class="text-center text-info">Nueva Actividad</h2>
            </div>
            <div class="modal-body row">
                <form id="frmGenerales" method="post" action="">
                    <div class="form-group">
                        <table align="center">
                            <tr style="display:none;">
                                <td tyle="width: 45%" class="text-info">
                                    <span>Seleccione la actividad padre:</span>
                                </td>
                                <td>&nbsp;</td>
                                <td>
                                    <select id="slActPadre" name="$this" class="form-control input-lg">
                                    <?php if(isset($this->lsTipoActividad) && count($this->lsTipoActividad)): ?>
                                        <?php for ($i = 0; $i < count($this->lsTipoActividad); $i++) : ?>
                                        <option value="<?php echo $this->lsTipoActividad[$i]['codigo']; ?>">
                                            <?php echo $this->lsTipoActividad[$i]['nombre']; ?>
                                        </option>
                                        <?php endfor;?>
                                    <?php else : ?>
                                        <option value="">-- No existen tipos registrados --</option>
                                    <?php endif;?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td tyle="width: 45%" class="text-info">
                                    <span>Actividades para zona del curso</span>
                                </td>
                                <td>&nbsp;</td>
                                <td>
                                    <select id="slTipoActividad" name="slTipoActividad" class="form-control input-lg">
                                    <?php if(isset($this->lsTipoActividad) && count($this->lsTipoActividad)): ?>
                                        <option value="">(Tipo Actividad)</option>
                                        <?php for ($i = 0; $i < count($this->lsTipoActividad); $i++) : ?>
                                        <option value="<?php echo $this->lsTipoActividad[$i]['codigo']; ?>">
                                            <?php echo $this->lsTipoActividad[$i]['nombre']; ?>
                                        </option>
                                        <?php endfor;?>
                                    <?php else : ?>
                                        <option value="">-- No existen tipos registrados --</option>
                                    <?php endif;?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 45%">
                                    <br />Nombre:<br />
                                    <input id="txtNombreAct" name="txtNombreAct" type="text" class="form-control input-lg" value="" placeholder="Ej: Tarea#1, Corto#1, etc.">&nbsp;
                                </td>
                                <td>&nbsp;</td>
                                <td>
                                    <br />Valor (puntos netos):&nbsp;<br />
                                    <input id="txtValorAct" name="txtValorAct" type="number" min="1" max="100" class="form-control input-lg" value="">&nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">Descripcion:&nbsp;<br />
                                    <input id="txtDescAct" name="txtDescAct" type="text" class="form-control input-lg" value="">
                                </td>                            
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: center">
                                    <span id="spanConfirma" id="spanConfirma" class="text-success"></span>
                                </td>
                            </tr>
                            <tr>
                                <td tyle="width: 45%">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><br/>
                                    <input type="button" id="btnNvaActividad" name="btnNvaActividad" value="Agregar" class="btn btn-danger btn-lg btn-block">
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>