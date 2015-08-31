<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Agregar Curso</h2>
                <p><?php if(isset($this->query)) echo $this->query; ?></p> <!-- Aca le digo que muestre query -->
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>admCrearCurso">
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
                <form id="frCursos" method="post" action="<?php echo BASE_URL; ?>admHistoriaCrearCurso/agregarCurso">
                    <div id="divEstudiantes" class="form-group" >
                        <div class="col-md-6 col-md-offset-3">
                            <table>
                                <tr>
                                    <td>
                                        <?php if(isset($this->tiposCurso) && count($this->tiposCurso)): ?>
                                        <select id="slTiposCurso" name="slTiposCurso" class="form-control input-lg">
                                            <option value="default">---- Seleccione un tipo de curso ----</option>
                                            <?php for($i =0; $i < count($this->tiposCurso); $i++) : ?>
                                            <option value="<?php echo $this->tiposCurso[$i]['codigo'];?>">
                                                <?php echo $this->tiposCurso[$i]['nombre']; ?>
                                            </option>
                                            <?php endfor;?>
                                        </select>
                                        <?php else : ?>
                                        &nbsp;
                                        <?php endif;?>
                                    </td>
                                </tr>
                                <tr>
                                    <td rowspan="2" colspan="2">
                                        <input type="submit" id="btnAgregarEmp" name="btnAgregarEmp" value="Nuevo Empleado" class="btn btn-danger btn-lg btn-block">
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>*Código:
                                        <input type="text" id="txtNombreEst1" name="txtNombreEst1" class="form-control input-lg" value="<?php if(isset($this->datos['txtNombreEst1'])) echo $this->datos['txtNombreEst1']?>">
                                        <br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        *Nombre:
                                        <input type="text" id="txtApellidoEst1" name="txtApellidoEst1" class="form-control input-lg" value="<?php if(isset($this->datos['txtApellidoEst1'])) echo $this->datos['txtApellidoEst1']?>">
                                        <br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        *Traslape:     
                                        <select id="slPerfil" name="slPerfil" class="form-control input-lg">
                                            <option value="0">---- Seleccione una opción ----</option>
                                            <option value="1">Sí</option>
                                            <option value="2">No</option>
                                        </select>
                                        <br/>
                                    </td>
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
    
