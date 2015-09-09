<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Agregar Horario</h2>
                <p><?php if(isset($this->query)) echo $this->query; ?></p>
                <hr class="primary">
                <h4 class="section-heading"><?php if(isset($this->curso)) echo $this->curso;?></h4>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>gestionHorario">
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
            <div id="divCentros" class="row">
                <form id="frCarreras" method="post" action="<?php echo BASE_URL; ?>gestionHorario/agregarHorario">
                    <div id="divEstudiantes" class="form-group" >
                        <div class="col-md-6 col-md-offset-3">
                             <table>
                                <tr>
                                    <td colspan="3">
                                        *Jornada:
                                        <?php if(isset($this->jornadas) && count($this->jornadas)): ?>
                                        <select id="slJornadas" name="slJornadas" class="form-control input-lg">
                                            <?php for($i =0; $i < count($this->jornadas); $i++) : ?>
                                            <option value="<?php echo $this->jornadas[$i]['codigo'];?>">
                                                <?php echo $this->jornadas[$i]['nombre']; ?>
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
                                    <td>*Tipo período:
                                        <?php if(isset($this->tiposPeriodo) && count($this->tiposPeriodo)): ?>
                                        <select id="slTiposPeriodos" name="slTiposPeriodos" class="form-control input-lg">
                                            <option value="">-- Tipo período --</option>
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
                                    <td>
                                        *Período:
                                        <select id="slPeriodos" name="slPeriodos" class="form-control input-lg">
                                            <option value="" disabled>-- Período --</option>
                                        </select><br/>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        *Catedrático:     
                                        <select id="slTraslape" name="slTraslape" class="form-control input-lg">
                                            <option value="false">No</option>
                                            <option value="true">Sí</option>
                                        </select>
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>*Hora inicio:
                                        <input type="text" id="txtNombre" name="txtNombre" class="form-control input-lg" value="" style="text-align:right">
                                        <br/>
                                    </td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" id="txtNombre" name="txtNombre" class="form-control input-lg" value="">
                                    </td>    
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>*Hora fin:
                                        <input type="text" id="txtNombre" name="txtNombre" class="form-control input-lg" value="" style="text-align:right">
                                        <br/>
                                    </td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" id="txtNombre" name="txtNombre" class="form-control input-lg" value="">
                                    </td>    
                                    <td>&nbsp;</td>
                                    <td rowspan="2" colspan="2">
                                        <input type="submit" id="btnAgregarHor" name="btnAgregarHor" value="Nuevo Horario" class="btn btn-danger btn-lg btn-block">
                                    </td>
                                </tr>
                                <tr>
                                    <td>*Salón:
                                        <input type="text" id="txtCodigo" name="txtCodigo" class="form-control input-lg" value="<?php if(isset($this->datos['txtCodigo'])) echo $this->datos['txtCodigo']?>">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>
                                        *Edificio:
                                        <input type="text" id="txtNombre" name="txtNombre" class="form-control input-lg" value="<?php if(isset($this->datos['txtNombre'])) echo $this->datos['txtNombre']?>">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
<!--                            <table>
                                <tr>
                                    <td colspan="3" width="100%">
                                        *Nombre:
                                        <input type="text" id="txtNombre" name="txtNombre" class="form-control input-lg" value="<?php if(isset($this->datos['txtNombre'])) echo $this->datos['txtNombre']?>">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>
                                        <input type="submit" id="btnAgregarHor" name="btnAgregarHor" value="Nuevo Horario" class="btn btn-danger btn-lg btn-block">
                                    </td>
                                </tr>
                            </table>-->
                            <br />
                        </div>
                    </div>
                    <input type="hidden" name="hdEnvio" value="1">
                </form>
            </div>
        </div>
    </div>
</section>