<?php

class ControllerMediaCenter extends Controller
{
    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->registry->set('pcUrls', 'mediacenter');
    }
    public function index()
    {
        $this->load_model('mediacenter');
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
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_home'),
            'href' => HTTP_HOST . 'home'
        ];
        $data['breadcrumbs'][] = [
            'text' => $data['banner']['title'],
            'href' => ''
        ];
        $data['mediacenters'] = array();
        $limit = 9;
        if (isset($this->request->get['page'])) {
            $page = (int)$this->request->get['page'];
        } else {
            $page = 1;
        }
        $filterData = array(
            'start' => ($page - 1) * $limit,
            'limit' => $limit
        );
        $mediacenters = $this->model_mediacenter->getMediaCenters($filterData);
        foreach ($mediacenters as $media) {
            $short_description =  strip_tags(html_entity_decode($media['short_description'], ENT_QUOTES, 'UTF-8'));
            $image = BASE_URL . "uploads/image/mediacenter/" . $media['thumbnail'];
            $data['mediacenters'][] = array(
                'media_center_id'   => $media['media_center_id'],
                'title'             => $media['title'],
                'publish_date'      => $media['publish_date'],
                'short_description' => $short_description,
                'image'             => $image,
                'href'              =>  HTTPS_HOST . "media-center/" . $media['seo_url']
            );
        }
        // echo '<pre>'; print_r($data['mediacenters']); exit;
        $data['text_read_more']   =  $this->language->get('text_read_more');
        $data['text_mediacenter']   =  $this->language->get('text_patientstories_read_more');
        $data['text_no_record']   =  $this->language->get('text_no_record');
        $data['text_button_view_all_2']   =  $this->language->get('text_button_view_all_2');
        $data['text_home_author_lable']   =  $this->language->get('text_home_author_lable');
        $data['text_all']                 =  $this->language->get('text_all');
        $data['text_learn_more']          =  $this->language->get('text_learn_more');
        $data['heading_title']   =  $this->language->get('heading_title');
        $total = $this->model_mediacenter->getTotalMediaCenters($filterData);
        $pagination = new Pagination();
        $pagination->total = $total;
        $pagination->page = $page;
        $pagination->limit = $limit;
        $pagination->url = HTTP_HOST . 'media-center' . '?page={page}';
        // echo '<pre>'; print_r($pagination->url); exit;
        $pagination->text_first = '';
        $pagination->text_last = '';
        if ($total > $limit) {
            $data['pagination'] = $pagination->render();
        } else {
            $data['pagination'] = '';
        }
        $this->template = 'food/template/news.tpl';
        $this->data = $data;
        $this->zones = array(
            'header',
            'footer'
        );
        $this->response->setOutput($this->render());
    }
       

    public function Detail()
    {
        $this->load_model('mediacenter');
        $this->load_model('home');
        $mediaId =  $this->registry->get('slug_data')['slog_id'];
        $mediaDetails = $this->model_mediacenter->getMediaDetails($mediaId);
        if (!$mediaId || !$mediaDetails['publish']) {
            $this->redirect(HTTPS_HOST.'error404');
            exit;
        }
        $data['mediaDetails'] = array();
        if ($mediaDetails) {
            $imgURL = BASE_URL . "uploads/image/mediacenter/";
            $banner = isset($mediaDetails['banner_image']) && !empty($mediaDetails['banner_image']) ? $imgURL . $mediaDetails['banner_image'] : BASE_URL . 'uploads/no_image.png';
            $short_description =  html_entity_decode($mediaDetails['short_description'], ENT_QUOTES, 'UTF-8');
            $description = str_replace('&nbsp;', ' ', html_entity_decode($mediaDetails['description'], ENT_QUOTES, 'UTF-8'));
            $data['mediaDetails'] = array(
                'banner' => $banner,
                'banner_title' => $mediaDetails['title'],
                'publish_date' => $mediaDetails['publish_date'],
                'short_description' => $short_description,
                'description' => $description
            );
        }

        $data['action'] = HTTP_HOST . $this->registry->get('slug_data')['url'];
        $cleaned_description = strip_tags(html_entity_decode($mediaDetails['description'], ENT_QUOTES, 'UTF-8'));
        $trimmed_description = substr($cleaned_description, 0, 250);
        $this->document->addFBMeta('og:image', $banner . "?" . time());
        $this->document->addFBMeta('og:image:width', '1120');
        $this->document->addFBMeta('og:image:height', '768');
        $this->document->addFBMeta('og:url', $data['action']);
        $this->document->addFBMeta('og:description', $trimmed_description);
        $this->document->addFBMeta('og:title', $mediaDetails['title']);
        $this->document->addFBMeta('og:type', 'website');
        $this->document->addFBMeta('og:site_name', 'Food');
        $this->document->addTWMeta('twitter:image', $banner . "?" . time());
        $this->document->addTWMeta('twitter:title', $mediaDetails['title']);
        $this->document->addTWMeta('twitter:description', $trimmed_description);
        $this->document->addTWMeta('twitter:card', 'summary_large_image');
        $this->document->addTWMeta('twitter:site', 'Foods');
        $data['share_links'] = array(
            'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=' . ($data['action']),
            'twitter' => 'https://twitter.com/intent/tweet?text=' . $trimmed_description . '&url=' . urlencode($data['action']),
            'linkedin' => 'https://www.linkedin.com/sharing/share-offsite/?url=' . urlencode($data['action'])

        );

        if ($mediaDetails['meta_description']) {
            $cleaned_descrition =  strip_tags(html_entity_decode($mediaDetails['meta_description'], ENT_QUOTES, 'UTF-8'));
            $metaDescription = substr($cleaned_descrition, 0, 160);
            $this->document->setDescription($metaDescription);
        } elseif ($mediaDetails['description']) {
            $cleaned_descrition =  strip_tags(html_entity_decode($mediaDetails['description'], ENT_QUOTES, 'UTF-8'));
            $metaDescription = substr($cleaned_descrition, 0, 160);
            $this->document->setDescription($metaDescription);
        }
        if ($mediaDetails['meta_keyword']) {
            $this->document->setKeywords($mediaDetails['meta_keyword']);
        } elseif ($mediaDetails['title']) {
            $this->document->setKeywords($mediaDetails['title']);
        }
        if ($mediaDetails['meta_title']) {
            $this->document->setTitle($mediaDetails['meta_title']);
        } elseif ($mediaDetails['title']) {
            $this->document->setTitle($mediaDetails['title']);
        }
        $data['breadcrumbs'] = [
            'text' => $this->language->get('text_back'),
            'href' => HTTP_HOST . "media-center"
        ];
        $data['text_btn_read_more']   =  $this->language->get('text_btn_read_more');
        $data['relatedmediacenter'] = array();
        $relatedmediacenter = $this->model_mediacenter->getRelatedMediacenter($mediaId);
        // echo '<pre>'; print_r($relatedmediacenter); exit;
        foreach ($relatedmediacenter as $mediac) {
            $image = BASE_URL . "uploads/image/mediacenter/" . $mediac['thumbnail'];
            $short_description = strip_tags(html_entity_decode($mediac['short_description'], ENT_QUOTES, 'UTF-8'));
            $data['relatedmediacenter'][] = array(
                'media_center_id'   => $mediac['media_center_id'],
                'title'             => $mediac['title'],
                'publish_date'      => $mediac['publish_date'],
                'short_description' => $short_description,
                'image'             => $image,
                'href'              =>  HTTPS_HOST . "media-center/" . $mediac['seo_url']
            );
        }
        $newsblock = $this->model_home->getHtmlBlock('mediacenter-detail-page');
        if (!empty($newsblock['content'])) {
            $newsblock['content'] = str_replace('&nbsp;', ' ', html_entity_decode($newsblock['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['newsblock'] = $newsblock;
        $data['heading_title']          =  $this->language->get('heading_title');
        $data['text_title_news']          =  $this->language->get('text_title_news');
        $data['text_learn_more']          =  $this->language->get('text_learn_more');
        $data['text_view_all']     =  $this->language->get('text_view_all');
        $data['text_read_more']     =  $this->language->get('text_read_more');
        $data['text_share']          =  $this->language->get('text_share');
        $data['text_related_news']   =  $this->language->get('text_related_news');
        $data['text_only_date']   =  $this->language->get('text_only_date');
        $data['text_only_share']   =  $this->language->get('text_only_share');

        $this->template = 'food/template/news_details.tpl';
        $this->data = $data;
        $this->zones = array(
            'header',
            'footer'
        );
        $this->response->setOutput($this->render());

    }
}
