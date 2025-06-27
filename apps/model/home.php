<?php
class ModelHome extends Model
{

    public function getHomeSlider()
    {
        $sql = "SELECT *
        FROM `" . DB_PREFIX . "sliders` s
        JOIN `" . DB_PREFIX . "slider_description` sd ON s.id = sd.slider_id
        WHERE sd.lang_id = '" . $this->config->get('config_language_id') . "' AND s.status = 1
        ORDER BY s.sort_order ASC LIMIT 1";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getHtmlBlock($name)
    {
        $sql = "SELECT bd.content,bd.title
        FROM `" . DB_PREFIX . "block` b
        JOIN `" . DB_PREFIX . "block_description` bd ON b.id = bd.block_id
        WHERE bd.unique_text = '" . $name . "' AND bd.lang_id = '" . $this->config->get('config_language_id') . "' AND b.publish = 1";
        $query = $this->db->query($sql);
        return $query->row;
    }

    public function getHtmlBlockImages($name)
    {
        $sql = "SELECT bd.title,b.image
        FROM `" . DB_PREFIX . "blockimages` b
        JOIN `" . DB_PREFIX . "block_images_description` bd ON b.id = bd.block_id
        WHERE bd.unique_text = '" . $name . "' AND bd.lang_id = '" . $this->config->get('config_language_id') . "' AND b.publish = 1";
        $query = $this->db->query($sql);
        return $query->row;
    }

    public function getBusiness()
    {
      $sql = "SELECT bd.*,b.*,a.url as seo_url
        FROM `" . DB_PREFIX . "business` b
        LEFT JOIN `" . DB_PREFIX . "business_description` bd ON b.busines_id = bd.busines_id AND bd.lang_id = '" . $this->config->get('config_language_id') . "'
        LEFT JOIN `" . DB_PREFIX . "sectors` s ON b.sector_id = s.id
        LEFT JOIN `" . DB_PREFIX . "aliases` a ON a.slog_id = s.id AND a.slog = 'sectors/detail'
        WHERE b.publish = 1 AND b.busines_id IS NOT NULL ORDER BY b.sort_order ASC";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getHomeMediaCenter()
    {
        $sql = "SELECT m.*,md.*, a.url as seo_url
        FROM `" . DB_PREFIX . "media_center` m
        JOIN `" . DB_PREFIX . "media_center_description` md ON m.media_center_id = md.media_center_id
        LEFT JOIN aliases a ON m.media_center_id = a.slog_id AND a.slog = 'mediacenter/detail'                         
        WHERE md.lang_id = '" . $this->config->get('config_language_id') . "' AND m.publish = 1
        ORDER BY m.media_center_id DESC";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getAwards()
    {
        $sql = "SELECT *
        FROM `" . DB_PREFIX . "awards` a
        JOIN `" . DB_PREFIX . "award_description` ad ON a.id = ad.award_id
        WHERE ad.lang_id = '" . $this->config->get('config_language_id') . "' AND a.status = 1
        ORDER BY a.sort_order ASC";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getOverHistory()
    {
        $sql = "SELECT *
        FROM `" . DB_PREFIX . "ourhistory` oh
        JOIN `" . DB_PREFIX . "ourhistories_description` ohd ON oh.id = ohd.history_id
        WHERE ohd.lang_id = '" . $this->config->get('config_language_id') . "' AND oh.status = 1
        ORDER BY oh.sort_order ASC";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getOverTeam()
    {
        $sql = "SELECT *
        FROM `" . DB_PREFIX . "ourteams` ot
        JOIN `" . DB_PREFIX . "ourteams_description` otd ON ot.id = otd.team_id
        WHERE otd.lang_id = '" . $this->config->get('config_language_id') . "' AND ot.status = 1
        ORDER BY ot.sort_order ASC";
        $query = $this->db->query($sql);
        return $query->rows;
    }

   // GET MAP LOCATIONS 
    public function getlocations()
    {
        $sql = "SELECT l.*, ld.*
                FROM `" . DB_PREFIX . "locations` l
                LEFT JOIN `" . DB_PREFIX . "location_description` ld ON ld.location_id = l.id
                WHERE ld.lang_id = '" . (int)$this->config->get('config_language_id') . "' 
                AND l.publish = 1
                ORDER BY l.id DESC";
                $query = $this->db->query($sql);
                return $query->rows;
    }
    
    public function getLocationById($id) 
    {
        $sql = "SELECT l.*, ld.*
                FROM `" . DB_PREFIX . "locations` l
                LEFT JOIN `" . DB_PREFIX . "location_description` ld ON ld.location_id = l.id
                WHERE ld.lang_id = '" . (int)$this->config->get('config_language_id') . "' AND l.id = '" . (int)$id . "'
                AND l.publish = 1
                ORDER BY l.id DESC";
        $query = $this->db->query($sql);
        return $query->row;
    }
    // END GET MAP LOCATIONS
}
