<section id="" style="background-color: beige;">
    <div class="header">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Gesi&oacute;n de notas</h2>
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
                <table class="table-hover">
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
                            <input type="hidden" id="idCatedratico" name="idCatedratico" value="<?php echo $this->datosCat[0][0];?>" >
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
                            <input type="submit" id="btnActividades" name="btnActividades" value="Ver Actividades" class="btn btn-danger btn-lg btn-block" disabled="disabled">
                            <form id="frRecargar" method="post" action="<?php echo BASE_URL; ?>gestionNotas/cursosXDocente/<?php echo $this->idUsuario; ?>/<?php echo $this->id; ?>">
                                <input type="submit" id="btnNuevaBusqueda" name="btnNuevaBusqueda" value="Nueva Busqueda" class="btn btn-danger btn-lg btn-block" style="display:none;">
                            </form>
                        </td>
                    </tr>
                    <tr style="display:none">
                        <td>&nbsp;</td>
                        <td colspan="4">
                            <select id="slCursoxSeccion" name="slCursoxSeccion" class="form-control input-lg"></select>
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
                <table class="table-hover" id="tbAsignados" name="tbAsignados" border="2" style="display:none; text-align: center;">
                    <thead>
                        <tr>
                            <th style="text-align: center; width:20%;">Carnet</th>
                            <th style="text-align: center; width:40%;">Nombre</th>
                            <th style="text-align: center; width:15%;">Zona</th>
                            <th style="text-align: center; width:15%;">Final</th>
                            <th style="text-align: center; width:10%;">Total</th>
                        </tr>
                    </thead>
                    <tbody id="bodyAsignados" name="bodyAsignados">
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>