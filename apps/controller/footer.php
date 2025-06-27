<?php
class ControllerFooter extends Controller
{
	private $error = array();
	public function index()
	{
		$this->load_model('footer');
		$data['footerMenus'] = array();
		$data['footerMenus'] = $this->model_footer->getFooterMenu('Bottom');

		$data['footerLegalsMenus'] = array();
		$data['footerLegalsMenus'] = $this->model_footer->getFooterMenu('Legals');
		// echo '<pre>'; print_r($data['BusinessMenu']); exit;
		$data['logo'] = BASE_URL . "uploads/image/setting/" . $this->config->get('config_flogo');
		$data['config_address_location'] = $this->config->get('config_address_location');
		$data['facebook'] = $this->config->get('config_facebook');
		$data['twitter'] = $this->config->get('config_twitter');
		$data['instagram'] = $this->config->get('config_instagram');
		$data['youtube'] = $this->config->get('config_youtube');
		$data['whatsapp'] = $this->config->get('config_whatsapp');
		$data['config_name'] = $this->config->get('config_name' . $this->config->get('config_language_id'));
		$data['config_telephone'] = $this->config->get('config_telephone');
		$data['config_email'] = $this->config->get('config_email');
		$data['config_map'] = $this->config->get('config_map');
		$data['config_f_description'] = $this->config->get('config_f_description' . $this->config->get('config_language_id'));
		$data['text_our_business'] = $this->language->get('text_our_business');
		$data['text_copyrights'] = $this->language->get('text_copyrights');
		$data['contact_us'] = $this->language->get('contact_us');
		$data['text_legals'] = $this->language->get('text_legals');
		$data['text_quick_links'] = $this->language->get('text_quick_links');
		$data['follow_us'] = $this->language->get('follow_us');
		$data['admin_location']  = $this->config->get('config_address' . $this->config->get('config_language_id'));
		$this->id = 'footer';
		$this->template = 'food/template/common/footer.tpl'; 
		$this->data = $data; 
		$this->response->setOutput($this->render());
	} 
}