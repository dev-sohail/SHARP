<?php
class ControllerMediaCenter extends Controller
{
	private $error = array();


	public function index()
	{

		$data = $this->language->getAll();
		$this->document->setTitle('Admin - Media Center');
		$this->load_model('mediacenter');

		$this->getList();
	}
	public function add()
	{

		$this->document->setTitle('Admin - Media Center');
		$this->load_model('mediacenter');


		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_mediacenter->addMediaCenter($this->request->post);
			$this->session->data['success'] = "Success: You have added a new Media Center!";
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
			$this->response->redirect($this->link('mediacenter', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function edit()
	{

		$this->document->setTitle('Admin - Media Center');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->load_model('mediacenter');
			$this->model_mediacenter->editMediaCenter($this->request->get['media_center_id'], $this->request->post);
			$this->session->data['success'] = "Success: You have modified Media Center!";
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
			$this->response->redirect($this->link('mediacenter', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete()
	{

		$this->load_model('mediacenter');
		if ($this->request->post['media_center_id'] && $this->validateDelete()) {
			$this->model_mediacenter->deleteMediaCenter($this->request->post['media_center_id']);
			$this->session->data['success'] = $this->language->get('Success: You have deleted Media Center!');
			$this->response->redirect($this->link('mediacenter', 'token=' . $this->session->data['token'], 'SSL'));
		}
		$this->getList();
	}
	protected function getForm()
	{
		$data = $this->language->getAll();
		$data['text_form'] = !isset($this->request->get['media_center_id']) ? 'Add New Media Center' : 'Edit Media Center';
		$data['is_edit'] = !isset($this->request->get['media_center_id']) ? "no" : "yes";
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		if (isset($this->error['title'])) {
			$data['error_title'] = $this->error['title'];
		} else {
			$data['error_title'] = '';
		}
		if (isset($this->error['short_description'])) {
			$data['error_short_description'] = $this->error['short_description'];
		} else {
			$data['error_short_description'] = '';
		}
		if (isset($this->error['description'])) {
			$data['error_description'] = $this->error['description'];
		} else {
			$data['error_description'] = '';
		}
		if (isset($this->error['publish_date'])) {
			$data['error_publish_date'] = $this->error['publish_date'];
		} else {
			$data['error_publish_date'] = '';
		}
		if (isset($this->error['thumbnail'])) {
			$data['error_thumbnail'] = $this->error['thumbnail'];
		} else {
			$data['error_thumbnail'] = '';
		}
		if (isset($this->error['banner_image'])) {
			$data['error_banner_image'] = $this->error['banner_image'];
		} else {
			$data['error_banner_image'] = '';
		}
		if (isset($this->error['seo_url'])) {
			$data['error_seo_url'] = $this->error['seo_url'];
		} else {
			$data['error_seo_url'] = '';
		}
		$url = '';
		if (!isset($this->request->get['media_center_id'])) {
			$data['action'] = $this->link('mediacenter/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->link('mediacenter/edit', 'token=' . $this->session->data['token'] . '&media_center_id=' . $this->request->get['media_center_id'] . $url, 'SSL');
		}
		$data['cancel'] = $this->link('mediacenter', 'token=' . $this->session->data['token'] . $url, 'SSL');
		if (isset($this->request->get['media_center_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$this->load_model('mediacenter');
			$media_center_info = $this->model_mediacenter->getMediaCenter($this->request->get['media_center_id']);
		}
		$db_filter = [
			'order' => 'DESC'
		];
		$this->load_model('language');
		$data['languages'] = $this->model_language->getLanguages($db_filter);
		if (isset($this->request->post['media_center_description'])) {
			$data['media_center_description'] = $this->request->post['media_center_description'];
		} elseif (isset($this->request->get['media_center_id'])) {
			$data['media_center_description'] = $this->model_mediacenter->getMediaCenterDescriptions($this->request->get['media_center_id']);
		} else {
			$data['media_center_description'] = array();
		}
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($media_center_info)) {
			$data['sort_order'] = $media_center_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
		if (isset($this->request->post['publish_date'])) {
			$data['publish_date'] = $this->request->post['publish_date'];
		} elseif (!empty($media_center_info)) {
			$data['publish_date'] = date('Y-m-d', strtotime($media_center_info['publish_date']));
		} else {
			$data['publish_date'] = '';
		}
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($media_center_info)) {
			$data['status'] = $media_center_info['publish'];
		} else {
			$data['status'] = true;
		}
		if (isset($this->request->post['thumbnail'])) {
			$data['thumbnail'] = $this->request->post['thumbnail'];
		} elseif (!empty($media_center_info)) {
			$data['thumbnail'] = $media_center_info['thumbnail'];
		} else {
			$data['thumbnail'] = '';
		}
		if (isset($this->request->post['banner_image'])) {
			$data['banner_image'] = $this->request->post['banner_image'];
		} elseif (!empty($media_center_info)) {
			$data['banner_image'] = $media_center_info['banner_image'];
		} else {
			$data['banner_image'] = '';
		}
		if (isset($this->request->post['seo_url'])) {
			$data['seo_url'] = $this->request->post['seo_url'];
		} elseif (!empty($media_center_info)) {
			$data['seo_url'] = $media_center_info['seo_url'];
		} else {
			$data['seo_url'] = '';
		}
		$this->load_model('mediacenter');
		$data['token'] = $this->session->data['token'];
		$this->data = $data;
		$this->template = 'modules/mediacenter/form.tpl';
		$this->zones = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}
	protected function validateForm()
	{
		$data = $this->request->post;

		foreach ($data['media_center_description'] as $language_id => $value) {
			if ((utf8_strlen(trim($value['title'])) < 1)) {
				$this->error['title'][$language_id] = "Title field is missing";
			}
			if ((utf8_strlen(trim($value['short_description'])) < 1)) {
				$this->error['short_description'][$language_id] = "Short Description field is missing";
			}
			if ((utf8_strlen(trim($value['description'])) < 1)) {
				$this->error['description'][$language_id] = "Description field is missing";
			}
		}
		if ((utf8_strlen(trim($data['publish_date'])) < 1)) {
			$this->error['publish_date'] = "Publish Date field is missing";
		}
		if (!$this->request->get['media_center_id']) {
			if ($_FILES["banner_image"]["name"] == "") {
				$this->error['banner_image'] = 'Please upload banner image';
			}
			if ($_FILES["thumbnail"]["name"] == "") {
				$this->error['thumbnail'] = 'Please upload thumb image';
			}
		} else {
			if ($data["thumbnail"] == "") {
				$this->error['thumbnail'] = 'Please upload thumb image';
			}
			if ($data["banner_image"] == "") {
				$this->error['banner_image'] = 'Please upload banner image';
			}
		}
		$this->load_model('seourl');
		if ($data['seo_url'] != "") {
			$keyword = $this->model_seourl->seoUrl($data['seo_url']);
		}
		if ($keyword != '') {
			$this->load_model('seourl');
			$seo_urls = $this->model_seourl->getSeoUrlsByKeyword($keyword);

			foreach ($seo_urls as $seo_url) {

				if (($this->request->get['media_center_id'] != $seo_url['slog_id'] || ($seo_url['slog'] != 'mediacenter/detail'))) {
					$this->error['seo_url'] = "This url is already been used";
					break;
				}
			}
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

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		$data['add'] = $this->link('mediacenter/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->link('mediacenter/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['media_centers'] = array();
		$filter_data = array(
			'order' => $order,
		);
		$results = $this->model_mediacenter->getMediaCenters($filter_data);

		foreach ($results as $result) {
			$data['media_centers'][] = array(
				'media_center_id'     => $result['media_center_id'],
				'title'		 	=> $result['title'],
				'sort_order'	=> $result['sort_order'],
				'thumbnail'	=> $result['thumbnail'],
				'banner_image'	=> $result['banner_image'],
				'status' 		=> $result['publish'],
				'edit'       	=> $this->link('mediacenter/edit', 'token=' . $this->session->data['token'] . '&media_center_id=' . $result['media_center_id'] . $url, 'SSL'),
				'delete'       	=> $this->link('mediacenter/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
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
		$data['ajaxmediacenterstatus'] = $this->link('mediacenter/ajaxmediacenterstatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['token'] = $this->session->data['token'];

		$this->data = $data;

		$this->template = 'modules/mediacenter/list.tpl';

		$this->zones = array(
			'header',
			'columnleft',
			'footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateDelete()
	{

		if (!$this->user->hasPermission('modify', 'mediacenter')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}

		return !$this->error;
	}
	
	public function ajaxmediacenterstatus()
	{
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->load_model('mediacenter');
			$media_center_id = $this->request->post['media_center_id'];
			$status = $this->request->post['status'];
			$stat = $this->model_mediacenter->updateMediaCenterStatus($media_center_id, $status);
			if ($stat) {
				$json['success'] = true;
				$this->response->addHeader('Content-Type: application/json');
				$this->response->setOutput(json_encode($json));
			} else {
				$json['success'] = false;
				$this->response->addHeader('Content-Type: application/json');
				$this->response->setOutput(json_encode($json));
			}
		} else {
			$json['success'] = false;
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
		}
	}
}