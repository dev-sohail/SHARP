<?php
class ControllerProduct extends Controller
{
    private $error = array();
    public function index()
	{
		$data = $this->language->getAll();
		$this->document->setTitle('Admin - Products');
		$this->load_model('product');
		$this->getList();
	}

    protected function getList()
	{
        $data = $this->language->getAll();
		$data['heading_title'] = 'Products';
        $url = '';
		$data['breadcrumbs'][] = array(
			'text' => 'Product',
			'href' => $this->link('product', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
        if (isset($this->request->get['page'])) {
			$page = (int) $this->request->get['page'];
		} else {
			$page = 1;
		}
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
        $data['add']    = $this->link('product/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->link('product/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['products'] = array();
		$filter_data   = array(
			'order' => $order,
		);
		$results       = $this->model_product->getProducts($this->config->get('config_language_id'), $filter_data);
        foreach ($results as $result) {
			$data['products'][] = array(
				'product_id' => $result['id'],
				'title'    => $result['title'],
				'publish_date' => $result['publish_date'],
				'status'    => $result['status'],
				'edit'       => $this->link('product/edit', 'token=' . $this->session->data['token'] . '&product_id=' . $result['id'] . $url, 'SSL'),
				'delete'     => $this->link('product/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
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
		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array) $this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}
        // $data['main_slider'] = $results;
		$data['groupby'] = 1;
		$url             = '';
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$data['sort_status']     = $this->link('product', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$data['sort_date_added'] = $this->link('product', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');
        $data['sort_title']   = $this->link('product', 'token=' . $this->session->data['token'] . '&sort=title' . $url, 'SSL');
		$url = '';
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		$data['ajaxupdateproductstatus'] = $this->link('product/ajaxupdateproductstatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$bannerTotal        = $this->model_product->getTotalProducts();
		$pagination         = new Pagination();
		$pagination->total  = $bannerTotal;
		$pagination->page   = $page;
		$pagination->limit  = $this->config->get('config_limit_admin');
		$pagination->url    = HTTP_HOST . '?controller=product&token=' . $this->session->data['token'] . $url . '&page={page}';
		$data['pagination'] = $pagination->render();
		$data['results']    = sprintf($this->language->get('text_pagination'), ($bannerTotal) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($bannerTotal - $this->config->get('config_limit_admin'))) ? $bannerTotal : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $bannerTotal, ceil($bannerTotal / $this->config->get('config_limit_admin')));
		$data['ajaxUrl']    = HTTP_HOST . '?controller=product&token=' . $this->session->data['token'] . '&action=ajaxupdateproductstatus';
		$data['token']      = $this->session->data['token'];
		$this->data         = $data;
		$this->template     = 'modules/product/list.tpl';
		$this->zones        = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
		// echo "<script>var ajaxUrl = '" . $data['ajaxupdateproductstatus'] . "';</script>";
		// echo "<script>alert(ajaxUrl);</script>";
		// exit;
    }

    public function add()
	{
        $this->document->setTitle('Admin - Add Product');

		$this->load_model('product');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_product->addProduct($this->request->post);

			$this->session->data['success'] = $this->language->get('Success: You have added a new product!');

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
			$this->response->redirect($this->link('product', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
    }

    protected function validateForm()
	{
		if (!$this->user->hasPermission('modify', 'product')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		$data = $this->request->post;
        foreach ($data['product_description'] as $language_id => $value) {
            if ((utf8_strlen(trim($value['title'])) < 1)) {
                $this->error['title'][$language_id] = "Title field is missing";
            }
            if ((utf8_strlen(trim($value['description'])) < 1)) {
                $this->error['description'][$language_id] = "Description field is missing";
            }
            if ((utf8_strlen(trim($value['short_description'])) < 1)) {
                $this->error['short_description'][$language_id] = "Short Description field is missing";
            }
        }
        if (!$this->request->get['product_id']) {
            if ($_FILES["icon"]["name"] == "") {
                $this->error['icon'] = 'Please upload icon image';
            }
        } else {
            if ($data["icon"] == "") {
                $this->error['icon'] = 'Please upload icon image';
            }
        }
		// if (isset($this->request->post['product_features_image']) && !empty($this->request->post['product_features_image'])) {
		// 	foreach ($this->request->post['product_features_image'] as $index => $feature) {
		// 		if (empty($feature['image']) || utf8_strlen(trim($feature['image'])) < 1) {
		// 			$this->error['product_features_image'][$index]['image'] = "Image is missing.";
		// 		}
		// 		if (!isset($feature['sort_order']) || !is_numeric($feature['sort_order'])) {
		// 			$this->error['product_features_image'][$index]['sort_order'] = "Sort order is missing or invalid.";
		// 		}
		// 	}
		// }
		if (isset($this->request->post['screen_size']) && ! empty($this->request->post['screen_size'])) {
			$screen_size = $this->request->post['screen_size'];
			if (!is_numeric($screen_size) || $screen_size <= 0) {
				$this->error['screen_size'] = 'Screen size must be a positive number!';
			} else {
				$this->request->post['screen_size'] = $screen_size;
			}
		}
		if (isset($this->request->post['sku']) && ! empty($this->request->post['sku'])) {
			$sku = $this->request->post['sku'];
			// SKU validation: must be 3-32 chars, alphanumeric, dashes or underscores, start with a letter
			if (!preg_match('/^[a-zA-Z][a-zA-Z0-9_-]{2,31}$/', $sku)) {
				$this->error['sku'] = 'SKU must start with a letter and be 3-32 characters (letters, numbers, dashes, underscores).';
			}
		}
		if (isset($this->request->post['video']) && ! empty($this->request->post['video'])) {
			$video = $this->request->post['video'];
			if (! filter_var($video, FILTER_VALIDATE_URL)) {
				$this->error['video'] = 'Video URL is not valid!';
			} else {
				$this->request->post['video'] = $video;
			}
		}
		if (isset($this->request->post['product_benefits_image']) && !empty($this->request->post['product_benefits_image'])) {
			foreach ($this->request->post['product_benefits_image'] as $index => $benefit) {
				// Validate image
				if (empty($benefit['image']) || utf8_strlen(trim($benefit['image'])) < 1) {
					$this->error['product_benefits_image'][$index]['image'] = "Image is missing.";
				}
				// Validate description fields for each language
				if (isset($benefit['description']) && is_array($benefit['description'])) {
					foreach ($benefit['description'] as $language_id => $desc) {
						if (!isset($desc['title']) || utf8_strlen(trim($desc['title'])) < 1) {
							$this->error['product_benefits_image'][$index]['title'][$language_id] = "Title is missing.";
						}
						if (!isset($desc['description']) || utf8_strlen(trim($desc['description'])) < 1) {
							$this->error['product_benefits_image'][$index]['description'][$language_id] = "Description is missing.";
						}
					}
				} else {
					$this->error['product_benefits_image'][$index]['description'] = "Description is missing.";
				}
			}
		}
		if ($this->error && ! isset($this->error['warning'])) {
			$this->error['warning'] = ' Warning: Please check the form carefully for errors!';
		}
        // echo "<pre>";
        // print_r($this->error);  
        // echo "</pre>";
        // exit;
		if (! $this->error) {
			return true;
		} else {
			return false;
		}
	}

	public function edit()
	{
		$this->document->setTitle('Admin - Edit Product');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			// echo '<pre>'; print_r($this->request->post); '</pre>'; exit;
			$this->load_model('product');
			$this->model_product->editProduct($this->request->get['product_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have modified product!');
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
			$this->response->redirect($this->link('product', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}

	public function delete()
	{
		$this->load_model('product');
		if($this->validateDelete() && isset($this->request->post['product_id'])) {
			$this->model_product->deleteProduct($this->request->post['product_id']);
			$this->session->data['success'] = $this->language->get('Success: You have deleted a product!');

			$this->response->redirect($this->link('product', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->getList();
	}

	protected function getForm()
	{
		$data                       = $this->language->getAll();
		$data['text_form']          = ! isset($this->request->get['product_id']) ? 'Add New Product' : 'Edit Product';
		$data['img_feild_required'] = ! isset($this->request->get['product_id']) ? "required" : "";
		$data['is_edit']            = ! isset($this->request->get['product_id']) ? "no" : "yes";
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
		if (isset($this->error['description'])) {
			$data['error_description'] = $this->error['description'];
		} else {
			$data['error_description'] = '';
		}
		if (isset($this->error['short_description'])) {
			$data['error_short_description'] = $this->error['short_description'];
		} else {
			$data['error_short_description'] = '';
		}
        if (isset($this->error['icon'])) {
            $data['error_icon'] = $this->error['icon'];
        } else {
            $data['error_icon'] = '';
        }
		if (isset($this->error['screen_size'])) {
			$data['error_screen_size'] = $this->error['screen_size'];
		} else {
			$data['error_screen_size'] = '';
		}
		if (isset($this->error['sku'])) {
			$data['error_sku'] = $this->error['sku'];
		} else {
			$data['error_sku'] = '';
		}
		if (isset($this->error['video'])) {
			$data['error_video'] = $this->error['video'];
		} else {
			$data['error_video'] = '';
		}
		if (isset($this->error['made_in'])) {
			$data['error_made_in'] = $this->error['made_in'];
		} else {
			$data['error_made_in'] = '';
		}
		if (isset($this->error['product_features_image'])) {
			$data['error_product_features_image'] = $this->error['product_features_image'];
		} else {
			$data['error_product_features_image'] = '';
		}
		// if (isset($this->error['product_benefits_image'])) {
		// 	$data['error_product_benefits_image'] = $this->error['product_benefits_image'];
		// } else {
		// 	$data['error_product_benefits_image'] = '';
		// }
		// echo '<pre>'; print_r($data['error_product_features_image']); echo '</pre>'; exit;

		$url = '';

		if (! isset($this->request->get['product_id'])) {
			$data['action'] = $this->link('product/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->link('product/edit', 'token=' . $this->session->data['token'] . '&product_id=' . $this->request->get['product_id'] . $url, 'SSL');
		}
		$data['cancel'] = $this->link('product', 'token=' . $this->session->data['token'] . $url, 'SSL');
		if (isset($this->request->get['product_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$this->load_model('product');
			$product_info = $this->model_product->getProduct($this->request->get['product_id']);
		}
		$data['product_info'] = $product_info;
		$db_filter             = [
			'order' => 'DESC'
		];
		$this->load_model('language');
		$data['languages'] = $this->model_language->getLanguages($db_filter);
		if (isset($this->request->post['product_description'])) {
			$data['product_description'] = $this->request->post['product_description'];
		} elseif (isset($this->request->get['product_id'])) {
			$data['product_description'] = $this->model_product->getProductDescriptions($this->request->get['product_id']);
		} else {
			$data['product_description'] = array();
		}

		// fatch dynamic from country
		$this->load_model('product');
		$data['made_in_options'] = $this->model_product->getMadeInOptions();

		if (isset($this->request->post['made_in'])) {
			$data['made_in'] = $this->request->post['made_in'];
		} elseif (!empty($product_info) && isset($product_info['made_in'])) {
			$data['made_in'] = $product_info['made_in'];
		} else {
			$data['made_in'] = '';
		}
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (! empty($product_info)) {
			$data['sort_order'] = $product_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (! empty($product_info)) {
			$data['status'] = $product_info['status'];
		} else {
			$data['status'] = true;
		}
        if (isset($this->request->post['icon'])) {
            $data['icon'] = $this->request->post['icon'];
        } elseif (! empty($product_info)) {
            $data['icon'] = $product_info['icon'];
        } else {
            $data['icon'] = '';
        }
		if (isset($this->request->post['publish_date'])) {
			$data['publish_date'] = $this->request->post['publish_date'];
		} elseif (! empty($product_info) && isset($product_info['publish_date'])) {
			$data['publish_date'] = $product_info['publish_date'];
		} else {
			$data['publish_date'] = '';
		}
		if (isset($this->request->post['screen_size'])) {
			$data['screen_size'] = $this->request->post['screen_size'];
		} elseif (! empty($product_info) && isset($product_info['screen_size'])) {
			$data['screen_size'] = $product_info['screen_size'];
		} else {
			$data['screen_size'] = '';
		}
		if (isset($this->request->post['sku'])) {
			$data['sku'] = $this->request->post['sku'];
		} elseif (! empty($product_info) && isset($product_info['sku'])) {
			$data['sku'] = $product_info['sku'];
		} else {
			$data['sku'] = '';
		}
		if (isset($this->request->post['video'])) {
			$data['video'] = $this->request->post['video'];
		} elseif (! empty($product_info) && isset($product_info['video'])) {
			$data['video'] = $product_info['video'];
		} else {
			$data['video'] = '';
		}
		if (isset($this->request->post['featured'])) {
			$data['featured'] = $this->request->post['featured'];
		} elseif (! empty($product_info) && isset($product_info['featured'])) {
			$data['featured'] = $product_info['featured'];
		} else {
			$data['featured'] = '';
		}
		if (isset($this->request->post['product_features_image'])) {
			$product_features_images = $this->request->post['product_features_image'];
			// echo '<pre>';
			// print_r($product_features_image);
			// exit;
		} elseif (isset($this->request->get['product_id'])) {
			$product_features_images = $this->model_product->getProductFeatureImages($this->request->get['product_id']);
		} else {
			$product_features_images = array();
		}

		$data['product_features_images'] = array();

		foreach ($product_features_images as $product_features_image) {
			if (is_file(DIR_IMAGE . 'product/' . $product_features_image['image'])) {
				$image = $product_features_image['image'];
				$thumb = '../uploads/image/product/' . $product_features_image['image'];
			} else {
				$image = '';
				$thumb = '../uploads/image/no-image.png';
			}

			$data['product_features_images'][] = array(
				'image'      => $image,
				'thumb'      => $thumb,
				'sort_order' => $product_features_image['sort_order']
			);
		}

		

		// if (isset($this->request->post['product_benefits_image'])) {
		// 	$product_benefits_image = $this->request->post['product_benefits_image'];
		// } elseif (isset($this->request->get['product_id'])) {
		// 	$product_benefits_image = $this->model_product->getProductBenefitsImage($this->request->get['product_id']);
		// } else {
		// 	$product_benefits_image = array();
		// }

		// $data['product_benefits_image'] = array();

		// foreach ($product_benefits_image as $product_benefits_images) {
		// 	if (is_file(DIR_IMAGE . 'product/' . $product_benefits_images['image'])) {
		// 		$image = $product_benefits_images['image'];
		// 		$thumb = '../uploads/image/product/' . $product_benefits_images['image'];
		// 	} else {
		// 		$image = '';
		// 		$thumb = '../uploads/image/no-image.png';
		// 	}

		// 	$data['product_benefits_image'][] = array(
		// 		'image'      => $image,
		// 		'thumb'      => $thumb,
		// 		'title'       => $product_benefits_image['title'],
		// 		'description' => $product_benefits_image['description']
		// 	);
		// }
		// echo '<pre>'; print_r($data['product_benefits_image']); echo '</pre>'; exit;

		// $this->load_model('language');
		// $data['languages'] = $this->model_language->getLanguages($db_filter);
		// if (isset($this->request->post['product_benefits_description'])) {
		// 	$data['product_benefits_description'] = $this->request->post['product_benefits_description'];
		// } elseif (isset($this->request->get['product_id'])) {
		// 	$data['product_benefits_description'] = $this->model_product->getProductBenefitsDescription($this->request->get['product_id']);
		// } else {
		// 	$data['product_benefits_description'] = array();
		// }


		// echo '<pre>';
		// print_r($data['product_features_image']);
		// echo '</pre>';
		// exit;
		$this->data     = $data;
		$this->template = 'modules/product/form.tpl';
		$this->zones    = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
    }

	public function ajaxupdateproductstatus()
	{
		
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->load_model('product');
			$productId = $this->request->post['product_id'];
			$status = $this->request->post['status'];
			$this->model_product->updateProductStatus($productId, $status);
			$json['success'] = true;
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
		}
	}

	public function uploadImages()
	{
		if (!empty($_FILES["image"]["name"])) {
			$targetDirectory = DIR_IMAGE . "product/";
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
	
	protected function validateDelete()
	{

		if (!$this->user->hasPermission('modify', 'product')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		

		return !$this->error;
	}
}