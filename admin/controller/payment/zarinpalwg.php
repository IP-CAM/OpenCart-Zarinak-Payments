<?php 


class ControllerPaymentzarinpalwg extends Controller {
	private $error = array(); 

	public function index() {
		$this->load->language('payment/zarinpalwg');


		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->load->model('setting/setting');
			
			$this->model_setting_setting->editSetting('zarinpalwg', $this->request->post);				
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->https('extension/payment'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		
		$this->data['entry_PIN'] = $this->language->get('entry_PIN');
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');		
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['help_encryption'] = $this->language->get('help_encryption');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

		$this->data['error_warning'] = @$this->error['warning'];
		$this->data['error_PIN'] = @$this->error['PIN'];

		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('extension/payment'),
       		'text'      => $this->language->get('text_payment'),
      		'separator' => ' :: '
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('payment/zarinpalwg'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
				
		$this->data['action'] = $this->url->https('payment/zarinpalwg');
		
		$this->data['cancel'] = $this->url->https('extension/payment');

		if (isset($this->request->post['zarinpalwg_PIN'])) {
			$this->data['zarinpalwg_PIN'] = $this->request->post['zarinpalwg_PIN'];
		} else {
			$this->data['zarinpalwg_PIN'] = $this->config->get('zarinpalwg_PIN');
		}
		
		
		if (isset($this->request->post['zarinpalwg_order_status_id'])) {
			$this->data['zarinpalwg_order_status_id'] = $this->request->post['zarinpalwg_order_status_id'];
		} else {
			$this->data['zarinpalwg_order_status_id'] = $this->config->get('zarinpalwg_order_status_id'); 
		} 

		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->post['zarinpalwg_status'])) {
			$this->data['zarinpalwg_status'] = $this->request->post['zarinpalwg_status'];
		} else {
			$this->data['zarinpalwg_status'] = $this->config->get('zarinpalwg_status');
		}
		
		if (isset($this->request->post['zarinpalwg_sort_order'])) {
			$this->data['zarinpalwg_sort_order'] = $this->request->post['zarinpalwg_sort_order'];
		} else {
			$this->data['zarinpalwg_sort_order'] = $this->config->get('zarinpalwg_sort_order');
		}
		
		$this->id       = 'content';
		$this->template = 'payment/zarinpalwg.tpl';
		$this->layout   = 'common/layout';
		
 		$this->render();
	}

	private function validate() {

		if (!$this->user->hasPermission('modify', 'payment/zarinpalwg')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!@$this->request->post['zarinpalwg_PIN']) {
			$this->error['PIN'] = $this->language->get('error_PIN');
		}

		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
}
?>