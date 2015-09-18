<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Actualizar Asignaci&oacute;n de Edificios</h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>gestionEdificio/gestionEdificio/<?php echo $this->idEdificio; ?>">
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
                <form id="frAsignacion" method="post" action="<?php echo BASE_URL; ?>gestionEdificio/actualizarAsignacion/<?php echo $this->id; ?>/<?php echo $this->idEdificio; ?>">
                    <div id="divEstudiantes" class="form-group" >
                        <div class="col-md-6 col-md-offset-3">
                            <table class="text-primary table-hover">
                                <tr>
                                    <td colspan="7">Centro Unidad:   
                                                <?php if(isset($this->centro_unidadacademica) && count($this->centro_unidadacademica)): ?>
                                            <select id="slCentroUnidadAcademica" name="slCentroUnidadAcademica" class="form-control input-lg">
                                               <option value="">- Centro - Unidad acad&eacute;mica -</option>
                                                <?php for($i =0; $i < count($this->centro_unidadacademica); $i++) : ?>   
                                                    <?php if($this->centro_unidadacademica[$i]['centro_unidadacademica'] == $this->datosAsig[0]['centro_unidadacademica']): ?>
                                               <option value="<?php echo $this->centro_unidadacademica[$i]['centro_unidadacademica'];?>" selected="selected">
                                                             <?php echo $this->centro_unidadacademica[$i]['nombrecentro']; echo " - "; echo $this->centro_unidadacademica[$i]['nombreunidadacademica'];?>
                                                         </option>
                                                    <?php else : ?>
                                                         <option value="<?php echo $this->centro_unidadacademica[$i]['centro_unidadacademica'];?>">
                                                             <?php echo $this->centro_unidadacademica[$i]['nombrecentro']; echo " - "; echo $this->centro_unidadacademica[$i]['nombreunidadacademica'];?>
                                                         </option>
                                                <?php endif;?>
                                                <?php endfor;?>
                                            </select>
                                            <?php else : ?>
                                            &nbsp;
                                            <?php endif;?>
                                    </td>
                                    <td>&nbsp;&nbsp;Jornada:
                                        <?php if (isset($this->jornadas) && count($this->jornadas)): ?>
                                            &nbsp;&nbsp;<select id="slJornadas" name="slJornadas" class="form-control input-lg">
                                                <option value="">(Jornadas)
                                                </option>
                                                <?php for ($i = 0; $i < count($this->jornadas); $i++) : ?>
                                                    <?php if($this->jornadas[$i]['codigo'] == $this->datosAsig[0]['jornada']): ?>
                                                        <option value="<?php echo $this->jornadas[$i]['codigo']; ?>" selected="selected">
                                                            <?php echo $this->jornadas[$i]['nombre']; ?>
                                                        </option>
                                                    <?php else : ?>
                                                        <option value="<?php echo $this->jornadas[$i]['codigo']; ?>">
                                                        <?php echo $this->jornadas[$i]['nombre']; ?>
                                                    </option>
                                                    <?php endif;?>
                                                <?php endfor; ?>
                                            </select>
                                        <?php else : ?>
                                            <input type="text" id="txtJornadas" name="txtjornadas" class="form-control input-lg" value="-">
                                            <br/>
                                        <?php endif; ?>                                            
                                    </td>                                    
                                    <td><br/></td>
                                    
                                </tr>
                                <tr>
                                  
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