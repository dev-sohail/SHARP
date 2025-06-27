<?php
final class router
{
    private $registry;
    private $db;
    private $config;
    private $path;
    private $requri;
    private $args = array();
    public $file;
    public $controller;
    public $action;
    public $c_p_index = 1;
    public $slog_data = array();

    function __construct($registry)
    {
        $this->registry = $registry;
        $this->db = $registry->get('db');
        $this->config = $registry->get('config');
    }

    public function run()
    {
        $this->getController();

        if (is_readable($this->file) == false) {

            $this->file = DIR_APP . '/controller/error404.php';
            $this->controller = 'error404';
        }

        require_once($this->file);

        //Change were made to remove within contollername special character
        $this->controller = str_replace(array('-', '_', '&'), '', $this->controller);
        //Change were made to remove within contollername special character

        $class = 'Controller' . $this->controller;

        $controller = new $class($this->registry);

        if (is_callable(array($controller, $this->action)) == false) {
            $action = 'index';
        } else {
            $action = $this->action;
        }
        $controller->$action();
        /*** run the action ***/
    }
    private function getController()
    {
        $uris = array();
        $croute = "";
        $this->c_p_index = 1;
        $fullurl = explode('/', substr($_SERVER['REQUEST_URI'], 1), 2);
        $lang_short =  str_replace("-", " ", $fullurl[0]);

        if ($lang_short == 'ar') {
            $this->requri = str_replace(['ar/'], '', $_SERVER['REQUEST_URI']);
        } elseif ($lang_short == 'en') {
            $this->requri = str_replace('en/', '', $_SERVER['REQUEST_URI']);
        } else {
            $this->requri = $_SERVER['REQUEST_URI'];
        }

        $this->requri = preg_replace('/\?.*/', '', $this->requri); //remove all query string from the uri
        $croute = ltrim(rtrim($this->requri, "/"), "/");
        $curis = $croute ? @explode("/", $croute) : array();  // pagination setting
        if (count($curis) > 0) {
            foreach ($curis as $ks => $vl) {
                if ($vl == 'page') {
                    $tmpcp = ((isset($curis[$ks + 1]) && $curis[$ks + 1] != "") ? $curis[$ks + 1] : '');
                    $croute = str_replace('/page/' . $tmpcp, '', $croute);
                    $this->c_p_index = $tmpcp;
                }
            }
        }


        $this->registry->set('pcUrls', $croute); //save the refine path 
        $route = $this->getSEOurl($croute);
        // print_r($route); exit;
        $this->registry->set('bodyclass', $route);
        /*if($route=="") { // as its not seo url so check the files based and controller based scenario
            $route=$croute;
        } */


        $route = ($route == 'admin') ? '' :  $route;
        $parts = explode('/', $route);
        $this->controller = (isset($parts[0]) && $parts[0] != "") ? $parts[0] : 'home';
        $this->action = isset($parts[1]) ? str_replace('-', '_', $parts[1]) : 'index';
        $this->registry->set('c_p_index', $this->c_p_index);
        /*** set the file path ***/
        // print_r($this->controller); exit;
        $this->file = DIR_APP . 'controller/' . $this->controller . '.php';

    }

    public function getSEOurl($alias = "")
    {
        if ($alias == 'admin') {
            $cont = '';
            if (isset($_GET['controller']) && $_GET['controller'] != '') {
                $cont = $_GET['controller'];
            }
            return $cont;
        }
        if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')) {
            if ($alias != "") {
                $banners = $this->getAllBanners();
                if ($banners[$alias]) {
                    $this->registry->set('banners', $banners[$alias]);
                }
                // For Latest Slugs changes
                $slgs = '';
                $parts = explode('/', $alias);
                foreach ($parts as $part) {
                    $query = $this->db->query("SELECT slog_id,url,slog FROM aliases WHERE url = '" . $this->db->escape($part) . "' limit 1");
                    if ($query->num_rows > 0) {
                        $hash = '';
                        if (empty($slgs)) {
                            $hash = '/';
                        }
                        $slgs = $query->row['slog'] . $hash; //like category,product,news, cms, listing, services etc
                        $this->registry->set('slug_data', $query->row); // set the whole query available so to extract the item details
                    }
                }
                if (!empty($slgs)) {
                    return $slgs;
                } else {
                    $curis = $alias ? @explode("/", $alias) : array();  // pagination setting
                    if (count($curis) > 0) {
                        $slgs = $curis[0];
                        $routeis = array(
                            'slug' => $curis[0],
                            'query' => $curis[1]
                        );
                        $this->registry->set('slug_data', $routeis);
                        //return $slgs;
                    }
    
                    return $alias;
                }
                // if(empty($slgs)) {
    
    
                // $query = $this->db->query("SELECT slog_id,url,slog FROM aliases WHERE url = '" . $this->db->escape($alias) . "' limit 1");
                // if ($query->num_rows > 0) {
                //     $slgs = $query->row['slog']; //like category,product,news, cms, listing, services etc
                //     $this->registry->set('slug_data', $query->row); // set the whole query available so to extract the item details
                //     return $slgs;
                // } else {
                //     $curis = $alias ? @explode("/", $alias) : array();  // pagination setting
                //     if (count($curis) > 0) {
                //         $slgs = $curis[0];
                //         $routeis = array(
                //             'slug' => $curis[0],
                //             'query' => $curis[1]
                //         );
                //         $this->registry->set('slug_data', $routeis);
                //         //return $slgs;
                //     }
                //     return $alias;
                // }
            } else {
                return $alias;
            }
        } else {
            return $alias;
        }
      
    }

    public function getAllBanners()
    {

        $routes = array();
        $sql = "SELECT b.*,bd.* FROM banner b LEFT JOIN banner_description bd ON bd.banner_id = b.banner_id WHERE b.status = 1 AND bd.lang_id = '" . $this->config->get('config_language_id') . "'";

        $r_routes = $this->db->query($sql);
        foreach ($r_routes->rows as $r) {
            $routes[$r['url']] = array(
                'meta_title' => (($r['meta_title'] != '') ? $r['meta_title'] : ''),
                'meta_keyword' => (($r['meta_keyword'] != '') ? $r['meta_keyword'] : ''),
                'meta_description' => (($r['meta_description'] != '') ? $r['description'] : ''),
                'banner' => (($r['image'] != '') ? $r['image'] : ''),
                'description' => (($r['description'] != '') ? $r['description'] : ''),
                'title' => (($r['title'] != '') ? $r['title'] : ''),
            );
        }


        return $routes;
    }
}
