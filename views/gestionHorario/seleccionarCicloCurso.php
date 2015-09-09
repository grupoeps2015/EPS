<section id="" style="background-color: beige;">
    <div class="header-content">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Selecci&oacute;n de Ciclo</h2>
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
            <form id="frEstudiantes" method="post" action="<?php echo BASE_URL; ?>gestionHorario">
                <table>
                    <tr>
                        <td style="width: 10%">
                            <h4>Tipo Ciclo: </h4>
                            <br/>
                        </td>
                        <td style="width: 38%">
                            <select id="slTipos" name="slTipos" class="form-control input-lg">
                            <?php if (isset($this->lstTipos) && count($this->lstTipos)): ?>
                                    <option value="">-- Tipo Ciclo --</option>
                                    <?php for ($i = 0; $i < count($this->lstTipos); $i++) : ?>
                                        <option value="<?php echo $this->lstTipos[$i]['codigo']; ?>">
                                            <?php echo $this->lstTipos[$i]['nombre']; ?>
                                        </option>
                                    <?php endfor; ?>
                            <?php else : ?>
                                <option value="">-- No existen tipos registrados --</option>
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
                                <option value="" disabled>-- Ciclo --</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 10%">
                            <h4>Sección: </h4>
                            <br/>
                        </td>
                        <td style="width: 38%">
                            <select id="slSec" name="slSec" class="form-control input-lg">
                            <?php if (isset($this->lstSec) && count($this->lstSec)): ?>
                                    <option value="">-- Sección --</option>
                                    <option value="0">Todas las secciones</option>
                                    <?php for ($i = 0; $i < count($this->lstSec); $i++) : ?>
                                        <option value="<?php echo $this->lstSec[$i]['id']; ?>">
                                            <?php echo $this->lstSec[$i]['nombre']." - ".$this->lstSec[$i]['tiposeccion']." - ".$this->lstSec[$i]['curso']; ?>
                                        </option>
                                    <?php endfor; ?>
                            <?php else : ?>
                                <option value="">-- No existen secciones registradas --</option>
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
                    <tr>
                        <td colspan="5"><hr class="hr1"/></td>
                    </tr>
                </table>
                <input type="hidden" id="hdSeccion" name="hdSeccion">
            </form>
        </div>
    </div>
</section>