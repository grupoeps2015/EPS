<section id="" style="background-color: beige;">
    <div class="header-content">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Agregar Par&aacute;metro</h2>
                <hr class="primary">
                
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>gestionParametro">
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
        <form id="frParametros" method="post" action="<?php echo BASE_URL; ?>gestionParametro/agregarParametro">
            <div id="divParametros" class="form-group" >
                <div class="col-md-6 col-md-offset-3">
                    <table style="text-align:center;">
                        <tr>
                            <td colspan="2">
                                <?php if(isset($this->centro_unidadacademica) && count($this->centro_unidadacademica)): ?>
                                <select id="slCentroUnidadAcademica" name="slCentroUnidadAcademica" class="form-control input-lg">
                                   <option value="">- Centro - Unidad acad&eacute;mica -</option>
                                    <?php for($i =0; $i < count($this->centro_unidadacademica); $i++) : ?>
                                    <option value="<?php echo $this->centro_unidadacademica[$i]['centro_unidadacademica'];?>">
                                        <?php echo $this->centro_unidadacademica[$i]['nombrecentro']; echo " - "; echo $this->centro_unidadacademica[$i]['nombreunidadacademica'];?>
                                    </option>
                                    <?php endfor;?>
                                </select>
                                <?php else : ?>
                                &nbsp;
                                <?php endif;?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                &nbsp;
                                <select id="slCarreras" name="slCarreras" class="form-control input-lg">
                                    <option value="" disabled>- Carrera -</option>
                                </select>
                                <br/>
                            </td>
                        </tr>
                        <tr>
                            <td>*Nombre:&nbsp;</td>
                            <td style="width:80%">
                                <input type="text" id="txtNombreParametro" name="txtNombreParametro" class="form-control input-lg" value=""/>
                                <br/>
                            </td>
                        </tr>
                        <tr>
                            <td>*Valor:&nbsp;</td>
                            <td>
                                <input type="text" id="txtValorParametro" name="txtValorParametro" class="form-control input-lg" value=""/>
                                <br/>
                            </td>                                    
                        </tr>
                        <tr>
                            <td>*Descripci&oacute;n:&nbsp;</td>
                            <td>
                                <input type="text" id="txtDescripcionParametro" name="txtDescripcionParametro" class="form-control input-lg" value=""/>
                                <br/>
                            </td>
                        </tr>
                        <tr>
                            <td>*C&oacute;digo:&nbsp;</td>
                            <td>
                                <input type="text" id="txtCodigoParametro" name="txtCodigoParametro" class="form-control input-lg" value="">
                                <br/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php if(isset($this->tipoparametro) && count($this->tipoparametro)): ?>
                                <select id="slTipoParametro" name="slTipoParametro" class="form-control input-lg">
                                    <option value="">- Tipo par&aacute;metro -</option>
                                    <?php for($i =0; $i < count($this->tipoparametro); $i++) : ?>
                                    <option value="<?php echo $this->tipoparametro[$i]['tipoparametro'];?>">
                                        <?php echo $this->tipoparametro[$i]['nombretipoparametro']; ?>
                                    </option>
                                    <?php endfor;?>
                                </select>
                                <?php else : ?>
                                &nbsp;
                                <?php endif;?>
                                <br/>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td style="text-align:center;">
                                
                            </td><input type="submit" id="btnAgregarParametro" name="btnAgregarParametro" value="Nuevo Parámetro" class="btn btn-danger btn-lg btn-block" style="width:75%">
                        </tr>
                    </table>
                    <input type="hidden" name="hdEnvio" value="1" />
                </div>
            </div>
        </form>
    </div>
    
</section>
    