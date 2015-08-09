<h2>Listado de Usuarios</h2>

<?php if(isset($this->posts) && count($this->posts)): ?>
<table border="1" align="center">
    <?php for($i =0; $i < count($this->posts); $i++) : ?>
    <tr>
        <td><?php echo $this->posts[$i]['codigo']; ?></td>
        <td><?php echo $this->posts[$i]['nombre']; ?></td>
    </tr>
    <?php endfor;?>
</table>
<?php else : ?>
<p><strong>No hay datos disponibles</strong></p>
<?php endif;?>

<p>
    <a href="<?php echo BASE_URL?>admCrearUsuario/agregarUsuario">Agregar Usuario</a>
</p>