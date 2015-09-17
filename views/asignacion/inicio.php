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
    	<div id="divContenedor">
		<div id="divContenedorTabla">
			<table id="tabla" name="tabla" align="center" width="450">
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
				</tfoot>
			</table>
		</div>
	</div>
    <br/>
</section>