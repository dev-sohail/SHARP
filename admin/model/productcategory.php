<?php
class ModelProductCategory extends Model
{
    public function addProductCategory($data)
    {
        $defaultImageFileName = "no_image-100x100.png";
        $icon = $defaultImageFileName;

        if (!empty($_FILES["icon"]["name"])) {
            $targetDirectory = DIR_IMAGE . "productcategory/";
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
        $insertProductCategoryQuery = "INSERT INTO `" . DB_PREFIX . "productcategory` SET 
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
        $this->db->query($insertProductCategoryQuery);
        $productcategoryId = $this->db->getLastId();
        foreach ($data['productcategory_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            $description = $this->db->escape($languageValue['description']);
            $short_description = $this->db->escape($languageValue['short_description']);
            $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "productcategory_description SET 
            productcategory_id = '" . (int)$productcategoryId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
            description = '" . $description . "',
            short_description = '" . $short_description . "'";
            $this->db->query($insertDescriptionQuery);
        }
    }

    public function getProductCategory($productcategoryId)
    {
        $query = $this->db->query($sql = "SELECT * FROM `" . DB_PREFIX . "productcategory` WHERE id = " . (int)$productcategoryId);
        return $query->row;
    }

    public function getProductCategoryDescriptions($productcategoryId)
    {
        $productcategory_description_data = array();
        $sql = "SELECT * FROM `" . DB_PREFIX . "productcategory_description` WHERE productcategory_id = " . (int)$productcategoryId;
        $query = $this->db->query($sql);
        foreach ($query->rows as $result) {
            $productcategory_description_data[$result['lang_id']] = array(
                'title'             => $result['title'],
                'description'       => $result['description'],
                'short_description'       => $result['short_description']
            );
        }
        return $productcategory_description_data;
    }

    public function getProductCategorys($languageId, $data = array())
    {
        $languageId = (int)$languageId;
        $sql = "SELECT pd.*, p.* 
				FROM `" . DB_PREFIX . "productcategory` p
				LEFT JOIN `" . DB_PREFIX . "productcategory_description` pd ON p.id = pd.productcategory_id
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

    public function getTotalproductcategorys()
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "productcategory`");
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

    public function updateProductCategoryStatus($productcategoryId, $status)
    {
        $this->db->query("UPDATE `" . DB_PREFIX . "productcategory` SET status = '" . (int)$status . "' WHERE id = '" . (int)$productcategoryId . "'");
    }

    public function editProductCategory($productcategoryId, $data)
    {
        $targetDirectory = DIR_IMAGE . "productcategory/";
        $icon = '';
        if (!empty($_FILES["icon"]["name"])) {
            $icon = $_FILES["icon"]["name"];
            $targetFile = $targetDirectory . basename($icon);
            move_uploaded_file($_FILES["icon"]["tmp_name"], $targetFile);
            $icon = $this->db->escape($icon);
        }
        if (!empty($icon)) {
            $updateImageQuery = "UPDATE `" . DB_PREFIX . "productcategory` SET
            icon = '" . $icon . "'
            WHERE id = '" . (int)$productcategoryId . "'";
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
        $updateProductCategoryQuery = "UPDATE `" . DB_PREFIX . "productcategory` SET
        status = '" . $status . "',
        publish_date = '" . $publish_date . "',
        screen_size = '" . $screen_size . "',
        sku = '" . $sku . "',
        video = '" . $video . "',
        featured = '" . $featured . "',
        made_in = '" . $made_in . "',
        sort_order = '" . $sortOrder . "',
        date_modified = NOW()
        WHERE id = '" . (int)$productcategoryId . "'";
        $this->db->query($updateProductCategoryQuery);
        $deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "productcategory_description WHERE productcategory_id = '" . (int)$productcategoryId . "'";
        $this->db->query($deleteDescriptionQuery);
        foreach ($data['productcategory_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            $description = $this->db->escape($languageValue['description']);
            $short_description = $this->db->escape($languageValue['short_description']);
            $updateDescriptionQuery = "INSERT INTO " . DB_PREFIX . "productcategory_description SET 
            productcategory_id = '" . (int)$productcategoryId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
            description = '" . $description . "',
            short_description = '" . $short_description . "'";
            $this->db->query($updateDescriptionQuery);
        }
        // die($updateProductCategoryQuery);
    }

    public function deleteProductCategory($productcategoryId)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "productcategory WHERE id = '" . (int)$productcategoryId . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "productcategory_description WHERE productcategory_id = '" . (int)$productcategoryId . "'");
    }
}
