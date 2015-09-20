<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Agregar Asignación de Edificio</h2>
                <p><?php if (isset($this->query)) echo $this->query; ?></p>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL ?>gestionEdificio/gestionEdificio/<?php echo $this->id; ?>">
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
                <form id="frAsignacion" method="post" action="<?php echo BASE_URL; ?>gestionEdificio/asignacionEdificio/<?php echo $this->id;?>">
                    <div id="divAsignacion" class="form-group" >
                        <div class="col-md-6 col-md-offset-3">
                            <table align="center">
                                <tr>
                                    <td> Centro Unidad:
                                        <?php if (isset($this->centros) && count($this->centros)): ?>
                                        <select id="slCentros" name="slCentros" class="form-control input-lg">
                                                <option value="">(Centro-Unidad Academica)
                                                </option>
                                                <?php for ($i = 0; $i < count($this->centros); $i++) : ?>
                                                
                                                    <option value="<?php echo $this->centros[$i]['_id']; ?>">
                                                        
                                                        <?php echo $this->centros[$i]['_centro']; ?> - <?php echo $this->centros[$i]['_unidadacademica']; ?>
                                                    </option>
                                                <?php endfor; ?>
                                            </select>
                                        <?php else : ?>
                                            
                                            <br/>
                                        <?php endif; ?>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td> Jornada:
                                        <?php if (isset($this->jornadas) && count($this->jornadas)): ?>
                                            <select id="slJornadas" name="slJornadas" class="form-control input-lg">
                                                <option value="">(Jornadas)
                                                </option>
                                                <?php for ($i = 0; $i < count($this->jornadas); $i++) : ?>
                                                    <option value="<?php echo $this->jornadas[$i]['codigo']; ?>">
                                                        <?php echo $this->jornadas[$i]['nombre']; ?>
                                                    </option>
                                                <?php endfor; ?>
                                            </select>
                                        <?php else : ?>
                                         <?php endif; ?>
                                    </td>

                                </tr>


                                <tr>
                                    <td>&nbsp;</td>
                                    <td colspan="3">
                                        <br/>
                                        <input type="submit" id="btnActualizar" name="btnAsignar" value="Asignar" class="btn btn-danger btn-lg btn-block">
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>

                            <br />
                        </div>
                    </div>
                    <input type="hidden" name="hdEnvio" value="1">
                     <input type="hidden" name="hdEdificio" value="<?php echo $this->id; ?>">
                </form>
            </div>
        </div>
    </div>
</section>
