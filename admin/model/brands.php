<?php
class ModelBrands extends Model
{
	public function addBrand($data)
	{
		$defaultbIconFileName = "";
		$uploadedbIconFileName = $defaultbIconFileName;
		if (!empty($_FILES["icon"]["name"])) {
			$targetDirectory = DIR_IMAGE . "brands/";
			$targetFile = $targetDirectory . basename($_FILES["icon"]["name"]);
			if (!is_dir($targetDirectory)) {
				mkdir($targetDirectory, 0755);
			}
			move_uploaded_file($_FILES["icon"]["tmp_name"], $targetFile);
			$uploadedbIconFileName = $this->db->escape($_FILES["icon"]["name"]);
		}

		// $defaultbImageFileName = "";
		// $uploadedbImageFileName = $defaultbImageFileName;
		// if (!empty($_FILES["image"]["name"])) {
		// 	$targetDirectory = DIR_IMAGE . "brands/";
		// 	$targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
		// 	if (!is_dir($targetDirectory)) {
		// 		mkdir($targetDirectory, 0755);
		// 	}
		// 	move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
		// 	$uploadedbImageFileName = $this->db->escape($_FILES["image"]["name"]);
		// }

		$defaultThumbnaileFileName = "";
		$uploadedThumbnaileFileName = $defaultThumbnaileFileName;
		if (!empty($_FILES["thumbnail"]["name"])) {
			$targetDirectory = DIR_IMAGE . "brands/";
			$targetFile = $targetDirectory . basename($_FILES["thumbnail"]["name"]);
			if (!is_dir($targetDirectory)) {
				mkdir($targetDirectory, 0755);
			}
			move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $targetFile);
			$uploadedThumbnaileFileName = $this->db->escape($_FILES["thumbnail"]["name"]);
		}

		$status = (int)$data['status'];
		$location_id = (int)$data['location_id'];
		$youtube_url = $this->db->escape($data['youtube_url']);
		$facebook_url = $this->db->escape($data['facebook_url']);
		$instagram_url = $this->db->escape($data['instagram_url']);
		$x_url = $this->db->escape($data['x_url']);
		$opening_time = $this->db->escape($data['opening_time']);
		$closing_time = $this->db->escape($data['closing_time']);
		$sortOrder = (int)$data['sort_order'];
		$insertBrandsQuery = "INSERT INTO `" . DB_PREFIX . "brands` SET 
        youtube_url = '" . $youtube_url . "', 
        facebook_url = '" . $facebook_url . "', 
        instagram_url = '" . $instagram_url . "', 
        x_url = '" . $x_url . "', 
        location_id = '" . $location_id . "', 
		thumbnail = '" . $uploadedThumbnaileFileName . "',
        icon = '" . $uploadedbIconFileName . "', 
        status = '" . $status . "',
		opening_time = '" . $opening_time . "',
		closing_time = '" . $closing_time . "',
		date_added = NOW(),
		date_modified = NOW(),
        sort_order = '" . $sortOrder . "'";
		$this->db->query($insertBrandsQuery);
		$brandId = $this->db->getLastId();
		foreach ($data['brands_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$name = $this->db->escape($languageValue['name']);
			$full_description = $this->db->escape($languageValue['full_description']);
			$meta_title = $this->db->escape($languageValue['meta_title']);
			$meta_keyword = $this->db->escape($languageValue['meta_keyword']);
			$meta_description = $this->db->escape($languageValue['meta_description']);
			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "brands_description SET 
            brand_id = '" . (int)$brandId . "',
            lang_id = '" . $languageId . "',
            name = '" . $name . "',
            full_description = '" . $full_description . "',
			meta_title = '" . $meta_title . "',
			meta_keyword = '" . $meta_keyword . "',
            meta_description = '" . $meta_description . "'";
			$this->db->query($insertDescriptionQuery);
			if($languageId == 1)
			{
				$seoTitle = $name;
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
			
		$this->db->query("INSERT INTO " . DB_PREFIX . "aliases SET slog = 'brands/detail', url = '" . $this->db->escape($keyword) . "', slog_id = '" . $brandId . "'");
		}
		if (isset($data['ourmenu_images'])) {
			foreach ($data['ourmenu_images'] as $ourmenu_images) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "ourmenu_images SET brand_id = '" . (int)$brandId . "', image = '" . $this->db->escape($ourmenu_images['image']) . "', pdf = '" . $this->db->escape($ourmenu_images['pdf']) . "', sort_order = '" . (int)$ourmenu_images['sort_order'] . "'");
				$menu_description_id = $this->db->getLastId();
				foreach ($ourmenu_images['description'] as $language_id => $description) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "ourmenu_image_description` SET `menu_description_id` = '" . (int)$menu_description_id . "', `lang_id` = '" . (int)$language_id . "', `brand_id` = '" . (int)$brandId . "', `title` = '" . $this->db->escape($description['title']) . "', `content` = '" . $this->db->escape($description['content']) . "'");
				}
			}
		}

		if (isset($data['brand_images'])) {
			foreach ($data['brand_images'] as $brand_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "brand_images SET brand_id = '" . (int)$brandId . "', image = '" . $this->db->escape($brand_image['image']) . "', sort_order = '" . (int)$brand_image['sort_order'] . "'");
				$img_description_id = $this->db->getLastId();
				foreach ($brand_image['description'] as $language_id => $description) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "brand_image_description` SET `img_description_id` = '" . (int)$img_description_id . "', `lang_id` = '" . (int)$language_id . "', `brand_id` = '" . (int)$brandId . "'");
				}
			}
		}

		$this->cache->delete('home.brands.' . (int)$this->config->get('config_language_id'));
	}
	public function editBrand($brandId, $data)
	{
		$targetDirectory = DIR_IMAGE . "brands/";
		$iconFileName = '';
		if (!empty($_FILES["icon"]["name"])) {
			$iconFileName = $_FILES["icon"]["name"];
			$targetFile = $targetDirectory . basename($iconFileName);
			if (!is_dir($targetDirectory)) {
				mkdir($targetDirectory, 0755);
			}
			move_uploaded_file($_FILES["icon"]["tmp_name"], $targetFile);
			$iconFileName = $this->db->escape($iconFileName);
		}
		if (!empty($iconFileName)) {
			    $updateIconQuery = "UPDATE `" . DB_PREFIX . "brands` SET 
				icon = '" . $iconFileName . "' 
				WHERE brand_id = '" . (int)$brandId . "'";
			   $this->db->query($updateIconQuery);
		}

		// $ImageFileName = '';
		// if (!empty($_FILES["image"]["name"])) {
		// 	$ImageFileName = $_FILES["image"]["name"];
		// 	$targetFile = $targetDirectory . basename($ImageFileName);
		// 	if (!is_dir($targetDirectory)) {
		// 		mkdir($targetDirectory, 0755);
		// 	}
		// 	move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
		// 	$ImageFileName = $this->db->escape($ImageFileName);
		// }
		// if (!empty($ImageFileName)) {
		// 	    $updateIconQuery = "UPDATE `" . DB_PREFIX . "brands` SET 
		// 		image = '" . $ImageFileName . "' 
		// 		WHERE brand_id = '" . (int)$brandId . "'";
		// 	   $this->db->query($updateIconQuery);
		// }

		$ThumbnaileFileName = '';
		if (!empty($_FILES["thumbnail"]["name"])) {
			$ThumbnaileFileName = $_FILES["thumbnail"]["name"];
			$targetFile = $targetDirectory . basename($ThumbnaileFileName);
			if (!is_dir($targetDirectory)) {
				mkdir($targetDirectory, 0755);
			}
			move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $targetFile);
			$ThumbnaileFileName = $this->db->escape($ThumbnaileFileName);
		}
		if (!empty($ThumbnaileFileName)) {
			    $updateThumbnaileQuery = "UPDATE `" . DB_PREFIX . "brands` SET 
				thumbnail = '" . $ThumbnaileFileName . "' 
				WHERE brand_id = '" . (int)$brandId . "'";
			   $this->db->query($updateThumbnaileQuery);
		}
		$location_id = (int)$data['location_id'];
		$status = (int)$data['status'];
		$youtube_url = $this->db->escape($data['youtube_url']);
		$facebook_url = $this->db->escape($data['facebook_url']);
		$instagram_url = $this->db->escape($data['instagram_url']);
		$x_url = $this->db->escape($data['x_url']);
		$opening_time = $this->db->escape($data['opening_time']);
		$closing_time = $this->db->escape($data['closing_time']);
		$sortOrder = (int)$data['sort_order'];
		$updateBrandQuery = "UPDATE `" . DB_PREFIX . "brands` SET
			status = '" . $status . "',
			location_id = '" . $location_id . "',
			youtube_url = '" . $youtube_url . "',
			facebook_url = '" . $facebook_url . "',
			instagram_url = '" . $instagram_url . "',
			x_url = '" . $x_url . "',
			date_modified = NOW(),
			sort_order = '" . $sortOrder . "',
			opening_time = '" . $opening_time . "',
			closing_time = '" . $closing_time . "'
			WHERE brand_id = '" . (int)$brandId . "'";
		$this->db->query($updateBrandQuery);
		$deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "brands_description WHERE brand_id = '" . (int)$brandId . "'";
		$this->db->query($deleteDescriptionQuery);
		foreach ($data['brands_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$name = $this->db->escape($languageValue['name']);
			$full_description = $this->db->escape($languageValue['full_description']);
			$meta_title = $this->db->escape($languageValue['meta_title']);
			$meta_keyword = $this->db->escape($languageValue['meta_keyword']);
			$meta_description = $this->db->escape($languageValue['meta_description']);
			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "brands_description SET 
            brand_id = '" . (int)$brandId . "',
            lang_id = '" . $languageId . "',
            name = '" . $name . "',
            full_description = '" . $full_description . "',
			meta_title = '" . $meta_title . "',
			meta_keyword = '" . $meta_keyword . "',
			meta_description = '" . $meta_description . "'";
			$this->db->query($insertDescriptionQuery);
			if($languageId == 1)
			{
				$seoTitle = $name;
			}
		$this->load_model('seourl');
		$results = $this->db->query("SELECT * FROM aliases WHERE slog='brands/detail' AND slog_id='" . $brandId . "'");
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
			$this->db->query("UPDATE aliases SET url='" . $keyword . "' WHERE slog='brands/detail' AND slog_id='" . $brandId . "'");
		} else {
			$this->db->query("INSERT INTO aliases SET url='" . $keyword . "',slog='brands/detail',slog_id='" . $brandId . "'");
		} 
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "brand_images WHERE brand_id = '" . (int)$brandId . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "brand_image_description WHERE brand_id = '" . (int)$brandId . "'");
		if (isset($data['brand_images'])) {
			foreach ($data['brand_images'] as $brand_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "brand_images SET brand_id = '" . (int)$brandId . "', image = '" . $this->db->escape($brand_image['image']) . "', sort_order = '" . (int)$brand_image['sort_order'] . "'");
				$img_description_id = $this->db->getLastId();
				foreach ($brand_image['description'] as $language_id => $description) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "brand_image_description` SET `img_description_id` = '" . (int)$img_description_id . "', `lang_id` = '" . (int)$language_id . "', `brand_id` = '" . (int)$brandId . "'");
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "ourmenu_images WHERE brand_id = '" . (int)$brandId . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "ourmenu_image_description WHERE brand_id = '" . (int)$brandId . "'");
		if (isset($data['ourmenu_images'])) {
			foreach ($data['ourmenu_images'] as $ourmenu_images) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "ourmenu_images SET brand_id = '" . (int)$brandId . "', image = '" . $this->db->escape($ourmenu_images['image']) . "', pdf = '" . $this->db->escape($ourmenu_images['pdf']) . "', sort_order = '" . (int)$ourmenu_images['sort_order'] . "'");
				$menu_description_id = $this->db->getLastId();
				foreach ($ourmenu_images['description'] as $language_id => $description) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "ourmenu_image_description` SET `menu_description_id` = '" . (int)$menu_description_id . "', `lang_id` = '" . (int)$language_id . "', `brand_id` = '" . (int)$brandId . "', `title` = '" . $this->db->escape($description['title']) . "', `content` = '" . $this->db->escape($description['content']) . "'");
				}
			}
		}

		$this->cache->delete('home.brands.' . (int)$this->config->get('config_language_id'));
	}
	public function deleteBrand($brandId)
	{
		$this->db->query("DELETE FROM `" . DB_PREFIX . "brands` WHERE brand_id = '" . (int)$brandId . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "brands_description` WHERE brand_id = '" . (int)$brandId . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "brand_images WHERE brand_id = '" . (int)$brandId . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "brand_image_description WHERE brand_id = '" . (int)$brandId . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "ourmenu_images WHERE brand_id = '" . (int)$brandId . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "ourmenu_image_description WHERE brand_id = '" . (int)$brandId . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "aliases` WHERE slog = 'brands/detail' AND slog_id = '" . (int)$brandId . "'"); 
		$this->cache->delete('home.brands.' . (int)$this->config->get('config_language_id'));
	}
	public function getListBrand($brandId)
	{
		$sql = "SELECT b.* ,a.url as seo_url FROM `" . DB_PREFIX . "brands` b
		LEFT JOIN aliases a ON a.slog_id = b.brand_id AND a.slog='brands/detail' WHERE b.brand_id = " . $brandId;
		$query = $this->db->query($sql);
		return $query->row;
	}
	public function getBrandImages($brandId)
	{
		$brandImageData = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "brand_images WHERE brand_id = '" . (int)$brandId . "' ORDER BY sort_order ASC");
		foreach ($query->rows as $imageDescription) {
			$brandImageData[] = [
				'image'                     => $imageDescription['image'],
				'sort_order'                => $imageDescription['sort_order']
			];
		}
		return $brandImageData;
	}


	public function getBrandMenu($brandId)
	{
		$businessImageData = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ourmenu_images WHERE brand_id = '" . (int)$brandId . "' ORDER BY sort_order ASC");
		foreach ($query->rows as $imageDescription) {
			$description_data = [];

			$description_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "ourmenu_image_description` WHERE `menu_description_id` = '" . (int)$imageDescription['id'] . "'");

			foreach ($description_query->rows as $description) {
				$description_data[$description['lang_id']] = ['title' => $description['title'], 'content' => $description['content']];
			}

			$businessImageData[] = [
				'description' 				=> $description_data,
				'image'                     => $imageDescription['image'],
				'pdf'                       => $imageDescription['pdf'],
				'sort_order'                => $imageDescription['sort_order']
			];
		}
		return $businessImageData;
	}



	public function getBrandDescription($brandId)
	{
		$brands_description = array();
		$sql = "SELECT * FROM `" . DB_PREFIX . "brands_description` WHERE brands_description.brand_id = " . $brandId;
		$query = $this->db->query($sql);
		foreach ($query->rows as $result) {
			$brands_description[$result['lang_id']] = array(
				'name'             => $result['name'],
				'full_description'      => $result['full_description'],
				'meta_keyword'      => $result['meta_keyword'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description']
			);
		}
		return $brands_description;
	}
	public function getListBrands($data)
	{
		$sql = "SELECT bd.*, b.*, ld.title as location_name 
        FROM `brands` b
        LEFT JOIN brands_description bd ON b.brand_id = bd.brand_id
        LEFT JOIN location_description ld ON ld.location_id = b.location_id
        WHERE bd.lang_id = 1 AND ld.lang_id = 1";
		if (isset($data['filter_title']) && ($data['filter_title'] != '')) {
			$sql .= " AND  bd.name LIKE '%" . $data['filter_title'] . "%'";
		}
		$sql .= " ORDER BY b.brand_id";
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " DESC";
		}
		if (isset($data['limit'])) {
			$sql .= " Limit " . $data['limit'];
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}
	public function getBrandsLocation()
	{
				$sql = "SELECT lc.id AS location_id, ld.title AS location_name
				FROM `locations` AS lc
				LEFT JOIN `location_description` AS ld ON lc.id = ld.location_id
				WHERE ld.lang_id = '" . $this->config->get('config_language_id') . "' AND lc.publish = 1
				ORDER BY lc.sort_order ASC";
				$query = $this->db->query($sql);
				return $query->rows;
	}
	public function updateBrandsStatus($brand_id, $status)
	{
		$sql = "UPDATE `" . DB_PREFIX . "brands` SET status = '" . (int)$status . "' WHERE brand_id = '" . (int)$brand_id . "'";
		$this->db->query($sql);
		return true;
	}
}
