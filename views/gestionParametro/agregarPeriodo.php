<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Agregar Per&iacute;odo</h2>
                <p><?php if(isset($this->query)) echo $this->query; ?></p>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>gestionParametro/listadoPeriodo">
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

    <div class="header-content">
        <div class="header-content-inner">
            <div class="row">
                <form id="frSecciones" method="post" action="<?php echo BASE_URL; ?>gestionParametro/agregarPeriodo">
                    <div id="divSecciones" class="form-group" >
                        <div class="col-md-6 col-md-offset-3">
                            <table>
                                <tr>
                                    <td>
                                        A&ntilde;o:
                                        <select id="slAnio" name="slAnio" class="form-control input-lg">
                                            <?php if (isset($this->lstAnios) && count($this->lstAnios)): ?>
                                                <option value="">-- A&ntilde;o --</option>
                                                <?php for ($i = 0; $i < count($this->lstAnios); $i++) : ?>
                                                    <option value="<?php echo $this->lstAnios[$i]['anio']; ?>" <?php if (isset($this->anio) && $this->lstAnios[$i]['anio'] == $this->anio) echo "selected" ?>>
                                                        <?php echo $this->lstAnios[$i]['anio']; ?>
                                                    </option>
                                                <?php endfor; ?>
                                            <?php else : ?>
                                                <option value="">-- No existen a&ntilde;o registrados --</option>
                                            <?php endif; ?>
                                        </select><br/>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>
                                        Ciclo:
                                        <select id="slCiclo" name="slCiclo" class="form-control input-lg">
                                            <?php if (isset($this->lstCiclos) && count($this->lstCiclos)): ?>
                                                <option value="">-- Ciclo --</option>
                                                <?php for ($i = 0; $i < count($this->lstCiclos); $i++) : ?>
                                                    <option value="<?php echo $this->lstCiclos[$i]['codigo']; ?>" <?php if (isset($this->ciclo) && $this->lstCiclos[$i]['codigo'] == $this->ciclo) echo "selected" ?>>
                                                        <?php echo $this->lstCiclos[$i]['nombre']; ?>
                                                    </option>
                                                <?php endfor; ?>
                                            <?php else : ?>
                                                <option value="" disabled>-- Ciclo --</option>
                                            <?php endif; ?>
                                        </select><br/>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        *Tipo de período:
                                        <?php if(isset($this->tiposPeriodo) && count($this->tiposPeriodo)): ?>
                                        <select id="slTiposPeriodo" name="slTiposPeriodo" class="form-control input-lg">
                                            <?php for($i =0; $i < count($this->tiposPeriodo); $i++) : ?>
                                            <option value="<?php echo $this->tiposPeriodo[$i]['codigo'];?>">
                                                <?php echo $this->tiposPeriodo[$i]['nombre']; ?>
                                            </option>
                                            <?php endfor;?>
                                        </select><br/>
                                        <?php else : ?>
                                        &nbsp;
                                        <?php endif;?>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        *Tipo de asignación:
                                        <?php if(isset($this->tiposAsign) && count($this->tiposAsign)): ?>
                                        <select id="slTiposAsign" name="slTiposAsign" class="form-control input-lg">
                                            <?php for($i =0; $i < count($this->tiposAsign); $i++) : ?>
                                            <option value="<?php echo $this->tiposAsign[$i]['codigo'];?>">
                                                <?php echo $this->tiposAsign[$i]['nombre']; ?>
                                            </option>
                                            <?php endfor;?>
                                        </select><br/>
                                        <?php else : ?>
                                        &nbsp;
                                        <?php endif;?>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td rowspan="2" colspan="2">
                                        <input type="submit" id="btnAgregarSec" name="btnAgregarSec" value="Nuevo Período" class="btn btn-danger btn-lg btn-block" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Fecha Inicial:
                                        <input type="date" id="txtFechaInicial" name="txtFechaInicial" class="form-control input-lg" value="" placeholder="dd/mm/aaaa"/>
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>
                                        Fecha Final:
                                        <input type="date" id="txtFechaFinal" name="txtFechaFinal" class="form-control input-lg" value="" placeholder="dd/mm/aaaa"/>
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                            <br />
                        </div>
                    </div>
                    <input type="hidden" name="hdEnvio" value="1">
                </form>
            </div>
        </div>
    </div>
</section>