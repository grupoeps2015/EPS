<?php session_start() ?>
<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Actualizar Par&aacute;metro</h2>
                <!--<p><?php if (isset($this->datosPar)) print_r($this->datosPar); ?></p>  ahora le diremos que muestre datosPar -->
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>admCrearParametro">
                                Regresar
                            </a>
                        </i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center">
                    
                </div>
            </div>
        </div>
    </div>

    <div class="header-content">
        <div class="header-content-inner">
            <div id="divCentros" class="row">
                <br/><br/><br/>
                <form id="frParametros" method="post" action="<?php echo BASE_URL; ?>admCrearParametro/actualizarParametro">
                    <div id="divParametros" class="form-group" >
                        <div class="col-md-6 col-md-offset-3">
                            <table align="center">
                                <tr>
                                    <td colspan="3">Nombre:
                                        <input type="text" id="txtNombreParametro" name="txtNombreParametro" class="form-control input-lg" value="<?php if(isset($this->datosPar) && count($this->datosPar)) echo $this->datosPar[0]['nombreparametro']; ?>">
                                        <br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">Valor:
                                        <input type="text" id="txtValorParametro" name="txtValorParametro" class="form-control input-lg" value="<?php if(isset($this->datosPar) && count($this->datosPar)) echo $this->datosPar[0]['valorparametro']; ?>">
                                        <br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">Descripci&oacute;n:
                                        <input type="text" id="txtDescripcionParametro" name="txtDescripcionParametro" class="form-control input-lg" value="<?php if(isset($this->datosPar) && count($this->datosPar)) echo $this->datosPar[0]['descripcionparametro']; ?>">
                                        <br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">Extensi&oacute;n:
                                        <input type="text" id="txtExtensionParametro" name="txtExtensionParametro" class="form-control input-lg" value="<?php if(isset($this->datosPar) && count($this->datosPar)) echo $this->datosPar[0]['extensionparametro']; ?>">
                                        <br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td tyle="width: 45%">
                                        <?php if(isset($this->centro_unidadacademica) && count($this->centro_unidadacademica)): ?>
                                        <select id="slCentroUnidadAcademica" name="slCentroUnidadAcademica" class="form-control input-lg">
                                           <option value="">- Centro - Unidad acad&eacute;mica -</option>
                                            <?php for($i =0; $i < count($this->centro_unidadacademica); $i++) : ?>   
                                                <?php if($this->centro_unidadacademica[$i]['centro_unidadacademica'] == $this->datosPar[0]['centrounidadacademica']): ?>
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
                                    <td>&nbsp;</td>
                                    <td>
                                    <select id="slCarreras" name="slCarreras" class="form-control input-lg">
                                        <option value="">- Carrera -</option>
                                    </select>
                                    </td>
                                </tr>    
                                 <tr>
                                    <td tyle="width: 45%">
                                        <br/>
                                        <?php if(isset($this->tipoparametro) && count($this->tipoparametro)): ?>
                                        <select id="slTipoParametro" name="slTipoParametro" class="form-control input-lg">
                                            <option value="">- Tipo par&aacute;metro -</option>
                                            <?php for($i =0; $i < count($this->tipoparametro); $i++) : ?>
                                            <?php if($this->tipoparametro[$i]['tipoparametro'] == $this->datosPar[0]['tipoparametro']): ?>
                                            <option value="<?php echo $this->tipoparametro[$i]['tipoparametro'];?>" selected>
                                                <?php echo $this->tipoparametro[$i]['nombretipoparametro']; ?>
                                            </option>
                                            <?php else : ?>
                                            <option value="<?php echo $this->tipoparametro[$i]['tipoparametro'];?>">
                                                <?php echo $this->tipoparametro[$i]['nombretipoparametro']; ?>
                                            </option>
                                            <?php endif;?>
                                            <?php endfor;?>
                                        </select>
                                        <?php else : ?>
                                        &nbsp;
                                        <?php endif;?>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <br/>
                                        <input type="hidden" id="idCarrera" name="idCarrera" value=<?php echo $this->datosPar[0]['carrera'] ?>>
                                        <input type="submit" id="btnActualizarParametro" name="btnActualizar" value="Actualizar" class="btn btn-danger btn-lg btn-block">
                                    </td>
                                </tr>
                            </table>
                            <br />
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <br />

    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-building wow bounceIn text-primary"></i>
                    <h3>Gesti&oacute;n de edificios</h3>
                    <p class="text-muted">Capacidad de salones y gestion de uso</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-mortar-board wow bounceIn text-primary"></i>
                    <h3>Gesti&oacute;n de Unidades Acad&eacute;micas</h3>
                    <p class="text-muted">Faculades, Escuelas y Centros Regionales</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-group wow bounceIn text-primary" data-wow-delay=".1s"></i>
                    <h3>Gesti&oacute;n de personal</h3>
                    <p class="text-muted">Directores, Control Academico, Catedraticos</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box">
                    <i class="fa fa-4x fa-pencil wow bounceIn text-primary" data-wow-delay=".2s"></i>
                    <h3>Gesti&oacute;n de estudiantes</h3>
                    <p class="text-muted">Alumnos regulares</p>
                </div>
            </div>
        </div>
    </div>
</section>
