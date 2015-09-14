<section id="" style="background-color: beige;">
    <div class="header">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Gesi&oacute;n de notas</h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>gestionNotas/index/<?php echo $this->id?>">
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
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <table>
                    <tr>
                        <td class="text-primary" style="width:10%">Nombre:&nbsp;</td>
                        <td style="width: 1%"></td>
                        <td colspan="2" style="width: 39%"><?php echo $this->datosCat[0][2];?></td>
                        <td style="width: 1%">&nbsp;</td>
                        <td style="width: 25%">&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="text-primary" style="width:10%">Registro:&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan="2"><?php echo $this->datosCat[0][1];?></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="7"><hr class="hr1"/></td>
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
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><br/>
                            <input type="submit" id="btnActividades" name="btnActividades" value="Ver Actividades" class="btn btn-danger btn-lg btn-block" disabled="disabled">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</section>