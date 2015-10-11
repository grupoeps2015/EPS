<head>
    <style type="text/css">
        ul { list-style-type: none;  margin:0; padding: 0; overflow-x: hidden; }
        li { margin: 0; padding: 0; }
        label { display: block; color: WindowText; background-color: Window; margin: 0; padding: 0; width: 100%; }
        label:hover { background-color: Highlight; color: HighlightText; }
    </style>
</head>

<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Asignar Areas Académicas</h2>
                <p><?php if (isset($this->query)) echo $this->query; ?></p> <!-- Aca le digo que muestre query -->
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL ?>gestionPensum/listadoCarrera">
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
                <form id="frCarreras" method="post" action="<?php echo BASE_URL; ?>gestionPensum/asignarAreaCarrera/<?php echo $this->id; ?>">
                    <div id="divEstudiantes" class="form-group" >
                        <div class="col-md-6 col-md-offset-3">
                            <table>
                                <tr>
                                    <td>
                                        <h4>Carrera: </h4>
                                    </td>
                                    <td>
                                        <?php echo $this->datosCar[0]['nombre']; ?>
                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                        <h4 style="margin-right: 16px;">Areas Academicas: </h4>
                                    </td>
                                    <td>
                                        <ul style=" height: 100px; overflow: auto; width: 300px; border: none; background: #ffffff !important;">
                                            <?php if (isset($this->lstAreas) && count($this->lstAreas)): ?>
                                                <?php for ($i = 0; $i < count($this->lstAreas); $i++) : ?>
                                                    <li> <input type="checkbox" name="check_list[]" value="<?php echo $this->lstAreas[$i]['_id']; ?>">
                                                        <?php echo $this->lstAreas[$i]['_nombre']; ?>
                                                    </li>
                                                <?php endfor; ?>
                                            <?php else : ?>
                                                <option value="">-- No existen areas registradas --</option>
                                            <?php endif; ?>

                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        &nbsp;
                                    </td>
                                    <td>
                                        <input type="submit" name="submit" value="Agregar" style="float:right;" class="btn btn-danger btn-lg btn-warning">
                                    </td>
                                </tr>
                            </table>
                            <br/>
                            <h4>Listado de areas asignadas:</h4>
                            <br/>
                            <table id="tbAsignaciones" border="2" align="center">
                                <thead>
                                    <tr>
                                        <th style="text-align:center">Area Academica</th>
                                        <th style="text-align:center">Estado</th>
                                        <th style="text-align:center">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($this->lstCarAreas) && count($this->lstCarAreas)): ?>
                                        <?php for ($i = 0; $i < count($this->lstCarAreas); $i++) : ?>
                                            <tr>
                                                
                                                <td style="text-align: center"><?php echo $this->lstCarAreas[$i]['_nombrecarrera']; ?></td>
                                                <td style="text-align: center"><?php echo $this->lstCarAreas[$i]['_nombrearea']; ?></td>
                                                
                                                <td style="text-align: center;">
                                                    <?php if (strcmp($this->lstCarAreas[$i]['_estado'], '1') == 0): ?>
                                                                              <a href="<?php echo BASE_URL . 'gestionPensum/eliminarCarreraArea/'. $this->id .'/-1/' . $this->lstCarAreas[$i]['_id']; ?>">Eliminar</a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endfor; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <input type="hidden" name="hdEnvio" value="1">
                </form>
                <?php
                ?>
            </div>
        </div>
    </div>
    <br />

</section>