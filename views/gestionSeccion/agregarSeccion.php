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
                            <a href="<?php echo BASE_URL?>gestionSeccion/index/<?php echo $this->id;?>">
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
                                        <input type="submit" id="btnAgregarSec" name="btnAgregarSec" value="Nueva Sección" class="btn btn-danger btn-lg btn-block" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>*Nombre:
                                        <input type="text" id="txtNombre" name="txtNombre" class="form-control input-lg" value="" />
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>
                                        Descripción:
                                        <input type="text" id="txtDesc" name="txtDesc" class="form-control input-lg" value="" />
                                        <br/>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                            <br />
                        </div>
                    </div>
                    <input type="hidden" name="hdEnvio" value="1">
                    <input type="hidden" name='hdCentroUnidad' value="<?php echo $this->id;?>"/>
                </form>
            </div>
        </div>
    </div>
</section>