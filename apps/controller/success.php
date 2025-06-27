<?php
class ControllerSuccess extends Controller {
	public function index() {
			unset($this->session->data['booking_id']);
		if (isset($this->session->data['order_id'])) {
			$this->cart->clear();
			unset($this->session->data['order_id']);
		}
		$this->document->setTitle('Success');
		if ($this->session->data['member_id'] && $this->session->data['is_logged_in']) {
			$data['text_message'] = 'dssd';
		} 

		$data['continue'] = HTTP_HOST . 'home';
		$this->template = 'wvalley/template/success.tpl';
		$this->data = $data;

		$this->zones = array(
			'header',
			'footer'
		);
		$this->response->setOutput($this->render());


	}
}