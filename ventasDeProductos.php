<?php 
 session_start();
 isset($_SESSION['rol']) ? $id_rol = $_SESSION['rol'] : $id_rol = null;
require_once "../../clases/Conexion.php";
$c= new conectar();
$conexion=$c->conexion();
?>


<!-- <h4>VENDER PRODUCTO</h4> -->
<br>
<br>
<div class="row">
    <div class="col-sm-4">

        <form id="frmVentasProductos" style="margin-left: 65%;">
            <div style="width: 200%">
                <label>TIPO VENTA</label>
                <select type="text" class="form-control input-sm" id="tipoVenta" name="tipoVenta">
                    <option value="">SELECCIONAR...</option>
                    <option value="1">CONTADO</option>
                    <option VALUE="2">CREDITO</option>
                </select>
    <br>
                <label>CLIENTE</label>
                <select class="form-control input-sm" id="clientenVenta" name="clienteVenta">
                    <option value="">SELECCIONAR...</option>
                    <?php
                    $sql="SELECT id_codigo,nombre,apellido 
                    from clientes";
                    $result=mysqli_query($conexion,$sql);
                    while ($cliente=mysqli_fetch_row($result)):
                        ?>
                        <option value="<?php echo $cliente[0] ?>"><?php echo $cliente[1]." ".$cliente[2] ?></option>
                    <?php endwhile; ?>
                </select>
    <br>
                <label>ARTICULO</label>
                <select class="form-control input-sm" id="productoVenta" name="productoVenta">
                    <option value="">SELECCIONAR...</option>
                    <?php
                    $sql="SELECT id_producto,nombre from articulos order by nombre";
                    $result=mysqli_query($conexion,$sql);
                    while ($articulo=mysqli_fetch_row($result)):
                        ?>
                        <option value="<?php echo $articulo[0] ?>"><?php echo $articulo[1]; ?></option>
                    <?php endwhile; ?>
                </select>
    <br>
    <br>
                <label>CANTIDAD</label>
                <input type="number" class="form-control input-sm" id="cantidadV" name="cantidadV">
                <input type="hidden" class="form-control input-sm" id="precioV" name="precioV">
    <br>
                <label>Precio Venta</label>
    <br>
                <input type="number" class="form-control input-sm" id="precioC" name="precioC">
                <center><span class="btn btn-primary" style="padding:5px;margin: 14px 2px 2px 0px;" id="btnAgregaVenta">AGREGAR
                </span></center>
            </div>
        </form>
    </div>
    <div class="col-sm-3">
    </div>
    <div class="col-sm-4">
        <div id="tablaVentasTempLoad"></div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){

        $('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");

        $('#productoVenta').change(function(){
            $.ajax({
                type:"POST",
                data:"idproducto=" + $('#productoVenta').val(),
                url:"../procesos/ventas/llenarFormProducto.php",
                success:function(r){
                    if(r == '0'){
                        alert('Error');
                    }else{
                        dato=jQuery.parseJSON(r);
                        $('#cantidadV').val(dato['cantidad']);
                        $('#precioV').val(dato['precio']);
                    }
                }
            });
        });

        $('#btnAgregaVenta').click(function(){

            datos=$('#frmVentasProductos').serialize();

            //Validamoas 
            console.log(parseInt($('#precioC').val())+'-'+parseInt($('#precioV').val()));
            
            if( $('#cantidadV').val() > 0 ){
                if(parseInt($('#precioC').val()) >= parseInt($('#precioV').val())){
                    $.ajax({
                        type:"POST",
                        data:datos,
                        url:"../procesos/ventas/agregaProductoTemp.php",
                        success:function(r){
                            if(r == 'Cantidad'){
                                alertify.error("LA CANTIDAD INGRESADA ES MAYOR A LAS EXISTENCIAS");
                            }else{
                                $('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");
                                $.ajax({
                                    type:"POST",
                                    data:"idproducto=" + $('#productoVenta').val(),
                                    url:"../procesos/ventas/llenarFormProducto.php",
                                    success:function(r){
                                        
                                        info=jQuery.parseJSON(r);
                                        if(info != null){
                                            $('#cantidadV').val(dato['cantidad']);
                                            $('#precioV').val(dato['precio']);
                                            $('#frmVentasProductos')[0].reset();
                                            $("#tipoVenta").val('').trigger('change');
                                            $("#productoVenta").val('').trigger('change');
                                        }
                                    }
                                });                         
                            }
                        }
                    });
                }else{
                    alertify.error("NO SE PUEDE VENDER EL PRODUCTO..!");
                }
            }else{
                alertify.error("ERROR AL AGREGAR..!");
            }
        });

        $('#btnVaciarVentas').click(function(){

            $.ajax({
                url:"../procesos/ventas/vaciarTemp.php",
                success:function(r){
                    $('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");
                }
            });
        });

    });
</script>

<script type="text/javascript">
    function quitarP(index){
        $.ajax({
            type:"POST",
            data:"ind=" + index,
            url:"../procesos/ventas/quitarproducto.php",
            success:function(r){
                $('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");
                alertify.success("ARTICULO ELIMINADO!");
            }
        });
    }

    function crearVenta(){
        $.ajax({
            url:"../procesos/ventas/crearVenta.php",
            success:function(r){
                if(r > 0){
                    $('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");
                    $('#frmVentasProductos')[0].reset();
                    $("#tipoVenta").val('').trigger('change');
                    $("#clienteVenta").val('').trigger('change');
                    $("#productoVenta").val('').trigger('change');
                    alertify.alert("VENTA EXITOSA!!!");
                }else if(r==0){
                    alertify.alert("NO HAY LISTA DE VENTAS..!");
                }else{
                    alertify.error("NO SE PUDO GENERAR LA VENTA..!");
                }
            }
        });
    }
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#clienteVenta').select2();
        $('#productoVenta').select2();
    });
</script>