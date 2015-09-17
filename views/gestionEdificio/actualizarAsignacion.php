<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Actualizar Horario</h2>
                <p><?php if(isset($this->query)) echo $this->query; ?></p>
                <hr class="primary">
                <h4 class="section-heading text-warning"><?php if(isset($this->curso)) echo $this->curso;?></h4>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>gestionEdificio/gestionEdificio/<?php echo $this->id; ?>">
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
                <form id="frAsignacion" method="post" action="<?php echo BASE_URL; ?>gestionEdificio/actualizarAsignacion/<?php echo $this->id; ?>">
                    <div id="divEstudiantes" class="form-group" >
                        <div class="col-md-6 col-md-offset-3">
                            <table class="text-primary table-hover">
                                <tr>
                                    <td colspan="7">
                                        *Unidad Academica:     
                                        <?php if(isset($this->datosAsig) && count($this->datosAsig)): ?>
                                        <select id="slUnidades" name="slUnidades" class="form-control input-lg">
                                            <option value="">-- Unidad Academica --</option>
                                            <?php for($i =0; $i < count($this->unidades); $i++) : ?>
                                            <option value="<?php echo $this->unidades[$i]['id'];?>" <?php if(isset($this->datosAsig[0]['nombreunidadacademica']) && $this->datosAsig[0]['nombreunidadacademica'] == $this->unidades[$i]['id']) echo 'selected'?>>
                                                <?php echo $this->unidades[$i]['nombre']." - "; ?>
                                            </option>
                                            <?php endfor;?>
                                        </select><br/>
                                        <?php else : ?>
                                        &nbsp;
                                        <?php endif;?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">*Centro:
                                        <?php if(isset($this->datosAsig) && count($this->datosAsig)): ?>
                                        <select id="slCentro" name="slCentro" class="form-control input-lg">
                                            <option value="">-- Centro --</option>
                                            <?php for($i =0; $i < count($this->centros); $i++) : ?>
                                            <option value="<?php echo $this->centros[$i]['id'];?>" <?php if(isset($this->datosAsig[0]['centro']) && $this->datosAsig[0]['centro'] == $this->centros[$i]['id']) echo 'selected'?>>
                                                <?php echo $this->centros[$i]['nombre']; ?>
                                            </option>
                                            <?php endfor;?>
                                        </select><br/>
                                        <?php else : ?>
                                        &nbsp;
                                        <?php endif;?>
                                    </td>
                                    <td>&nbsp;</td>
                                    
                                    <td colspan="3" style="width: 30%;">*Jornada:
                                        <?php if(isset($this->jornadas) && count($this->jornadas)): ?>
                                        <select id="slJornadas" name="slJornadas" class="form-control input-lg">
                                            <option value="">(Seleccione)</option>
                                            <?php for($i =0; $i < count($this->jornadas); $i++) : ?>
                                            <option value="<?php echo $this->jornadas[$i]['codigo'];?>" <?php if(isset($this->datosAsig[0]['jornada']) && $this->datosAsig[0]['jornada'] == $this->jornadas[$i]['codigo']) echo 'selected'?>>
                                                <?php echo $this->jornadas[$i]['nombre']; ?>
                                            </option>
                                            <?php endfor;?>
                                        </select><br/>
                                        <?php else : ?>
                                        &nbsp;
                                        <?php endif;?>
                                    </td>
                                  
                                    <td>&nbsp;</td>
                                    <td colspan="3">
                                        <input type="submit" id="btnActualizarAsig" name="btnActualizarAsig" value="Actualizar" class="btn btn-danger btn-lg btn-block">
                                    </td>
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