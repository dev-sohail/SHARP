<?php
class ControllerProduct extends Controller
{
    private $error = array();
    public function index()
	{
		$data = $this->language->getAll();
		$this->document->setTitle('Admin - Product');
		$this->load_model('product');
		$this->getList();
	}

    protected function getList()
	{
        $data = $this->language->getAll();
		$data['heading_title'] = 'Product';
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
		$data['ajaxupdateproductstatus'] = $this->link('/ajaxupdateproductstatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
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
            if ((utf8_strlen(trim($value['designation'])) < 1)) {
                $this->error['designation'][$language_id] = "Designation field is missing";
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
        if (isset($this->error['designation'])) {
            $data['error_designation'] = $this->error['designation'];
        } else {
            $data['error_designation'] = '';
        }
        if (isset($this->error['icon'])) {
            $data['error_icon'] = $this->error['icon'];
        } else {
            $data['error_icon'] = '';
        }
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
		if (isset($this->request->post['number_of_stars'])) {
			$data['number_of_stars'] = $this->request->post['number_of_stars'];
		} elseif (! empty($product_info)) {
			$data['number_of_stars'] = $product_info['number_of_stars'];
		} else {
			$data['number_of_stars'] = 5;
		}
        if (isset($this->request->post['icon'])) {
            $data['icon'] = $this->request->post['icon'];
        } elseif (! empty($product_info)) {
            $data['icon'] = $product_info['icon'];
        } else {
            $data['icon'] = '';
        }
		// echo '<pre>';
		// print_r($data);
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
	protected function validateDelete()
	{

		if (!$this->user->hasPermission('modify', 'product')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		

		return !$this->error;
	}
}