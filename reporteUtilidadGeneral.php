<?php
require_once "../../clases/Conexion.php";

$start = $_GET['start'];
$end = $_GET['end'];

//start report

$c= new conectar();
$conexion=$c->conexion();
$total =0;

    $sql="SELECT DISTINCT
        v.id_venta,
        COALESCE(CONCAT(c.nombre,c.apellido))cliente,
        COALESCE(a.nombre)articulo,
        a.id_producto,
        v.tipo_venta,
        v.id_usuario,
        v.cantidad,
        a.precio as costoUnitario,
        v.precio as precioUnitario,
        v.total as ventaTotal,
        (v.cantidad * a.precio) as costoVenta,
        COALESCE((v.total - (v.cantidad * a.precio)),'') utilidadBruta,
        v.fechaCompra
    FROM ventas v
    INNER JOIN clientes AS c on c.id_codigo = v.id_cliente
    INNER JOIN recaudo AS r on r.id_cliente = v.id_cliente
    INNER JOIN articulos AS a ON a.id_producto = v.id_producto
    WHERE v.fechaCompra
    BETWEEN '".$start."' AND '".$end."' ORDER BY v.fechaCompra DESC";
    $result=mysqli_query($conexion,$sql);
?>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-10">
		<div class="table-responsive">
            <table class="table table-bordered table-hover table-condensed" style="text-align: center;" id="table-ventas">
                <thead>
                    <tr>
                        <td>Cliente</td>
                        <td>Articulo</td>
                        <td>Código</td>
                        <td>Fecha Compra</td>
                        <td>Cantidad</td>
                        <td>Costo Unitario</td>
                        <td>Precio Unitario</td>
                        <td>Venta Total</td>
                        <td>Costo Venta</td>
                        <td>Utilidad Bruta</td>
                    </tr>
                </thead>
                <tbody>
                    <?php while($ver=mysqli_fetch_row($result)): ?>
                    <tr>
                        <td><?php echo $ver[1] ?></td>
                        <td><?php echo $ver[2] ?></td>
                        <td><?php echo $ver[3] ?></td>
                        <td><?php echo $ver[12] ?></td>
                        <td><?php echo $ver[6] ?></td>
                        <td><?php echo $ver[7] ?></td>
                        <td><?php echo $ver[8] ?></td>
                        <td><?php echo $ver[9] ?></td>
                        <td><?php echo $ver[10] ?></td>
                        <td><?php echo $ver[11] ?></td>
                    </tr>
				<?php 
                    $total=$total + $ver[11];    
                    endwhile; ?>
                        <tfoot>
                            <tr>
                                <th colspan="9">
                                    Total Utilidad
                                </th>
                                <td><?php echo $total; ?></td>
                            </tr>
                        </tfoot>
                </tbody>
            </table>
		</div>
	</div>
</div>