<?php
class ControllerProductEnquiry extends Controller
{
    private $error = array();
    public function index()
    {
        $data = $this->language->getAll();
        $this->document->setTitle('Admin - ProductEnquirys');
        $this->load_model('productenquiry');
        $this->getList();
    }

    protected function getList()
    {
        $data = $this->language->getAll();
        $data['heading_title'] = 'ProductEnquirys';
        $url = '';
        $data['breadcrumbs'][] = array(
            'text' => 'ProductEnquiry',
            'href' => $this->link('productenquiry', 'token=' . $this->session->data['token'] . $url, 'SSL')
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
        $data['add']    = $this->link('productenquiry/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->link('productenquiry/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $data['productenquirys'] = array();
        $filter_data   = array(
            'order' => $order,
        );
        $results       = $this->model_productenquiry->getProductEnquirys($this->config->get('config_language_id'), $filter_data);
        foreach ($results as $result) {
            $data['productenquirys'][] = array(
                'productenquiry_id' => $result['id'],
                'title'    => $result['title'],
                'publish_date' => $result['publish_date'],
                'status'    => $result['status'],
                'edit'       => $this->link('productenquiry/edit', 'token=' . $this->session->data['token'] . '&productenquiry_id=' . $result['id'] . $url, 'SSL'),
                'delete'     => $this->link('productenquiry/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
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
        $data['sort_status']     = $this->link('productenquiry', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
        $data['sort_date_added'] = $this->link('productenquiry', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');
        $data['sort_title']   = $this->link('productenquiry', 'token=' . $this->session->data['token'] . '&sort=title' . $url, 'SSL');
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
        $data['ajaxupdateproductenquirystatus'] = $this->link('productenquiry/ajaxupdateproductenquirystatus', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $bannerTotal        = $this->model_productenquiry->getTotalProductEnquirys();
        $pagination         = new Pagination();
        $pagination->total  = $bannerTotal;
        $pagination->page   = $page;
        $pagination->limit  = $this->config->get('config_limit_admin');
        $pagination->url    = HTTP_HOST . '?controller=productenquiry&token=' . $this->session->data['token'] . $url . '&page={page}';
        $data['pagination'] = $pagination->render();
        $data['results']    = sprintf($this->language->get('text_pagination'), ($bannerTotal) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($bannerTotal - $this->config->get('config_limit_admin'))) ? $bannerTotal : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $bannerTotal, ceil($bannerTotal / $this->config->get('config_limit_admin')));
        $data['ajaxUrl']    = HTTP_HOST . '?controller=productenquiry&token=' . $this->session->data['token'] . '&action=ajaxupdateproductenquirystatus';
        $data['token']      = $this->session->data['token'];
        $this->data         = $data;
        $this->template     = 'modules/productenquiry/list.tpl';
        $this->zones        = array(
            'header',
            'columnleft',
            'footer'
        );
        $this->response->setOutput($this->render());
        // echo "<script>var ajaxUrl = '" . $data['ajaxupdateproductenquirystatus'] . "';</script>";
        // echo "<script>alert(ajaxUrl);</script>";
        // exit;
    }

    public function add()
    {
        $this->document->setTitle('Admin - Add ProductEnquiry');

        $this->load_model('productenquiry');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

            $this->model_productenquiry->addProductEnquiry($this->request->post);

            $this->session->data['success'] = $this->language->get('Success: You have added a new productenquiry!');

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
            $this->response->redirect($this->link('productenquiry', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        $this->getForm();
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'productenquiry')) {
            $this->error['warning'] = 'Warning: You do not have permission for modification!';
        }
        $data = $this->request->post;
        foreach ($data['productenquiry_description'] as $language_id => $value) {
            if ((utf8_strlen(trim($value['title'])) < 1)) {
                $this->error['title'][$language_id] = "Title field is missing";
            }
        }
        if (isset($this->request->post['screen_size']) && ! empty($this->request->post['screen_size'])) {
            $screen_size = $this->request->post['screen_size'];
            if (!is_numeric($screen_size) || $screen_size <= 0) {
                $this->error['screen_size'] = 'Screen size must be a positive number!';
            } else {
                $this->request->post['screen_size'] = $screen_size;
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
        $this->document->setTitle('Admin - Edit ProductEnquiry');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            // echo '<pre>'; print_r($this->request->post); '</pre>'; exit;
            $this->load_model('productenquiry');
            $this->model_productenquiry->editProductEnquiry($this->request->get['productenquiry_id'], $this->request->post);
            $this->session->data['success'] = $this->language->get('Success: You have modified productenquiry!');
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
            $this->response->redirect($this->link('productenquiry', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        $this->getForm();
    }

    public function delete()
    {
        $this->load_model('productenquiry');
        if ($this->validateDelete() && isset($this->request->post['productenquiry_id'])) {
            $this->model_productenquiry->deleteProductEnquiry($this->request->post['productenquiry_id']);
            $this->session->data['success'] = $this->language->get('Success: You have deleted a productenquiry!');

            $this->response->redirect($this->link('productenquiry', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->getList();
    }

    protected function getForm()
    {
        $data                       = $this->language->getAll();
        $data['text_form']          = ! isset($this->request->get['productenquiry_id']) ? 'Add New ProductEnquiry' : 'Edit ProductEnquiry';
        $data['img_feild_required'] = ! isset($this->request->get['productenquiry_id']) ? "required" : "";
        $data['is_edit']            = ! isset($this->request->get['productenquiry_id']) ? "no" : "yes";
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

        $url = '';

        if (! isset($this->request->get['productenquiry_id'])) {
            $data['action'] = $this->link('productenquiry/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->link('productenquiry/edit', 'token=' . $this->session->data['token'] . '&productenquiry_id=' . $this->request->get['productenquiry_id'] . $url, 'SSL');
        }
        $data['cancel'] = $this->link('productenquiry', 'token=' . $this->session->data['token'] . $url, 'SSL');
        if (isset($this->request->get['productenquiry_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $this->load_model('productenquiry');
            $productenquiry_info = $this->model_productenquiry->getProductEnquiry($this->request->get['productenquiry_id']);
        }
        $data['productenquiry_info'] = $productenquiry_info;
        $db_filter             = [
            'order' => 'DESC'
        ];
        $this->load_model('language');
        $data['languages'] = $this->model_language->getLanguages($db_filter);
        if (isset($this->request->post['productenquiry_description'])) {
            $data['productenquiry_description'] = $this->request->post['productenquiry_description'];
        } elseif (isset($this->request->get['productenquiry_id'])) {
            $data['productenquiry_description'] = $this->model_productenquiry->getProductEnquiryDescriptions($this->request->get['productenquiry_id']);
        } else {
            $data['productenquiry_description'] = array();
        }

        // fatch dynamic from country
        $this->load_model('productenquiry');
        $data['made_in_options'] = $this->model_productenquiry->getMadeInOptions();

        if (isset($this->request->post['made_in'])) {
            $data['made_in'] = $this->request->post['made_in'];
        } elseif (!empty($productenquiry_info) && isset($productenquiry_info['made_in'])) {
            $data['made_in'] = $productenquiry_info['made_in'];
        } else {
            $data['made_in'] = '';
        }
        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif (! empty($productenquiry_info)) {
            $data['sort_order'] = $productenquiry_info['sort_order'];
        } else {
            $data['sort_order'] = '';
        }
        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (! empty($productenquiry_info)) {
            $data['status'] = $productenquiry_info['status'];
        } else {
            $data['status'] = true;
        }
        if (isset($this->request->post['icon'])) {
            $data['icon'] = $this->request->post['icon'];
        } elseif (! empty($productenquiry_info)) {
            $data['icon'] = $productenquiry_info['icon'];
        } else {
            $data['icon'] = '';
        }
        if (isset($this->request->post['publish_date'])) {
            $data['publish_date'] = $this->request->post['publish_date'];
        } elseif (! empty($productenquiry_info) && isset($productenquiry_info['publish_date'])) {
            $data['publish_date'] = $productenquiry_info['publish_date'];
        } else {
            $data['publish_date'] = '';
        }
        if (isset($this->request->post['screen_size'])) {
            $data['screen_size'] = $this->request->post['screen_size'];
        } elseif (! empty($productenquiry_info) && isset($productenquiry_info['screen_size'])) {
            $data['screen_size'] = $productenquiry_info['screen_size'];
        } else {
            $data['screen_size'] = '';
        }
        if (isset($this->request->post['sku'])) {
            $data['sku'] = $this->request->post['sku'];
        } elseif (! empty($productenquiry_info) && isset($productenquiry_info['sku'])) {
            $data['sku'] = $productenquiry_info['sku'];
        } else {
            $data['sku'] = '';
        }
        if (isset($this->request->post['video'])) {
            $data['video'] = $this->request->post['video'];
        } elseif (! empty($productenquiry_info) && isset($productenquiry_info['video'])) {
            $data['video'] = $productenquiry_info['video'];
        } else {
            $data['video'] = '';
        }
        if (isset($this->request->post['featured'])) {
            $data['featured'] = $this->request->post['featured'];
        } elseif (! empty($productenquiry_info) && isset($productenquiry_info['featured'])) {
            $data['featured'] = $productenquiry_info['featured'];
        } else {
            $data['featured'] = '';
        }
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        // exit;
        $this->data     = $data;
        $this->template = 'modules/productenquiry/form.tpl';
        $this->zones    = array(
            'header',
            'columnleft',
            'footer'
        );
        $this->response->setOutput($this->render());
    }

    public function ajaxupdateproductenquirystatus()
    {
        $json = array();
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $this->load_model('productenquiry');
            $productenquiryId = $this->request->post['productenquiry_id'];
            $status = $this->request->post['status'];
            $this->model_productenquiry->updateProductEnquiryStatus($productenquiryId, $status);
            $json['success'] = true;
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));
        }
    }

    protected function validateDelete()
    {

        if (!$this->user->hasPermission('modify', 'productenquiry')) {
            $this->error['warning'] = 'Warning: You do not have permission for modification!';
        }


        return !$this->error;
    }
}
