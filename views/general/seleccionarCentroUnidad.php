<section id="" style="background-color: beige;">
    <div class="header-content">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Gesti&oacute;n de Usuarios</h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-home wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>login/inicio">
                                Inicio
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
            <form id="frEstudiantes" method="post" action="<?php echo BASE_URL; ?><?php if (isset($this->url)) echo $this->url; ?>">
                <table>
                    <tr>
                        <td style="width: 10%">
                            <h4>Centro Educativo: </h4>
                        </td>
                        <td style="width: 38%">
                            <select id="slCentros" name="slCentros" class="form-control input-lg">
                            <?php if (isset($this->lstCentros) && count($this->lstCentros)): ?>
                                    <option value="">-- Centro Educativo --</option>
                                    <?php for ($i = 0; $i < count($this->lstCentros); $i++) : ?>
                                        <option value="<?php echo $this->lstCentros[$i]['codigo']; ?>">
                                            <?php echo $this->lstCentros[$i]['nombre']; ?>
                                        </option>
                                    <?php endfor; ?>
                            <?php else : ?>
                                <option value="">-- No existen centros registrados --</option>
                            <?php endif; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 10%">
                            <h4>Unidad Academica: </h4>
                        </td>
                        <td style="width:40%;">
                            <select id="slUnidad" name="slUnidad" class="form-control input-lg">
                                <option value="" disabled>-- Unidad Academica --</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td style="text-align:right;">
                            <input type="submit" id="btnConsultar" value="Consultar" class="btn btn-danger btn-lg btn-warning" disabled>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5"><hr class="hr1"/></td>
                    </tr>
                </table>
                <input type="hidden" id ="hdCentroUnidad" name="hdCentroUnidad" >
            </form>
        </div>
    </div>
</section>