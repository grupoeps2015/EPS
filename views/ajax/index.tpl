<br/><br/><br/><br/><h2>Ajax</H2>

<form>
    Pais:
    <select id="pais">
        <option value="">-- seleccione --</option>
        {foreach from=$paises item=p}
            
        <option value="{$p.departamento}">{$p.nombre}</option>
            
        {/foreach}
    </select>
</form>