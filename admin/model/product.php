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
        $made_in = $this->db->escape($data['made_in']);
        $publish_date = $this->db->escape($data['publish_date']);
        $screen_size = $this->db->escape($data['screen_size']);
        $sku = $this->db->escape($data['sku']);
        $video = $this->db->escape($data['video']);
        $featured = $this->db->escape($data['featured']);
        $insertProductQuery = "INSERT INTO `" . DB_PREFIX . "product` SET 
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
        $this->db->query($insertProductQuery);
        $productId = $this->db->getLastId();
        foreach ($data['product_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            $description = $this->db->escape($languageValue['description']);
            $short_description = $this->db->escape($languageValue['short_description']);
            $insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "product_description SET 
            product_id = '" . (int)$productId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
            description = '" . $description . "',
            short_description = '" . $short_description . "'";
            $this->db->query($insertDescriptionQuery);
        }
        if (isset($data['product_features_image'])) {
            foreach ($data['product_features_image'] as $product_features_image) {
                // echo "INSERT INTO " . DB_PREFIX . "product_features_image SET 
                // product_id = '" . (int)$productId . "', 
                // image = '" . $this->db->escape($product_features_image['image']) . "', 
                // sort_order = '" . (int)$product_features_image['sort_order'] . "'
                // ";  exit;
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_features_image SET 
                product_id = '" . (int)$productId . "', 
                image = '" . $this->db->escape($product_features_image['image']) . "', 
                sort_order = '" . (int)$product_features_image['sort_order'] . "'
                ");
            }
        }
        // if (isset($data['product_benefits_image'])) {
        //     foreach ($data['product_benefits_image'] as $product_benefits_image) {
        //         $this->db->query("INSERT INTO " . DB_PREFIX . "product_benefits_image SET 
        //         product_id = '" . (int)$productId . "', 
        //         image = '" . $this->db->escape($product_benefits_image['image']) . "',
        //         ");

        //         foreach ($data['product_benefits_description'] as $languageId => $languageValue) {
        //             $languageId = (int)$languageId;
        //             $title = $this->db->escape($languageValue['title']);
        //             $description = $this->db->escape($languageValue['description']);
        //             $insertBenefitDescriptionQuery = "INSERT INTO " . DB_PREFIX . "product_benefits_description SET 
        //             product_id = '" . (int)$productId . "',
        //             lang_id = '" . $languageId . "',
        //             title = '" . $title . "',
        //             description = '" . $description . "'";
        //             $this->db->query($insertBenefitDescriptionQuery);
        //         }
        //     }
        // }
        // '<pre>';
        // print_r($insertbene);
        // print_r($insertfeat);
        // print_r($product_benefits_image);
        // print_r($product_features_image);
        // '</pre>';
        // die($product_benefits_image);
        // exit('hello');
    }

    public function getProduct($productId)
	{
		$query = $this->db->query($sql = "SELECT * FROM `" . DB_PREFIX . "product` WHERE id = " . (int)$productId);
		return $query->row;
	}

    public function getProductDescriptions($productId)
    {
        $product_description_data = array();
		$sql = "SELECT * FROM `" . DB_PREFIX . "product_description` WHERE product_id = " . (int)$productId;
		$query = $this->db->query($sql);
		foreach ($query->rows as $result) {
			$product_description_data[$result['lang_id']] = array(
				'title'             => $result['title'],
				'description'       => $result['description'],
				'short_description'       => $result['short_description']
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

	public function getTotalproducts()
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "product`");
		return $query->row['total'];
	}

    public function getMadeInOptions()
    {
        $made_in_options = [];
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` ORDER BY name");
        foreach ($query->rows as $row) {
            $made_in_options[] = [
                'country_id' => $row['country_id'],
                'name' => $row['name']
            ];
        }
        return $made_in_options;
    }

    public function getProductFeatureImages($product_id)
    {

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_features_image WHERE product_id = '" . (int)$product_id . "' ORDER BY sort_order ASC");

        return $query->rows;
    }

    public function getProductBenefitsImage($product_id)
    {
        $product_benefits_image = [];
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_benefits_image WHERE product_id = '" . (int)$product_id . "' ORDER BY sort_order ASC");
        foreach ($query->rows as $imageDescription) {
            $description_data = [];

            $description_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_benefits_description` WHERE product_id = '" . (int)$imageDescription['product_id'] . "'");

            foreach ($description_query->rows as $description) {
                $description_data[$description['lang_id']] = ['title' => $description['title'], 'content' => $description['content']];
            }

            $product_benefits_image[] = [
                'image'                     => $imageDescription['image'],
                'title'                     => $description_data['title'],
                'description'                 => $description_data['description']
            ];
        }
        return $product_benefits_image;
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
        $publish_date = $this->db->escape($data['publish_date']);
        $screen_size = $this->db->escape($data['screen_size']);
        $sku = $this->db->escape($data['sku']);
        $video = $this->db->escape($data['video']);
        $featured = $this->db->escape($data['featured']);
        $made_in = $this->db->escape($data['made_in']);
        $updateProductQuery = "UPDATE `" . DB_PREFIX . "product` SET
        status = '" . $status . "',
        publish_date = '" . $publish_date . "',
        screen_size = '" . $screen_size . "',
        sku = '" . $sku . "',
        video = '" . $video . "',
        featured = '" . $featured . "',
        made_in = '" . $made_in . "',
        sort_order = '" . $sortOrder . "',
        date_modified = NOW()
        WHERE id = '" . (int)$productId . "'";
        $this->db->query($updateProductQuery);
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$productId . "'");
        foreach ($data['product_description'] as $languageId => $languageValue) {
            $languageId = (int)$languageId;
            $title = $this->db->escape($languageValue['title']);
            $description = $this->db->escape($languageValue['description']);
            $short_description = $this->db->escape($languageValue['short_description']);
            $updateDescriptionQuery = "INSERT INTO " . DB_PREFIX . "product_description SET 
            product_id = '" . (int)$productId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
            description = '" . $description . "',
            short_description = '" . $short_description . "'";
            $this->db->query($updateDescriptionQuery);
        }
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_features_image WHERE product_id = '" . (int)$productId . "'");
        if (isset($data['product_features_image'])) {
            foreach ($data['product_features_image'] as $product_features_image) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_features_image SET product_id = '" . (int)$productId . "', image = '" . $this->db->escape($product_features_image['image']) . "', sort_order = '" . (int)$product_features_image['sort_order'] . "'");
            }
        }
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_benefits_image WHERE product_id = '" . (int)$productId . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_benefits_description WHERE product_id = '" . (int)$productId . "'");
        if (isset($data['product_benefits_image'])) {
            foreach ($data['product_benefits_image'] as $product_benefits_image) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_benefits_image SET product_id = '" . (int)$productId . "', image = '" . $this->db->escape($product_benefits_image['image']) . "'");

                foreach ($data['product_benefits_description'] as $languageId => $languageValue) {
                    $languageId = (int)$languageId;
                    $title = $this->db->escape($languageValue['title']);
                    $description = $this->db->escape($languageValue['description']);
                    $insertBenefitsDescriptionQuery = "INSERT INTO " . DB_PREFIX . "product_benefits_description SET 
                    product_id = '" . (int)$productId . "',
                    lang_id = '" . $languageId . "',
                    title = '" . $title . "',
                    description = '" . $description . "'";
                    $this->db->query($insertBenefitsDescriptionQuery);
                }
            }
        }
        // if (isset($data['product_benefits_description'])) {
        //     foreach ($data['product_benefits_description'] as $languageId => $languageValue) {
        //         $languageId = (int)$languageId;
        //         $title = $this->db->escape($languageValue['title']);
        //         $description = $this->db->escape($languageValue['description']);
        //         $insertBenefitsDescriptionQuery = "INSERT INTO " . DB_PREFIX . "product_benefits_description SET 
        //         product_id = '" . (int)$productId . "',
        //         lang_id = '" . $languageId . "',
        //         title = '" . $title . "',
        //         description = '" . $description . "'";
        //         $this->db->query($insertBenefitsDescriptionQuery);
        //     }
        // }
    // die($updateProductQuery);
    // die($insertBenefitsDescriptionQuery);
    // die($product_benefits_image);
    }

    public function deleteProduct($productId)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "product WHERE id = '" . (int)$productId . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_features_image WHERE product_id = '" . (int)$productId . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_benefits_image WHERE product_id = '" . (int)$productId . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_benefits_description WHERE product_id = '" . (int)$productId . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$productId . "'");
    }
}