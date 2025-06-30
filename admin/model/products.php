<?php
class ModelProduct extends Model
{
    public function addProduct($data)
	{
        $defaultImageFileName = "no_image-100x100.png";
        $icon = $defaultImageFileName;
 
        if (!empty($_FILES["icon"]["name"])) {
            $targetDirectory = DIR_IMAGE . "product/";
            $targetFile = $targetDirectory . basename($_FILES["icon"]["name"]);
            if (!is_dir($targetDirectory)) {
                mkdir($targetDirectory, 0755);
            }
            move_uploaded_file($_FILES["icon"]["tmp_name"], $targetFile);
            $icon = $this->db->escape($_FILES["icon"]["name"]);
        }
        $status = $this->db->escape($data['status']);
		$sortOrder = $this->db->escape($data['sort_order']);
        $numberOfStars = (int)$data['number_of_stars'];
        $insertFeedbackQuery = "INSERT INTO `" . DB_PREFIX . "product` SET 
        icon = '" . $icon . "',
        number_of_stars = '" . (int)$numberOfStars . "', 
        sort_order = '" . (int)$sortOrder . "',
        status = '" . $status . "',
        date_added = NOW()";
        $this->db->query($insertFeedbackQuery);
        $productId = $this->db->getLastId();
        foreach ($data['product_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            $description = $this->db->escape($languageValue['description']);
            $designation = $this->db->escape($languageValue['designation']);
            $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "product_description SET 
            feedback_id = '" . (int)$productId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
            description = '" . $description . "',
            designation = '" . $designation . "'";
            $this->db->query($insertDescriptionQuery);
        }
    }

    public function getProduct($productId)
	{
		$query = $this->db->query($sql = "SELECT * FROM `" . DB_PREFIX . "product` WHERE id = " . (int)$productId);
		return $query->row;
	}

    public function getProductDescriptions($productId)
    {
        $product_description_data = array();
		$sql = "SELECT * FROM `" . DB_PREFIX . "product_description` WHERE feedback_id = " . (int)$productId;
		$query = $this->db->query($sql);
		foreach ($query->rows as $result) {
			$product_description_data[$result['lang_id']] = array(
				'title'             => $result['title'],
				'description'       => $result['description'],
				'designation'       => $result['designation']
			);
		}
		return $product_description_data;
    }

	public function getProducts($languageId, $data = array())
	{
		$languageId = (int)$languageId;
		$sql = "SELECT pd.*, p.* 
				FROM `" . DB_PREFIX . "product` p
				LEFT JOIN `" . DB_PREFIX . "product_description` pd ON p.id = pd.product_id
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

	public function getTotalProducts()
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "product`");
		return $query->row['total'];
	}

    public function updateProductStatus($productId, $status) 
    {
		$this->db->query("UPDATE `" . DB_PREFIX . "product` SET status = '" . (int)$status . "' WHERE id = '" . (int)$productId . "'");
	}

    public function editProduct($productId, $data)
    {
        $targetDirectory = DIR_IMAGE . "product/";
        $icon = '';
        if (!empty($_FILES["icon"]["name"])) {
            $icon = $_FILES["icon"]["name"];
            $targetFile = $targetDirectory . basename($icon);
            move_uploaded_file($_FILES["icon"]["tmp_name"], $targetFile);
            $icon = $this->db->escape($icon);
        }
        if (!empty($icon)) {
            $updateImageQuery = "UPDATE `" . DB_PREFIX . "product` SET
            icon = '" . $icon . "'
            WHERE id = '" . (int)$productId . "'";
            $this->db->query($updateImageQuery);
        }
        $status = $this->db->escape($data['status']);
		$sortOrder = $this->db->escape($data['sort_order']);
        $numberOfStars = isset($data['number_of_stars']) ? (int)$data['number_of_stars'] : 5;
        $updateFeedbackQuery = "UPDATE `" . DB_PREFIX . "product` SET
        status = '" . $status . "',
        number_of_stars = '" . $numberOfStars . "',
        sort_order = '" . $sortOrder . "',
        date_modified = NOW()
        WHERE id = '" . (int)$productId . "'";
        $this->db->query($updateFeedbackQuery);
        $deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "product_description WHERE feedback_id = '" . (int)$productId . "'";
        $this->db->query($deleteDescriptionQuery);
        foreach ($data['product_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            $description = $this->db->escape($languageValue['description']);
            $designation = $this->db->escape($languageValue['designation']);
            $updateDescriptionQuery = "INSERT INTO " . DB_PREFIX . "product_description SET 
            feedback_id = '" . (int)$productId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
            description = '" . $description . "',
            designation = '" . $designation . "'";
            $this->db->query($updateDescriptionQuery);
        }
    // die($updateFeedbackQuery);
    }

    public function deleteProduct($productId)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "product WHERE id = '" . (int)$productId . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE feedback_id = '" . (int)$productId . "'");
    }
}