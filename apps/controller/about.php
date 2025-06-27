<?php


class ControllerAbout extends Controller
{
    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->registry->set('pcUrls', 'about-us');
    }
    public function index()
    {
        $data = array();
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

        $messageblock = $this->model_home->getHtmlBlock('message-block');
        if (!empty($messageblock['content'])) {
            $messageblock['content'] = str_replace('&nbsp;', ' ', html_entity_decode($messageblock['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['messageblock'] = $messageblock;

        $barbarablock = $this->model_home->getHtmlBlock('barbara-block');
        if (!empty($barbarablock['content'])) {
            $barbarablock['content'] = str_replace('&nbsp;', ' ', html_entity_decode($barbarablock['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['barbarablock'] = $barbarablock;

        $awardsblock = $this->model_home->getHtmlBlock('awards-block');
        if (!empty($awardsblock['content'])) {
            $awardsblock['content'] = str_replace('&nbsp;', ' ', html_entity_decode($awardsblock['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['awardsblock'] = $awardsblock;

        $blockhistory = $this->model_home->getHtmlBlock('block-history');
        if (!empty($blockhistory['content'])) {
            $blockhistory['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockhistory['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockhistory'] = $blockhistory;

        $blockalothaim = $this->model_home->getHtmlBlock('block-al-othaim-group');
        if (!empty($blockalothaim['content'])) {
            $blockalothaim['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockalothaim['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockalothaim'] = $blockalothaim;

        $blockourteam = $this->model_home->getHtmlBlock('block-our-team');
        if (!empty($blockourteam['content'])) {
            $blockourteam['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockourteam['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockourteam'] = $blockourteam;


        $blockwhyus = $this->model_home->getHtmlBlock('about-block-why-us');
        if (!empty($blockwhyus['content'])) {
            $blockwhyus['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockwhyus['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockwhyus'] = $blockwhyus;


        $blockwhyussecond = $this->model_home->getHtmlBlock('why-us-second');
        if (!empty($blockwhyussecond['content'])) {
            $blockwhyussecond['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockwhyussecond['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockwhyussecond'] = $blockwhyussecond;

        $blockquistestfirst = $this->model_home->getHtmlBlock('quis-test-first');
        if (!empty($blockquistestfirst['content'])) {
            $blockquistestfirst['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockquistestfirst['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockquistestfirst'] = $blockquistestfirst;

        $blockquistestsecond = $this->model_home->getHtmlBlock('quis-test-second');
        if (!empty($blockquistestsecond['content'])) {
            $blockquistestsecond['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockquistestsecond['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockquistestsecond'] = $blockquistestsecond;

        $blockquistestthird = $this->model_home->getHtmlBlock('quis-test-third');
        if (!empty($blockquistestthird['content'])) {
            $blockquistestthird['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockquistestthird['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockquistestthird'] = $blockquistestthird;

        $blockvisionvalues = $this->model_home->getHtmlBlock('block-vision-values');
        if (!empty($blockvisionvalues['content'])) {
            $blockvisionvalues['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockvisionvalues['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockvisionvalues'] = $blockvisionvalues;

        $blocknisiut = $this->model_home->getHtmlBlock('block-nisi-ut');
        if (!empty($blocknisiut['content'])) {
            $blocknisiut['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blocknisiut['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blocknisiut'] = $blocknisiut;

        $blocknisiutsecond = $this->model_home->getHtmlBlock('block-nisi-ut-second');
        if (!empty($blocknisiutsecond['content'])) {
            $blocknisiutsecond['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blocknisiutsecond['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blocknisiutsecond'] = $blocknisiutsecond;

        $blockvisionvaluesright = $this->model_home->getHtmlBlock('block-vision-values-right');
        if (!empty($blockvisionvaluesright['content'])) {
            $blockvisionvaluesright['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockvisionvaluesright['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockvisionvaluesright'] = $blockvisionvaluesright;


        $AboutTopImage = $this->model_home->getHtmlBlockImages('about-top-image');
        $data['AboutTopImage'] = $AboutTopImage;
        
        $AboutWhyUs = $this->model_home->getHtmlBlockImages('about-why-us-image');
        $data['AboutWhyUs'] = $AboutWhyUs;
        
        $AboutVision = $this->model_home->getHtmlBlockImages('about-vision-and-values-image');
        $data['AboutVision'] = $AboutVision;

        $AboutalothaimGroupImage = $this->model_home->getHtmlBlockImages('about-al-othaim-group-image');
        $data['AboutalothaimGroupImage'] = $AboutalothaimGroupImage;
        
        $AboutHistoryImage = $this->model_home->getHtmlBlockImages('about-history-image');
        $data['AboutHistoryImage'] = $AboutHistoryImage;

        $awards = $this->model_home->getAwards();
        $data['awards'] = $awards;

        $OverHistory = $this->model_home->getOverHistory();
        $data['OverHistory'] = $OverHistory;

        $OverTeam = $this->model_home->getOverTeam();
        $data['OverTeam'] = $OverTeam;

        $data['heading_title'] = $this->language->get('heading_title');
        $this->template = 'food/template/about.tpl';
        $this->data = $data;
        $this->zones = array(
            'header',
            'footer'
        );
        $this->response->setOutput($this->render());
    }
}
