<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Agregar Sección</h2>
                <p><?php if(isset($this->query)) echo $this->query; ?></p>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>gestionSeccion">
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
            <div class="row">
                <form id="frSecciones" method="post" action="<?php echo BASE_URL; ?>gestionSeccion/agregarSeccion">
                    <div id="divSecciones" class="form-group" >
                        <div class="col-md-6 col-md-offset-3">
                            <table>
                                <tr>
                                    <td colspan="3">
                                        *Tipo de sección:
                                        <?php if(isset($this->tiposSeccion) && count($this->tiposSeccion)): ?>
                                        <select id="slTiposSeccion" name="slTiposSeccion" class="form-control input-lg">
                                            <?php for($i =0; $i < count($this->tiposSeccion); $i++) : ?>
                                            <option value="<?php echo $this->tiposSeccion[$i]['codigo'];?>">
                                                <?php echo $this->tiposSeccion[$i]['nombre']; ?>
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
                                        *Curso:
                                        <?php if(isset($this->cursos) && count($this->cursos)): ?>
                                        <select id="slCursos" name="slCursos" class="form-control input-lg">
                                            <?php for($i =0; $i < count($this->cursos); $i++) : ?>
                                            <option value="<?php echo $this->cursos[$i]['id'];?>">
                                                <?php echo $this->cursos[$i]['codigo'] . " - " . $this->cursos[$i]['nombre']; ?>
                                            </option>
                                            <?php endfor;?>
                                        </select><br/>
                                        <?php else : ?>
                                        &nbsp;
                                        <?php endif;?>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td rowspan="2" colspan="2">
                                        <input type="submit" id="btnAgregarSec" name="btnAgregarSec" value="Nueva Sección" class="btn btn-danger btn-lg btn-block">
                                    </td>
                                </tr>
                                <tr>
                                    <td>*Nombre:
                                        <input type="text" id="txtNombre" name="txtNombre" class="form-control input-lg" value="<?php if(isset($this->datos['txtNombre'])) echo $this->datos['txtNombre']?>">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>
                                        Descripción:
                                        <input type="text" id="txtDesc" name="txtDesc" class="form-control input-lg" value="<?php if(isset($this->datos['txtDesc'])) echo $this->datos['txtDesc']?>">
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
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
    <br />

<!--    <div class="container">
        <div class="row">
            <form id="frFile" name="frFile" method='post' enctype="multipart/form-data" action='<?php echo BASE_URL; ?>gestionSeccion/cargarCSV'>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <p class="text-muted">Crea multiples secciones utilizando archivos delimitados por comas</p>
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
    </div>-->
</section>