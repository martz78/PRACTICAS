<?php
include_once 'conexion.php';
$totales= isset($_POST['totales']) ? $_POST['totales']: "";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="estilo.css">
    <title>Document</title>
</head>

<body>
<form action="index.php" method="post" style="text-align:center">
    <label for=""></label>
    <input type="text" name="totales" id="totales" value="<?php echo isset($_POST['totales']) ? $_POST['totales'] : ""; ?>">
   <!-- <input type="submit" value="Graficar"> -->
    
   <!-- <div id="yearCheckboxes" style="float: center; margin-right: 20px;">
        <?php
        
        $consulta_anios = "SELECT DISTINCT YEAR(fecha) as year FROM detalle_factura
            INNER JOIN encabezado_factura ON detalle_factura.codigo=encabezado_factura.codigo
            ORDER BY year ASC";
        $result_anios = mysqli_query($conexion, $consulta_anios);
        while ($row_anio = mysqli_fetch_assoc($result_anios)) {
            $year = $row_anio['year'];
            $checked = (isset($_POST['anios']) && in_array($year, $_POST['anios'])) ? 'checked' : '';
            echo '<label for="year_' . $year . '"><input type="checkbox" name="anios[]" id="year_' . $year . '" value="' . $year . '" ' . $checked . '> ' . $year . '</label>';
        }
        ?>
    </div> -->
</form>

    

    <figure class="highcharts-figure">
        <div id="container"></div>
    </figure>
</body>

</html>

<script>

    Highcharts.chart('container', {

        title: {
            text: 'Empresa XYZ',
            align: 'center'
        },

        subtitle: {
            text: 'Total de ventas anuales de los ultimos 10 años',
            align: 'center'
        },

        yAxis: {
            title: {
                text: 'Ventas en $'
            }
        },

        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },

        xAxis: {
            categories: [
                <?php
                

                if ($totales !== "") {
                    
                    $consulta = "SELECT DISTINCT YEAR(fecha) as year FROM detalle_factura
                        INNER JOIN encabezado_factura ON detalle_factura.codigo=encabezado_factura.codigo
                        GROUP BY YEAR(fecha)
                        HAVING SUM(venta) >= $totales
                        ORDER BY year ASC"; 
                } else {
                    
                    $consulta = "SELECT DISTINCT YEAR(fecha) as year FROM detalle_factura
                        INNER JOIN encabezado_factura ON detalle_factura.codigo=encabezado_factura.codigo
                        ORDER BY year ASC";
                }

                $result = mysqli_query($conexion, $consulta);

                while ($row = mysqli_fetch_assoc($result)) {

                    if (isset($_POST['anios']) && is_array($_POST['anios'])) {

                        $anios_seleccionados = $_POST['anios'];
                        foreach ($anios_seleccionados as $anio) {
                            if($anio===$row['year']){
                                echo "'" . $row['year'] . "',";
                            }
                           
                        }
                    } else {
                        echo "'" . $row['year'] . "',";
                    }
                    

                }
                ?>
            ]
        },

        series: [{
            name: 'Ventas anuales',
            data: [
                <?php
                  
                
                  $anios_seleccionados = isset($_POST['anios']) ? $_POST['anios'] : array();
                if($totales ===""){
                    

                    if (!empty($anios_seleccionados)) {
                        $anios_seleccionados_str = implode(',', $anios_seleccionados);
                        $consulta = "SELECT SUM(venta) as venta, YEAR(fecha) as year FROM detalle_factura
                            INNER JOIN encabezado_factura ON detalle_factura.codigo = encabezado_factura.codigo
                            WHERE YEAR(fecha) IN ($anios_seleccionados_str)
                            GROUP BY YEAR(fecha)";
                    } else {
                        
                        $consulta = "SELECT SUM(venta) as venta, YEAR(fecha) as year FROM detalle_factura
                            INNER JOIN encabezado_factura ON detalle_factura.codigo = encabezado_factura.codigo
                            GROUP BY YEAR(fecha)";
                    }
                               $executar = mysqli_query($conexion, $consulta);
                               while ($dato = mysqli_fetch_array($executar)) {
                                   $d=number_format($dato[0],2,'.','');
                                   echo $d.",";
                 }
 
                }
                else {
                

                    if (!empty($anios_seleccionados)) {
                        $anios_seleccionados_str = implode(',', $anios_seleccionados);
                        $consulta = "SELECT SUM(venta) as venta, YEAR(fecha) as year FROM detalle_factura
                            INNER JOIN encabezado_factura ON detalle_factura.codigo = encabezado_factura.codigo
                            WHERE YEAR(fecha) IN ($anios_seleccionados_str)
                            GROUP BY YEAR(fecha)
                    HAVING sum(venta) >=$totales";
                    } else {
                       
                        $consulta = "SELECT SUM(venta) as venta, YEAR(fecha) as year FROM detalle_factura
                            INNER JOIN encabezado_factura ON detalle_factura.codigo = encabezado_factura.codigo
                            GROUP BY YEAR(fecha) 
                    HAVING sum(venta) >=$totales";
                    }
                               $executar = mysqli_query($conexion, $consulta);
                               while ($dato = mysqli_fetch_array($executar)) {
                                   $d=number_format($dato[0],2,'.','');
                                   echo $d.",";
                 }
                }
                ?>
            ]
        }],

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }

    });
    $(document).ready(function () {
    $("#totales").keyup(function () {

        var totales = $(this).val();

        
        var totales = $("#totales").val();
           
        $.ajax({
            type: "POST", 
            url: "index.php", 
            data: { totales: totales
             }, 
            success: function (response) {
             console.log(response);
                $("#container").html(response);
            }
        });
    });
});
    
</script>