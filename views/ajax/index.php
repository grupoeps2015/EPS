<br/><br/><br/><br/><h2>Ajax</H2>

<form>
    <select id="slDeptos">
        <option value="">-- seleccione --</option>
        <?php if(isset($this->deptos) && count($this->deptos)): ?>
            <?php for($i =0; $i < count($this->deptos); $i++) : ?>
            <option value="<?php echo $this->deptos[$i]['codigo'];?>">
                <?php echo $this->deptos[$i]['nombre']; ?>
            </option>
            <?php endfor;?>
        <?php endif;?>
    </select>
    <br /><br />
    <select id="slMunis">
    </select>
</form>