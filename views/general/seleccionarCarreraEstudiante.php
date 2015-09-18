<section id="" style="background-color: beige;">
    <div class="header-content">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Selecci&oacute;n de Carrera</h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
            </div>
        </div>
    </div>
    <br/>
    
    <div class="container" >
        <div class="col-md-6 col-md-offset-3">
            <form id="frEstudiantes" method="post" action="<?php echo BASE_URL; ?>general/seleccionarCarreraEstudiante">
                <table>
                    <tr>
                        <td style="width: 10%">
                            <h4>Carrera: </h4><br />
                        </td>
                        <td style="width: 38%">
                            <select id="slCarreras" name="slCarreras" class="form-control input-lg">
                            <?php if (isset($this->lstCarreras) && count($this->lstCarreras)): ?>
                                    <option value="">-- Carrera --</option>
                                    <?php for ($i = 0; $i < count($this->lstCarreras); $i++) : ?>
                                        <option value="<?php echo $this->lstCarreras[$i]['codigo']; ?>">
                                            <?php echo $this->lstCarreras[$i]['nombre']; ?>
                                        </option>
                                    <?php endfor; ?>
                            <?php else : ?>
                                <option value="">-- No existen carreras registrados --</option>
                            <?php endif; ?>
                            </select><br />
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td style="text-align:right;">
                            <input type="submit" id="btnConsultar" value="Seleccionar" class="btn btn-danger btn-lg btn-warning" disabled>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5"><hr class="hr1"/></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</section>