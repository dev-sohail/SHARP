<?php
class Controllercategories extends Controller
{
    private $error = array();
    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->registry->set('pcUrls', 'categories');
    }
    public function index()
    {
        $this->load_model('categories');
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
        $data['categories'] = array();
        $categories = $this->model_categories->getCategories();
        foreach ($categories as $category) {
            $data['categories'][] = [
                'category_id' => $category['category_id'],
                'title' => $category['title'],
                'description' => $category['meta_description'] ?? '',
                'image' => $category['image'],
                'link' => $category['seo_url'],
                'status' => $category['status'],
                'href' => HTTP_HOST . 'categories/' . $category['seo_url']

            ];
        }
        // echo '<pre>';
        // print_r($data['categories']);exit;

        $data['heading_title'] =  $this->language->get('heading_title');
        $this->template = 'food\template\categories.tpl';
        $this->data = $data;
        $this->zones = array(
            'header',
            'footer'
        );
        $this->response->setOutput($this->render());
    }
    public function categoriesdetail()
    {
        $this->load_model('categories');
        $this->load_model('home');
        $categoriesId =  $this->registry->get('slug_data')['slog_id'];
        $CategoriesDetails = $this->model_categories->getCategoriesDetails($categoriesId);
        // echo '<pre>'; print_r($CategoriesDetails); exit;
        if (!$CategoriesDetails || !$CategoriesDetails['status']) {
            $this->redirect(HTTPS_HOST . 'error404');
            exit;
        }
        $data['CategoriesDetails'] = array();
        if ($CategoriesDetails) {
            $imgURL = BASE_URL . "uploads/image/categories/";
            $banner = isset($CategoriesDetails['image']) && !empty($CategoriesDetails['image']) ? $imgURL . $CategoriesDetails['image'] : BASE_URL . 'uploads/no_image.png';
            $thumbnail = isset($CategoriesDetails['thumbnail']) && !empty($CategoriesDetails['thumbnail']) ? $imgURL . $CategoriesDetails['thumbnail'] : BASE_URL . 'uploads/no_image.png';
            $icon = isset($CategoriesDetails['icon']) && !empty($CategoriesDetails['icon']) ? $imgURL . $CategoriesDetails['icon'] : BASE_URL . 'uploads/no_image.png';
            $full_description = str_replace('&nbsp;', ' ', html_entity_decode($CategoriesDetails['full_description'], ENT_QUOTES, 'UTF-8'));
            $data['CategoriesDetails'] = array(
                'category_id' => $CategoriesDetails['category_id'],
                'category_name'   => $CategoriesDetails['name'],
                'full_description' => $full_description,
                'thumbnail'    => $thumbnail,
                'category_image'  => $banner,
                'icon'         => $icon,
            );
        }

        if ($CategoriesDetails['meta_description']) {
            $cleaned_descrition =  strip_tags(html_entity_decode($CategoriesDetails['meta_description'], ENT_QUOTES, 'UTF-8'));
            $metaDescription = substr($cleaned_descrition, 0, 160);
            $this->document->setDescription($metaDescription);
        } elseif ($CategoriesDetails['description']) {
            $cleaned_descrition =  strip_tags(html_entity_decode($CategoriesDetails['description'], ENT_QUOTES, 'UTF-8'));
            $metaDescription = substr($cleaned_descrition, 0, 160);
            $this->document->setDescription($metaDescription);
        }
        if ($CategoriesDetails['meta_keyword']) {
            $this->document->setKeywords($CategoriesDetails['meta_keyword']);
        } elseif ($CategoriesDetails['title']) {
            $this->document->setKeywords($CategoriesDetails['title']);
        }
        if ($CategoriesDetails['meta_title']) {
            $this->document->setTitle($CategoriesDetails['meta_title']);
        } elseif ($CategoriesDetails['title']) {
            $this->document->setTitle($CategoriesDetails['title']);
        }



        $morecategories = $this->model_categories->getRelatedcategories();
        $data['morecategories'] = $morecategories;

        // $categorymenublock = $this->model_home->getHtmlBlock('category-menu-block');
        // if (!empty($categorymenublock['content'])) {
        //     $categorymenublock['content'] = str_replace('&nbsp;', ' ', html_entity_decode($categorymenublock['content'], ENT_QUOTES, 'UTF-8'));
        // }
        // $data['categorymenublock'] = $categorymenublock;

        // $relatedcategoryblock = $this->model_home->getHtmlBlock('related-category-block');
        // if (!empty($relatedcategoryblock['content'])) {
        //     $relatedcategoryblock['content'] = str_replace('&nbsp;', ' ', html_entity_decode($relatedcategoryblock['content'], ENT_QUOTES, 'UTF-8'));
        // }
        // $data['relatedcategoryblock'] = $relatedcategoryblock;
        // $data['text_follow_on'] = $this->language->get('text_follow_on');
        // $data['text_our_categories'] = $this->language->get('text_our_categories');
        $data['heading_title'] = $this->language->get('heading_title');
        // $data['text_opening_hours'] = $this->language->get('text_opening_hours');
        // $data['text_contact_details'] = $this->language->get('text_contact_details');
        // $data['text_coasterra'] = $this->language->get('text_coasterra');
        // $data['text_only_view'] = $this->language->get('text_only_view');
        $this->template = 'food/template/categories.tpl';
        $this->data = $data;
        $this->zones = array(
            'header',
            'footer'
        );
        $this->response->setOutput($this->render());
    }
    public function subsubcategoriesdetail()
    {
        $this->load_model('subcategories');
        $this->load_model('home');
        $subcategoriesId =  $this->registry->get('slug_data')['slog_id'];
        $SubCategoriesDetails = $this->model_subcategories->getSubCategoriesDetails($subcategoriesId);
        if (!$SubCategoriesDetails || !$SubCategoriesDetails['status']) {
            $this->redirect(HTTPS_HOST . 'error404');
            exit;
        }
        $data['SubCategoriesDetails'] = array();
        if ($SubCategoriesDetails) {
            $imgURL = BASE_URL . "uploads/image/subcategories/";
            $banner = isset($SubCategoriesDetails['image']) && !empty($SubCategoriesDetails['image']) ? $imgURL . $SubCategoriesDetails['image'] : BASE_URL . 'uploads/no_image.png';
            $thumbnail = isset($SubCategoriesDetails['thumbnail']) && !empty($SubCategoriesDetails['thumbnail']) ? $imgURL . $SubCategoriesDetails['thumbnail'] : BASE_URL . 'uploads/no_image.png';
            $icon = isset($SubCategoriesDetails['icon']) && !empty($SubCategoriesDetails['icon']) ? $imgURL . $SubCategoriesDetails['icon'] : BASE_URL . 'uploads/no_image.png';
            $full_description = str_replace('&nbsp;', ' ', html_entity_decode($SubCategoriesDetails['full_description'], ENT_QUOTES, 'UTF-8'));
            $data['SubCategoriesDetails'] = array(
                'subcategory_id' => $SubCategoriesDetails['subcategory_id'],
                'subcategory_name'   => $SubCategoriesDetails['name'],
                'full_description' => $full_description,
                'thumbnail'    => $thumbnail,
                'subcategory_image'  => $banner,
                'icon'         => $icon,
            );
        }
        if ($SubCategoriesDetails['meta_description']) {
            $cleaned_descrition =  strip_tags(html_entity_decode($SubCategoriesDetails['meta_description'], ENT_QUOTES, 'UTF-8'));
            $metaDescription = substr($cleaned_descrition, 0, 160);
            $this->document->setDescription($metaDescription);
        } elseif ($SubCategoriesDetails['description']) {
            $cleaned_descrition =  strip_tags(html_entity_decode($SubCategoriesDetails['description'], ENT_QUOTES, 'UTF-8'));
            $metaDescription = substr($cleaned_descrition, 0, 160);
            $this->document->setDescription($metaDescription);
        }
        if ($SubCategoriesDetails['meta_keyword']) {
            $this->document->setKeywords($SubCategoriesDetails['meta_keyword']);
        } elseif ($SubCategoriesDetails['title']) {
            $this->document->setKeywords($SubCategoriesDetails['title']);
        }
        if ($SubCategoriesDetails['meta_title']) {
            $this->document->setTitle($SubCategoriesDetails['meta_title']);
        } elseif ($SubCategoriesDetails['title']) {
            $this->document->setTitle($SubCategoriesDetails['title']);
        }
        $data['heading_title'] = $this->language->get('heading_title');
        $this->template = 'food/template/subsubcategories.tpl';
        $this->data = $data;
        $this->zones = array(
            'header',
            'footer'
        );
        $this->response->setOutput($this->render());
    }
}
