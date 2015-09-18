<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Actualizar Sección</h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>gestionCurso/listadoSeccion">
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
                <form id="frSecciones" method="post" action="<?php echo BASE_URL; ?>gestionCurso/actualizarSeccion/<?php echo $this->id; ?>">
                    <div id="divEstudiantes" class="form-group" >
                        <div class="col-md-6 col-md-offset-3">
                            <table>
                                <tr>
                                    <td colspan="3">
                                        *Tipo de sección:
                                        <?php if(isset($this->tiposSeccion) && count($this->tiposSeccion)): ?>
                                        <select id="slTiposSeccion" name="slTiposSeccion" class="form-control input-lg">
                                            <?php for($i =0; $i < count($this->tiposSeccion); $i++) : ?>
                                            <option value="<?php echo $this->tiposSeccion[$i]['codigo'];?>" <?php if(isset($this->datosSec[0]['tiposeccion']) && $this->datosSec[0]['tiposeccion'] == $this->tiposSeccion[$i]['codigo']) echo 'selected'?>>
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
                                            <option value="<?php echo $this->cursos[$i]['id'];?>" <?php if(isset($this->datosSec[0]['curso']) && $this->datosSec[0]['curso'] == $this->cursos[$i]['id']) echo 'selected'?>>
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
                                        <input type="submit" id="btnActualizarSec" name="btnActualizarSec" value="Actualizar" class="btn btn-danger btn-lg btn-block">
                                    </td>
                                </tr>
                                <tr>
                                    <td>*Nombre:
                                        <input type="text" id="txtNombre" name="txtNombre" class="form-control input-lg" value="<?php if(isset($this->datosSec[0]['nombre'])) echo $this->datosSec[0]['nombre']?>" />
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>
                                        Descripción:
                                        <input type="text" id="txtDesc" name="txtDesc" class="form-control input-lg" value="<?php if(isset($this->datosSec[0]['descripcion'])) echo $this->datosSec[0]['descripcion']?>" />
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
</section>