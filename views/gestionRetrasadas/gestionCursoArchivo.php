<section id="" style="background-color: beige;">
    <form id="frCursoArchivo" name="frCursoArchivo" method='post' enctype="multipart/form-data" action='<?php echo BASE_URL; ?>gestionRetrasadas/crearArchivo'>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Cat&aacute;logo de Cursos</h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL; ?>asignacion/inicio">
                                Regresar
                            </a>
                        </i>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 text-cenater"></div>
                <div class="col-lg-4 col-md-6 text-center">
                    
                </div>
                <div class="col-lg-3 col-md-6 text-center">                    
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div>
            <div class="col-md-8 col-md-offset-2">
            <br/>
            <button type="button" id="btnSubmit" onclick="generarArchivo()" class="btn btn-danger btn-lg btn-block" style="width:40%; float: left">Generar Archivo</button>
            </div>
            
            <div id="divCursos" class="form-group" >
                <div style="margin-left: 10%; margin-right: 10%">
                    <table id="tbCursos" border="2">
                        <thead>
                            <tr>
                                <th style="text-align:center">Seleccionar<br><br><input type="checkbox" name="marcarTodos" id="marcarTodos" value="-1">Marcar todos</th>
                                <th style="text-align:center">Código</th>
                                <th style="text-align:center">Nombre</th>
                                <th style="text-align:center">Tipo</th>
                                <th style="text-align:center">Traslape</th>                               
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($this->lstCur) && count($this->lstCur)): ?>
                            <?php for($i =0; $i < count($this->lstCur); $i++) : ?>
                            <tr>
                                <td style="text-align: center"><input class="_cursos" type="checkbox" id="<?php echo $this->lstCur[$i]['codigo']; ?>" nombre="<?php echo $this->lstCur[$i]['nombre']; ?>" value="<?php echo $this->lstCur[$i]['codigo']; ?>"/></td>
                                <td style="text-align: center"><?php echo $this->lstCur[$i]['codigo']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstCur[$i]['nombre']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstCur[$i]['tipocurso']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstCur[$i]['traslape']; ?></td>
                            </tr>
                            <?php endfor;?>
                        <?php endif;?>
                        </tbody>
                    </table>
                    <br />
                </div>
            </div>
        <input type="hidden" id="_texto" name="_texto" value="">        
    </div>   
    </form>
</section>

<script text="text/javascript">
function generarArchivo()
   {
       var strListaCursos="";
       $("._cursos:checked").each(function () {
            var id = $(this).attr("id");
            var nombre = $(this).attr("nombre");
            var unidad = "<?php echo $this->id; ?>";
            var extension = "<?php echo EXTENSION_ESCUELAHISTORIA; ?>";
            var carrera = "<?php echo $this->carrera; ?>";
       
            //console.log(unidad + " " + extension + " " + carrera + " " + id + " " + nombre + " " + "CURSO");
          strListaCursos += unidad + "|" + extension + "|" + carrera + "|" + id + "|" + nombre + "|" + "CURSO" + "%%";
        });
       //console.log(strListaCursos);
       document.getElementById("_texto").value = strListaCursos;
       document.frCursoArchivo.submit();
   }
   
</script>