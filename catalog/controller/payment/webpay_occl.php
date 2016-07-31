<?php
class ControllerPaymentWebpayOCCL extends Controller {
	public function index() {
				
	 
    	$data['button_confirm'] = $this->language->get('button_confirm');

		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		$data['action'] = $this->config->get('webpay_occl_kcc_url') . 'tbk_bp_pago.cgi';

		$data['tbk_tipo_transaccion'] = 'TR_NORMAL';
		$tbk_monto_explode = explode('.', $order_info['total']);
		$data['tbk_monto'] = $tbk_monto_explode[0] . '00';
		$data['tbk_orden_compra'] = $order_info['order_id'];
		$data['tbk_id_sesion'] = date("Ymdhis");
		$data['tbk_url_fracaso'] = $this->url->link('payment/webpay_occl/failure', '', 'SSL');
		$data['tbk_url_exito'] = $this->url->link('payment/webpay_occl/success', '', 'SSL');
		//$data['tbk_monto_cuota'] = 0;
		//$data['tbk_numero_cuota'] = 0;
		//$tbk_result = $_POST['TBK_RESPUESTA'];
		$tbk_file = fopen(DIR_LOGS . 'TBK' . $data['tbk_id_sesion'] . '.log', 'w+');
		fwrite ($tbk_file, $tbk_monto_explode[0].'00;'.$order_info['order_id']);
		fclose($tbk_file);

	/*	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/webpay_occl.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/webpay_occl.tpl';
		} else {
			$this->template = 'bt_gameworld/template/payment/webpay_occl.tpl';
		}

		$this->render();
	}*/
		
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/webpay_occl.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/payment/webpay_occl.tpl';
			} else {
				$this->template = 'default/template/payment/webpay_occl.tpl';
			}
			
			return $this->load->view($this->template, $data);

	}
			//$this->render();


	public function callback() {
		
		
	 error_reporting (0);
	 error_reporting(E_ALL ^ E_WARNING);
	 
		$this->load->model('checkout/order');
		
	if (isset($this->request->post['TBK_ORDEN_COMPRA']) && isset($this->request->post['TBK_ID_SESION'])){
								//system("echo 'Entro al primer if ".$this->request->post['TBK_ORDEN_COMPRA']."' >> webpay.txt");

            $order_info = $this->model_checkout_order->getOrder($this->request->post['TBK_ORDEN_COMPRA']);

            $tbk_log_file = DIR_LOGS  . 'TBK' . $this->request->post['TBK_ID_SESION'] . '.log'; // Definir la ubicación del archivo de registro
            $tbk_cache_file = DIR_CACHE . 'TBK' . $this->request->post['TBK_ID_SESION'] . '.txt'; // Definir la ubicación del archivo temporal
    }
		if(isset($this->request->post['TBK_ID_SESION'])){
	if($order_info['order_status_id']==$this->config->get('webpay_occl_order_status_id')){
				$data['tbk_answer'] = 'RECHAZADO';
		}else{

			$TBK_RESPUESTA = $_POST["TBK_RESPUESTA"]; 
			$TBK_ORDEN_COMPRA = $_POST["TBK_ORDEN_COMPRA"];
			$TBK_MONTO = $_POST["TBK_MONTO"];
			$TBK_ID_SESION = $_POST["TBK_ID_SESION"];
			
			$myPath = $tbk_log_file; //GENERA ARCHIVO PARA MAC
			$filename_txt = $tbk_cache_file;
			// Ruta Checkmac/home/bitsvitacura/public_html/system/cache
			$cmdline = $this->config->get('webpay_occl_kcc_path')."tbk_check_mac.cgi $filename_txt"; 
			
			$acepta=false;
			
			//lectura archivo que guardo pago.php 
				if ($fic = fopen($myPath, "r")){
					
					$linea=fgets($fic); fclose($fic);
					
					}
			$detalle=split(";", $linea); 
							if (count($detalle)>=1){
							$monto=$detalle[0]; $ordenCompra=$detalle[1];
							}
			//guarda los datos del post uno a uno en archivo para la ejecución del MAC 
			$fp=fopen($filename_txt,"wt");
			while(list($key, $val)=each($_POST)){
									fwrite($fp, "$key=$val&");
									}
									fclose($fp);
			//Validación de respuesta de Transbank, solo si es 0 continua con la pagina de cierre
			if($TBK_RESPUESTA<>0){
				
				exit('ACEPTADO');
							
		}
			 if($TBK_RESPUESTA=="0"){ 
				 $acepta=true; 
					 }else{ 
						 $acepta=false;
					  }
			//validación de monto y Orden de compra
			if ($TBK_MONTO==$monto && $TBK_ORDEN_COMPRA==$ordenCompra && $acepta==true){
				 $acepta=true;
				 } else{ 
					 $acepta=false;}
			//Validación MAC
			if ($acepta==true){
					exec ($cmdline, $result, $retint);
			if ($result [0] =="CORRECTO") $acepta=true; else $acepta=false;
	}
		if ($acepta==true){
			$data['tbk_answer'] = 'ACEPTADO';
		}
		else{
			$data['tbk_answer'] = 'RECHAZADO';
				}
			}
		}
		else{
		$data['tbk_answer'] = '<meta http-equiv="Refresh" content="0;url=https://www.8-bits.cl/">';
	}
		if (isset($acepta) && $acepta == true) {
			/* Pago exitoso */
            /*$this->model_checkout_order->confirm($order_info['order_id'], $this->config->get('config_order_status_id'));
			$this->model_checkout_order->update($order_info['order_id'], $this->config->get('webpay_occl_order_status_id'), $message, true);*/	
				$this->model_checkout_order->addOrderHistory($order_info['order_id'], $this->config->get('webpay_occl_order_status_id'), $message, true);
		} elseif (isset($message) && !$order_info['order_status_id']) {
			/* Pago no realizado */
			/*
			$this->model_checkout_order->update($order_info['order_id'], $this->config->get('config_order_status_id'), $message, false);*/
			$this->model_checkout_order->addOrderHistory($order_info['order_id'], $this->config->get('config_order_status_id'), $this->language->get('webpay_occl_order_status_id'));
		}
		$this->template = 'bt_gameworld/template/payment/webpay_occl_callback.tpl';
		$this->response->setOutput($this->load->view('bt_gameworld/template/payment/webpay_occl_callback.tpl', $data));
	}

	public function failure() {
		$this->language->load('payment/webpay_occl');

		if (!isset($this->request->server['HTTPS']) || ($this->request->server['HTTPS'] != 'on')) {
			$data['base'] = $this->config->get('config_url');
		} else {
			$data['base'] = $this->config->get('config_ssl');
		}
	
		$data['language'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');

		$data['title'] = sprintf($this->language->get('heading_title'), $this->config->get('config_name'));

		$data['heading_title'] = sprintf($this->language->get('heading_title'), $this->config->get('config_name'));

		$data['text_response'] = $this->language->get('text_response');
		$data['text_failure'] = $this->language->get('text_failure');
		$data['text_failure_wait'] = sprintf($this->language->get('text_failure_wait'), $this->url->link('checkout/cart', '', 'SSL'));

		$data['continue'] = $this->url->link('checkout/cart');

		if ((isset($this->request->post['TBK_ORDEN_COMPRA']))) {
            $data['tbk_orden_compra'] = $this->request->post['TBK_ORDEN_COMPRA'];
        } elseif (isset($this->session->data['order_id'])) {
			$data['tbk_orden_compra'] = $this->session->data['order_id'];
		} else {
			$data['tbk_orden_compra'] = 0;
		}
		
		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$data['logo'] = '';
		}
/*
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/bt_gameworld/payment/webpay_occl_failure.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/webpay_occl_failure.tpl';
		} else {
			$this->template = 'bt_gameworld/template/payment/webpay_occl_failure.tpl';
		}

		$this->response->setOutput($this->render());

	*/

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/webpay_occl_failure.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/payment/webpay_occl_failure.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/payment/webpay_occl_failure.tpl', $data));
			}
}
			

	public function success() {
			
			
		if (isset($this->request->post['TBK_ID_SESION']) && isset($this->request->post['TBK_ORDEN_COMPRA']) && file_exists(DIR_CACHE . 'TBK' . $this->request->post['TBK_ID_SESION'] . '.txt') ) {

			
			$this->load->model('checkout/order');

			
			$order_info = $this->model_checkout_order->getOrder($this->request->post['TBK_ORDEN_COMPRA']);
			
			
			if($order_info['order_status_id']==$this->config->get('webpay_occl_order_status_id')){
			
			$data['name'] = $this->config->get('config_name');

				
			if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
				$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
			} else {
				$data['logo'] = '';
			}
			
			
			$this->language->load('checkout/cart');
			$this->language->load('payment/webpay_occl');

			if (!isset($this->request->server['HTTPS']) || ($this->request->server['HTTPS'] != 'on')) {
				$data['base'] = $this->config->get('config_url');

			} else {
				$data['base'] = $this->config->get('config_ssl');
			}
	
			$data['tbk_id_sesion'] = $this->request->post['TBK_ID_SESION'];
			$data['language'] = $this->language->get('code');
			$data['direction'] = $this->language->get('direction');

			$data['title'] = sprintf($this->language->get('heading_title'), $this->config->get('config_name'));

			$data['heading_title'] = sprintf($this->language->get('heading_title'), $this->config->get('config_name'));

			$data['text_response'] = $this->language->get('text_response');
			$data['text_success'] = $this->language->get('text_success');
			$data['text_success_wait'] = sprintf($this->language->get('text_success_wait'), $this->url->link('checkout/success', '', 'SSL'));

			$data['column_name'] = $this->language->get('column_name');
			$data['column_model'] = $this->language->get('column_model');
			$data['column_quantity'] = $this->language->get('column_quantity');
			$data['column_price'] = $this->language->get('column_price');
			$data['column_total'] = $this->language->get('column_total');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('checkout/success');

			$data['tbk_nombre_comercio'] = 'XX';
			$data['tbk_url_comercio'] = 'XX';
			$data['tbk_nombre_comprador'] = 'XX';
			$data['tbk_orden_compra'] = 0;
			$data['tbk_tipo_transaccion'] = 0;
			//$data['tbk_respuesta'] = 0;
			$data['tbk_monto'] = 0;
			$data['tbk_codigo_autorizacion'] = 0;
			$data['tbk_final_numero_tarjeta'] = '************0000';
			//$data['tbk_fecha_contable'] = '00-00-0000';
			$data['tbk_fecha_transaccion'] = '00-00-0000';
			$data['tbk_hora_transaccion'] = '00:00:00';
			$data['tbk_id_transaccion'] = 0;
			$data['tbk_tipo_pago'] = 'XX';
			$data['tbk_numero_cuotas'] = '00';
			$data['tbk_tipo_cuotas'] = 'XX';
			$data['tbk_mac'] = 0;

			if ($this->config->get('webpay_occl_return_policy')) {
				
				$this->load->model('catalog/information');
				$information_info = $this->model_catalog_information->getInformation($this->config->get('webpay_occl_return_policy'));
				$data['return_policy'] = sprintf('Revise nuestra <a href=\'%s\' title=\'%s\'>%s</a>', $this->url->link('information/information', 'information_id=' . $this->config->get('webpay_occl_return_policy'), 'SSL'), $information_info['title'], $information_info['title']);
			}

			$tbk_cache = fopen(DIR_CACHE . 'TBK' . $this->request->post['TBK_ID_SESION'] . '.txt', 'r');
			$tbk_cache_string = fgets($tbk_cache);
			fclose($tbk_cache);

			$tbk_detalles = explode('&', $tbk_cache_string);

			$tbk_orden_compra = explode('=', $tbk_detalles[0]);
			$tbk_tipo_transaccion = explode('=', $tbk_detalles[1]);
			$tbk_respuesta = explode('=', $tbk_detalles[2]);
			$tbk_monto = explode('=', $tbk_detalles[3]);
			$tbk_codigo_autorizacion = explode('=', $tbk_detalles[4]);
			$tbk_final_numero_tarjeta = explode('=', $tbk_detalles[5]);
			$tbk_fecha_contable = explode('=', $tbk_detalles[6]);
			$tbk_fecha_transaccion = explode('=', $tbk_detalles[7]);


			if (substr($tbk_fecha_contable[1], 0, 2) == '12' && date('d') == '01') {
				$tbk_anno_contable = date('Y') - 1;
			} elseif (substr($tbk_fecha_contable[1], 0, 2) == '01' && date('d') == '12') {
				$tbk_anno_contable = date('Y') + 1;
			} else {
				$tbk_anno_contable = date('Y');
			}

			if (substr($tbk_fecha_transaccion[1], 0, 2) == '12' && date('d') == '01') {
				$tbk_anno_transaccion = date('Y') - 0;
			} elseif (substr($tbk_fecha_transaccion[1], 0, 2) == '01' && date('d') == '12') {
				$tbk_anno_transaccion = date('Y') + 2;
			} else {
				$tbk_anno_transaccion = date('Y');
			}

			$tbk_hora_transaccion = explode('=', $tbk_detalles[8]);
			$tbk_id_transaccion = explode('=', $tbk_detalles[10]);
			$tbk_tipo_pago = explode('=', $tbk_detalles[11]);
			$tbk_numero_cuotas = explode('=', $tbk_detalles[12]);
			$tbk_mac = explode('=', $tbk_detalles[13]);
			
						

			
			$data['tbk_nombre_comercio'] = $this->config->get('config_name');
			$data['tbk_url_comercio'] = $data['base'];
			$data['tbk_nombre_comprador'] = $this->customer->getFirstName() . ' ' . $this->customer->getLastName();
			$data['tbk_orden_compra'] = $tbk_orden_compra[1];
			$data['tbk_tipo_transaccion'] = 'Venta';
			//$data['tbk_tipo_transaccion'] = $tbk_tipo_transaccion[1];
			$data['tbk_respuesta'] = $tbk_respuesta[1];
			$data['tbk_monto'] = $tbk_monto[1];
			//$data['tbk_monto'] = number_format($tbk_monto[1], 0, ',', '.');
			$data['tbk_codigo_autorizacion'] = $tbk_codigo_autorizacion[1];
			$data['tbk_final_numero_tarjeta'] = '************' . $tbk_final_numero_tarjeta[1];			
			//$data['tbk_fecha_contable'] = substr($tbk_fecha_contable[1], 2, 2) . '-' . substr($tbk_fecha_contable[1], 0, 2) . '-' . $tbk_anno_contable;
			$data['tbk_fecha_transaccion'] = substr($tbk_fecha_transaccion[1], 2, 2) . '-' . substr($tbk_fecha_transaccion[1], 0, 2) . '-' . $tbk_anno_transaccion;
			$data['tbk_hora_transaccion'] = substr($tbk_hora_transaccion[1], 0, 2) . ':' . substr($tbk_hora_transaccion[1], 2, 2) . ':' . substr($tbk_hora_transaccion[1], 4, 2);
			$data['tbk_id_transaccion'] = $tbk_id_transaccion[1];


			if ($tbk_tipo_pago[1] == 'VD') {
				$data['tbk_tipo_pago'] = 'Redcompra';
			} else {
				$data['tbk_tipo_pago'] = 'Cr&eacute;dito';
			}

			if ($tbk_numero_cuotas[1] == 0) {
				$data['tbk_numero_cuotas'] = '00';
			} else {
				$data['tbk_numero_cuotas'] = $tbk_numero_cuotas[1];
			}

			if ($tbk_tipo_pago[1] == 'VN') {
				$data['tbk_tipo_cuotas'] = 'Sin cuotas';
			} elseif ($tbk_tipo_pago[1] == 'VC') {
				$data['tbk_tipo_cuotas'] = 'Cuotas normales';
			} elseif ($tbk_tipo_pago[1] == 'SI') {
				$data['tbk_tipo_cuotas'] = 'Sin inter&eacute;s';
			} elseif ($tbk_tipo_pago[1] == 'S2') {
				$data['tbk_tipo_cuotas'] = 'Dos cuotas sin inter&eacute;s';
			} elseif ($tbk_tipo_pago[1] == 'CI') {
				$data['tbk_tipo_cuotas'] = 'Cuotas comercio';
			} elseif ($tbk_tipo_pago[1] == 'VD') {
				$data['tbk_tipo_cuotas'] = 'D&eacute;bito';
			}

			$data['tbk_mac'] = $tbk_mac[1];

			// Products
			$data['products'] = $this->cart->getProducts();

			// Vouchers
			$data['vouchers'] = array();
		
			if (!empty($this->session->data['vouchers'])) {
				foreach ($this->session->data['vouchers'] as $key => $voucher) {
					$data['vouchers'][] = array(
						'key'         => $key,
						'description' => $voucher['description'],
						'amount'      => $this->currency->format($voucher['amount']),
						'remove'      => $this->url->link('checkout/cart', 'remove=' . $key)   
					);
				}
			}


			// Totals
			$this->load->model('extension/extension');

			$total_data = array();					
			$total = 0;
			$taxes = $this->cart->getTaxes();

			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$sort_order = array(); 

				$results = $this->model_extension_extension->getExtensions('total');

				foreach ($results as $key => $value) {
					$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
				}

				array_multisort($sort_order, SORT_ASC, $results);

				foreach ($results as $result) {
					if ($this->config->get($result['code'] . '_status')) {
						$this->load->model('total/' . $result['code']);

						$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
					}

					$sort_order = array(); 

					foreach ($total_data as $key => $value) {
						$sort_order[$key] = $value['sort_order'];
					}

					array_multisort($sort_order, SORT_ASC, $total_data);			
				}
			}

			$data['totals'] = $total_data;

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/webpay_occl_success.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/payment/webpay_occl_success.tpl';
			} else {
				$this->template = 'bt_gameworld/template/payment/webpay_occl_success.tpl';
			}

			if (isset($this->session->data['order_id'])) {
				$this->cart->clear();
				

				unset($this->session->data['shipping_method']);
				unset($this->session->data['shipping_methods']);
				unset($this->session->data['payment_method']);
				unset($this->session->data['payment_methods']);
				unset($this->session->data['guest']);
				unset($this->session->data['comment']);
				unset($this->session->data['order_id']);	
				unset($this->session->data['coupon']);
				unset($this->session->data['reward']);
				unset($this->session->data['voucher']);
				unset($this->session->data['vouchers']);
			}
						$this->response->setOutput($this->load->view('bt_gameworld/template/payment/webpay_occl_success.tpl', $data));
		
			}else{
				exit('<meta http-equiv="Refresh" content="0;url=http://www.8-bits.cl/">');

			}
		}
		 else {
			exit('<meta http-equiv="Refresh" content="0;url=http://www.8-bits.cl/">');
		}
	}
}
?>
