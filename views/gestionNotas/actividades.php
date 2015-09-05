<section id="" style="background-color: beige;">
    <div class="header-content">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Gesi&oacute;n de notas</h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>gestionNotas">
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
    
    <div class="container" >
        <div class="col-md-6 col-md-offset-3">
            <form id="frEstudiantes" method="post" action="<?php echo BASE_URL; ?>gestionUsuario/listadoUsuarios">
                <table>
                    <tr>
                        <td style="width: 10%">
                            <h4>Cursos asignados: </h4>
                        </td>
                        <td style="width: 38%">
                            <select id="slCursos" name="slCursos" class="form-control input-lg">
                                <option id="4">FILOSOFIA I</option>
                                <option id="9">FILOSOFIA II</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 10%">
                            <h4>Unidad Academica: </h4>
                        </td>
                        <td style="width:40%;">
                            <select id="slActividad" name="slActividad" class="form-control input-lg">
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
            </form>
        </div>
    </div>
    
</section>
