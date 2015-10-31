<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Cursos asignados</h2>
                <p><?php if(isset($this->query)) echo $this->query; ?></p>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL; ?><?php if(isset($_SESSION["rol"])){if($_SESSION["rol"] == ROL_ESTUDIANTE){echo "estudiante";} else if($_SESSION["rol"] == ROL_DOCENTE){echo "catedratico";}else{echo "login";}} ;?>/inicio">
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
            <form id="frEstudiantes" method="post" action="<?php echo BASE_URL; ?>asignacion/boletaAsignacion">
                <table style="width:100%">
                    <tr>
                        <td style="width:50%">
                            A&ntilde;o:
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
                            </select><br/>
                        </td>
                        <td>&nbsp;</td>
                        <td style="width:50%">
                            Ciclo:
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
                            </select><br/>
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align:right;">
                            <input type="submit" id="btnConsultar" value="Consultar" class="btn btn-danger btn-lg btn-warning" disabled>
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <input type="hidden" name="hdEnvio" value="1">
                </table>
            </form>
            </div>
            <div class="col-md-8 col-md-offset-2">
            <?php if(isset($this->asignacion)) :?>
                <br />
                <table id="tbBoleta" border="2">
                    <thead>
                        <tr>
                            <th style="text-align:center">Código</th>
                            <th style="text-align:center">Nombre</th>
                            <th style="text-align:center">Sección</th>
                            <th style="text-align:center">Día</th>
                            <th style="text-align:center">Inicio</th>
                            <th style="text-align:center">Fin</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($this->lstPar) && count($this->lstPar)): ?>
                        <?php for($i =0; $i < count($this->lstPar); $i++) : ?>
                        <tr>
                            <td style="text-align: center;"><?php echo $this->lstPar[$i]['codigocurso']; ?></td>
                            <td style="text-align: center;"><?php echo $this->lstPar[$i]['nombrecurso']; ?></td>
                            <td style="text-align: center;"><?php echo $this->lstPar[$i]['nombreseccion']; ?></td>
                            <td style="text-align: center"><?php echo $this->lstPar[$i]['nombredia']; ?></td>
                            <td style="text-align: center;"><?php echo $this->lstPar[$i]['inicio']; ?></td>
                            <td style="text-align: center"><?php echo $this->lstPar[$i]['fin']; ?></td>
                        </tr>
                        <?php endfor;?>
                    <?php endif;?> 
                    </tbody>
                </table>
                <br />
                <center>
                <h4 style="color: red">ID de boleta de asignación: <span style="color: black">[<?php echo $this->asignacion?>]</span></h4>
                <h4 style="color: blue">Fecha y hora: <span style="color: black"><?php echo $this->fecha . " " . $this->hora?></span></h4>
                </center>
            <?php else : ?>
                <center>
            <h4>No hay registro de asignación para el ciclo seleccionado.</h4>
            </center>
            <?php endif; ?>
        </div>
    </div>
    <br/>
</section>