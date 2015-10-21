<section id="" style="background-color: beige;">
    <div class="header-content">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Actualizar Par&aacute;metro</h2>
                <hr class="primary">
                
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL ?>gestionParametro">
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
            <form id="frParametros" method="post" action="<?php echo BASE_URL; ?>gestionParametro/actualizarParametro/<?php echo $this->id;?>">
                <div id="divParametros" class="form-group" >
                    <div class="col-md-6 col-md-offset-3">
                        <table style="width:100%">
                             <tr>
                                <td colspan="3">
                                    <?php if(isset($this->centro_unidadacademica) && count($this->centro_unidadacademica)): ?>
                                    <select id="slCentroUnidadAcademica" name="slCentroUnidadAcademica" class="form-control input-lg" disabled>
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
                                    <br/>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"> 
                                    <select id="slCarreras" name="slCarreras" class="form-control input-lg" disabled>
                                        <option value="">- Carrera -</option>
                                    </select>
                                    <br/>
                                </td>
                            </tr>
                            <tr>
                                <td>Nombre:&nbsp;</td>
                                <td colspan="2">
                                    <input type="text" id="txtNombreParametro" name="txtNombreParametro" class="form-control input-lg" value="<?php if(isset($this->datosPar) && count($this->datosPar)) echo $this->datosPar[0]['nombreparametro']; ?>" disabled>
                                    <br/>
                                </td>
                            </tr>
                            <tr>
                                <td>Valor:&nbsp;</td>
                                <td colspan="2">
                                    <?php if(isset($this->datosPar) && count($this->datosPar) && $this->datosPar[0]['codigoparametro'] == CONS_PARAM_CENTROUNIDAD_TIPOCICLO) : ?>
                                        <select id="txtValorParametro" name="txtValorParametro" class="form-control input-lg">
                                        <?php if (isset($this->lsTipoCiclo) && count($this->lsTipoCiclo)): ?>
                                                <option value="">-- Tipo Ciclo --</option>
                                                <?php for ($i = 0; $i < count($this->lsTipoCiclo); $i++) : ?>
                                                    <option value="<?php echo $this->lsTipoCiclo[$i]['codigo']; ?>" <?php if($this->lsTipoCiclo[$i]['codigo'] == $this->datosPar[0]['valorparametro']) echo "selected"; ?>>
                                                        <?php echo $this->lsTipoCiclo[$i]['nombre']; ?>
                                                    </option>
                                                <?php endfor; ?>
                                        <?php else : ?>
                                            <option value="">-- No existen tipos registrados --</option>
                                        <?php endif; ?>
                                        </select>
                                    <?php else : ?>
                                        <input type="text" id="txtValorParametro" name="txtValorParametro" class="form-control input-lg" value="<?php if(isset($this->datosPar) && count($this->datosPar)) echo $this->datosPar[0]['valorparametro']; ?>">
                                    <?php endif; ?>
                                    <br/>
                                </td>
                            </tr>
                            <tr>
                                <td>Tipo:&nbsp;</td> 
                                <td colspan="2">
                                    <?php if(isset($this->tipoparametro) && count($this->tipoparametro)): ?>
                                    <select id="slTipoParametro" name="slTipoParametro" class="form-control input-lg" disabled>
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
                                    <br/>
                                </td>
                            </tr>
                            <tr>
                                <td>C&oacute;digo:&nbsp;</td>
                                <td colspan="2">
                                    <input type="text" id="txtCodigoParametro" name="txtCodigoParametro" class="form-control input-lg" value="<?php if(isset($this->datosPar) && count($this->datosPar)) echo $this->datosPar[0]['codigoparametro']; ?>" disabled>
                                    <br/>
                                </td>
                            </tr>
                            <tr>
                                <td>Descripci&oacute;n:&nbsp;</td>
                                <td colspan="2">
                                    <textarea id="txtDescripcionParametro" name="txtDescripcionParametro" class="form-control input-lg" rows="3" style="resize: none;" disabled><?php if(isset($this->datosPar) && count($this->datosPar)) echo $this->datosPar[0]['descripcionparametro']; ?></textarea>
                                    <br/>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>
                                    <input type="hidden" id="idCarrera" name="idCarrera" value=<?php echo $this->datosPar[0]['carrera'] ?>>
                                    <input type="submit" id="btnActualizarParametro" name="btnActualizar" value="Actualizar" class="btn btn-danger btn-lg btn-block" style="width:60%">
                                </td>
                            </tr>
                        </table>
                        <input type="hidden" name="hdEnvio" value="1" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>