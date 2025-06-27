<?php
class ControllerDashboard extends Controller {
	public function index() {
		$this->document->setTitle("Admin - Dashboard");
		$data=$this->language->getAll();  
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => 'Dashboard',
			'href' => $this->link('dashboard', 'token=' . $this->session->data['token'], 'SSL') 
		);
		$data['pages'] = $this->link('pages', 'token=' . $this->session->data['token'], 'SSL');
		$data['setting'] = $this->link('setting', 'token=' . $this->session->data['token'], 'SSL');
		$data['enquiries'] = $this->link('enquiries', 'token=' . $this->session->data['token'], 'SSL');
		$data['blogs'] = $this->link('blogs', 'token=' . $this->session->data['token'], 'SSL');
		$data['careers'] = $this->link('careers', 'token=' . $this->session->data['token'], 'SSL');
		$data['frontmenu'] = $this->link('frontmenu', 'token=' . $this->session->data['token'], 'SSL');
		$data['movies'] = $this->link('movies', 'token=' . $this->session->data['token'], 'SSL');
		$data['brands'] = $this->link('brands', 'token=' . $this->session->data['token'], 'SSL');
		$data['mediacenter'] = $this->link('mediacenter', 'token=' . $this->session->data['token'], 'SSL');
		if ($this->user->getGroupId() != '1') {
			$data['viewer'] = true;
		} else {
			$data['viewer'] = false;
		}
		$this->data = $data; 
		$this->template = 'common/dashboard.tpl'; 
		$this->zones = array(
			'header',
			'columnleft',
			'footer'
		); 
		$this->response->setOutput($this->render()); 
	}
}