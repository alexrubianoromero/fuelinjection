$("#btn_crear_cuenta").click(function(){
//   alert('crearcuenta');
var idorden =  $("#idorden").val();
  $.ajax({
        url:"../cxp/crear_cxp.php",
        type:"POST",
        data:{
            "idorden":idorden
        },
        success: function(resp){
           $("#div_resultados_cxp").html(resp);
        }        
  });
});

$("#btn_grabar_cxp").click(function(){
    //   alert('crearcuenta');
    var idorden =  $("#idorden").val();
    var id_tecnico =  $("#id_tecnico").val();
    var valor =  $("#valor").val();
    var observaciones =  $("#observaciones").val();
    var tipocxp =  $("#tipocxp").val();
      $.ajax({
            url:"../cxp/grabar_cuenta.php",
            type:"POST",
            data:{
                "idorden":idorden,"id_tecnico":id_tecnico,"valor":valor,"observaciones":observaciones,
                "tipocxp":tipocxp
            },
            success: function(resp){
               $("#div_resultados_cxp").html(resp);
            }        
      });
    });

    $("#btn_listar_cuentas").click(function(){
        //   alert('crearcuenta');
          var idorden =  $("#idorden").val();
          $.ajax({
                url:"../cxp/listadocxp.php",
                type:"POST",
                data:{
                    "idorden":idorden
                },
                success: function(resp){
                   $("#div_resultados_cxp").html(resp);
                }        
          });
        });
        $("#btn_listar_cuentas_historico").click(function(){
          //   alert('crearcuenta');
          var idorden =  $("#idorden").val();
            $.ajax({
                  url:"../cxp/listadocxp.php",
                  type:"POST",
                  data:{
                    "idorden":idorden,
                      "historico":"1"
                  },
                  success: function(resp){
                     $("#div_resultados_cxp").html(resp);
                  }        
            });
          });
        
        $(".crear_abono").click(function(){
            var id = $(this).val();
            //   alert('crearcuenta');
            // var idorden =  $("#idorden").val();
            var tipo_recibo = '2';
              $.ajax({
                    url:"../cxp/captura_recibos_de_caja_cxp.php",
                    type:"POST",
                    data:{
                        "tipo_recibo":tipo_recibo,
                        "id":id
                    },
                    success: function(resp){
                       $("#div_resultados_cxp").html(resp);
                    }        
              });
            });


            $("#btn_grabar_recibo").click(function(){
							var data =  'fecha=' + $("#fecha").val();
							data += '&dequienoaquin=' + $("#dequienoaquin").val();
							data += '&porconceptode=' + $("#porconceptode").val();
							data += '&lasumade=' + $("#lasumade").val();
							data += '&observaciones=' + $("#observaciones").val();
							data += '&tipo_recibo=' + $("#tipo_recibo").val();
							data += '&numero_recibo=' + $("#numero_recibo").val();
              data += '&id_mecanico=' + $("#id_mecanico").val();
              data += '&id_cxp=' + $("#id_cxp").val();
							$.post('../cxp/grabar_recibo_caja_cxp.php',data,function(a){
							//$(window).attr('location', '../index.php);
							$("#div_resultados_cxp").html(a);
								//alert(data);
							});	
						 });           


             $(".ver_abonos").click(function(){
              var id = $(this).val();
              //   alert('crearcuenta');
              // var idorden =  $("#idorden").val();
              var tipo_recibo = '2';
                $.ajax({
                      url:"../cxp/listado_abonos.php",
                      type:"POST",
                      data:{
                          "id":id
                      },
                      success: function(resp){
                         $("#div_abonos").html(resp);
                      }        
                });
              });

          

