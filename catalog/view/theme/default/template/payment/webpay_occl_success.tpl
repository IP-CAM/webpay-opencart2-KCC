<?php 
 if(isset($tbk_id_sesion) && isset($tbk_codigo_autorizacion)) {
error_reporting(E_ALL ^ E_WARNING);
error_reporting(0);

	 echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
 ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $language; ?>" xml:lang="<?php echo $language; ?>">
<head>



<link href='https://fonts.googleapis.com/css?family=Open+Sans:700italic,400,700' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $themeName;?>/stylesheet/boss_add_cart.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $themeName;?>/stylesheet/boss_carousel.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $themeName;?>/stylesheet/boss_megamenu.css" />
  <link href="catalog/view/javascript/radio/skins/square/square.css" rel="stylesheet">
<script src="catalog/view/javascript/radio/icheck.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">


<!-- <meta http-equiv="refresh" content="5;url=<?php echo $continue; ?>"> -->
<title><?php echo $title; ?></title>

<base href="<?php echo $base; ?>" />

</head>
<body>
<div style="text-align: center;">
<center>     <?php if ($logo) { ?>
          <a href=""><img src="<?php echo $logo; ?>" class="img-responsive" /></a>
          <?php } else { ?>
          <h1><a href="<?php echo $home; ?>"><?php echo $name; ?></a></h1>
          <?php } ?></center>
<br />
  <h4 class="margin-top">Gracias por comprar en <?php echo $name; ?></h4>
  <p><?php echo $text_response; ?></p>
  <hr />
  <table style="margin-left: auto; margin-right: auto; text-align: left;">
    <tr>
      <th colspan="2" style="text-align: center;"><h4 class="margin-titulo">Datos de la compra</h4></th>
    </tr>
    <tr>
      <td><b>Nombre del comercio:</b></td>
      <td><?php echo $tbk_nombre_comercio; ?></td>
    </tr>
    <tr>
      <td><b>URL del comercio:</b></td>
      <td><?php echo $tbk_url_comercio; ?></td>
    </tr>
    <tr>
      <td><b>Nombre del comprador:</b></td>
      <td><?php echo $tbk_nombre_comprador; ?></td>
    </tr>
    <tr>
      <td><b>N&uacute;mero del pedido:</b></td>
      <td><?php echo $tbk_orden_compra; ?></td>
    </tr>
    <tr>
      <td><b>Monto (pesos chilenos):</b></td>
      <td>$<?php  $monto = ($tbk_monto / 100); echo number_format($monto,0,".","."); ?></td>
    </tr>
    <tr>
      <th colspan="2" style="text-align: center;"><h4 class="margin-titulo">Datos de la transacci&oacute;n</h4></th>
    </tr>
    <tr>
      <td><b>C&oacute;digo de autorizaci&oacute;n:</b></td>
      <td><?php echo $tbk_codigo_autorizacion; ?></td>
    </tr>
    <tr>
      <td><b>Fecha de la transacci&oacute;n:</b></td>
      <td><?php echo $tbk_fecha_transaccion; ?></td>
    </tr>
    <tr>
      <td><b>Hora de la transacci&oacute;n:</b></td>
      <td><?php echo $tbk_hora_transaccion; ?></td>
    </tr>
    <tr>
      <td><b>Tarjeta :</b></td>
      <td><?php echo $tbk_final_numero_tarjeta; ?></td>
    </tr>
    <tr>
      <td><b>Tipo de transacci&oacute;n:</b></td>
      <td><?php echo $tbk_tipo_transaccion; ?></td>
    </tr>
    <tr>
      <td><b>Tipo de pago:</b></td>
      <td><?php echo $tbk_tipo_pago; ?></td>
    </tr>
    <tr>
      <td><b>N&uacute;mero de cuotas:</b></td>
      <td><?php echo $tbk_numero_cuotas; ?></td>
    </tr>
    <tr>
      <td><b>Tipo de cuotas:</b></td>
      <td><?php echo $tbk_tipo_cuotas; ?></td>
    </tr>
  </table>
  <br />
  <div class="container" >
  <table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
    <thead>
      <tr>
        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;"><?php echo $column_name; ?></td>
        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;"><?php echo $column_model; ?></td>
        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;"><?php echo $column_quantity; ?></td>
        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;"><?php echo $column_price; ?></td>
        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;"><?php echo $column_total; ?></td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $product) { ?>
      <tr>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?php echo $product['name']; ?>
          
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?php echo $product['model']; ?></td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?php echo $product['quantity']; ?></td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;">$<?php echo number_format($product['price'],0,".",".") ?></td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;">$<?php echo number_format($product['total'],0,".","."); ?></td>
      </tr>
      <?php } ?>
      <?php foreach ($vouchers as $voucher) { ?>
      <tr>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?php echo $voucher['description']; ?></td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"></td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;">1</td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?php echo number_format($voucher['amount'],0,".","."); ?></td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?php echo number_format($voucher['amount'],0,".","."); ?></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php
       foreach ($totals as $total) {
      
       ?>
      <tr>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;" colspan="4"><b><?php echo $total['title']; ?>:</b></td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;">
        <?php
        if($total['title']=='Envío por pagar a oficina de Chilexpres')
        {
        	echo "Por Pagar"; 
        }
        elseif($total['title']=='Recoger en Tienda')
        {
        	echo "Sin Costo"; 
        }
        else
        { 
        	echo "$".number_format($total['value'],0,".",".");
        }
        
         
         ?></td>
      </tr>
      <?php } ?>
    </tfoot>
  
  </table>
  <div>
 <!-- <p><a class="no-print" target="_blank" href="https://www.8-bitsvitacura.cl/terminos-y-condiciones">Términos y condiciones</a>-->
  <?php //echo $return_policy; ?></p>
  <hr />
  <p class="no-print"><?php echo $text_success; ?></p>
  <p class="no-print"><?php echo $text_success_wait; ?></p>
   <b>No se realizan devoluciones, ni reembolsos.</b><p class="">
En caso de tener alguna duda favor de contactar a (Juan Fernández R) o (Departamento E-commerce) al teléfono (22-2447318) o al mail (Contacto@8-bits.cl)</p>



  <!--
Faltan:
- Ver archivo './catalog/model/checkout/order.php' para obtener las variables $vouchers y $totals.
  -->
</div>
</body>
</html>
<?php
}else{
?>
<meta http-equiv="Refresh" content="0;url=https://www.8-bitsvitacura.cl/">
<?php } ?>