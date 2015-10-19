<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Asignación de Prerrequisitos</h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL ?>gestionPensum/gestionCursoPensum/<?php echo $this->idPensum; ?>/<?php echo $this->idCarrera; ?>">
                                Regresar
                            </a>
                        </i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <!--<i class="fa fa-2x fa-building-o wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL ?>gestionPensum/agregarPensum">
                                Agregar Pensum
                            </a>
                        </i>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div>
        <form id="frPensum" method="post" action="<?php echo BASE_URL; ?>gestionPensum/crearPensum/">
            <div id="divPensum" class="form-group" >
                <div style="margin-left: 5%; margin-right: 5%">
                    
                    <table align ="center">
                        <tr>
                            <td>
                                <table align="center" >
                                    <tr >
                                        <td colspan="3" style="padding:10px !important;"><label style="font-size: 19px; font-weight: normal;">Selecciona el tipo de prerrequisito que deseas agregar:</label></td>

                                    </tr>
                                    <tr>
                                        <td style="width: 700px !important; padding: 10px;" colspan="3">
                                            <input id="textbox" name="textbox" type="text" placeholder="(ingrese el codigo o nombre del curso)" style="font-size: 19px !important; width: 660px; height: 35px;"/>
                                            <?php if (isset($this->lstCursos) && count($this->lstCursos)): ?>
                                                <select id="slCursos" name="slCursos" class="form-control input-lg">
                                                    <option value="">- Cursos disponibles -</option>
                                                    <?php for ($i = 0; $i < count($this->lstCursos); $i++) : ?>
                                                        <?php if ($this->lstCursos[$i]['estado'] == "Activo"): ?>
                                                            <option value="<?php echo $this->lstCursos[$i]['id']; ?>">
                                                                <?php
                                                                echo $this->lstCursos[$i]['codigo'];
                                                                echo " - ";
                                                                echo $this->lstCursos[$i]['nombre'];
                                                                ?>
                                                            </option>                                    
                                                        <?php endif; ?>
                                                    <?php endfor; ?>
                                                </select>
                                            <?php else : echo " No hay cursos disponibles "; ?>
                                            <?php endif; ?>
                                        </td>    
                                    </tr>
                                    <tr>
                                        <td style="padding: 10px;"><input type="checkbox" id="chkOtrosPrerrequisitos" name="chkOtrosPrerrequisitos"> Otros Prerrequisitos (créditos)<br></td>
                                        <td style="padding: 10px;">
                                            <input type="text" id="txtOtrosPrerrequisitos" name="txtOtrosPrerrequisitos" hidden="true" disabled="true" placeholder="Cantidad de créditos">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style=" padding-top: 25px;"><input onclick="agregar()" value="Agregar" type="button"  class="btn btn-success btn-default" style="width:350px;"/></td>
                                        <td style="padding-top: 25px;"><input onclick="remover()" value="Eliminar" type="button"  class="btn btn-success btn-default" style="width:350px;"/></td>
                                    </tr>

                                </table>
                            </td>
                            <td style="padding: 10px;">
                                <table border="1" style="height: 100px;" id ="tablaArbol" name ="tablaArbol">
                                    <th style="padding: 10px;"><center><font style="font-size: 19px;"> PRERREQUISITOS AGREGADOS</font> <br/><font style="font-weight: normal;"> (seleccione "Prerrequisitos" para agregar uno nuevo)</font></center></th>
                                    <tr>
                                        <td style="border: 1px solid black;"><div id="arbolPensum" style="margin-right: 25px; padding: 10px;"/></td>
                                        
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid beige;">
                                            <input onclick="mostrar();" value="Validar Todos" type="button" name ="validar" id="validar" class="btn btn-success btn-lg btn-block" style="float: right;  width:100%; margin-top: 25px;"/>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            

                        </tr>
                        
                        <tr>
                            
                            <td align="center"><br />
                                <input type="submit" name ="submit" id="submit" value="Guardar" class="btn btn-danger btn-lg btn-block" style="width:70%; margin-top: 25px;"/>
                            </td>
                            
                        </tr>
                    </table>

<!--<input onclick="actualizar()" value="actualizar" type="button"/>-->

                    <!--  Contenedor del pensum -->



                    <!--<input onclick="displayNodes()" value="recorrer arbol" type="button"/>-->

                </div>
            </div>
            <input type="hidden" name="hdEnvio" value="1">
            <input type="hidden" name="hdPensum" value="<?php echo $this->idPensum;?>">
            <input type="hidden" name="hdCarrera" value="<?php echo $this->idCarrera;?>">
            <input type="hidden" name="hdCursoPensumArea" value="<?php echo $this->idCursoPensum;?>">
            <input type="hidden" id="hdPrerrequisitos" name="hdPrerrequisitos" value="<?php echo $_GET['prerrequisitos'];?>">

        </form>
    </div>   
</section>