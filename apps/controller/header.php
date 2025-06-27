<?php
class ControllerHeader extends Controller
{
	public function __construct($registry)
	{
		$this->registry = $registry;
	}
	public function index()
	{
		$this->load_model('footer');
		$this->load_model('home');
		$data = array();
		$data = $this->language->getAll();
		$data['headerMenus'] = array();
		$data['headerMenus'] = $this->model_footer->getFooterMenu('Top');
		$currentUrl = $_SERVER['REQUEST_URI'];  
        $data['currentUrl'] = $currentUrl;
		$data['hlogo'] = BASE_URL . "uploads/image/setting/" . $this->config->get('config_hlogo');
		$data['flogo'] = BASE_URL . "uploads/image/setting/" . $this->config->get('config_favicon');
		$data['config_name'] = $this->config->get('config_name' . $this->config->get('config_language_id'));
		$data['lang'] = $this->config->get('config_language');
		$data['config_facebook'] = $this->config->get('config_facebook');
		$data['config_twitter'] = $this->config->get('config_twitter');
		$data['config_instagram'] = $this->config->get('config_instagram');
		$data['config_youtube'] = $this->config->get('config_youtube');
		$classurl = $_SERVER['REQUEST_URI'];
		$classurl = trim($classurl, '/');
		if (!empty($classurl) && $classurl !== "ar") {
			$class = preg_replace(['/\?[^?]*$/', '/\//'], ['', '-'], $classurl);
			$data['body_class'] = trim($class, '-');
		} else {
			$data['body_class'] = 'home';
		}
		$data['meta_title'] = $this->document->getTitle();
		$data['meta_description'] = $this->document->getDescription();
		$data['meta_keywords'] = $this->document->getKeywords();
		$data['langauges'] = $this->load_controller('language');
		$data['lang'] = $this->session->data['lang'];
		$data['text_our_companies_drop']   	    =   $this->language->get('text_our_companies_drop');
		$data['text_al_othaim_investment']   	=  	$this->language->get('text_al_othaim_investment');
		$data['text_al_othaim_mall']   			= 	$this->language->get('text_al_othaim_mall');
		$data['text_al_othaim_life']   			= 	$this->language->get('text_al_othaim_life');
		$data['text_al_othaim_entertainment']   = 	$this->language->get('text_al_othaim_entertainment');
		$data['text_al_othaim_noircinema']   	=   $this->language->get('text_al_othaim_noircinema');
		$data['text_al_othaim_sport']   		=   $this->language->get('text_al_othaim_sport');
		$data['text_al_othaim_royal']   		=   $this->language->get('text_al_othaim_royal');
		$data['text_al_othaim_ai']   			=   $this->language->get('text_al_othaim_ai');
		if ($data['lang'] == 'ar') {
			$data['href_al_othaim_investment']   	=   'https://www.alothaiminvestment.com/ar/';
			$data['href_al_othaim_mall']   			=   'https://othaimmalls.com/ar/';
			$data['href_al_othaim_life']   			= 	'https://alothaimlife.com/ar/';
			$data['href_al_othaim_entertainment']   = 	'https://othaimworld.com/ar/';
			$data['href_al_othaim_noircinema']   	=   'https://noircinema.sa/ar/';
			$data['href_al_othaim_sport']   		=   'https://alothaimsport.com/ar/';
			$data['href_al_othaim_royal']   		=   'https://refahhotels.com/ar/';
			$data['href_al_othaim_ai']   			=   'https://alothaimai.com/ar/';
		} else {
			$data['href_al_othaim_investment']   	=   'https://www.alothaiminvestment.com/';
			$data['href_al_othaim_mall']   			=   'https://othaimmalls.com/';
			$data['href_al_othaim_life']   			= 	'https://alothaimlife.com/';
			$data['href_al_othaim_entertainment']   = 	'https://othaimworld.com/';
			$data['href_al_othaim_noircinema']      =   'https://noircinema.sa/';
			$data['href_al_othaim_sport']   		=   'https://alothaimsport.com/';
			$data['href_al_othaim_royal']   		=   'https://refahhotels.com/';
			$data['href_al_othaim_ai']   			=   'https://alothaimai.com/';
		}
		$this->id = 'header';
		$this->template = 'food/template/common/header.tpl';
		$this->data = $data;
		$this->response->setOutput($this->render());
	}
}
