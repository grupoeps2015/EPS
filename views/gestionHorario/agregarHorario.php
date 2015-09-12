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
                            <a href="<?php echo BASE_URL?>gestionHorario/index/<?php echo $this->parametros; ?>">
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
                                        <?php if(isset($this->catedraticos) && count($this->catedraticos)): ?>
                                        <select id="slCatedraticos" name="slCatedraticos" class="form-control input-lg">
                                            <?php for($i =0; $i < count($this->catedraticos); $i++) : ?>
                                            <option value="<?php echo $this->catedraticos[$i]['id'];?>">
                                                <?php echo $this->catedraticos[$i]['registro']." - "; ?>
                                                <?php if($this->catedraticos[$i]['primernombre'] != ""){echo $this->catedraticos[$i]['primernombre']." ";} ?>
                                                <?php if($this->catedraticos[$i]['segundonombre'] != ""){echo $this->catedraticos[$i]['segundonombre']." ";} ?>
                                                <?php if($this->catedraticos[$i]['primerapellido'] != ""){echo $this->catedraticos[$i]['primerapellido']." ";} ?>
                                                <?php if($this->catedraticos[$i]['segundoapellido'] != ""){echo $this->catedraticos[$i]['segundoapellido']." ";} ?>
                                                <?php echo "- ".$this->catedraticos[$i]['tipodocente']; ?>
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
                                        *Día:     
                                        <?php if(isset($this->dias) && count($this->dias)): ?>
                                        <select id="slDias" name="slDias" class="form-control input-lg">
                                            <?php for($i =0; $i < count($this->dias); $i++) : ?>
                                            <option value="<?php echo $this->dias[$i]['codigo'];?>">
                                                <?php echo $this->dias[$i]['nombre']; ?>
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
                                    <td>*Hora inicio:
                                        <input type="text" id="txtHoraInicial" name="txtHoraInicial" class="form-control input-lg" value="" style="text-align:right">
                                        <br/>
                                    </td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" id="txtMinutoInicial" name="txtMinutoInicial" class="form-control input-lg" value="">
                                    </td>    
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>*Hora fin:
                                        <input type="text" id="txtHoraFinal" name="txtHoraFinal" class="form-control input-lg" value="" style="text-align:right">
                                        <br/>
                                    </td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" id="txtMinutoFinal" name="txtMinutoFinal" class="form-control input-lg" value="">
                                    </td>    
                                    <td>&nbsp;</td>
                                    <td rowspan="2" colspan="2">
                                        <input type="submit" id="btnAgregarHor" name="btnAgregarHor" value="Nuevo Horario" class="btn btn-danger btn-lg btn-block">
                                    </td>
                                </tr>
                                <tr>
                                    <td>*Edificio:
                                        <?php if(isset($this->edificios) && count($this->edificios)): ?>
                                        <select id="slEdificios" name="slEdificios" class="form-control input-lg">
                                            <option value="">-- Edificio --</option>
                                            <?php for($i =0; $i < count($this->edificios); $i++) : ?>
                                            <option value="<?php echo $this->edificios[$i]['id'];?>">
                                                <?php echo $this->edificios[$i]['nombre']; ?>
                                            </option>
                                            <?php endfor;?>
                                        </select><br/>
                                        <?php else : ?>
                                        &nbsp;
                                        <?php endif;?>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>
                                        *Salón:
                                        <select id="slSalones" name="slSalones" class="form-control input-lg">
                                            <option value="" disabled>-- Salón --</option>
                                        </select><br/>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                            <br />
                        </div>
                    </div>
                    <input type="hidden" name="hdEnvio" value="1">
                    <input type="hidden" name='slSec' value="<?php if(isset($this->idcurso)) echo $this->idcurso;?>"/>
                    <input type="hidden" name='hdSeccion' value="<?php if(isset($this->curso)) echo $this->curso;?>"/>
                    <input type="hidden" name='hdCentroUnidad' value="<?php if(isset($this->id)) echo $this->id;?>"/>
                    <input type="hidden" name='slCiclo' value="<?php if(isset($this->idciclo)) echo $this->idciclo;?>"/>
                </form>
            </div>
        </div>
    </div>
</section>