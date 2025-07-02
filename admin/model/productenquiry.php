<?php
class ModelProductEnquiry extends Model
{
    public function addProductEnquiry($data)
    {
        $defaultImageFileName = "no_image-100x100.png";
        $icon = $defaultImageFileName;

        if (!empty($_FILES["icon"]["name"])) {
            $targetDirectory = DIR_IMAGE . "productenquiry/";
            $targetFile = $targetDirectory . basename($_FILES["icon"]["name"]);
            if (!is_dir($targetDirectory)) {
                mkdir($targetDirectory, 0755);
            }
            move_uploaded_file($_FILES["icon"]["tmp_name"], $targetFile);
            $icon = $this->db->escape($_FILES["icon"]["name"]);
        }
        $status = $this->db->escape($data['status']);
        $sortOrder = $this->db->escape($data['sort_order']);
        $made_in = $this->db->escape($data['made_in']);
        $publish_date = $this->db->escape($data['publish_date']);
        $screen_size = $this->db->escape($data['screen_size']);
        $sku = $this->db->escape($data['sku']);
        $video = $this->db->escape($data['video']);
        $featured = $this->db->escape($data['featured']);
        $insertProductEnquiryQuery = "INSERT INTO `" . DB_PREFIX . "productenquiry` SET 
        icon = '" . $icon . "',
        made_in = '" . $made_in . "',
        publish_date = '" . $publish_date . "',
        screen_size = '" . $screen_size . "',
        sku = '" . $sku . "',
        video = '" . $video . "',
        featured = '" . $featured . "',
        sort_order = '" . (int)$sortOrder . "',
        status = '" . $status . "',
        date_added = NOW()";
        $this->db->query($insertProductEnquiryQuery);
        $productenquiryId = $this->db->getLastId();
        foreach ($data['productenquiry_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            $description = $this->db->escape($languageValue['description']);
            $short_description = $this->db->escape($languageValue['short_description']);
            $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "productenquiry_description SET 
            productenquiry_id = '" . (int)$productenquiryId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
            description = '" . $description . "',
            short_description = '" . $short_description . "'";
            $this->db->query($insertDescriptionQuery);
        }
    }

    public function getProductEnquiry($productenquiryId)
    {
        $query = $this->db->query($sql = "SELECT * FROM `" . DB_PREFIX . "productenquiry` WHERE id = " . (int)$productenquiryId);
        return $query->row;
    }

    public function getProductEnquiryDescriptions($productenquiryId)
    {
        $productenquiry_description_data = array();
        $sql = "SELECT * FROM `" . DB_PREFIX . "productenquiry_description` WHERE productenquiry_id = " . (int)$productenquiryId;
        $query = $this->db->query($sql);
        foreach ($query->rows as $result) {
            $productenquiry_description_data[$result['lang_id']] = array(
                'title'             => $result['title'],
                'description'       => $result['description'],
                'short_description'       => $result['short_description']
            );
        }
        return $productenquiry_description_data;
    }

    public function getProductEnquirys($languageId, $data = array())
    {
        $languageId = (int)$languageId;
        $sql = "SELECT pd.*, p.* 
				FROM `" . DB_PREFIX . "productenquiry` p
				LEFT JOIN `" . DB_PREFIX . "productenquiry_description` pd ON p.id = pd.productenquiry_id
				WHERE pd.lang_id = '" . $languageId . "' or  pd.lang_id = 1
				ORDER BY p.id";
        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " DESC";
        }
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getTotalproductenquirys()
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "productenquiry`");
        return $query->row['total'];
    }

    public function getMadeInOptions()
    {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` ORDER BY name");
        $made_in_options = [];
        foreach ($query->rows as $row) {
            $made_in_options[] = [
                'country_id' => $row['country_id'],
                'name' => $row['name']
            ];
        }
        return $made_in_options;
    }

    public function updateProductEnquiryStatus($productenquiryId, $status)
    {
        $this->db->query("UPDATE `" . DB_PREFIX . "productenquiry` SET status = '" . (int)$status . "' WHERE id = '" . (int)$productenquiryId . "'");
    }

    public function editProductEnquiry($productenquiryId, $data)
    {
        $targetDirectory = DIR_IMAGE . "productenquiry/";
        $icon = '';
        if (!empty($_FILES["icon"]["name"])) {
            $icon = $_FILES["icon"]["name"];
            $targetFile = $targetDirectory . basename($icon);
            move_uploaded_file($_FILES["icon"]["tmp_name"], $targetFile);
            $icon = $this->db->escape($icon);
        }
        if (!empty($icon)) {
            $updateImageQuery = "UPDATE `" . DB_PREFIX . "productenquiry` SET
            icon = '" . $icon . "'
            WHERE id = '" . (int)$productenquiryId . "'";
            $this->db->query($updateImageQuery);
        }
        $status = $this->db->escape($data['status']);
        $sortOrder = $this->db->escape($data['sort_order']);
        $publish_date = $this->db->escape($data['publish_date']);
        $screen_size = $this->db->escape($data['screen_size']);
        $sku = $this->db->escape($data['sku']);
        $video = $this->db->escape($data['video']);
        $featured = $this->db->escape($data['featured']);
        $made_in = $this->db->escape($data['made_in']);
        $updateProductEnquiryQuery = "UPDATE `" . DB_PREFIX . "productenquiry` SET
        status = '" . $status . "',
        publish_date = '" . $publish_date . "',
        screen_size = '" . $screen_size . "',
        sku = '" . $sku . "',
        video = '" . $video . "',
        featured = '" . $featured . "',
        made_in = '" . $made_in . "',
        sort_order = '" . $sortOrder . "',
        date_modified = NOW()
        WHERE id = '" . (int)$productenquiryId . "'";
        $this->db->query($updateProductEnquiryQuery);
        $deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "productenquiry_description WHERE productenquiry_id = '" . (int)$productenquiryId . "'";
        $this->db->query($deleteDescriptionQuery);
        foreach ($data['productenquiry_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            $description = $this->db->escape($languageValue['description']);
            $short_description = $this->db->escape($languageValue['short_description']);
            $updateDescriptionQuery = "INSERT INTO " . DB_PREFIX . "productenquiry_description SET 
            productenquiry_id = '" . (int)$productenquiryId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
            description = '" . $description . "',
            short_description = '" . $short_description . "'";
            $this->db->query($updateDescriptionQuery);
        }
        // die($updateProductEnquiryQuery);
    }

    public function deleteProductEnquiry($productenquiryId)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "productenquiry WHERE id = '" . (int)$productenquiryId . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "productenquiry_description WHERE productenquiry_id = '" . (int)$productenquiryId . "'");
    }
}
