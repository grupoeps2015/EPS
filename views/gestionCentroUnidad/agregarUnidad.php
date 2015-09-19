<section id="" style="background-color: beige;">
    <div class="header">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Agregar Unidad Acad&eacute;mica</h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>gestionCentroUnidad/listadoUnidades/<?php echo $this->id; ?>">
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
            <form id="frUnidad" method="post" action="<?php echo BASE_URL; ?>gestionCentroUnidad/agregarUnidad/<?php $this->id;?>">
                <table class="text-primary" style="width: 100%;">
                    <tr>
                        <td colspan="5" class="text-info">
                            <span>Active la opci&oacute;n de <b>Unidad Superior</b> si va a crear una Unidad Acad&eacute;mica que sea parte de otra ya existente</span>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            Unidad Superior&nbsp;<input type="checkbox" id="cbTienePadre" name="cbTienePadre" value="100"/>
                        </td>
                        <td>&nbsp;</td>
                        <td colspan="2">
                            <select id="slExistentes" name="slExistentes" class="form-control input-lg" disabled>
                                <?php if(isset($this->lsExistentes) && count($this->lsExistentes)): ?>
                                    <option value="NULL">(Unidad Acad&eacutemica)</option>
                                    <?php for($i =0; $i < count($this->lsExistentes); $i++) : ?>
                                    <option value="<?php echo $this->lsExistentes[$i]['codigo'];?>">
                                        <?php echo $this->lsExistentes[$i]['nombre']; ?>
                                    </option>
                                    <?php endfor;?>
                                <?php else : ?>
                                    <option value="NULL">- No hay informaci&oacute;n disponible -</option>
                                <?php endif;?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4"><hr class="hr1"/></td>
                    </tr>
                    <tr>
                        <td align="center" colspan="5" class="text-primary">
                            <b>Informaci&oacute;n General</b>
                        </td>
                    </tr>
                    <tr>
                        <td>C&oacute;digo:</td>
                        <td>&nbsp;</td>
                        <td colspan="3">
                            <input type="number" name="txtCodigoUni" id="txtCodigoUni" class="form-control input-lg" value=""/>
                        </td>
                    </tr>
                    <tr>
                        <td>Nombre:</td>
                        <td>&nbsp;</td>
                        <td colspan="3">
                            <input type="text" name="txtNombreUni" id="txtNombreUni" class="form-control input-lg" value=""/>
                        </td>
                    </tr>
                    <tr>
                        <td>Tipo Unidad Acad&eacute;mica:</td>
                        <td>&nbsp;</td>
                        <td colspan="3">
                            <select id="slTipos" name="slTipos" class="form-control input-lg">
                                <?php if(isset($this->lsTipos) && count($this->lsTipos)): ?>
                                    <option value="">(Seleccione un Tipo)*</option>
                                    <?php for($i =0; $i < count($this->lsTipos); $i++) : ?>
                                    <option value="<?php echo $this->lsTipos[$i]['codigo'];?>">
                                        <?php echo $this->lsTipos[$i]['nombre']; ?>
                                    </option>
                                    <?php endfor;?>
                                <?php else : ?>
                                    <option value="">- No hay informaci&oacute;n disponible -</option>
                                <?php endif;?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan="3" align="center"><br/>
                            <input type="submit" id="btnAgregar" name="btnAgregar" value="Agregar" class="btn btn-danger btn-lg btn-block" style="width: 60%">
                        </td>
                    </tr>
                </table>
                <input type="hidden" name="hdEnvio" value="1">
            </form>
        </div>
        <div class="col-md-6 col-md-offset-1">
            
        </div>
    </div>
    <br/>
    
    <div class="container" style="display:none;">
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
                        <p>&nbsp;<br/>&nbsp;</p>
                        <div id="divcsvFile" class="fileUpload btn btn-warning" >
                            <span>Cargar Archivo</span>
                            <input class="upload" type="file" id="csvFile" name="csvFile"/>
                        </div>
                        <i class="fa fa-3x fa-file-text wow bounceIn text-primary" data-wow-delay=".1s"></i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <input type="hidden" id="hdFile" name="hdFile" value="0">
            </form>
        </div>
    </div>
</section>