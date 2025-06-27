<?php

class ControllerHome extends Controller
{

	private $error = array();
	public function __construct($registry)
	{
		parent::__construct($registry);
		$this->registry->set('pcUrls', 'home');
	}
	public function index()
	{
        echo 'Coming Soon'; exit;

		$slugData =  $this->registry->get('slug_data');
		$this->load_model('home');
        // $this->load_model('contact');
        // $data['action'] = HTTP_HOST;
		$homeSlider = $this->model_home->getHomeSlider();
		$data['homeSlider'] = $homeSlider;
        $mediaCenter = $this->model_home->getHomeMediaCenter();
		 $data['mediaCenter'] = $mediaCenter;
		$brandLocations = $this->model_home->getlocations();
		$data['brandLocations'] = $brandLocations;
        // echo '<pre>'; print_r($data['brandLocations']); exit;
        $aboutblock = $this->model_home->getHtmlBlock('home-about-us');
        if (!empty($aboutblock['content'])) {
            $aboutblock['content'] = str_replace('&nbsp;', ' ', html_entity_decode($aboutblock['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['aboutblock'] = $aboutblock;
        $blockfactstats = $this->model_home->getHtmlBlock('facts-and-Stats');
        if (!empty($blockfactstats['content'])) {
            $blockfactstats['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockfactstats['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockfactstats'] = $blockfactstats;

        $block800 = $this->model_home->getHtmlBlock('800+');
        if (!empty($block800['content'])) {
            $block800['content'] = str_replace('&nbsp;', ' ', html_entity_decode($block800['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['block800'] = $block800;

        $block600 = $this->model_home->getHtmlBlock('60+');
        if (!empty($block600['content'])) {
            $block600['content'] = str_replace('&nbsp;', ' ', html_entity_decode($block600['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['block600'] = $block600;

        $block10 = $this->model_home->getHtmlBlock('10+');
        if (!empty($block10['content'])) {
            $block10['content'] = str_replace('&nbsp;', ' ', html_entity_decode($block10['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['block10'] = $block10;

        $block80 = $this->model_home->getHtmlBlock('80+');
        if (!empty($block80['content'])) {
            $block80['content'] = str_replace('&nbsp;', ' ', html_entity_decode($block80['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['block80'] = $block80;

        $blocknews = $this->model_home->getHtmlBlock('block-news');
        if (!empty($blocknews['content'])) {
            $blocknews['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blocknews['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blocknews'] = $blocknews;

        $blockfollowus = $this->model_home->getHtmlBlock('follow-us-on');
        if (!empty($blockfollowus['content'])) {
            $blockfollowus['content'] = str_replace('&nbsp;', ' ', html_entity_decode($blockfollowus['content'], ENT_QUOTES, 'UTF-8'));
        }
        $data['blockfollowus'] = $blockfollowus;
        $BlockLeftImage = $this->model_home->getHtmlBlockImages('home-left-image');
        $data['BlockLeftImage'] = $BlockLeftImage;
        $BlockRightImage = $this->model_home->getHtmlBlockImages('home-right-image');
        $data['BlockRightImage'] = $BlockRightImage;
        $BlockMiddleImage = $this->model_home->getHtmlBlockImages('home-middle-image');
        $data['BlockMiddleImage'] = $BlockMiddleImage;
		$data['text_learn_more'] = $this->language->get('text_learn_more');
		$data['text_read'] = $this->language->get('text_read');
		$data['text_view_all'] = $this->language->get('text_view_all');
		$data['text_in_theaters'] = $this->language->get('text_in_theaters');
		$data['learn_more'] = $this->language->get('learn_more');
		$data['facebook'] = $this->config->get('config_facebook');
		$data['twitter'] = $this->config->get('config_twitter');
		$data['instagram'] = $this->config->get('config_instagram');
		$data['youtube'] = $this->config->get('config_youtube');
		$data['google_map_key'] = $this->config->get('config_google_map_api_key');
        $data['config_instagram_url'] = $this->config->get('config_instagram_url');
        $data['config_instagram_handler_name'] = $this->config->get('config_instagram_handler_name');
		if ($this->config->get('config_meta_description' . $this->config->get('config_language_id'))) {
			$cleaned_descrition =  strip_tags(html_entity_decode($this->config->get('config_meta_description' . $this->config->get('config_language_id')), ENT_QUOTES, 'UTF-8'));
			$metaDescription = substr($cleaned_descrition, 0, 160);
			$this->document->setDescription($metaDescription);
		}
		if ($this->config->get('config_meta_keyword' . $this->config->get('config_language_id'))) {
			$this->document->setKeywords($this->config->get('config_meta_keyword' . $this->config->get('config_language_id')));
		}
		if ($this->config->get('config_meta_title' . $this->config->get('config_language_id'))) {
            
			$this->document->setTitle($this->config->get('config_meta_title') . $this->config->get('config_language_id'));
		}
		$data['lang'] = $this->session->data['lang'];
        $data['config_map'] = $this->config->get('config_map');

        $data['instagram_feeds'] = array();
        if ($this->config->get('config_instagram_token')) {
            $url = "https://graph.instagram.com/me/media?fields=id,username,permalink,media_url,thumbnail_url,media_type&limit=7&access_token=" . $this->config->get('config_instagram_token');
            $response = $this->request($url);
            if (isset($response['data']) && !empty($response['data'])) {
                foreach ($response['data'] as $item) {
                    if (in_array($item['media_type'], ['IMAGE', 'VIDEO']) && !empty($item['media_url'])) {
                        $is_video = $item['media_type'] == 'VIDEO' ? true : false;
                        $data['instagram_feeds'][] = array(
                            'id' => $item['id'],
                            'username' => $item['username'] ?? '',
                            'permalink' => $item['permalink'] ?? '',
                            'media_url' => $item['media_url'],
                            'thumbnail_url' => !empty($item['thumbnail_url']) ? $item['thumbnail_url'] : $item['media_url'],
                            'media_type' => $item['media_type'],
                            'is_video' => $is_video,
                        );
                    }
                }
            } else {
                $data['instagram_feeds'] = array();
            }
        }
        $data['text_about'] = $this->language->get('text_about');
        $data['text_our_brands'] = $this->language->get('text_our_brands');
        $data['text_locations'] = $this->language->get('text_locations');
		$this->template = 'food/template/common/home.tpl';
		$this->data = $data;
		$this->zones = array(
			'header',
			'footer'
		);
		$this->response->setOutput($this->render());
	}

    public function getLocationData()
    {
        $json = array();
        $this->load_model('home');
        $id = isset($this->request->get['id']) ? (int)$this->request->get['id'] : 0;
    
        if ($id) {
            $brand = $this->model_home->getLocationById($id);
            if ($brand) {
                $json['brand'] = $brand;
            } else {
                $json['error'] = "Brand not found.";
            }
        } else {
            $json['error'] = "Invalid brand ID.";
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    private function request($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $request = curl_exec($curl);
        curl_close($curl);
        $request = json_decode($request, true);
        return $request;
    }
     
}
