<div class="bar">
    <a id="new" class="button" href="javascript:void(0);">Nuevo Cliente</a>
</div>
<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Fecha de Nacimiento</th>
            <th>Peso</th>
            <th>Editar</th>
            <th>Borrar</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($view->clientes as $cliente):  // uso la otra sintaxis de php para templates ?>
            <tr>
                <td><?php echo $cliente['id'];?></td>
                <td><?php echo $cliente['nombre'];?></td>
                <td><?php echo $cliente['apellido'];?></td>
                <td><?php echo $cliente['fecha_nac'];?></td>
                <td><?php echo $cliente['peso'];?></td>
                <td><a class="edit" href="javascript:void(0);" data-id="<?php echo $cliente['id'];?>">Editar</a></td>
                <td><a class="delete" href="javascript:void(0);" data-id="<?php echo $cliente['id'];?>">Borrar</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="bar">
    <a style="background-color:#fbc2c4;color:brown" class="button" href="http://www.tutorialjquery.com/ejemplo-de-altas-bajas-y-modificaciones-con-php-ajax-y-jquery">Descargar</a>
</div>
