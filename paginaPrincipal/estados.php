<?php
    $dispositivo='NodeMCU';

    function temperatura_actual($dispositivo){
        require_once('conexion.php');
        $conn=new conexion();
        
        //Esta es la consulta para ver la temperatura en la tabla de estado
        //SELECT `temperatura` FROM `estado` WHERE `dispositivo`='node1';
        $queryTemp="SELECT `Temperatura` FROM `estado` WHERE `dispositivo`='$dispositivo'";
        $resultado= mysqli_query($conn->conectarDB(),$queryTemp);
        $row=mysqli_fetch_row($resultado);
        echo $row[0];

        
    }

    function humedad_actual($dispositivo){
        require_once('conexion.php');
        $conn=new conexion();
        
        //Esta es la consulta para ver la temperatura en la tabla de estado
        //SELECT `humedad` FROM `estado` WHERE `dispositivo`='node1';
        $queryTemp="SELECT `Humedad` FROM `estado` WHERE `dispositivo`='$dispositivo'";
        $resultado= mysqli_query($conn->conectarDB(),$queryTemp);
        $row=mysqli_fetch_row($resultado);

        echo $row[0];
    }
?>

<body>
    <figure class="highcharts-figure">
        <p class="highcharts-description">Mediciones actualizadas</p>
        <div class="back">
            <img src="caret-left-solid.svg" alt="back-icon" style="width:10px; background-color: #333335;">
            <a href="http://iotpagina3.000webhostapp.com">&nbsp;&nbsp;Inicio</a>
        </div>
        <div id="container-speed" class="chart-container"></div>
        <div id="container-rpm" class="chart-container"></div>
    </figure>
</body>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/themes/dark-unica.js"></script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Convergence&family=Inter:wght@300&display=swap');

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }

    *{
        font-family: 'Convergence', sans-serif;
        background-color: #333335;
    }

    body{
        min-height: 100vh;
        padding: 5px;
        margin:0;
    }

    .highcharts-figure .highcharts-description{
        color:#fff;
        font-size: 20px;
        font-weight: 600;
        background-color: #333335;
    }

    .highcharts-figure .back{
        position: relative;
        padding: 10px;
        margin: 10px;
        display: flex;
        flex-direction: row;
        align-items: center;
        background-color: #333335;
    }

    .highcharts-figure .back a{
        text-decoration: none;
        color: #fff;
        font-weight: 600;
        font-size: 18px;
        background-color: #333335;
    }

    .highcharts-figure .chart-container{
        background-color: #333335;
        padding-top: 0;

    }

</style>

<script type="text/javascript">
    var gaugeOptions = {
        chart: {
            type: 'solidgauge'
        },

        title: null,

        pane: {
            center: ['50%', '85%'],
            size: '130%',
            startAngle: -90,
            endAngle: 90,
            background: {
                backgroundColor:
                    Highcharts.defaultOptions.legend.backgroundColor || '#333335',
                innerRadius: '60%',
                outerRadius: '100%',
                shape: 'arc'
            }
        },

        exporting: {
            enabled: false
        },

        tooltip: {
            enabled: false
        },

        // the value axis
        yAxis: {
            stops: [
                [0.1, '#55BF3B'], // green
                [0.5, '#FFD43A'], // yellow
                [0.9, '#DF5353'] // red
            ],
            lineWidth: 0,
            tickWidth: 0,
            minorTickInterval: null,
            tickAmount: 2,
            title: {
                y: -70
            },
            labels: {
                y: 16
            }
        },

        plotOptions: {
            solidgauge: {
                dataLabels: {
                    y: 5,
                    borderWidth: 0,
                    useHTML: true
                }
            }
        }
    };

    // TEMPERATURA
    var chartSpeed = Highcharts.chart('container-speed', Highcharts.merge(gaugeOptions, {
        yAxis: {
            min: 0,
            max: 60,
            title: {
                text: 'TEMPERATURA'
            }
        },

        credits: {
            enabled: false
        },

        series: [{
            name: 'TEMPERATURA',
            data: [<?php temperatura_actual($dispositivo); ?>],
            dataLabels: {
                format:
                    '<div style="text-align:center">' +
                    '<span style="font-size:25px">{y}</span><br/>' +
                    '<span style="font-size:12px;opacity:0.4">ºC</span>' +
                    '</div>'
            },
            tooltip: {
                valueSuffix: ' ºC'
            }
        }]

    }));

    // HUMEDAD
    var chartRpm = Highcharts.chart('container-rpm', Highcharts.merge(gaugeOptions, {
        yAxis: {
            min: 0,
            max: 100,
            title: {
                text: 'HUMEDAD'
            }
        },

        series: [{
            name: 'HUMEDAD',
            data: [<?php humedad_actual($dispositivo); ?>],
            dataLabels: {
                format:
                    '<div style="text-align:center">' +
                    '<span style="font-size:25px">{y:.1f}</span><br/>' +
                    '<span style="font-size:12px;opacity:0.4">%</span>' +
                    '</div>'
            },
            tooltip: {
                valueSuffix: ' %'
            }
        }]

    }));
</script>

<?php
    //Vuelvo a acargar la pagina para actuallizar los datos
    echo '<script type="text/JavaScript"> location.reload(); </script>';
    sleep(5);
?>