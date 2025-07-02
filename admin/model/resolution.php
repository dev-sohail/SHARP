<?php
class ModelResolution extends Model
{
    public function addResolution($data)
    {
        $screen_size = $this->db->escape($data['screen_size']);
        $status = $this->db->escape($data['status']);
        $insertResolutionQuery = "INSERT INTO `" . DB_PREFIX . "resolution` SET 
        screen_size = '" . $screen_size . "',
        status = '" . $status . "',
        date_added = NOW()";
        $this->db->query($insertResolutionQuery);
        $resolutionId = $this->db->getLastId();
        foreach ($data['resolution_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "resolution_description SET 
            resolution_id = '" . (int)$resolutionId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "'";
            $this->db->query($insertDescriptionQuery);
        }
    }

    public function getResolution($resolutionId)
    {
        $query = $this->db->query($sql = "SELECT * FROM `" . DB_PREFIX . "resolution` WHERE id = " . (int)$resolutionId);
        return $query->row;
    }

    public function getResolutionDescriptions($resolutionId)
    {
        $resolution_description_data = array();
        $sql = "SELECT * FROM `" . DB_PREFIX . "resolution_description` WHERE resolution_id = " . (int)$resolutionId;
        $query = $this->db->query($sql);
        foreach ($query->rows as $result) {
            $resolution_description_data[$result['lang_id']] = array(
                'title'             => $result['title']
            );
        }
        return $resolution_description_data;
    }

    public function getResolutions($languageId, $data = array())
    {
        $languageId = (int)$languageId;
        $sql = "SELECT rd.*, r.* 
				FROM `" . DB_PREFIX . "resolution` r
				LEFT JOIN `" . DB_PREFIX . "resolution_description` rd ON r.id = rd.resolution_id
				WHERE rd.lang_id = '" . $languageId . "' or  rd.lang_id = 1
				ORDER BY r.id";
        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " DESC";
        }
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getTotalresolutions()
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "resolution`");
        return $query->row['total'];
    }

    public function updateResolutionStatus($resolutionId, $status)
    {
        $this->db->query("UPDATE `" . DB_PREFIX . "resolution` SET status = '" . (int)$status . "' WHERE id = '" . (int)$resolutionId . "'");
    }

    public function editResolution($resolutionId, $data)
    {
        $screen_size = $this->db->escape($data['screen_size']);
        $status = $this->db->escape($data['status']);
        $updateResolutionQuery = "UPDATE `" . DB_PREFIX . "resolution` SET
        status = '" . $status . "',
        screen_size = '" . $screen_size . "',
        date_modified = NOW()
        WHERE id = '" . (int)$resolutionId . "'";
        $this->db->query($updateResolutionQuery);
        $deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "resolution_description WHERE resolution_id = '" . (int)$resolutionId . "'";
        $this->db->query($deleteDescriptionQuery);
        foreach ($data['resolution_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            $updateDescriptionQuery = "INSERT INTO " . DB_PREFIX . "resolution_description SET 
            resolution_id = '" . (int)$resolutionId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "'";
            $this->db->query($updateDescriptionQuery);
        }
        // die($updateResolutionQuery);
    }

    public function deleteResolution($resolutionId)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "resolution WHERE id = '" . (int)$resolutionId . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "resolution_description WHERE resolution_id = '" . (int)$resolutionId . "'");
    }
}
