<?php
class ControllerCountry extends Controller {
	private $error = array();

	public function index() {
		$this->document->setTitle('Countries');
		$this->load_model('country');
		$this->getList();
	}

	public function add() {
		$this->document->setTitle('Add Country');
		$this->load_model('country');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_country->addCountry($this->request->post);
			$this->session->data['success'] = 'Success: You have modified countries!';
			$this->response->redirect($this->link('country', 'token=' . $this->session->data['token'], true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->document->setTitle('Edit Country');
		$this->load_model('country');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_country->editCountry($this->request->get['country_id'], $this->request->post);
			$this->session->data['success'] = 'Success: You have modified countries!';
			$this->response->redirect($this->link('country', 'token=' . $this->session->data['token'], true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->document->setTitle('Countries');
		$this->load_model('country');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $country_id) {
				$this->model_country->deleteCountry($country_id);
			}

			$this->session->data['success'] = 'Success: You have modified countries!';
			$this->response->redirect($this->link('country', 'token=' . $this->session->data['token'], true));
		}

		$this->getList();
	}

	protected function getList() {
		$data = array();
		$data['add'] = $this->link('country/add', 'token=' . $this->session->data['token'], true);
		$data['delete'] = $this->link('country/delete', 'token=' . $this->session->data['token'], true);

		$data['countries'] = array();

		$results = $this->model_country->getCountries();

		foreach ($results as $result) {
			$data['countries'][] = array(
				'country_id' => $result['country_id'],
				'name'       => $result['name'],
				'iso_code_2' => $result['iso_code_2'],
				'iso_code_3' => $result['iso_code_3'],
				'edit'       => $this->link('country/edit', 'token=' . $this->session->data['token'] . '&country_id=' . $result['country_id'], true)
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
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}
		$data['token'] = $this->session->data['token'];
		$this->data = $data;
		$this->template = 'modules/country/list.tpl';
		$this->zones = array('header', 'columnleft', 'footer');
		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$data = array();
		$data['text_form'] = !isset($this->request->get['country_id']) ? 'Add Country' : 'Edit Country';

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (!isset($this->request->get['country_id'])) {
			$data['action'] = $this->link('country/add', 'token=' . $this->session->data['token'], true);
		} else {
			$data['action'] = $this->link('country/edit', 'token=' . $this->session->data['token'] . '&country_id=' . $this->request->get['country_id'], true);
		}

		$data['cancel'] = $this->link('country', 'token=' . $this->session->data['token'], true);

		if (isset($this->request->get['country_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$country_info = $this->model_country->getCountry($this->request->get['country_id']);
		}

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($country_info)) {
			$data['name'] = $country_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['iso_code_2'])) {
			$data['iso_code_2'] = $this->request->post['iso_code_2'];
		} elseif (!empty($country_info)) {
			$data['iso_code_2'] = $country_info['iso_code_2'];
		} else {
			$data['iso_code_2'] = '';
		}

		if (isset($this->request->post['iso_code_3'])) {
			$data['iso_code_3'] = $this->request->post['iso_code_3'];
		} elseif (!empty($country_info)) {
			$data['iso_code_3'] = $country_info['iso_code_3'];
		} else {
			$data['iso_code_3'] = '';
		}

		if (isset($this->request->post['address_format'])) {
			$data['address_format'] = $this->request->post['address_format'];
		} elseif (!empty($country_info)) {
			$data['address_format'] = $country_info['address_format'];
		} else {
			$data['address_format'] = '';
		}

		if (isset($this->request->post['postcode_required'])) {
			$data['postcode_required'] = $this->request->post['postcode_required'];
		} elseif (!empty($country_info)) {
			$data['postcode_required'] = $country_info['postcode_required'];
		} else {
			$data['postcode_required'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($country_info)) {
			$data['status'] = $country_info['status'];
		} else {
			$data['status'] = '1';
		}
		$data['token'] = $this->session->data['token'];

		$this->data = $data;
		$this->template = 'modules/country/form.tpl';
		$this->zones = array('header', 'columnleft', 'footer');
		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'country')) {
			$this->error['warning'] = 'Warning: You do not have permission to modify countries!';
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 128)) {
			$this->error['name'] = 'Country Name must be between 3 and 128 characters!';
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'country')) {
			$this->error['warning'] = 'Warning: You do not have permission to modify countries!';
		}
		
		return !$this->error;
	}
} 