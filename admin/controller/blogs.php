<?php
class ControllerBlogs extends Controller
{
	private $error = array();
	public function index()
	{
		$data = $this->language->getAll();
		$this->document->setTitle('Admin - Blogs');
		$this->load_model('blogs');
		$this->getList();
	}
	protected function getList()
	{
		$data                  = $this->language->getAll();
		$url                   = '';
		$data['breadcrumbs'][] = array(
			'text' => 'Blogs',
			'href' => $this->link('blogs', 'token=' . $this->session->data['token'] . $url, 'SSL')
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
		$data['add']    = $this->link('blogs/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->link('blogs/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['users'] = array();
		$filter_data   = array(
			'order' => $order,
		);
		$results = $this->model_blogs->getBlogs($filter_data);

		foreach ($results as $result) {
			$data['blogs'][] = array(
				'blog_id'   => $result['id'],
				'title'   	  => $result['title'],
				'author'     => $result['author'],
				'publish'     => $result['publish'],
				'edit'        => $this->link('blogs/edit', 'token=' . $this->session->data['token'] . '&blog_id=' . $result['id'] . $url, 'SSL'),
				'delete'      => $this->link('blogs/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
			);
		}
		$data['main_slider'] = $results;
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
		$data['groupby'] = 1;
		$url             = '';
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$data['sort_status']     = $this->link('blogs', 'token=' . $this->session->data['token'] . '&sort=publish' . $url, 'SSL');
		$data['sort_date_added'] = $this->link('blogs', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');
		$url                     = '';
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
		$data['ajaxblogstatus'] = $this->link('blogs/ajaxblogstatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$sliderTotal        = $this->model_blogs->getTotalBlogs();
		$pagination         = new Pagination();
		$pagination->total  = $sliderTotal;
		$pagination->page   = $page;
		$pagination->limit  = $this->config->get('config_limit_admin');
		$pagination->url    = HTTP_HOST . '?controller=blogs/&token=' . $this->session->data['token'] . $url . '&page={page}';
		$data['pagination'] = $pagination->render();
		$data['results']    = sprintf($this->language->get('text_pagination'), ($sliderTotal) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($sliderTotal - $this->config->get('config_limit_admin'))) ? $sliderTotal : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $sliderTotal, ceil($sliderTotal / $this->config->get('config_limit_admin')));
		$data['ajaxUrl']    = HTTP_HOST . '?controller=blogs';
		$data['token']      = $this->session->data['token'];
		$this->data         = $data;
		$this->template     = 'modules/blogs/list.tpl';
		$this->zones        = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}
	public function add()
	{
		$this->document->setTitle('Admin - Blog');

		$this->load_model('blogs');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_blogs->addBlog($this->request->post);

			$this->session->data['success'] = $this->language->get('Success: You have added a new Blog!');

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
			$this->response->redirect($this->link('blogs', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}
	protected function validateForm()
	{
		if (!$this->user->hasPermission('modify', 'blogs')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}
		$error_publish_date = 'Publish date field is missing';
		$data = $this->request->post;
		foreach ($data['blog_description'] as $language_id => $value) {
			if ((utf8_strlen(trim($value['title'])) < 1)) {
				$this->error['title'][$language_id] = "Title field is missing";
			}
			if ((utf8_strlen(trim($value['author'])) < 1)) {
				$this->error['author'][$language_id] = "Author field is missing";
			}
			if ((utf8_strlen(trim($value['short_description'])) < 1)) {
				$this->error['short_description'][$language_id] = "Short Description field is missing";
			}
			if ((utf8_strlen(trim($value['description'])) < 1)) {
				$this->error['description'][$language_id] = "Description field is missing";
			}
		}
		if (!$this->request->get['blog_id']) {
			if ($_FILES["thumb_image"]["name"] == "") {
				$this->error['thumb_image'] = 'Please upload Thumb Image';
			}
		} else {
			if ($data["thumb_image"] == "" && $_FILES["thumb_image"]["name"] == "") {
				$this->error['thumb_image'] = 'Please upload Thumb Image';
			}
		}

		if (!$this->request->get['blog_id']) {
			if ($_FILES["banner_image"]["name"] == "") {
				$this->error['banner_image'] = 'Please upload Banner Image';
			}
		} else {
			if ($data["banner_image"] == "" && $_FILES["banner_image"]["name"] == "") {
				$this->error['banner_image'] = 'Please upload Banner Image';
			}
		}
		if ($this->request->post['publish_date'] == '') {
			$this->error['publish_date'] =  $error_publish_date;
		}
	
		$this->load_model('seourl');
		if ($data['seo_url'] != "") {
			$keyword = $this->model_seourl->seoUrl($data['seo_url']);
		}
		if ($keyword != '') {
			$this->load_model('seourl');
			$seo_urls = $this->model_seourl->getSeoUrlsByKeyword($keyword);
			foreach ($seo_urls as $seo_url) {
				if (($this->request->get['blog_id'] != $seo_url['slog_id'] || ($seo_url['slog'] != 'blogs/detail'))) {
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
	public function edit()
	{
		$this->document->setTitle('Admin - Blog');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->load_model('blogs');
			$this->model_blogs->editBlog($this->request->get['blog_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('Success: You have modified Blog!');
			$url                            = '';
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->link('blogs', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}
	public function delete()
	{
		$this->load_model('blogs');
		if ($this->validateDelete() && $this->request->post['blog_id']) {
			$this->model_blogs->deleteBlog($this->request->post['blog_id']);

			$this->session->data['success'] = $this->language->get('Success: You have deleted Blog!');
			$this->response->redirect($this->link('blogs', 'token=' . $this->session->data['token'], 'SSL'));

		}

		$this->getList();
	}
	protected function getForm()
	{
		$data                       = $this->language->getAll();
		$data['text_form']          = !isset($this->request->get['blog_id']) ? 'Add New Blog' : 'Edit Blog';
		$data['img_feild_required'] = !isset($this->request->get['blog_id']) ? "required" : "";
		$data['is_edit']            = !isset($this->request->get['blog_id']) ? "no" : "yes";
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
		if (isset($this->error['author'])) {
			$data['error_author'] = $this->error['author'];
		} else {
			$data['error_author'] = '';
		}
		if (isset($this->error['publish_date'])) {
			$data['error_publish_date'] = $this->error['publish_date'];
		} else {
			$data['error_publish_date'] = '';
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
		if (isset($this->error['thumb_image'])) {
			$data['error_thumb_image'] = $this->error['thumb_image'];
		} else {
			$data['error_thumb_image'] = '';
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

		if (!isset($this->request->get['blog_id'])) {
			$data['action'] = $this->link('blogs/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->link('blogs/edit', 'token=' . $this->session->data['token'] . '&blog_id=' . $this->request->get['blog_id'] . $url, 'SSL');
		}
		$data['cancel'] = $this->link('blogs', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['blog_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$this->load_model('blogs');
			$blog_info = $this->model_blogs->getBlog($this->request->get['blog_id']);
		}
		$data['single_blog'] = $blog_info;
		$db_filter = [
			'order' => 'DESC'
		];
		$this->load_model('language');
		$data['languages'] = $this->model_language->getLanguages($db_filter);
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($blog_info)) {
			$data['sort_order'] = $blog_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
		if (isset($this->request->post['publish'])) {
			$data['publish'] = $this->request->post['publish'];
		} elseif (!empty($blog_info)) {
			$data['publish'] = $blog_info['publish'];
		} else {
			$data['publish'] = true;
		}
		if (isset($this->request->post['seo_url'])) {
			$data['seo_url'] = $this->request->post['seo_url'];
		} elseif (!empty($blog_info)) {
			$data['seo_url'] = $blog_info['seo_url'];
		} else {
			$data['seo_url'] = false;
		}
		if (isset($this->request->post['thumb_image'])) {
			$data['thumb_image'] = $this->request->post['thumb_image'];
		} elseif (!empty($blog_info)) {
			$data['thumb_image'] = $blog_info['thumb_image'];
		} else {
			$data['thumb_image'] = '';
		}
		if (isset($this->request->post['banner_image'])) {
			$data['banner_image'] = $this->request->post['banner_image'];
		} elseif (!empty($blog_info)) {
			$data['banner_image'] = $blog_info['banner_image'];
		} else {
			$data['banner_image'] = '';
		}
		if (isset($this->request->post['publish_date'])) {
			$data['publish_date'] = $this->request->post['publish_date'];
		} elseif (!empty($blog_info)) {
			$data['publish_date'] = date('Y-m-d', strtotime($blog_info['publish_date']));
		} else {
			$data['publish_date'] = '';
		}
		if (isset($this->request->post['blog_description'])) {
			$data['blog_description'] = $this->request->post['blog_description'];
		} elseif (isset($this->request->get['blog_id'])) {
			$data['blog_description'] = $this->model_blogs->getBlogDescription($this->request->get['blog_id']);
			// echo '<pre>'; print_r($data['blog_description']); exit;
		} else {
			$data['blog_description'] = array();
		}
		$this->data     = $data;
		$this->template = 'modules/blogs/form.tpl';
		$this->zones    = array(
			'header',
			'columnleft',
			'footer'
		);
		$this->response->setOutput($this->render());
	}

	public function ajaxblogstatus()
	{
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->load_model('blogs');
			$blog_id = $this->request->post['blog_id'];
			$status = $this->request->post['status'];
			$this->model_blogs->updateBlogsStatus($blog_id, $status);
			$json['success'] = true;
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
		}
	}
	protected function validateDelete()
	{

		if (!$this->user->hasPermission('modify', 'blogs')) {
			$this->error['warning'] = 'Warning: You do not have permission for modification!';
		}


		return !$this->error;
	}
}
