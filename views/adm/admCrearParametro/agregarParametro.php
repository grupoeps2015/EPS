<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Agregar Par&aacute;metro</h2>
                <p><?php if(isset($this->query)) echo $this->query; ?></p>
                <hr class="primary">
            </div>
        </div>
    </div>

    <div class="header-content">
        <div class="header-content-inner">
                 <br/><br/><br/>
                <form id="frParametros" method="post" action="<?php echo BASE_URL; ?>admCrearParametro/agregarParametro">
                    <div id="divParametros" class="form-group" >
                        <div class="col-md-6 col-md-offset-3">
                            <table>
                                <tr>
                                    <td>*Nombre
                                        <input type="text" id="txtNombreParametro" name="txtNombreParametro" class="form-control input-lg" value="<?php if(isset($this->datos['txtNombreParametro'])) echo $this->datos['txtNombreParametro']?>">
                                        <br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>*Valor
                                        <input type="text" id="txtValorParametro" name="txtValorParametro" class="form-control input-lg" value="<?php if(isset($this->datos['txtValorParametro'])) echo $this->datos['txtValorParametro']?>">
                                        <br/>
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td>*Descripci&oacute;n
                                        <input type="text" id="txtDescripcionParametro" name="txtDescripcionParametro" class="form-control input-lg" value="<?php if(isset($this->datos['txtDescripcionParametro'])) echo $this->datos['txtDescripcionParametro']?>">
                                        <br/>
                                    </td>  
                                </tr>
                                <tr>
                                    <td>*Extensi&oacute;n     
                                        <input type="number" id="txtExtensionParametro" name="txtExtensionParametro" class="form-control input-lg" value="<?php if(isset($this->datos['txtExtensionParametro'])) echo $this->datos['txtExtensionParametro']?>">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                 <tr>
                                    <td tyle="width: 45%">
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
                                    <td>&nbsp;</td>
                                    <td>
                                    <select id="slCarreras" name="slCarreras" class="form-control input-lg">
                                        <option value="" disabled>- Carrera -</option>
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
                                            <option value="<?php echo $this->tipoparametro[$i]['tipoparametro'];?>">
                                                <?php echo $this->tipoparametro[$i]['nombretipoparametro']; ?>
                                            </option>
                                            <?php endfor;?>
                                        </select>
                                        <?php else : ?>
                                        &nbsp;
                                        <?php endif;?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td rowspan="2" colspan="2">
                                        <br/>                                        
                                        <input type="submit" id="btnAgregarParametro" name="btnAgregarParametro" value="Nuevo Parámetro" class="btn btn-danger btn-lg btn-warning" disabled>
                                    </td>
                                </tr>                                
                            </table>
                            <br />
                        </div>
                    </div>
                    </form>  
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
    