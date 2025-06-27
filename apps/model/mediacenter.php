<?php

class ModelMediaCenter extends Model
{


    public function getMediaCenters($data)
    {
          $sql = "SELECT mc.*, mcd.*, a.url as seo_url 
          FROM media_center mc 
          LEFT JOIN `" . DB_PREFIX . "aliases` a ON a.slog_id = mc.media_center_id AND a.slog = 'mediacenter/detail'
          LEFT JOIN media_center_description mcd ON mcd.media_center_id = mc.media_center_id 
          WHERE mc.publish = '1' AND mcd.lang_id = '" . $this->config->get('config_language_id') . "'";

        $sql .= " GROUP BY mc.media_center_id";
        $sql .= " ORDER BY mc.sort_order ASC, mc.media_center_id DESC";
        if (isset($data['start']) || isset($data['limit'])) {
            $sql .= " LIMIT " . (int)$data['start'] . ", " . (int)$data['limit'];
        }

        $query = $this->db->query($sql);    
        $media_center = $query->rows;
        return $media_center;
    }
    public function getTotalMediaCenters($data)
    {
       $sql = "SELECT COUNT(*) as total FROM media_center mc  
       LEFT JOIN `" . DB_PREFIX . "aliases` a ON a.slog_id = mc.media_center_id AND a.slog = 'mediacenter/detail'
       LEFT JOIN media_center_description mcd ON mcd.media_center_id = mc.media_center_id 
       WHERE mc.publish = '1' AND mcd.lang_id = '" . $this->config->get('config_language_id') . "'";
       if (!empty($data['filter_title'])) {
        $sql .= " AND mc.title LIKE '" . $this->db->escape('%' . $data['filter_title'] . '%') . "'";
        }
        $query = $this->db->query($sql);
        $total = $query->row['total'];
        return $total;
    }

    public function getMediaDetails($mediaId)
    {
        $sql = "SELECT mc.*,mcd.* FROM `" . DB_PREFIX . "media_center` mc 
        INNER JOIN media_center_description mcd ON mcd.media_center_id = mc.media_center_id
        LEFT JOIN `" . DB_PREFIX . "aliases` a ON a.slog_id = mc.media_center_id AND a.slog = 'mediacenter/detail'
        WHERE mc.media_center_id = '" . $mediaId . "' 
        AND mc.publish = '1' AND mcd.lang_id='" . $this->config->get('config_language_id') . "'";
        $query = $this->db->query($sql);
        $result = $query->row;
        return $result;
    }
    public function getRelatedMediacenter($mediaId)
    {
        $sql = "SELECT mc.*, mcd.*, a.url as seo_url 
        FROM media_center mc 
        LEFT JOIN `" . DB_PREFIX . "aliases` a ON a.slog_id = mc.media_center_id AND a.slog = 'mediacenter/detail'
        LEFT JOIN media_center_description mcd ON mcd.media_center_id = mc.media_center_id 
        WHERE mc.publish = '1' AND mcd.lang_id = '" . $this->config->get('config_language_id') . "'";
        if ($mediaId != '') {
            $sql .= "AND mc.media_center_id !='" . $mediaId . "'";
        }
        $sql .= " GROUP BY mc.media_center_id ORDER BY mc.date_added DESC";
        // LIMIT 2
        $query = $this->db->query($sql);
        $media_center = $query->rows;
        return $media_center;
    }

}
