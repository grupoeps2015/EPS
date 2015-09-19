<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Asignaci&oacute;n de cursos</h2>
                <p><?php if(isset($this->query)) echo $this->query; ?></p>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>login/inicio">
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
    <br/>
    <div class="container" >
        <div class="col-md-6 col-md-offset-3">
            <form id="frEstudiantes" method="post" action="<?php echo BASE_URL; ?>asignacion">
                <table>
                    <tr>
                        <td style="width: 10%">
                            <h4>A&ntilde;o: </h4>
                            <br/>
                        </td>
                        <td style="width:40%;">
                            <select id="slAnio" name="slAnio" class="form-control input-lg">
                                <?php if (isset($this->lstAnios) && count($this->lstAnios)): ?>
                                    <option value="">-- A&ntilde;o --</option>
                                    <?php for ($i = 0; $i < count($this->lstAnios); $i++) : ?>
                                        <option value="<?php echo $this->lstAnios[$i]['anio']; ?>" <?php if (isset($this->anio) && $this->lstAnios[$i]['anio'] == $this->anio) echo "selected" ?>>
                                            <?php echo $this->lstAnios[$i]['anio']; ?>
                                        </option>
                                    <?php endfor; ?>
                                <?php else : ?>
                                    <option value="">-- No existen a&ntilde;o registrados --</option>
                                <?php endif; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 10%">
                            <h4>Ciclo: </h4>
                            <br/>
                        </td>
                        <td style="width:40%;">
                            <select id="slCiclo" name="slCiclo" class="form-control input-lg">
                                <?php if (isset($this->lstCiclos) && count($this->lstCiclos)): ?>
                                    <option value="">-- Ciclo --</option>
                                    <?php for ($i = 0; $i < count($this->lstCiclos); $i++) : ?>
                                        <option value="<?php echo $this->lstCiclos[$i]['codigo']; ?>" <?php if (isset($this->ciclo) && $this->lstCiclos[$i]['codigo'] == $this->ciclo) echo "selected" ?>>
                                            <?php echo $this->lstCiclos[$i]['nombre']; ?>
                                        </option>
                                    <?php endfor; ?>
                                <?php else : ?>
                                    <option value="" disabled>-- Ciclo --</option>
                                <?php endif; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td style="text-align:right;">
                            <input type="submit" id="btnConsultar" value="Consultar" class="btn btn-danger btn-lg btn-warning" disabled>
                        </td>
                    </tr>
                    <input type="hidden" name="hdEnvio" value="1">
                </table>
            </form>
            <?php if(isset($this->asignacion)) :?>
            <table id="tabla" name="tabla">
                <thead>
                    <tr>
                        <th><h4>Curso</h4></th>
                        <th><h4>Secci&oacute;n</h4></th>
                        <th width="22">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><select class="clsCurso form-control input-lg"><option>Seleccione</option></select></td>
                        <td><select class="clsSeccion form-control input-lg"><option>Seleccione</option></select></td>
                        <td align="right"><input type="button" value="-" class="clsEliminarFila btn btn-danger btn-lg btn-warning"></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" align="right">
                            <input type="button" value="Agregar curso" class="clsAgregarFila btn btn-danger btn-lg btn-warning">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="right">
                            <input type="submit" id="btnAsignar" value="Asignar" class="btn btn-danger btn-lg btn-warning" disabled>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <?php endif; ?>
        </div>
    </div>
    <br/>
</section>