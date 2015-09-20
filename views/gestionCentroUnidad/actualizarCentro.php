<section id="" style="background-color: beige;">
    <div class="header">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Actualizar Centro Universitario</h2>
                <span class="text-success"><?php if(isset($this->exito)) echo $this->exito; ?></span>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>gestionCentroUnidad">
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
        <div class="col-md-6 col-md-offset-3">
            <form id="frCentros" method="post" action="<?php echo BASE_URL; ?>gestionCentroUnidad/actualizarCentro/<?php echo $this->id;?>">
                <table class="text-primary" style="width: 100%;">
                    <tr>
                        <td colspan="3"><br/>Nombre:
                            <input type="text" name="txtNombreCen" id="txtNombreCen" class="form-control input-lg" value="<?php if(isset($this->datosCentro)) echo $this->datosCentro[0]['nombre'] ?>"/>
                        </td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    <tr>
                        <td colspan="3"><br/>Direcci&oacute;n:
                            <select id="slDeptos" name="slDeptos" class="form-control input-lg">
                                <?php if(isset($this->lsDeptos) && count($this->lsDeptos)): ?>
                                    <option value="">(Seleccione un Departamento)*</option>
                                    <?php for($i =0; $i < count($this->lsDeptos); $i++) : ?>
                                        <?php if($this->lsDeptos[$i]['codigo'] == $this->datosCentro[0]['departamento']): ?>
                                        <option value="<?php echo $this->lsDeptos[$i]['codigo'];?>" selected>
                                            <?php echo $this->lsDeptos[$i]['nombre']; ?>
                                        </option>
                                        <?php else: ?>
                                        <option value="<?php echo $this->lsDeptos[$i]['codigo'];?>">
                                            <?php echo $this->lsDeptos[$i]['nombre']; ?>
                                        </option>
                                        <?php endif;?>
                                    <?php endfor;?>
                                <?php else : ?>
                                    <option value="">- No hay informaci&oacute;n disponible -</option>
                                <?php endif;?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <select id="slMunis" name="slMunis" class="form-control input-lg">
                                <option value="" disabled>(Seleccione un Municipios)*</option>
                            </select>
                            <input type="hidden" id="hdMunicipio" name="hdMunicipio" value="<?php if(isset($this->datosCentro)) echo $this->datosCentro[0]['municipio'] ?>">
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="width: 53%">
                            <input id="txtDireccion" name="txtDireccion" type="text" class="form-control input-lg" placeholder="Ejemplo: 5ta calle 1-20" value="<?php if(isset($this->datosCentro)) echo $this->datosCentro[0]['direccion'] ?>" style="width:98%"/>
                        </td>
                        <td style="width: 2%">&nbsp;</td>
                        <td style="width: 20%">
                            <input id="txtZona" name="txtZona" type="number" min="0" max="27" class="form-control input-lg" value="<?php if(isset($this->datosCentro)) echo $this->datosCentro[0]['zona'] ?>" placeholder="Zona"/>
                        </td>
                        <td style="width: 2%">&nbsp;</td>
                        <td style="width: 23%">
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><br/>
                            <input type="submit" id="btnActualizar" name="btnActualizar" value="Actualizar" class="btn btn-warning btn-lg btn-block">
                        </td>
                    </tr>
                </table>
                <input type="hidden" name="hdEnvio" value="1">
            </form>
        </div>
    </div>
    <br/>
</section>