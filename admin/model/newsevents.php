<?php
class ModelNewsEvents extends Model
{
    public function addNewsEvents($data)
    {
        $uploadedbanner_image = $this->handleUploadedImage($_FILES["banner_image"]);
        $uploadedthumbnail_image = $this->handleUploadedImage($_FILES["thumbnail"]);
        $publish = (int)$data['publish'];
        $publish_date = $this->db->escape($data['publish_date']);
        $sortOrder = (int)$data['sort_order'];
        $ne_category_id = (int)$data['ne_category_id'];
		$show_on_home = $this->db->escape($data['show_on_home']);
        $insertQuery = "INSERT INTO `" . DB_PREFIX . "news_events` SET 
        banner_image = '" . $uploadedbanner_image . "', 
        thumbnail = '" . $uploadedthumbnail_image . "', 
        publish = '" . $publish . "',
        show_on_home = '" . $show_on_home . "', 
        ne_category_id = '" . $ne_category_id . "',
        publish_date = '" . $publish_date . "',
        date_added = NOW(),
        date_modified = NOW(),
        sort_order = '" . $sortOrder . "'";
        
        $this->db->query($insertQuery);
        $newsEventId = $this->db->getLastId();
        
        foreach ($data['news_events_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            $description = $this->db->escape($languageValue['description']);
            $meta_title = $this->db->escape($languageValue['meta_title']);
            $meta_keyword = $this->db->escape($languageValue['meta_keyword']);
            $meta_description = $this->db->escape($languageValue['meta_description']);
            
            $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "news_events_description SET 
            news_event_id = '" . (int)$newsEventId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
            meta_title = '" . $meta_title . "',
            meta_keyword = '" . $meta_keyword . "',
            meta_description = '" . $meta_description . "',
            description = '" . $description . "'";
            
            $this->db->query($insertDescriptionQuery);
            
            if ($languageId == '1') {
                $seoTitle = $title;
            }
        }
        
        $this->load_model('seourl');
        if ($data['seo_url']) {
            $keyword = $this->model_seourl->seoUrl($data['seo_url']);
        } else {
            $keyword = $this->model_seourl->seoUrl($seoTitle);
            if (isset($keyword)) {
                $checkUrl = $this->model_seourl->chkUUrl($keyword);
                if (!$checkUrl) {
                    $keyword = $keyword;
                } else {
                    $originalTitle = $keyword;
                    $counter = 2;
                    while ($checkUrl) {
                        $keyword = $originalTitle . '-' . $counter;
                        $checkUrl = $this->model_seourl->chkUUrl($keyword);
                        $counter++;
                    }
                }
            }
        }
        
        $this->db->query("INSERT INTO " . DB_PREFIX . "aliases SET slog = 'newsevents/detail', url = '" . $this->db->escape($keyword) . "', slog_id = '" . $newsEventId . "'");
        $this->cache->delete('home.news_events_data');
        return $newsEventId;
    }

    private function handleUploadedImage($file)
    {
        if (empty($file['name'])) {
            return "";
        }
        $targetDirectory = DIR_IMAGE . "newsevents/";
        $targetFile = $targetDirectory . basename($file["name"]);
        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }
        move_uploaded_file($file["tmp_name"], $targetFile);
        return $this->db->escape($file["name"]);
    }

    public function editNewsEvents($news_event_id, $data)
    {
        if (!empty($_FILES["banner_image"]["name"])) {
            $banner_image = $this->handleUploadedImage($_FILES["banner_image"]);
            $updateQuery = "UPDATE `" . DB_PREFIX . "news_events` SET
            banner_image = '" . $banner_image . "'
            WHERE news_event_id = '" . (int)$news_event_id . "'";
            $this->db->query($updateQuery);
        }
        
        if (!empty($_FILES["thumbnail"]["name"])) {
            $thumbnail = $this->handleUploadedImage($_FILES["thumbnail"]);
            $updateQuery = "UPDATE `" . DB_PREFIX . "news_events` SET thumbnail = '" . $thumbnail . "' 
            WHERE news_event_id = '" . (int)$news_event_id . "'";
            $this->db->query($updateQuery);
        }
        
        
        $publish = (int)$data['publish'];
        $sortOrder = (int)$data['sort_order'];
        $publish_date = $this->db->escape($data['publish_date']);
        $ne_category_id = (int)$data['ne_category_id'];
        $show_on_home = $this->db->escape($data['show_on_home']);
        $updateQuery = "UPDATE `" . DB_PREFIX . "news_events` SET
        publish = '" . $publish . "', 
        show_on_home = '" . $show_on_home . "', 
        ne_category_id = '" . $ne_category_id . "',
        date_modified = NOW(),
        publish_date = '" . $publish_date . "',
        sort_order = '" . $sortOrder . "'
        WHERE news_event_id = '" . (int)$news_event_id . "'";
        
        $this->db->query($updateQuery);
        $deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "news_events_description WHERE news_event_id = '" . (int)$news_event_id . "'";
        $this->db->query($deleteDescriptionQuery);
        
        foreach ($data['news_events_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            $description = $this->db->escape($languageValue['description']);
            $meta_title = $this->db->escape($languageValue['meta_title']);
            $meta_keyword = $this->db->escape($languageValue['meta_keyword']);
            $meta_description = $this->db->escape($languageValue['meta_description']);
            
            $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "news_events_description SET 
            news_event_id = '" . (int)$news_event_id . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
            meta_title = '" . $meta_title . "',
            meta_keyword = '" . $meta_keyword . "',
            meta_description = '" . $meta_description . "',
            description = '" . $description . "'";
            
            $this->db->query($insertDescriptionQuery);
            
            if ($languageId == '1') {
                $seoTitle = $title;
            }
        }
        
        $this->load_model('seourl');
        $results = $this->db->query("SELECT * FROM aliases WHERE slog='newsevents/detail' AND slog_id='" . $news_event_id . "'");
        
        if ($data['seo_url']) {
            $keyword = $this->model_seourl->seoUrl($data['seo_url']);
        } else {
            $keyword = $this->model_seourl->seoUrl($seoTitle);
            if (isset($keyword)) {
                $checkUrl = $this->model_seourl->chkUUrl($keyword);
                if (!$checkUrl) {
                    $keyword = $keyword;
                } else {
                    $originalTitle = $keyword;
                    $counter = 2;
                    while ($checkUrl) {
                        $keyword = $originalTitle . '-' . $counter;
                        $checkUrl = $this->model_seourl->chkUUrl($keyword);
                        $counter++;
                    }
                }
            }
        }
        
        if ($results->rows) {
            $this->db->query("UPDATE aliases SET url='" . $keyword . "' WHERE slog='newsevents/detail' AND slog_id='" . $news_event_id . "'");
        } else {
            $this->db->query("INSERT INTO aliases SET url='" . $keyword . "',slog='newsevents/detail',slog_id='" . $news_event_id . "'");
        }
        
        $this->cache->delete('home.news_events_data');
    }

    public function deleteNewsEvents($news_event_id)
    {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "news_events_description` WHERE news_event_id = '" . (int)$news_event_id . "'");
        $this->db->query("DELETE FROM `" . DB_PREFIX . "news_events` WHERE news_event_id = '" . (int)$news_event_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "aliases WHERE slog='newsevents/detail' AND slog_id = '" . (int)$news_event_id . "'");
        $this->cache->delete('home.news_events_data');
    }

    public function getNewsEvents($news_event_id)
    {
        $sql = "SELECT ne.*,a.url as seo_url,a.slog_id FROM `" . DB_PREFIX . "news_events` ne 
        LEFT JOIN aliases a ON a.slog_id = ne.news_event_id AND a.slog = 'newsevents/detail' WHERE ne.news_event_id = " . $news_event_id;
    //    echo $sql; exit;
        $query = $this->db->query($sql);
        return $query->row;
    }

	// public function getNewsEvents($data)
	// {
	// 	$sql = "SELECT ned.*, ne .* FROM `news_events` ne
	// 			LEFT JOIN news_events_description ned ON ne.news_event_id = ned.news_event_id
	// 			WHERE ned.lang_id = 1 ORDER BY ne.news_event_id";
    //         if (isset($data['order']) && ($data['order'] == 'DESC')) {
    //             $sql .= " DESC";
    //         } else {
    //             $sql .= " DESC";
    //         }
    //         $query = $this->db->query($sql);
    //         return $query->rows;
    //     }



    public function getNewsEventsDescriptions($news_event_id)
    {
        $news_events_description_data = array();
        $sql = "SELECT * FROM `" . DB_PREFIX . "news_events_description` ned WHERE ned.news_event_id = " . $news_event_id;
        $query = $this->db->query($sql);
        
        foreach ($query->rows as $result) {
            $news_events_description_data[$result['lang_id']] = array(
                'title'                 => $result['title'],
                'description'           => $result['description'],
                'meta_keyword'          => $result['meta_keyword'],
                'meta_title'            => $result['meta_title'],
                'meta_description'      => $result['meta_description']
            );
        }
        return $news_events_description_data;
    }

    public function getNewsEventsList($data)
    {
        $sql = "SELECT ned.*, ne.* FROM `news_events` ne
                LEFT JOIN news_events_description ned ON ne.news_event_id = ned.news_event_id
                WHERE ned.lang_id = 1 ORDER BY ne.news_event_id";
                
        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " DESC";
        }
        
        $query = $this->db->query($sql);
        return $query->rows;
    }

public function getNewsEventsCategories()
{
    $sql = "SELECT nec.ne_category_id, 
            necd.title
            FROM news_events_categories nec
            LEFT JOIN ne_categories_description necd
            ON nec.ne_category_id = necd.ne_category_id
            WHERE necd.lang_id = 1 AND nec.publish = 1
            ORDER BY nec.sort_order ASC";
         $query = $this->db->query($sql);
         return $query->rows;
}

    public function getNewsEventsCategoriesList()
    {
        $sql = "SELECT ne_categories.ne_category_id, 
                ne_categories_description.title, ne_categories.sort_order 
                FROM ne_categories LEFT JOIN ne_categories_description 
                ON ne_categories.ne_category_id = ne_categories_description.ne_category_id
                WHERE ne_categories_description.lang_id = 1 AND ne_categories.publish = 1
                ORDER BY ne_categories.sort_order ASC";
                
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function updateNewsEventsStatus($news_event_id, $publish)
    {
        $sql = "UPDATE `" . DB_PREFIX . "news_events` SET publish = '" . (int)$publish . "' WHERE news_event_id = '" . (int)$news_event_id . "'";
        $this->db->query($sql);
        return true;
    }
}