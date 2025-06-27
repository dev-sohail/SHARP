<?php
class ControllerBanner extends Controller
{
	private $error = array();
	public function index()
	{
		$data = $this->language->getAll();
		$this->document->setTitle('Admin - Banners');
		$this->load_model('banner');
		$this->getList();
	}
	public function add()
	{

		$this->document->setTitle('Admin - Banners');
		$this->load_model('banner');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_banner->addBanner($this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have added a new banner !');
			$url = '';
			$this->response->redirect($this->link('banner', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		// die;
		$this->getForm();
	}

	public function edit()
	{
		$this->document->setTitle('Admin - Banners');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->load_model('banner');
			$this->model_banner->editBanner($this->request->get['banner_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have modified banner!');
			$url = '';
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->link('banner', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}
	public function delete()
	{
		$this->load_model('banner');
		if (isset($this->request->post['banner_id']) && $this->validateDelete()) {

			$this->model_banner->deleteBanner($this->request->post['banner_id']);

			$data['success'] = 'Success: You have deleted banner!';

			$this->response->redirect($this->link('banner', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getList();
	}
	protected function getForm()
	{
		$data = $this->language->getAll();
		$data['text_form'] = !isset($this->request->get['banner_id']) ? 'Add New Banner' : 'Edit Banner';

		if ($this->user->getGroupId() != '1') {
			$data['viewer'] = true;
		} else {
			$data['viewer'] = false;
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		if (isset($this->error['image'])) {
			$data['error_image'] = $this->error['image'];
		} else {
			$data['error_image'] = '';
		}
		if (isset($this->error['title'])) {
			$data['error_title'] = $this->error['title'];
		} else {
			$data['error_title'] = '';
		}
		if (isset($this->error['url'])) {
			$data['error_url'] = $this->error['url'];
		} else {
			$data['error_url'] = '';
		}



		$url = '';

		if (!isset($this->request->get['banner_id'])) {
			$data['action'] = $this->link('banner/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->link('banner/edit', 'token=' . $this->session->data['token'] . '&banner_id=' . $this->request->get['banner_id'] . $url, 'SSL');
		}
		$data['cancel'] = $this->link('banner', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['banner_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$this->load_model('banner');
			$banner_info = $this->model_banner->getBanner($this->request->get['banner_id']);
		}


		$db_filter = [
			'order' => 'DESC'
		];
		$this->load_model('language');
		$data['languages'] = $this->model_language->getLanguages($db_filter);
		if (isset($this->request->post['banner_description'])) {
			$data['banner_description'] = $this->request->post['banner_description'];
		} elseif (isset($this->request->get['banner_id'])) {
			$data['banner_description'] = $this->model_banner->getBannerDescriptions($this->request->get['banner_id']);
		} else {
			$data['banner_description'] = array();
		}
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($banner_info)) {
			$data['sort_order'] = $banner_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($banner_info)) {
			$data['status'] = $banner_info['status'];
		} else {
			$data['status'] = true;
		}
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($banner_info)) {
			$data['image'] = $banner_info['image'];
		} else {
			$data['image'] = '';
		}
		if (isset($this->request->post['url'])) {
			$data['url'] = $this->request->post['url'];
		} elseif (!empty($banner_info)) {
			$data['url'] = $banner_info['url'];
		} else {
			$data['url'] = '';
		}

		// echo "<pre>";print_r($data);exit;
		$this->data = $data;
		$this->template = 'modules/banner/form.tpl';
		$this->zones = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}
	protected function validateForm()
	{
		if (!$this->user->hasPermission('modify', 'banner')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		$data = $this->request->post;

		foreach ($data['banner_description'] as $language_id => $value) {
			if ((utf8_strlen(trim($value['title'])) < 1)) {
				$this->error['title'][$language_id] = "Title field is missing";
			}
		}
		if (!$this->request->get['banner_id']) {
			if ($_FILES["image"]["name"] == "") {
				$this->error['image'] = 'Please upload banner image';
			}
		}
		if ((utf8_strlen(trim($data['url'])) < 1)) {
			$this->error['url'] = "Page url is missing";
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = ' Warning: Please check the form carefully for errors!';
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	protected function getList()
	{

		$data = $this->language->getAll();
		$url = '';
		$data['breadcrumbs'][] = array(
			'text' => 'Home Banner',
			'href' => $this->link('banner', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		$data['add'] = $this->link('banner/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		if ($this->user->getGroupId() != '1') {
			$data['viewer'] = true;
			$data['button_edit_icon'] = 'fa fa-eye';
		} else {
			$data['viewer'] = false;
			$data['button_edit_icon'] = 'fa fa-pencil';
		}
		$data['banners'] = array();
		$filter_data = array(
			'order' => $order,
		);
		$results = $this->model_banner->getBanners($filter_data);
		foreach ($results as $result) {
			$data['banners'][] = array(
				'banner_id'     => $result['banner_id'],
				'name'   	 	=> $result['name'],
				'sort_order'   => $result['sort_order'],
				'status' 		=> $result['status'],
				'edit'       	=> $this->link('banner/edit', 'token=' . $this->session->data['token'] . '&banner_id=' . $result['banner_id'] . $url, 'SSL'),
				'delete'       	=> $this->link('banner/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
			);
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['ajaxbannerstatus'] = $this->link('banner/ajaxbannerstatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['token'] = $this->session->data['token'];
		$this->data = $data;
		$this->template = 'modules/banner/list.tpl';
		$this->zones = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}

	public function ajaxbannerstatus()
	{
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
		$this->load_model('banner');
		$id = $this->request->post['id'];
		$status = $this->request->post['status'];
		$this->model_banner->updateBannerStatus($id, $status);
		$json['success'] = true;
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
		}
	}
	protected function validateDelete()
	{

		if (!$this->user->hasPermission('modify', 'banner')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}


		return !$this->error;
	}
}
