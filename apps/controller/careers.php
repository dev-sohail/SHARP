<?php
class ControllerCareers extends Controller
{
    private $error = array();
    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->registry->set('pcUrls', 'careers');
    }
    public function index()
    {

        $this->load_model('careers');
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
            $image = BASE_URL . "uploads/default_banner.jpg";
        }
        $data['banner'] = array(
            'title'              => $page['name'],
            'short_description' => $short_description,
            'image'             => $image
        );

        $blockexcitingopportunities = $this->model_home->getHtmlBlock('block-exciting-opportunities');
        if (!empty($blockexcitingopportunities['content'])) {
            $blockexcitingopportunities['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockexcitingopportunities['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockexcitingopportunities'] = $blockexcitingopportunities;
    
        $data['text_recusandae'] =  $this->language->get('text_recusandae');
        $data['text_check_vacancies'] =  $this->language->get('text_check_vacancies');
        $data['heading_title'] =  $this->language->get('heading_title');
        $this->template = 'food/template/careers.tpl';
        $this->data = $data;
        $this->zones = array(
            'header',
            'footer'
        );
        $this->response->setOutput($this->render());
    }
   
}
