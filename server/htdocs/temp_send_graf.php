<!-- 
Autor: David Castillo Alvarado
Documento: grafica la información solicitada al servidor
Proyecto: Registro de temperatura (DHT22) en servidos local SQL, con interfaz gráfica.
Descripción: Las temperaturas medidas por el sensor DHT22 son registradas en el servidos SQL
             el cual tiene un alojamiento local.
             El acceso a los datos se realiza por medio de una interfaz gráfica de usuario 
             a través del buscador web (Chrome).
Fuente:   https://www.highcharts.com/
-->

<?php 
require_once ('conectar1.php');
$conexion = conectar1();
// el strip_tags impide que se ejecuten codigo indeseados
$serie = strip_tags($_POST ['SNN']); // el numero de serie que se quiere mostrar
$mes = strip_tags($_POST ['mes']);    // La fecha que se quiere mostrar
$dia = strip_tags($_POST ['dia']);    // El día que se quiere mostrar
$todo = $_POST ['all'];

if ($todo == "todo" ){
$mes = "999";    // La fecha que se quiere mostrar
$dia = "999";    // El día que se quiere mostrar
    echo "Muestra todo el record";
}else{
    echo "Muestra por día";
}
    // mostrar toda la base de datos

$intervalo=0;
//temperatura_diaria("777", "0", "11", "20");
//temperatura_diaria($conexion,$serie, $intervalo, $mes, $dia);

function temperatura_diaria ($conexion,$serie,$intervalo,$mes,$dia,$todo) {
    
    $ano=date("Y");
   
    if ($todo == "todo"){
      $resultado=mysqli_query($conexion, "SELECT UNIX_TIMESTAMP(`fecha`), `Temperatura` FROM data WHERE `Serie`= '$serie'");
    }else{

   $resultado=mysqli_query($conexion, "SELECT UNIX_TIMESTAMP(`fecha`), `Temperatura` FROM data WHERE year(`fecha`) = '$ano' AND month(`fecha`) = '$mes' AND day(`fecha`) = '$dia' AND `Serie`= '$serie'");

    }

    while ($row=mysqli_fetch_array($resultado, MYSQLI_NUM))

    {
        echo "[";
        echo $row[0]*1000;
        echo ",";
        echo $row[1];
        echo "],";

        for ($x=0; $x<$intervalo; $x++)
        {
            $row=mysqli_fetch_array($resultado,MYSQLI_NUM);
        }
    }

    mysqli_close($conexion);
}

?>


<div id="container1" style="width: 100%; height: 500px;"></div> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>


<script> 
      snn = <?php echo $serie;?>;
      dd  = <?php echo $dia;?>;
      mm  = <?php echo $mes;?>;
    titulo = 'Temperatura en el día ' + dd + ' Mes ' + mm;
    disp = 'DHT22/Wemos Serie - ' + snn;
$(function () {
    Highcharts.createElement('link', {
   href: 'https://fonts.googleapis.com/css?family=Unica+One',
   rel: 'stylesheet',
   type: 'text/css'
}, null, document.getElementsByTagName('head')[0]);

Highcharts.theme = {
   colors: ['#2b908f', '#90ee7e', '#f45b5b', '#7798BF', '#aaeeee', '#ff0066', '#eeaaee',
      '#55BF3B', '#DF5353', '#7798BF', '#aaeeee'],
   chart: {
      backgroundColor: {
         linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
         stops: [
            [0, '#2a2a2b'],
            [1, '#3e3e40']
         ]
      },
      style: {
         fontFamily: '\'Unica One\', sans-serif'
      },
      plotBorderColor: '#606063'
   },
   title: {
      style: {
         color: '#E0E0E3',
         textTransform: 'uppercase',
         fontSize: '20px'
      }
   },
   subtitle: {
      style: {
         color: '#E0E0E3',
         textTransform: 'uppercase'
      }
   },
   xAxis: {
      gridLineColor: '#707073',
      labels: {
         style: {
            color: '#E0E0E3'
         }
      },
      lineColor: '#707073',
      minorGridLineColor: '#505053',
      tickColor: '#707073',
      title: {
         style: {
            color: '#A0A0A3'

         }
      }
   },
   yAxis: {
      gridLineColor: '#707073',
      labels: {
         style: {
            color: '#E0E0E3'
         }
      },
      lineColor: '#707073',
      minorGridLineColor: '#505053',
      tickColor: '#707073',
      tickWidth: 1,
      title: {
         style: {
            color: '#A0A0A3'
         }
      }
   },
   tooltip: {
      backgroundColor: 'rgba(0, 0, 0, 0.85)',
      style: {
         color: '#F0F0F0'
      }
   },
   plotOptions: {
      series: {
         dataLabels: {
            color: '#B0B0B3'
         },
         marker: {
            lineColor: '#333'
         }
      },
      boxplot: {
         fillColor: '#505053'
      },
      candlestick: {
         lineColor: 'white'
      },
      errorbar: {
         color: 'white'
      }
   },
   legend: {
      itemStyle: {
         color: '#E0E0E3'
      },
      itemHoverStyle: {
         color: '#FFF'
      },
      itemHiddenStyle: {
         color: '#606063'
      }
   },
   credits: {
      style: {
         color: '#666'
      }
   },
   labels: {
      style: {
         color: '#707073'
      }
   },

   drilldown: {
      activeAxisLabelStyle: {
         color: '#F0F0F3'
      },
      activeDataLabelStyle: {
         color: '#F0F0F3'
      }
   },

   navigation: {
      buttonOptions: {
         symbolStroke: '#DDDDDD',
         theme: {
            fill: '#505053'
         }
      }
   },

   // scroll charts
   rangeSelector: {
      buttonTheme: {
         fill: '#505053',
         stroke: '#000000',
         style: {
            color: '#CCC'
         },
         states: {
            hover: {
               fill: '#707073',
               stroke: '#000000',
               style: {
                  color: 'white'
               }
            },
            select: {
               fill: '#000003',
               stroke: '#000000',
               style: {
                  color: 'white'
               }
            }
         }
      },
      inputBoxBorderColor: '#505053',
      inputStyle: {
         backgroundColor: '#333',
         color: 'silver'
      },
      labelStyle: {
         color: 'silver'
      }
   },

   navigator: {
      handles: {
         backgroundColor: '#666',
         borderColor: '#AAA'
      },
      outlineColor: '#CCC',
      maskFill: 'rgba(255,255,255,0.1)',
      series: {
         color: '#7798BF',
         lineColor: '#A6C7ED'
      },
      xAxis: {
         gridLineColor: '#505053'
      }
   },

   scrollbar: {
      barBackgroundColor: '#808083',
      barBorderColor: '#808083',
      buttonArrowColor: '#CCC',
      buttonBackgroundColor: '#606063',
      buttonBorderColor: '#606063',
      rifleColor: '#FFF',
      trackBackgroundColor: '#404043',
      trackBorderColor: '#404043'
   },

   // special colors for some of the
   legendBackgroundColor: 'rgba(0, 0, 0, 0.5)',
   background2: '#505053',
   dataLabelsColor: '#B0B0B3',
   textColor: '#C0C0C0',
   contrastTextColor: '#F0F0F3',
   maskColor: 'rgba(255,255,255,0.3)'
};

// Apply the theme
Highcharts.setOptions(Highcharts.theme); 
       Highcharts.setOptions({
        global: {
            useUTC: false //false-Muestra con la hora local true-Muestra hora universal
        }
    });
    $('#container1').highcharts({
        chart: {
            type: 'spline',
            zoomType: 'xy',
        },
        colors: ['#337ab7', '#cc3c1a'],
        "title": {
            "text": titulo, 
            "style":{"fontFamily":"\"Lucida Grande\", \"Lucida Sans Unicode\", Verdana,Arial,               Helvetica, sans-serif",
                                 "color":"#91e8e1",
                                 "fontSize":"20px",
                                 "fontWeight":"normal",
                                 "fontStyle":"normal",
                                 "fill":"#333333"},
            
        },
        xAxis: {
             type: 'datetime',
             
        },
        yAxis: {
            title: {
                text: 'Temperatura *C',
                "style":{
                                 "color":"#91e8e1",
                                 "fontSize":"16px",
                                 "fontWeight":"normal",
                                 "fontStyle":"normal",
                                 },
            },
        plotBands: [ { // Frio
            from: 10,
            to: 19,
            color: 'rgba(0, 0, 0, 0)',
            label: {
                text: 'Frío',
                style: {
                    color: '#606060',
                    "fontSize":"18px"
                }
            }
        }, { // Templado
            from: 19,
            to: 20.5,
            color: 'rgba(68, 170, 213, 0.1)',
            label: {
                text: 'Templado',
                style: {
                    color: '#606060',
                    "fontSize":"18px"
                }
            }
        }, { // Calido
            from: 20.5,
            to: 23,
            color: 'rgba(0, 0, 0, 0)',
            label: {
                text: 'Calido',
                
                style: {
                    color: '#606060',
                    "fontSize":"18px"
                }
            }
        }, { // Muy Caliente
            from: 23,
            to: 40,
            color: 'rgba(68, 170, 213, 0.1)',
            label: {
                text: 'Caluroso',
                style: {
                    color: '#606060',
                    "fontSize":"18px"
                }
            }
        }]
        },
        tooltip: {
            valueSuffix: ' *C'
        },  
    
        series: [{
            name: disp,

            data: [  <?php temperatura_diaria($conexion,$serie,$intervalo,$mes,$dia,$todo);  
                     ?> 
        ]},

    ],

    navigation: {
        menuItemStyle: {
            fontSize: '12px'
        }
    }
    
    });
});

</script>
















