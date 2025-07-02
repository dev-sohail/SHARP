<?php
class ModelScreenSize extends Model
{
    public function addScreenSize($data)
    {
        $status = $this->db->escape($data['status']);
        $sortOrder = $this->db->escape($data['sort_order']);
        $screen_size = $this->db->escape($data['screen_size']);
        $insertScreenSizeQuery = "INSERT INTO `" . DB_PREFIX . "screensize` SET 
        screen_size = '" . $screen_size . "',
        sort_order = '" . (int)$sortOrder . "',
        status = '" . $status . "',
        date_added = NOW()";
        $this->db->query($insertScreenSizeQuery);
        $screensizeId = $this->db->getLastId();
        foreach ($data['screensize_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "screensize_description SET 
            screensize_id = '" . (int)$screensizeId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "'";
            $this->db->query($insertDescriptionQuery);
        }
    // echo '<pre>'; print_r($insertDescriptionQuery); '</pre>';exit;
    }

    public function getScreenSize($screensizeId)
    {
        $query = $this->db->query($sql = "SELECT * FROM `" . DB_PREFIX . "screensize` WHERE id = " . (int)$screensizeId);
        return $query->row;
    }

    public function getScreenSizeDescriptions($screensizeId)
    {
        $screensize_description_data = array();
        $sql = "SELECT * FROM `" . DB_PREFIX . "screensize_description` WHERE screensize_id = " . (int)$screensizeId;
        $query = $this->db->query($sql);
        foreach ($query->rows as $result) {
            $screensize_description_data[$result['lang_id']] = array(
                'title'             => $result['title']
            );
        }
        return $screensize_description_data;
    }

    public function getScreenSizes($languageId, $data = array())
    {
        $languageId = (int)$languageId;
        $sql = "SELECT sd.*, s.* 
				FROM `" . DB_PREFIX . "screensize` s
				LEFT JOIN `" . DB_PREFIX . "screensize_description` sd ON s.id = sd.screensize_id
				WHERE sd.lang_id = '" . $languageId . "' or  sd.lang_id = 1
				ORDER BY s.id";
        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " DESC";
        }
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getTotalscreensizes()
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "screensize`");
        return $query->row['total'];
    }

    public function updateScreenSizeStatus($screensizeId, $status)
    {
        $this->db->query("UPDATE `" . DB_PREFIX . "screensize` SET status = '" . (int)$status . "' WHERE id = '" . (int)$screensizeId . "'");
    }

    public function editScreenSize($screensizeId, $data)
    {
        $status = $this->db->escape($data['status']);
        $sortOrder = $this->db->escape($data['sort_order']);
        $screen_size = $this->db->escape($data['screen_size']);
        $updateScreenSizeQuery = "UPDATE `" . DB_PREFIX . "screensize` SET
        status = '" . $status . "',
        screen_size = '" . $screen_size . "',
        sort_order = '" . $sortOrder . "',
        date_modified = NOW()
        WHERE id = '" . (int)$screensizeId . "'";
        $this->db->query($updateScreenSizeQuery);
        $deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "screensize_description WHERE screensize_id = '" . (int)$screensizeId . "'";
        $this->db->query($deleteDescriptionQuery);
        foreach ($data['screensize_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            $updateDescriptionQuery = "INSERT INTO " . DB_PREFIX . "screensize_description SET 
            screensize_id = '" . (int)$screensizeId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "'";
            $this->db->query($updateDescriptionQuery);
        }
        // die($updateScreenSizeQuery);
    }

    public function deleteScreenSize($screensizeId)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "screensize WHERE id = '" . (int)$screensizeId . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "screensize_description WHERE screensize_id = '" . (int)$screensizeId . "'");
    }
}
