<?php
class ControllerBusiness extends Controller
{
	private $error = array();
	public function index()
	{
		$data = $this->language->getAll();
		$this->document->setTitle('Admin - Businesses');
		$this->load_model('business');
		$this->getList();
	}
	public function add()
	{
		$this->document->setTitle('Admin - Businesses');
		$this->load_model('business');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_business->addBusiness($this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have added a new Business!');
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
			$this->response->redirect($this->link('business', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		// die;
		$this->getForm();
	}
	public function edit()
	{
		$this->document->setTitle('Admin - Businesses');
		// echo "<pre>";print_r($this->request->post);exit;
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->load_model('business');
			$this->model_business->editBusiness($this->request->get['busines_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have modified Business!');
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
			$this->response->redirect($this->link('business', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}
	public function delete()
	{
		$this->load_model('business');
		$this->model_business->deleteBusiness($this->request->post['busines_id']);
		$this->getList();
	}
	protected function getForm()
	{
		$data = $this->language->getAll();
		$data['text_form'] = !isset($this->request->get['busines_id']) ? 'Add New Business' : 'Edit Business';
		$data['img_feild_required'] = !isset($this->request->get['busines_id']) ? "required" : "";
		$data['is_edit'] = !isset($this->request->get['busines_id']) ? "no" : "yes";

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		if (isset($this->error['banner_image'])) {
			$data['error_banner'] = $this->error['banner_image'];
		} else {
			$data['error_banner'] = '';
		}
		if (isset($this->error['other_d_image'])) {
			$data['error_other_d_image'] = $this->error['other_d_image'];
		} else {
			$data['error_other_d_image'] = '';
		}
		if (isset($this->error['stats_scond_image'])) {
			$data['error_stats_scond_image'] = $this->error['stats_scond_image'];
		} else {
			$data['error_stats_scond_image'] = '';
		}
		if (isset($this->error['icon'])) {
			$data['error_icon'] = $this->error['icon'];
		} else {
			$data['error_icon'] = '';
		}
		if (isset($this->error['thumbnail'])) {
			$data['error_thumbnail'] = $this->error['thumbnail'];
		} else {
			$data['error_thumbnail'] = '';
		}
		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}
		if (isset($this->error['other_d_title'])) {
			$data['error_other_d_title'] = $this->error['other_d_title'];
		} else {
			$data['error_other_d_title'] = '';
		}
		if (isset($this->error['other_d_description'])) {
			$data['error_other_d_description'] = $this->error['other_d_description'];
		} else {
			$data['error_other_d_description'] = '';
		}
		if (isset($this->error['detail_second_description'])) {
			$data['error_detail_second_description'] = $this->error['detail_second_description'];
		} else {
			$data['error_detail_second_description'] = '';
		}
		if (isset($this->error['short_description'])) {
			$data['error_s_description'] = $this->error['short_description'];
		} else {
			$data['error_s_description'] = '';
		}
		if (isset($this->error['busines_images'])) {
			$data['error_busines_images'] = $this->error['busines_images'];
		} else {
			$data['error_busines_images'] = '';
		}
		if (isset($this->error['busines_icons'])) {
			$data['error_busines_icons'] = $this->error['busines_icons'];
		} else {
			$data['error_busines_icons'] = '';
		}
		if (isset($this->error['busines_other_detail'])) {
			$data['error_busines_other_detail'] = $this->error['busines_other_detail'];
		} else {
			$data['error_busines_other_detail'] = '';
		}
		if (isset($this->error['full_description'])) {
			$data['error_f_description'] = $this->error['full_description'];
		} else {
			$data['error_f_description'] = '';
		}
		if (isset($this->error['website_url'])) {
			$data['error_website_url'] = $this->error['website_url'];
		} else {
			$data['error_website_url'] = '';
		}
		if (isset($this->error['iframe_map'])) {
			$data['error_iframe_map'] = $this->error['iframe_map'];
		} else {
			$data['error_iframe_map'] = '';
		}
		if (isset($this->error['phone'])) {
			$data['error_phone'] = $this->error['phone'];
		} else {
			$data['error_phone'] = '';
		}
		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}
		if (isset($this->error['address'])) {
			$data['error_address'] = $this->error['address'];
		} else {
			$data['error_address'] = '';
		}
		if (isset($this->error['sector_id'])) {
			$data['error_sector'] = $this->error['sector_id'];
		} else {
			$data['error_sector'] = '';
		}
		$url = '';
		if (!isset($this->request->get['busines_id'])) {
			$data['action'] = $this->link('business/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->link('business/edit', 'token=' . $this->session->data['token'] . '&busines_id=' . $this->request->get['busines_id'] . $url, 'SSL');
		}
		$data['cancel'] = $this->link('business', 'token=' . $this->session->data['token'] . $url, 'SSL');
		if (isset($this->request->get['busines_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$this->load_model('business');
			$busines_info = $this->model_business->getListBusiness($this->request->get['busines_id']);
		}
		$data['business'] = $busines_info;
		$db_filter = [
			'order' => 'DESC'
		];
		$this->load_model('language');
		$data['languages'] = $this->model_language->getLanguages($db_filter);
		if (isset($this->request->post['business_description'])) {
			$data['business_description'] = $this->request->post['business_description'];
		} elseif (isset($this->request->get['busines_id'])) {
			$data['business_description'] = $this->model_business->getBusinessDescription($this->request->get['busines_id']);
		} else {
			$data['business_description'] = array();
		}
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($busines_info)) {
			$data['sort_order'] = $busines_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
		if (isset($this->request->post['iframe_map'])) {
			$data['iframe_map'] = $this->request->post['iframe_map'];
		} elseif (!empty($busines_info)) {
			$data['iframe_map'] = $busines_info['iframe_map'];
		} else {
			$data['iframe_map'] = '';
		}
		if (isset($this->request->post['website_url'])) {
			$data['website_url'] = $this->request->post['website_url'];
		} elseif (!empty($busines_info)) {
			$data['website_url'] = $busines_info['website_url'];
		} else {
			$data['website_url'] = '';
		}
		if (isset($this->request->post['phone'])) {
			$data['phone'] = $this->request->post['phone'];
		} elseif (!empty($busines_info)) {
			$data['phone'] = $busines_info['phone'];
		} else {
			$data['phone'] = '';
		}
		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} elseif (!empty($busines_info)) {
			$data['email'] = $busines_info['email'];
		} else {
			$data['email'] = '';
		}
		if (isset($this->request->post['address'])) {
			$data['address'] = $this->request->post['address'];
		} elseif (!empty($busines_info)) {
			$data['address'] = $busines_info['address'];
		} else {
			$data['address'] = '';
		}
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($busines_info)) {
			$data['status'] = $busines_info['publish'];
		} else {
			$data['status'] = true;
		}
		if (isset($this->request->post['banner_image'])) {
			$data['banner_image'] = $this->request->post['banner_image'];
		} elseif (!empty($busines_info)) {
			$data['banner_image'] = $busines_info['banner_image'];
		} else {
			$data['banner_image'] = '';
		}
		if (isset($this->request->post['other_d_image'])) {
			$data['other_d_image'] = $this->request->post['other_d_image'];
		} elseif (!empty($busines_info)) {
			$data['other_d_image'] = $busines_info['other_d_image'];
		} else {
			$data['other_d_image'] = '';
		}
		if (isset($this->request->post['stats_scond_image'])) {
			$data['stats_scond_image'] = $this->request->post['stats_scond_image'];
		} elseif (!empty($busines_info)) {
			$data['stats_scond_image'] = $busines_info['stats_scond_image'];
		} else {
			$data['stats_scond_image'] = '';
		}
		if (isset($this->request->post['icon'])) {
			$data['icon'] = $this->request->post['icon'];
		} elseif (!empty($busines_info)) {
			$data['icon'] = $busines_info['icon'];

		} else {
			$data['icon'] = '';
		}
		if (isset($this->request->post['thumbnail'])) {
			$data['thumbnail'] = $this->request->post['thumbnail'];
		} elseif (!empty($busines_info)) {
			$data['thumbnail'] = $busines_info['thumbnail'];
		} else {
			$data['thumbnail'] = '';
		}
		if (isset($this->request->post['featured'])) {
			$data['featured'] = $this->request->post['featured'];
		} elseif (!empty($busines_info)) {
			$data['featured'] = $busines_info['mark_feature'];
		} else {
			$data['featured'] = false;
		}
		if (isset($this->request->post['sector_id'])) {
			$data['sector_id'] = $this->request->post['sector_id'];
		} elseif (!empty($busines_info)) {
			$data['sector_id'] = $busines_info['sector_id'];
		} else {
			$data['sector_id'] = '';
		}
		$this->load_model('business');
		$data['c_sectors'] = $this->model_business->getCsectors();
		if (isset($this->request->post['busines_images'])) {
			$business_images = $this->request->post['busines_images'];
		} elseif (isset($this->request->get['busines_id'])) {
			$business_images = $this->model_business->getBusinessImages($this->request->get['busines_id']);
		} else {
			$business_images = array();
		}
		
		$data['business_images'] = array();
		foreach ($business_images as $busines_images) {
			if (is_file(DIR_IMAGE . 'business/' . $busines_images['image'])) {
				$image = $busines_images['image'];
				$thumb = '../uploads/image/business/' . $busines_images['image'];
			} else {
				$image = '';
				$thumb = '../uploads/image/no-image.png';
			}
			$data['business_images'][] = array(
				'image'      => $image,
				'thumb'      => $thumb,
				'sort_order' => $busines_images['sort_order'],
				'description' => $busines_images['description']
			);
		}

		if (isset($this->request->post['busines_icons'])) {
			$busines_icons = $this->request->post['busines_icons'];
		} elseif (isset($this->request->get['busines_id'])) {
			$busines_icons = $this->model_business->getBusinessIcons($this->request->get['busines_id']);
		} else {
			$busines_icons = array();
		}
		$data['busines_icons'] = array();
		foreach ($busines_icons as $busines_icon) {
			if (is_file(DIR_IMAGE . 'business/' . $busines_icon['image'])) {
				$image = $busines_icon['image'];
				$thumb = '../uploads/image/business/' . $busines_icon['image'];
			} else {
				$image = '';
				$thumb = '../uploads/image/no-image.png';
			}
			$data['busines_icons'][] = array(
				'image'      => $image,
				'thumb'      => $thumb,
				'sort_order' => $busines_icon['sort_order'],
				'description' => $busines_icon['description']
			);
		}
		if (isset($this->request->post['business_other_details'])) {
			$business_other_details = $this->request->post['business_other_details'];
		} elseif (isset($this->request->get['busines_id'])) {
			$business_other_details = $this->model_business->getBusinessOtherDetails($this->request->get['busines_id']);

		} else {
			$business_other_details = array();
		}
		$data['business_other_details'] = array();
		foreach ($business_other_details as $business_other_detail) {
			$data['business_other_details'][] = array(
				'sort_order' => $business_other_detail['sort_order'],
				'description' => $business_other_detail['description']
			);
		}
		// echo '<pre>'; print_r($_POST); exit;
		$data['token'] = $this->session->data['token'];
		$this->data = $data;
		$this->template = 'modules/business/form.tpl';
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
		if ((utf8_strlen(trim($data['sector_id'])) < 1)) {
			$this->error['sector_id'] = "Sector field is missing";
		}
		if (trim($this->request->post['phone']) == '') {
			$this->error['phone'] = 'Phone field is missing';
		} elseif (!is_numeric($this->request->post['phone'])) {
			$this->error['phone'] = 'Phone number should contain only digits';
		} elseif (strlen($this->request->post['phone']) < 9) {
			$this->error['phone'] = 'Phone number must be at least 9 digits long';
		}
		if (trim($this->request->post['email']) == '') {
			$this->error['email'] = 'Email field is missing';
		} elseif (!filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
			$this->error['email'] = 'Invalid email format';
		}
		if (trim($this->request->post['address']) == '') {
			$this->error['address'] =  'Address field is missing';
		}
		if (trim($this->request->post['website_url']) == '') {
			$this->error['website_url'] = 'Website URL field is missing';
		} elseif (!filter_var($this->request->post['website_url'], FILTER_VALIDATE_URL)) {
			$this->error['website_url'] = 'Please enter a valid Website URL';
		}
		if (trim($this->request->post['iframe_map']) == '') {
			$this->error['iframe_map'] = 'Map URL field is missing';
		} elseif (!filter_var($this->request->post['iframe_map'], FILTER_VALIDATE_URL)) {
			$this->error['iframe_map'] = 'Please enter a valid Map URL';
		}
		
		foreach ($data['business_description'] as $language_id => $value) {
			if ((utf8_strlen(trim($value['name'])) < 1)) {
				$this->error['name'][$language_id] = "Title field is missing";
			}
			if ((utf8_strlen(trim($value['other_d_title'])) < 1)) {
				$this->error['other_d_title'][$language_id] = "Detail Title field is missing";
			}
			if ((utf8_strlen(trim($value['other_d_description'])) < 1)) {
				$this->error['other_d_description'][$language_id] = "Detail Description field is missing";
			}
			if ((utf8_strlen(trim($value['detail_second_description'])) < 1)) {
				$this->error['detail_second_description'][$language_id] = "Detail Second Description field is missing";
			}
			if ((utf8_strlen(trim($value['short_description'])) < 1)) {
				$this->error['short_description'][$language_id] = "Short description field is missing";
			}
			if ((utf8_strlen(trim($value['full_description'])) < 1)) {
				$this->error['full_description'][$language_id] = "Description field is missing";
			}
		}

		if (isset($this->request->post['busines_images']) && !empty($this->request->post['busines_images'])) {
			foreach ($this->request->post['busines_images'] as $option_value_id1 => $option_value1) {
				if ((utf8_strlen($option_value1['image']) < 1)) {
					$this->error['busines_images'][$option_value_id1]['image'] = "Image is missing.";
				}
				foreach ($option_value1['description'] as $language_id1 => $option_value_description1) {
					if ((utf8_strlen($option_value_description1['title']) < 1)) {
						$this->error['busines_images'][$option_value_id1]['title'][$language_id1] = "Title is missing.";
					}
					if ((utf8_strlen($option_value_description1['content']) < 1)) {
						$this->error['busines_images'][$option_value_id1]['content'][$language_id1] = "Content is missing.";
					}
				}
			}
		}

		if (isset($this->request->post['busines_icons']) && !empty($this->request->post['busines_icons'])) {
			foreach ($this->request->post['busines_icons'] as $option_value_id2 => $option_value2) {
				if ((utf8_strlen($option_value2['image']) < 1)) {
					$this->error['busines_icons'][$option_value_id2]['image'] = "Image is missing.";
				}
				foreach ($option_value2['description'] as $language_id2 => $option_value_description2) {
					if ((utf8_strlen($option_value_description2['title']) < 1)) {
						$this->error['busines_icons'][$option_value_id2]['title'][$language_id2] = "Title is missing.";
					}
					if ((utf8_strlen($option_value_description2['content']) < 1)) {
						$this->error['busines_icons'][$option_value_id2]['content'][$language_id2] = "Content is missing.";
					}
				}
			}
		}

		if (isset($this->request->post['business_other_details']) && !empty($this->request->post['business_other_details'])) {
			foreach ($this->request->post['business_other_details'] as $option_value_id3 => $option_value3) {
				foreach ($option_value3['description'] as $language_id3 => $option_value_description3) {
					if ((utf8_strlen($option_value_description3['title']) < 1)) {
						$this->error['busines_other_detail'][$option_value_id3]['title'][$language_id3] = "Title is missing.";
					}
					if ((utf8_strlen($option_value_description3['content']) < 1)) {
						$this->error['busines_other_detail'][$option_value_id3]['content'][$language_id3] = "Content is missing.";
					}
				}
			}
		}
		// if (!is_numeric($data['price']) || $data['price'] < 1) {
		// 	$this->error['price'] = "Price should be numeric and greater than 1.";
		// }
		if (!$this->request->get['busines_id']) {

			if ($_FILES["banner_image"]["name"] == "") {
				$this->error['banner_image'] = 'Please upload business banner image';
			}
			if ($_FILES["other_d_image"]["name"] == "") {
				$this->error['other_d_image'] = 'Please upload business other image';
			}
			if ($_FILES["stats_scond_image"]["name"] == "") {
				$this->error['stats_scond_image'] = 'Please upload business stats second image';
			}
			if ($_FILES["icon"]["name"] == "") {
				$this->error['icon'] = 'Please upload business icon';
			}
			if ($_FILES["thumbnail"]["name"] == "") {
				$this->error['thumbnail'] = 'Please upload business thumbnail';
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
		$data['add'] = $this->link('business/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->link('business/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['businesses'] = array();
		$filter_data = array(
			'order' => $order,
		);
		$results = $this->model_business->getListBusinesses($filter_data);
		foreach ($results as $result) {
			$data['businesses'][] = array(
				'busines_id'     => $result['busines_id'],
				'name'		 	=> $result['name'],
				'sector_name'	=> $result['sector_name'],
				'status' 		=> $result['publish'],
				'sort_order'    => $result['sort_order'],
				'edit'       	=> $this->link('business/edit', 'token=' . $this->session->data['token'] . '&busines_id=' . $result['busines_id'] . $url, 'SSL'),
				'delete'       	=> $this->link('business/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
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
		$data['ajaxBusinessstatus'] = $this->link('business/ajaxBusinessstatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['token'] = $this->session->data['token'];
		$this->data = $data;
		$this->template = 'modules/business/list.tpl';
		$this->zones = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}
	public function uploadImages()
	{
		if (!empty($_FILES["image"]["name"])) {
			$targetDirectory = DIR_IMAGE . "business/";
			$filename = time();
			$path = $_FILES['image']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			$filename = time();

			$targetFile = $targetDirectory . $filename . '.' . $ext;
			if (!is_dir($targetDirectory)) {
				mkdir($targetDirectory, 0755);
			}
			if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
				$json['success'] = true;
				$json['filename'] = $filename . '.' . $ext;
			} else {
				$json['success'] = false;
			}
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function ajaxBusinessstatus()
	{
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->load_model('business');
			$busines_id = $this->request->post['busines_id'];
			$status = $this->request->post['status'];
			$stat = $this->model_business->updateBusinessStatus($busines_id, $status);
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
