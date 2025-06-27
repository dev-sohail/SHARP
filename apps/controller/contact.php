<?php

class ControllerContact extends Controller
{
	private $error = array();
	public function __construct($registry)
	{
		parent::__construct($registry);
		$this->registry->set('pcUrls', 'contact-us');
	}
	public function index()
	{
		$data = array();
        $data['action'] = HTTPS_HOST . $this->registry->get('pcUrls'); 
		$this->load_model('contact');
		$this->load_model('home');
		$this->load_model('page');
		$page_id =  $this->registry->get('slug_data')['slog_id'];
		$page = $this->model_page->getPage($page_id);
        if (empty($page)) {
            $this->redirect(HTTPS_HOST . 'error404');
            exit;
        }
		$short_description =  strip_tags(html_entity_decode($page['short_description'], ENT_QUOTES, 'UTF-8'));
		if ($page['banner_image']) {
			$image = BASE_URL . "uploads/image/pages/" . $page['banner_image'];
		} else {
			$image =  BASE_URL . "uploads/default_banner.jpg";
		}
		$data['banner'] = array(
			'title'              => $page['name'],
			'short_description' => $short_description,
			'image'             => $image
		);
		if ($page['meta_description']) {
			$cleaned_descrition =  strip_tags(html_entity_decode($page['meta_description'], ENT_QUOTES, 'UTF-8'));
			$metaDescription = substr($cleaned_descrition, 0, 160);
			$this->document->setDescription($metaDescription);
		} elseif ($page['short_description']) {
			$cleaned_descrition =  strip_tags(html_entity_decode($page['short_description'], ENT_QUOTES, 'UTF-8'));
			$metaDescription = substr($cleaned_descrition, 0, 160);
			$this->document->setDescription($metaDescription);
		}
		if ($page['meta_keyword']) {
			$this->document->setKeywords($page['meta_keyword']);
		} elseif ($page['title']) {
			$this->document->setKeywords($page['title']);
		}
		if ($page['meta_title']) {
			$this->document->setTitle($page['meta_title']);
		} elseif ($page['title']) {
			$this->document->setTitle($page['title']);
		}
		// Form data
		$data['first_name'] = $this->request->post['first_name'] ?? '';
		$data['last_name'] = $this->request->post['last_name'] ?? '';
		$data['phone'] = $this->request->post['phone'] ?? '';
		$data['email'] = $this->request->post['email'] ?? '';
		$data['message'] = $this->request->post['message'] ?? '';

		if (isset($this->session->data['success'])) {
				$data['success'] = $this->session->data['success'];
				unset($this->session->data['success']);
			}
		$data['public_key'] = $this->config->get('config_google_captcha_public');
		$bgetIntouch = $this->model_home->getHtmlBlock('get-in-touch');
        if (!empty($bgetIntouch['content'])) {
            $bgetIntouch['content'] = str_replace('&nbsp;', ' ', html_entity_decode($bgetIntouch['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['bgetIntouch'] = $bgetIntouch;
		$data['config_address_location'] = $this->config->get('config_address_location');
		$data['config_telephone'] = $this->config->get('config_telephone');
		$data['config_email'] = $this->config->get('config_email');
		$data['config_facebook'] = $this->config->get('config_facebook');
		$data['config_youtube'] = $this->config->get('config_youtube');
		$data['config_instagram'] = $this->config->get('config_instagram');
		$data['config_twitter'] = $this->config->get('config_twitter');
		// $data['config_map'] = $this->config->get('config_map');
		$data['config_address'] = $this->config->get('config_address' . $this->config->get('config_language_id'));
		$data['text_view_on_map'] = $this->language->get('text_view_on_map');
		$data['text_view_website_contact'] = $this->language->get('text_view_website_contact');
		$data['text_corporate_office'] = $this->language->get('text_corporate_office');
		$data['text_call'] = $this->language->get('text_call');
		$data['text_email'] = $this->language->get('text_email');
		$data['text_follow'] = $this->language->get('text_follow');
		$data['text_address'] = $this->language->get('text_address');
		$data['text_btn_submit'] = $this->language->get('text_btn_submit');
		$data['text_full_name'] = $this->language->get('text_full_name');
		$data['text_c_email'] = $this->language->get('text_c_email');
		$data['text_subject'] = $this->language->get('text_subject');
		$data['text_message'] = $this->language->get('text_message');
        $data['err_first_name'] = $this->language->get('err_first_name');
        $data['err_last_name'] = $this->language->get('err_last_name');
        $data['err_email'] = $this->language->get('err_email');
        $data['err_invalid_email'] = $this->language->get('err_invalid_email');
        $data['err_message'] = $this->language->get('err_message');
        $data['err_phone'] = $this->language->get('err_phone');
        $data['err_invalid_phone'] = $this->language->get('err_invalid_phone');
        $data['heading_title'] = $this->language->get('heading_title');
		$data['text_first_name'] = $this->language->get('text_first_name');
		$data['text_last_name'] = $this->language->get('text_last_name');
		$data['entry_phone_contact'] = $this->language->get('entry_phone_contact');
		$data['entry_email_address'] = $this->language->get('entry_email_address');
		$data['entry_message'] = $this->language->get('entry_message');
		$data['entry_leave_a'] = $this->language->get('entry_leave_a');
		$data['entry_follow_us'] = $this->language->get('entry_follow_us');
		$data['mapimage'] = BASE_URL . "uploads/image/setting/" . $this->config->get('config_mapimage');
		$this->template = 'food/template/contact.tpl';
		$this->data = $data;
		$this->zones = ['header', 'footer'];
		$this->response->setOutput($this->render());
	}

	public function contactUsForm() {

		$this->load_model('contact');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (!$this->validateForm()) {
				$json = array('error' => $this->error);
				$this->response->setOutput(json_encode($json));
				return;
			}
		$query = $this->model_contact->addContact($this->request->post);
		$toEmail = $this->config->get('config_email');
		$message = $this->request->post['message'];
		if ($this->config->get('config_language_id') != 1) {
			$subject = 'طلب استفسار من ' . $this->request->post['first_name'] . ' ' . $this->request->post['last_name'];
			$subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
		} else {
			$subject = 'Enquiry from ' . $this->request->post['first_name'] . ' ' . $this->request->post['last_name'];
		}
		$emaildata = [
			'first_name' => $this->request->post['first_name'],
			'last_name' => $this->request->post['last_name'],
			'email' => $this->request->post['email'],
			'phone' => $this->request->post['phone'],
			'message' => $this->request->post['message'],
			'enquiry_from' => $this->request->post['enquiry_from']
		];
		$data = ['message' => $message, 'emailData' => $emaildata];
		// // Mail sending logic
		$mail = new Mail();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "ssl";
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->hostname = $this->config->get('config_mail_smtp_hostname');
		$mail->username = $this->config->get('config_mail_smtp_username');
		$mail->password = $this->config->get('config_mail_smtp_password');
		$mail->port = $this->config->get('config_mail_smtp_port');
		$mail->setTo($toEmail);
		$mail->setFrom($toEmail);
		$mail->setReplyTo($toEmail);
		$mail->setSender('Food');
		$mail->setSubject($subject);
		if ($this->config->get('config_language_id') != 1) {
			$this->template = 'food/template/mail/admin-notification-ar.tpl';
			// $this->template = 'food/template/mail/admin-notification.tpl';
		} else {
			// $this->template = 'food/template/mail/admin-notification-ar.tpl';
			$this->template = 'food/template/mail/admin-notification.tpl';
		}
		$this->data = $data;
		$mail->setHtml($this->render());
		$mail->send();
        $json['success'] = $this->language->get('text_new_success_message');   
        $this->response->setOutput(json_encode($json));
        return;
	  }
	}
	protected function validateForm()
   {
    $err_first_name = $this->language->get('err_first_name');
    $err_last_name = $this->language->get('err_last_name');
    $err_phone = $this->language->get('err_phone');
    $err_invalid_phone = $this->language->get('err_invalid_phone');
    $err_email = $this->language->get('err_email');
    $err_invalid_email = $this->language->get('err_invalid_email');
    $err_message = $this->language->get('err_message');
    $err_captcha = $this->language->get('err_captcha');

    if ((utf8_strlen($this->request->post['first_name']) < 1)) {
        $this->error['first_name'] = $err_first_name;

    }
    if ((utf8_strlen($this->request->post['last_name']) < 1)) {
        $this->error['last_name'] = $err_last_name;
    }
    
    if ((utf8_strlen(trim($this->request->post['email'])) < 1)) {
        $this->error['email'] = $err_email;
    } elseif (!filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
        $this->error['email'] = $err_invalid_email;
    }

    if ((utf8_strlen($this->request->post['message']) < 1)) {
        $this->error['message'] = $err_message;
    }

    if ((utf8_strlen(trim($this->request->post['phone'])) < 1)) {
        $this->error['phone'] = $err_phone;
    } elseif (!preg_match('/^\+?[0-9]{7,15}$/', $this->request->post['phone'])) {
        $this->error['phone'] = $err_invalid_phone;
    }
    // Google reCAPTCHA validation
    $recaptchaToken = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';
    // $recaptchaSecret = $this->config->get('config_google_captcha_secret');
    // $recaptchaUrl = "https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecret&response=$recaptchaToken";
    // $recaptchaResponse = file_get_contents($recaptchaUrl);
    // $recaptchaData = json_decode($recaptchaResponse);
    // if (!$recaptchaData->success && $recaptchaData->score < 0.5) {
    //     $this->error['captchaError'] = $err_captcha;
    // }
    return !$this->error;
 }

}
