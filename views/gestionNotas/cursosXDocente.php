<section id="" style="background-color: beige;"> 
    <div class="header">
        <div class="row">
            <div class="col-lg-12 text-center">
                <?php if($this->tipo == 1): ?>
                <h2 class="section-heading">Listado de alumnos asignados</h2>
                <?php else:?>
                <h2 class="section-heading">Gesti&oacute;n de notas</h2>
                <?php endif;?>                
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
                            <select id="slAnio" name="slAnio" class="form-control input-lg">
                            <?php if (isset($this->lstAnios) && count($this->lstAnios)): ?>
                                    <option value="">-- A&ntilde;o --</option>
                                    <?php for ($i = 0; $i < count($this->lstAnios); $i++) : ?>
                                        <option value="<?php echo $this->lstAnios[$i]['anio']; ?>">
                                            <?php echo $this->lstAnios[$i]['anio']; ?>
                                        </option>
                                    <?php endfor; ?>
                            <?php else : ?>
                                <option value="">-- No existen tipos registrados --</option>
                            <?php endif; ?>
                            </select>
                        </td>
                        <td>&nbsp;</td>
                        <td>
                            <select id="slCiclo" name="slCiclo" class="form-control input-lg">
                                <option value="" disabled>-- Ciclo --</option>
                            </select>
                        </td>
                        <td>&nbsp;</td>
                        <td>
                            &nbsp;<input type="radio" id="rbTipoNota" name="rbTipoNota" value="10" checked>Ciclo regular<br>
                            &nbsp;<input type="radio" id="rbTipoNota" name="rbTipoNota" value="20">1ra Retrasada<br>
                            &nbsp;<input type="radio" id="rbTipoNota" name="rbTipoNota" value="30">2da Retrasada
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
                            <input type="submit" id="btnActividades" name="btnActividades" value="Mostrar Listado" class="btn btn-danger btn-lg btn-block" disabled="disabled">
                            <?php if($this->tipo == 1): ?>
                            <form id="frRecargar" method="post" action="<?php echo BASE_URL; ?>gestionNotas/cursosXDocente/<?php echo $this->idUsuario; ?>/<?php echo $this->id; ?>/<?php echo $this->tipo; ?>">
                            <?php else : ?>
                            <form id="frRecargar" method="post" action="<?php echo BASE_URL; ?>gestionNotas/cursosXDocente/<?php echo $this->idUsuario; ?>/<?php echo $this->id; ?>">
                               <?php endif; ?>
                                <input type="submit" id="btnNuevaBusqueda" name="btnNuevaBusqueda" value="Nueva Busqueda" class="btn btn-danger btn-lg btn-block" style="display:none;">
                                <input type="hidden" id="hdNotaAprobacion" name="hdNotaAprobacion" value="<?php echo $this->notaAprobado;?>"/>
                                <input type="hidden" id="hdZonaTotal" name="hdZonaTotal" value="<?php echo $this->zonaTotal;?>"/>
                                <input type="hidden" id="hdFinalTotal" name="hdFinalTotal" value="<?php echo $this->finalTotal;?>"/>
                            </form>
                        </td>
                    </tr>
                    <tr style="display:none">
                        <td>&nbsp;</td>
                        <td colspan="3">
                            <select id="slCursoxSeccion" name="slCursoxSeccion" class="form-control input-lg"></select>
                        </td>
                        <td colspan="3">
                            <select id="slCarnetxAsignacion" name="slCarnetxAsignacion" class="form-control input-lg"></select>
                        </td>
                        <td colspan="2">
                            <select id="slIdxActividad" name="slIdxActividad" class="form-control input-lg"></select>
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
                <h3 align="center"><span id="spanMsg" name="spanMsg" class="text-warning"></span></h3>
                <table class="table-hover nowrap" cellspacing="0" align="center" id="tbAsignados" name="tbAsignados" border="1" style="display:none; text-align: center;">
                    <thead>
                        <tr id="headAsignados" name="headAsignados">
                            <?php if($this->tipo == 1): ?>
                            <th style="text-align: center; width:20%;">Carnet</th>
                            <th style="text-align: center; width:40%;">Nombre</th>
                            <th style="text-align: center; width:15%;">Secci&oacute;n</th>
                            <th style="text-align: center; width:15%;">Repitencia</th>
                            <th style="text-align: center; width:15%;">Tel&eacute;fono de emergencia</th>
                            <?php else : ?>
                            <th style="text-align: center; width:20%;">Carnet</th>
                            <th style="text-align: center; width:40%;">Nombre</th>
                            <th style="text-align: center; width:15%;">Zona</th>
                            <th style="text-align: center; width:15%;">Final</th>
                            <th style="text-align: center; width:10%;">Total</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody id="bodyAsignados" name="bodyAsignados">

                    </tbody>
                    <tfoot>
                        <form id="frFile" name="frFile" method='post' enctype="multipart/form-data">
                            <tr>
                                <td colspan="5" id="tdBotones" name="tdBotones">
                                    <div id="divcsvFile" class="fileUpload btn btn-warning" style="width:225px">
                                        <span id="spanCat">Cargar CSV</span>
                                        <input class="upload" type="file" id="csvFile" name="csvFile"/>
                                    </div> &nbsp;
                                    <input type="button" id="btnGuardar" name="btnGuardar" value="Guardar Cambios" class="btn btn-warning" style="width:225px"/>
                                </td>
                            </tr>
                            <?php if($_SESSION['rol']==0 || $_SESSION['rol']==1):?>
                            <tr>
                                <td colspan="5" id="tdExtra" name="tdExtra">
                                    <input type="button" id="btnAprobarNotas" name="btnAprobarNotas" value="Aprobar Notas Ingresadas" class="btn btn-warning" style="width:300px"/>&nbsp;
                                    <input type="button" id="btnImprimirActa" name="btnImprimirActa" value="Imprimir Acta de Notas" class="btn btn-warning" style="width:300px"/>
                                </td>
                            </tr>
                            <?php endif;?>
                            <input type="hidden" id="idCatedratico" name="idCatedratico" value="<?php echo $this->datosCat[0][0];?>" >
                            <input type="hidden" id="hdEstadoCiclo" name="hdEstadoCiclo" value="0" >
                            <input type="hidden" id="hdTipo" name="hdTipo" value="<?php echo $this->tipo; ?>" >
                            <input type="hidden" id="hdtipoAs" name="hdtipoAs" value="2">
                            <input type="hidden" id="hdcentrounidad" name="hdcentrounidad" value="<?php echo $_SESSION["centrounidad"]?>">
                            <input type="hidden" id="hdTotalAsignados" name="hdTotalAsignados" value="0" >
                            <input type="hidden" id="hdFile" name="hdFile" value="1"/>
                            <input type="hidden" id="hdActs" name="hdActs" value="-1"/>
                        </form>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>