<?php
class ControllerBrands extends Controller
{
	private $error = array();
	public function index()
	{
		$data = $this->language->getAll();
		$this->document->setTitle('Admin - Brands');
		$this->load_model('brands');
		$this->getList();
	}
	public function add()
	{
		$this->document->setTitle('Admin - Brands');
		$this->load_model('brands');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_brands->addBrand($this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have added a new Brand!');
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
			$this->response->redirect($this->link('brands', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		// die;
		$this->getForm();
	}
	public function edit()
	{
		$this->document->setTitle('Admin - Brands');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->load_model('brands');
			$this->model_brands->editBrand($this->request->get['brand_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have modified Brand!');
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
			$this->response->redirect($this->link('brands', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}
	public function delete()
	{
		$this->load_model('brands');
		if (isset($this->request->post['brand_id']) && $this->validateDelete()) {
			$this->model_brands->deleteBrand($this->request->post['brand_id']);
			$this->session->data['success'] = $this->language->get('Success: You have deleted Brand!');
			$this->response->redirect($this->link('brands', 'token=' . $this->session->data['token'], 'SSL'));
		} 
		$this->getList();
	}

	protected function getForm()
	{
		$data = $this->language->getAll();
		$data['text_form'] = !isset($this->request->get['brand_id']) ? 'Add New Brand' : 'Edit Brand';
		$data['img_feild_required'] = !isset($this->request->get['brand_id']) ? "required" : "";
		$data['is_edit'] = !isset($this->request->get['brand_id']) ? "no" : "yes";
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
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
		// if (isset($this->error['image'])) {
		// 	$data['error_image'] = $this->error['image'];
		// } else {
		// 	$data['error_image'] = '';
		// }
		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}
		if (isset($this->error['brand_images'])) {
			$data['error_brand_images'] = $this->error['brand_images'];
		} else {
			$data['error_brand_images'] = '';
		}
		if (isset($this->error['full_description'])) {
			$data['error_f_description'] = $this->error['full_description'];
		} else {
			$data['error_f_description'] = '';
		}
		if (isset($this->error['youtube_url'])) {
			$data['error_youtube_url'] = $this->error['youtube_url'];
		} else {
			$data['error_youtube_url'] = '';
		}
		if (isset($this->error['facebook_url'])) {
			$data['error_facebook_url'] = $this->error['facebook_url'];
		} else {
			$data['error_facebook_url'] = '';
		}
		if (isset($this->error['instagram_url'])) {
			$data['error_instagram_url'] = $this->error['instagram_url'];
		} else {
			$data['error_instagram_url'] = '';
		}
		if (isset($this->error['x_url'])) {
			$data['error_x_url'] = $this->error['x_url'];
		} else {
			$data['error_x_url'] = '';
		}
		if (isset($this->error['opening_time'])) {
			$data['error_opening_time'] = $this->error['opening_time'];
		} else {
			$data['error_opening_time'] = '';
		}
		if (isset($this->error['closing_time'])) {
			$data['error_closing_time'] = $this->error['closing_time'];
		} else {
			$data['error_closing_time'] = '';
		}
		if (isset($this->error['location_id'])) {
			$data['error_location_id'] = $this->error['location_id'];
		} else {
			$data['error_location_id'] = '';
		}
		if (isset($this->error['ourmenu_images'])) {
			$data['error_ourmenu_images'] = $this->error['ourmenu_images'];
		} else {
			$data['error_ourmenu_images'] = '';
		}
		if (isset($this->error['ourmenu_images_main'])) {
			$data['error_ourmenu_images_main'] = $this->error['ourmenu_images_main'];
		} else {
			$data['error_ourmenu_images_main'] = '';
		}
		if (isset($this->error['gallery_images_main'])) {
			$data['error_gallery_images_main'] = $this->error['gallery_images_main'];
		} else {
			$data['error_gallery_images_main'] = '';
		}
		if (isset($this->error['seo_url'])) {
			$data['error_seo_url'] = $this->error['seo_url'];
		} else {
			$data['error_seo_url'] = '';
		}
		$url = '';
		if (!isset($this->request->get['brand_id'])) {
			$data['action'] = $this->link('brands/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->link('brands/edit', 'token=' . $this->session->data['token'] . '&brand_id=' . $this->request->get['brand_id'] . $url, 'SSL');
		}
		$data['cancel'] = $this->link('brands', 'token=' . $this->session->data['token'] . $url, 'SSL');
		if (isset($this->request->get['brand_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$this->load_model('brands');
			$brands_info = $this->model_brands->getListBrand($this->request->get['brand_id']);
		}
		$data['brandss'] = $brands_info;
		$db_filter = [
			'order' => 'DESC'
		];
		$this->load_model('language');
		$data['languages'] = $this->model_language->getLanguages($db_filter);
		if (isset($this->request->post['brands_description'])) {
			$data['brands_description'] = $this->request->post['brands_description'];
		} elseif (isset($this->request->get['brand_id'])) {
			$data['brands_description'] = $this->model_brands->getBrandDescription($this->request->get['brand_id']);
		} else {
			$data['brands_description'] = array();
		}
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($brands_info)) {
			$data['sort_order'] = $brands_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
		if (isset($this->request->post['opening_time'])) {
			$data['opening_time'] = $this->request->post['opening_time'];
		} elseif (!empty($brands_info)) {
			$data['opening_time'] = $brands_info['opening_time'];
		} else {
			$data['opening_time'] = '';
		}
		if (isset($this->request->post['closing_time'])) {
			$data['closing_time'] = $this->request->post['closing_time'];
		} elseif (!empty($brands_info)) {
			$data['closing_time'] = $brands_info['closing_time'];
		} else {
			$data['closing_time'] = '';
		}
		if (isset($this->request->post['youtube_url'])) {
			$data['youtube_url'] = $this->request->post['youtube_url'];
		} elseif (!empty($brands_info)) {
			$data['youtube_url'] = $brands_info['youtube_url'];
		} else {
			$data['youtube_url'] = '';
		}
		if (isset($this->request->post['facebook_url'])) {
			$data['facebook_url'] = $this->request->post['facebook_url'];
		} elseif (!empty($brands_info)) {
			$data['facebook_url'] = $brands_info['facebook_url'];
		} else {
			$data['facebook_url'] = '';
		}
		if (isset($this->request->post['instagram_url'])) {
			$data['instagram_url'] = $this->request->post['instagram_url'];
		} elseif (!empty($brands_info)) {
			$data['instagram_url'] = $brands_info['instagram_url'];
		} else {
			$data['instagram_url'] = '';
		}
		if (isset($this->request->post['x_url'])) {
			$data['x_url'] = $this->request->post['x_url'];
		} elseif (!empty($brands_info)) {
			$data['x_url'] = $brands_info['x_url'];
		} else {
			$data['x_url'] = '';
		}
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($brands_info)) {
			$data['status'] = $brands_info['status'];
		} else {
			$data['status'] = true;
		}
		if (isset($this->request->post['icon'])) {
			$data['icon'] = $this->request->post['icon'];
		} elseif (!empty($brands_info)) {
			$data['icon'] = $brands_info['icon'];
		} else {
			$data['icon'] = '';
		}
		if (isset($this->request->post['thumbnail'])) {
			$data['thumbnail'] = $this->request->post['thumbnail'];
		} elseif (!empty($brands_info)) {
			$data['thumbnail'] = $brands_info['thumbnail'];
		} else {
			$data['thumbnail'] = '';
		}
		// if (isset($this->request->post['image'])) {
		// 	$data['image'] = $this->request->post['image'];
		// } elseif (!empty($brands_info)) {
		// 	$data['image'] = $brands_info['image'];
		// } else {
		// 	$data['image'] = '';
		// }
		if (isset($this->request->post['featured'])) {
			$data['featured'] = $this->request->post['featured'];
		} elseif (!empty($brands_info)) {
			$data['featured'] = $brands_info['mark_feature'];
		} else {
			$data['featured'] = false;
		}
		if (isset($this->request->post['seo_url'])) {
			$data['seo_url'] = $this->request->post['seo_url'];
		} elseif (!empty($brands_info)) {
			$data['seo_url'] = $brands_info['seo_url'];
		} else {
			$data['seo_url'] = false;
		}
		if (isset($this->request->post['location_id'])) {
			$data['location_id'] = $this->request->post['location_id'];
		} elseif (!empty($brands_info)) {
			$data['location_id'] = $brands_info['location_id'];
		} else {
			$data['location_id'] = '';
		}
		// echo '<pre>'; print_r(($this->request->post)); echo '</pre>'; exit;
		if (isset($this->request->post['ourmenu_images'])) {
			$ourmenu_images = $this->request->post['ourmenu_images'];
		} elseif (isset($this->request->get['brand_id'])) {
			$this->load_model('brands');
			$ourmenu_images = $this->model_brands->getBrandMenu($this->request->get['brand_id']);
			//  echo '<pre>'; print_r($ourmenu_images); echo '</pre>'; exit;
		} else {
			$ourmenu_images = array();
		}
		
		$data['ourmenu_images'] = array();
		foreach ($ourmenu_images as $ourmenu_image) {
		if (is_file(DIR_IMAGE . 'brands/' . $ourmenu_image['image'])) {
			$image = $ourmenu_image['image'];
			$thumb = '../uploads/image/brands/' . $ourmenu_image['image'];
		} else {
			$image = '';
			$thumb = '../uploads/image/no-image.png';
		}

		if (is_file(DIR_IMAGE . 'brands/pdf/' . $ourmenu_image['pdf'])) {
			$pdf = $ourmenu_image['pdf'];
			$pdf_url = '../uploads/image/brands/pdf/' . $ourmenu_image['pdf'];
		} else {
			$pdf = '';
			$pdf_url = '';
		}

		$data['ourmenu_images'][] = array(
			'image'      => $image,
			'thumb'      => $thumb,
			'pdf'        => $pdf,
			'pdf_url'    => $pdf_url, // Store the PDF URL separately
			'sort_order' => $ourmenu_image['sort_order'],
			'description' => $ourmenu_image['description']
		);
	}

		$this->load_model('brands');
		$data['brands_location'] = $this->model_brands->getBrandsLocation();
		// echo '<pre>'; print_r($data['brands_location']); exit;
		if (isset($this->request->post['brand_images'])) {
			$brand_images = $this->request->post['brand_images'];
		} elseif (isset($this->request->get['brand_id'])) {
			$brand_images = $this->model_brands->getBrandImages($this->request->get['brand_id']);
		} else {
			$brand_images = array();
		}
		$data['brand_images'] = array();
		foreach ($brand_images as $brand_image) {
			if (is_file(DIR_IMAGE . 'brands/' . $brand_image['image'])) {
				$image = $brand_image['image'];
				$thumb = '../uploads/image/brands/' . $brand_image['image'];
			} else {
				$image = '';
				$thumb = '../uploads/image/no-image.png';
			}
			$data['brand_images'][] = array(
				'image'      => $image,
				'thumb'      => $thumb,
				'sort_order' => $brand_image['sort_order'],
				'description' => $brand_image['description']
			);
		}
		$data['token'] = $this->session->data['token'];
		$this->data = $data;
		$this->template = 'modules/brands/form.tpl';
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
		if ((utf8_strlen(trim($data['location_id'])) < 1)) {
			$this->error['location_id'] = "Location field is missing";
		}
		// if (trim($this->request->post['youtube_url']) == '') {
		// 	$this->error['youtube_url'] = 'Youtube URL field is missing';
		// } elseif (!filter_var($this->request->post['youtube_url'], FILTER_VALIDATE_URL)) {
		// 	$this->error['youtube_url'] = 'Please enter a valid Youtube URL';
		// }
		// if (trim($this->request->post['facebook_url']) == '') {
		// 	$this->error['facebook_url'] = 'Facebook URL field is missing';
		// } elseif (!filter_var($this->request->post['facebook_url'], FILTER_VALIDATE_URL)) {
		// 	$this->error['facebook_url'] = 'Please enter a Facebook valid  URL';
		// }
		// if (trim($this->request->post['instagram_url']) == '') {
		// 	$this->error['instagram_url'] = 'Instagram URL field is missing';
		// } elseif (!filter_var($this->request->post['instagram_url'], FILTER_VALIDATE_URL)) {
		// 	$this->error['instagram_url'] = 'Please enter a Instagram valid  URL';
		// }
		// if (trim($this->request->post['x_url']) == '') {
		// 	$this->error['x_url'] = 'Twitter URL field is missing';
		// } elseif (!filter_var($this->request->post['x_url'], FILTER_VALIDATE_URL)) {
		// 	$this->error['x_url'] = 'Please enter a Twitter valid  URL';
		// }
		// if (trim($this->request->post['opening_time']) == '') {
		// 	$this->error['opening_time'] = 'Opening Time field is missing';
		// } 
		// if (trim($this->request->post['closing_time']) == '') {
		// 	$this->error['closing_time'] = 'Closing Time field is missing';
		// } 
		foreach ($data['brands_description'] as $language_id => $value) {
			if ((utf8_strlen(trim($value['name'])) < 1)) {
				$this->error['name'][$language_id] = "Title field is missing";
			}
			// if ((utf8_strlen(trim($value['full_description'])) < 1)) {
			// 	$this->error['full_description'][$language_id] = "Description field is missing";
			// }
		}
		// if (isset($this->request->post['brand_images']) && !empty($this->request->post['brand_images'])) {
		// 	foreach ($this->request->post['brand_images'] as $option_value_id1 => $option_value1) {
		// 		if ((utf8_strlen($option_value1['image']) < 1)) {
		// 			$this->error['brand_images'][$option_value_id1]['image'] = "Image is missing.";
		// 		}
		// 	}
		// } else {
		// 	$this->error['gallery_images_main'] = "Please add at least one image.";
		// }

		// if (isset($this->request->post['ourmenu_images']) && !empty($this->request->post['ourmenu_images'])) {
		// 	foreach ($this->request->post['ourmenu_images'] as $option_value_id1 => $option_value1) {
		// 		if ((utf8_strlen($option_value1['image']) < 1)) {
		// 			$this->error['ourmenu_images'][$option_value_id1]['image'] = "Image is missing.";
		// 		}
		// 		if ((utf8_strlen($option_value1['pdf']) < 1)) {
		// 			$this->error['ourmenu_images'][$option_value_id1]['pdf'] = "PDF is missing.";
		// 		}
		// 		foreach ($option_value1['description'] as $language_id1 => $option_value_description1) {
		// 			if ((utf8_strlen($option_value_description1['title']) < 1)) {
		// 				$this->error['ourmenu_images'][$option_value_id1]['title'][$language_id1] = "Title is missing.";
		// 			}
		// 			// if ((utf8_strlen($option_value_description1['content']) < 1)) {
		// 			// 	$this->error['ourmenu_images'][$option_value_id1]['content'][$language_id1] = "Content is missing.";
		// 			// }
		// 		}
		// 	}
		// } else {
		// 	$this->error['ourmenu_images_main'] = "Please add at least one element.";
		// }

		if (!$this->request->get['brand_id']) {
			if ($_FILES["icon"]["name"] == "") {
				$this->error['icon'] = 'Please upload icon';
			}
			if ($_FILES["thumbnail"]["name"] == "") {
				$this->error['thumbnail'] = 'Please upload thumbnail';
			}
			// if ($_FILES["image"]["name"] == "") {
			// 	$this->error['image'] = 'Please upload image';
			// }
		}
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = ' Warning: Please check the form carefully for errors!';
		}

		$this->load_model('seourl');
		if ($data['seo_url'] != "") {
			$keyword = $this->model_seourl->seoUrl($data['seo_url']);
		}
		if ($keyword != '') {
			$this->load_model('seourl');
			$seo_urls = $this->model_seourl->getSeoUrlsByKeyword($keyword);
			foreach ($seo_urls as $seo_url) {
				if (($this->request->get['brand_id'] != $seo_url['slog_id'] || ($seo_url['slog'] != 'brands/detail'))) {
					$this->error['seo_url'] = "This url is already been used";
					break;
				}
			}
		}
		// echo '<pre>';  print_r($this->request->post); print_r($this->error); exit;
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
		$data['add'] = $this->link('brands/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->link('brands/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['brands'] = array();
		$filter_data = array(
			'order' => $order,
		);
		$results = $this->model_brands->getListBrands($filter_data);
		// echo '<pre>'; print_r($results); exit;
		foreach ($results as $result) {
			$data['brands'][] = array(
				'brand_id'     => $result['brand_id'],
				'name'		 	=> $result['name'],
				'location_name'	=> $result['location_name'],
				'status' 		=> $result['status'],
				'sort_order'    => $result['sort_order'],
				'edit'       	=> $this->link('brands/edit', 'token=' . $this->session->data['token'] . '&brand_id=' . $result['brand_id'] . $url, 'SSL'),
				'delete'       	=> $this->link('brands/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
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
		$data['ajaxbrandssstatus'] = $this->link('brands/ajaxbrandssstatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['token'] = $this->session->data['token'];
		$this->data = $data;
		$this->template = 'modules/brands/list.tpl';
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
			$targetDirectory = DIR_IMAGE . "brands/";
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

	public function uploadPdf()
{
    if (!empty($_FILES["pdf"]["name"])) {
        $targetDirectory = DIR_IMAGE . "brands/pdf/";
        $filename = time();
        $path = $_FILES['pdf']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        if ($ext !== 'pdf') {
            $json['success'] = false;
            $json['error'] = 'Invalid file type. Only PDFs are allowed.';
        } else {
            if (!is_dir($targetDirectory)) {
                mkdir($targetDirectory, 0755, true);
            }

            $targetFile = $targetDirectory . $filename . '.' . $ext;

            if (move_uploaded_file($_FILES["pdf"]["tmp_name"], $targetFile)) {
                $json['success'] = true;
                $json['filename'] = $filename . '.' . $ext;
            } else {
                $json['success'] = false;
                $json['error'] = 'Failed to upload the file.';
            }
        }
    } else {
        $json['success'] = false;
        $json['error'] = 'No file uploaded.';
    }

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
}


	public function ajaxbrandssstatus()
	{
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->load_model('brands');
			$brand_id = $this->request->post['brand_id'];
			$status = $this->request->post['status'];
			$stat = $this->model_brands->updateBrandsStatus($brand_id, $status);
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

	protected function validateDelete()
	{
		if (!$this->user->hasPermission('modify', 'brands')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		return !$this->error;
	}
}