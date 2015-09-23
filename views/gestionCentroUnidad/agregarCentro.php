<section id="" style="background-color: beige;">
    <div class="header">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Agregar Centro Universitario</h2>
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
            <form id="frCentros" method="post" action="<?php echo BASE_URL; ?>gestionCentroUnidad/agregarCentro">
                <table class="text-primary" style="width: 100%;">
                    <tr>
                        <td colspan="3"><br/>Nombre:
                            <input type="text" name="txtNombreCen" id="txtNombreCen" class="form-control input-lg" value=""/>
                        </td>
                        <td>&nbsp;</td>
                        <td><br/>C&oacute;digo:
                            <input type="number" name="txtCodigo" id="txtCodigo" class="form-control input-lg" value=""/>
                        </td>
                    <tr>
                        <td colspan="3"><br/>Direcci&oacute;n:
                            <select id="slDeptos" name="slDeptos" class="form-control input-lg">
                                <?php if(isset($this->lsDeptos) && count($this->lsDeptos)): ?>
                                    <option value="">(Seleccione un Departamento)*</option>
                                    <?php for($i =0; $i < count($this->lsDeptos); $i++) : ?>
                                    <option value="<?php echo $this->lsDeptos[$i]['codigo'];?>">
                                        <?php echo $this->lsDeptos[$i]['nombre']; ?>
                                    </option>
                                    <?php endfor;?>
                                <?php else : ?>
                                    <option value="">- No hay informaci&oacute;n disponible -</option>
                                <?php endif;?>
                            </select>
                        </td>
                        <td style="width: 2%">&nbsp;</td>
                        <td style="width: 23%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <select id="slMunis" name="slMunis" class="form-control input-lg">
                                <option value="" disabled>(Seleccione un Municipios)*</option>
                            </select>
                        </td>
                        <td>&nbsp;</td>
                        <td>
                            <input type="submit" id="btnAgregar" name="btnAgregar" value="Agregar" class="btn btn-warning btn-lg btn-block">
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 53%">
                            <input id="txtDireccion" name="txtDireccion" type="text" class="form-control input-lg" value="" placeholder="Ejemplo: 5ta calle 1-20" style="width:98%"/>
                        </td>
                        <td style="width: 2%">&nbsp;</td>
                        <td style="width: 20%">
                            <input id="txtZona" name="txtZona" type="number" min="0" max="27" class="form-control input-lg" value="" placeholder="Zona"/>
                        </td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
                <input type="hidden" name="hdEnvio" value="1">
            </form>
        </div>
    </div>
    <br/>
    <div class="container">
        <div class="row">
            <form id="frFile" name="frFile" method='post' enctype="multipart/form-data" action='<?php echo BASE_URL; ?>gestionCentroUnidad/cargaCentroCSV'>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <p class="text-muted">Puedes cargar un archivo con centros universitarios y procesarlo</p>
                        <div class="fileUpload btn btn-warning" >
                            <span>Procesar archivo .csv</span>
                            <input class="upload" type='submit' style="width: 100%" id="btnCargar" name='btnCargar'>
                        </div>
                        <i class="fa fa-2x fa-forward wow bounceIn text-primary" data-wow-delay=".2s"></i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-file-text wow bounceIn text-primary" data-wow-delay=".1s"></i>
                        <br/>
                        <div id="divcsvFile" class="fileUpload btn btn-warning" >
                            <span>Cargar Archivo</span>
                            <input class="upload" type="file" id="csvFile" name="csvFile"/>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <input type="hidden" id="hdFile" name="hdFile" value="0">
            </form>
        </div>
    </div>
</section>