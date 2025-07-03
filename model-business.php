<?php
class ModelBusiness extends Model
{
	public function addBusiness($data)
	{

		$uploadedThumbnaileFileName = $this->handleUploadedImage($_FILES["thumbnail"]);
		$uploadedOtherImageFileName = $this->handleUploadedImage($_FILES["other_d_image"]);
		$uploadedStatsSecondFileName = $this->handleUploadedImage($_FILES["stats_scond_image"]);
		$uploadedbImageFileName = $this->handleUploadedImage($_FILES["banner_image"]);
		$uploadedbIconFileName = $this->handleUploadedImage($_FILES["icon"]);
		$publish = (int)$data['publish'];
		$sector_id = (int)$data['sector_id'];
		$website_url = $this->db->escape($data['website_url']);
		$phone = $this->db->escape($data['phone']);
		$email = $this->db->escape($data['email']);
		$address = $this->db->escape($data['address']);
		$iframe_map = $this->db->escape($data['iframe_map']);
		$sortOrder = (int)$data['sort_order'];
		$insertBusinessQuery = "INSERT INTO `" . DB_PREFIX . "business` SET 
        banner_image = '" . $uploadedbImageFileName . "', 
        website_url = '" . $website_url . "', 
        phone = '" . $phone . "', 
        email = '" . $email . "', 
        address = '" . $address . "', 
        sector_id = '" . $sector_id . "', 
		thumbnail = '" . $uploadedThumbnaileFileName . "',
		other_d_image = '" . $uploadedOtherImageFileName . "',
		stats_scond_image = '" . $uploadedStatsSecondFileName . "',
        icon = '" . $uploadedbIconFileName . "', 
        publish = '" . $publish . "',
        iframe_map = '" . $iframe_map . "',
		date_added = NOW(),
		date_modified = NOW(),
        sort_order = '" . $sortOrder . "'";
		$this->db->query($insertBusinessQuery);
		$businessId = $this->db->getLastId();
		foreach ($data['business_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$name = $this->db->escape($languageValue['name']);
			$other_d_title = $this->db->escape($languageValue['other_d_title']);
			$other_d_description = $this->db->escape($languageValue['other_d_description']);
			$detail_second_description = $this->db->escape($languageValue['detail_second_description']);
			$full_description = $this->db->escape($languageValue['full_description']);
			$short_description = $this->db->escape($languageValue['short_description']);
			$meta_title = $this->db->escape($languageValue['meta_title']);
			$meta_keyword = $this->db->escape($languageValue['meta_keyword']);
			$meta_description = $this->db->escape($languageValue['meta_description']);
			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "business_description SET 
            busines_id = '" . (int)$businessId . "',
            lang_id = '" . $languageId . "',
            name = '" . $name . "',
            other_d_title = '" . $other_d_title . "',
            other_d_description = '" . $other_d_description . "',
            detail_second_description = '" . $detail_second_description . "',
            full_description = '" . $full_description . "',
            short_description = '" . $short_description . "',
			meta_title = '" . $meta_title . "',
			meta_keyword = '" . $meta_keyword . "',
            meta_description = '" . $meta_description . "'";
			$this->db->query($insertDescriptionQuery);
		}
		if (isset($data['busines_images'])) {
			foreach ($data['busines_images'] as $busines_images) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "busines_images SET busines_id = '" . (int)$businessId . "', image = '" . $this->db->escape($busines_images['image']) . "', sort_order = '" . (int)$busines_images['sort_order'] . "'");
				$img_description_id = $this->db->getLastId();
				foreach ($busines_images['description'] as $language_id => $description) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "busines_image_description` SET `img_description_id` = '" . (int)$img_description_id . "', `lang_id` = '" . (int)$language_id . "', `busines_id` = '" . (int)$businessId . "', `title` = '" . $this->db->escape($description['title']) . "', `content` = '" . $this->db->escape($description['content']) . "'");
				}
			}
		}

		if (isset($data['busines_icons'])) {
			foreach ($data['busines_icons'] as $busines_icons) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "busines_icons SET busines_id = '" . (int)$businessId . "', image = '" . $this->db->escape($busines_icons['image']) . "', sort_order = '" . (int)$busines_icons['sort_order'] . "'");
				$img_description_id = $this->db->getLastId();
				foreach ($busines_icons['description'] as $language_id => $description) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "busines_icons_description` SET `img_description_id` = '" . (int)$img_description_id . "', `lang_id` = '" . (int)$language_id . "', `busines_id` = '" . (int)$businessId . "', `title` = '" . $this->db->escape($description['title']) . "', `content` = '" . $this->db->escape($description['content']) . "'");
				}
			}
		}

		if (isset($data['business_other_details'])) {
			foreach ($data['business_other_details'] as $business_other_detail) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "business_other_detail SET busines_id = '" . (int)$businessId . "', sort_order = '" . (int)$business_other_detail['sort_order'] . "'");
				$other_detail_id = $this->db->getLastId();
				foreach ($business_other_detail['description'] as $language_id => $description) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "business_other_detail_description` SET `other_detail_id` = '" . (int)$other_detail_id . "', `lang_id` = '" . (int)$language_id . "', `busines_id` = '" . (int)$businessId . "', `title` = '" . $this->db->escape($description['title']) . "', `content` = '" . $this->db->escape($description['content']) . "'");
				}
			}
		}

		$this->cache->delete('home.business.' . (int)$this->config->get('config_language_id'));
	}

	private function handleUploadedImage($file)
	{
		if (empty($file['name'])) {
			return "";
		}
		$targetDirectory = DIR_IMAGE . "business/";
		$originalFileName = pathinfo($file["name"], PATHINFO_FILENAME);
		$fileExtension = pathinfo($file["name"], PATHINFO_EXTENSION);
		$uniqueName = $originalFileName . '_' . date('YmdHis') . '.' . $fileExtension;
		$targetFile = $targetDirectory . $uniqueName;
		if (!is_dir($targetDirectory)) {
			mkdir($targetDirectory, 0755, true);
		}
		move_uploaded_file($file["tmp_name"], $targetFile);
		return $this->db->escape($uniqueName);
	}
	public function editBusiness($businessId, $data)
	{
		$sector_id = (int)$data['sector_id'];
		$publish = (int)$data['publish'];
		$sortOrder = (int)$data['sort_order'];
		$website_url = $this->db->escape($data['website_url']);
		$phone = $this->db->escape($data['phone']);
		$email = $this->db->escape($data['email']);
		$address = $this->db->escape($data['address']);
		$iframe_map = $this->db->escape($data['iframe_map']);
		$thumbnail = $this->db->escape($data['thumbnail']); 
		$other_d_image = $this->db->escape($data['other_d_image']); 
		$stats_scond_image = $this->db->escape($data['stats_scond_image']); 
		$banner_image = $this->db->escape($data['banner_image']); 
		$icon = $this->db->escape($data['icon']); 
		$thumbnail = $this->db->escape($data['thumbnail']);  
		if (!empty($_FILES["thumbnail"]["name"])) {
			$thumbnail = $this->handleUploadedImage($_FILES["thumbnail"]);
		}

		$other_d_image = $this->db->escape($data['other_d_image']);  
		if (!empty($_FILES["other_d_image"]["name"])) {
			$other_d_image = $this->handleUploadedImage($_FILES["other_d_image"]);
		}

		$stats_scond_image = $this->db->escape($data['stats_scond_image']);  
		if (!empty($_FILES["stats_scond_image"]["name"])) {
			$stats_scond_image = $this->handleUploadedImage($_FILES["stats_scond_image"]);
		}

		$banner_image = $this->db->escape($data['banner_image']);  
		if (!empty($_FILES["banner_image"]["name"])) {
			$banner_image = $this->handleUploadedImage($_FILES["banner_image"]);
		}

		$icon = $this->db->escape($data['icon']);  
		if (!empty($_FILES["icon"]["name"])) {
			$icon = $this->handleUploadedImage($_FILES["icon"]);
		}

		$updateBusinessQuery = "UPDATE `" . DB_PREFIX . "business` SET
		publish = '" . $publish . "',
		thumbnail = '" . $thumbnail . "', 
		other_d_image = '" . $other_d_image . "', 
		stats_scond_image = '" . $stats_scond_image . "', 
		banner_image = '" . $banner_image . "', 
		icon = '" . $icon . "', 
		sector_id = '" . $sector_id . "',
		website_url = '" . $website_url . "', 
		phone = '" . $phone . "', 
        email = '" . $email . "', 
        address = '" . $address . "', 
		date_modified = NOW(),
        sort_order = '" . $sortOrder . "',
        iframe_map = '" . $iframe_map . "'
        WHERE busines_id = '" . (int)$businessId . "'";
		$this->db->query($updateBusinessQuery);
		$deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "business_description WHERE busines_id = '" . (int)$businessId . "'";
		$this->db->query($deleteDescriptionQuery);
		foreach ($data['business_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$name = $this->db->escape($languageValue['name']);
			$other_d_title = $this->db->escape($languageValue['other_d_title']);
			$other_d_description = $this->db->escape($languageValue['other_d_description']);
			$detail_second_description = $this->db->escape($languageValue['detail_second_description']);
			$full_description = $this->db->escape($languageValue['full_description']);
			$short_description = $this->db->escape($languageValue['short_description']);
			$meta_title = $this->db->escape($languageValue['meta_title']);
			$meta_keyword = $this->db->escape($languageValue['meta_keyword']);
			$meta_description = $this->db->escape($languageValue['meta_description']);
			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "business_description SET 
            busines_id = '" . (int)$businessId . "',
            lang_id = '" . $languageId . "',
            name = '" . $name . "',
            other_d_title = '" . $other_d_title . "',
            other_d_description = '" . $other_d_description . "',
            detail_second_description = '" . $detail_second_description . "',
            full_description = '" . $full_description . "',
            short_description = '" . $short_description . "',
			meta_title = '" . $meta_title . "',
			meta_keyword = '" . $meta_keyword . "',
			meta_description = '" . $meta_description . "'";
			$this->db->query($insertDescriptionQuery);
			if ($languageId == '1') {
				$seoTitle = $name;
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "busines_images WHERE busines_id = '" . (int)$businessId . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "busines_image_description WHERE busines_id = '" . (int)$businessId . "'");
		if (isset($data['busines_images'])) {
			foreach ($data['busines_images'] as $busines_images) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "busines_images SET busines_id = '" . (int)$businessId . "', image = '" . $this->db->escape($busines_images['image']) . "', sort_order = '" . (int)$busines_images['sort_order'] . "'");
				$img_description_id = $this->db->getLastId();
				foreach ($busines_images['description'] as $language_id => $description) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "busines_image_description` SET `img_description_id` = '" . (int)$img_description_id . "', `lang_id` = '" . (int)$language_id . "', `busines_id` = '" . (int)$businessId . "', `title` = '" . $this->db->escape($description['title']) . "', `content` = '" . $this->db->escape($description['content']) . "'");
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "busines_icons WHERE busines_id = '" . (int)$businessId . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "busines_icons_description WHERE busines_id = '" . (int)$businessId . "'");
		if (isset($data['busines_icons'])) {
			foreach ($data['busines_icons'] as $busines_icons) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "busines_icons SET busines_id = '" . (int)$businessId . "', image = '" . $this->db->escape($busines_icons['image']) . "', sort_order = '" . (int)$busines_icons['sort_order'] . "'");
				$icon_description_id = $this->db->getLastId();
				foreach ($busines_icons['description'] as $language_id => $description) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "busines_icons_description` SET `icon_description_id` = '" . (int)$icon_description_id . "', `lang_id` = '" . (int)$language_id . "', `busines_id` = '" . (int)$businessId . "', `title` = '" . $this->db->escape($description['title']) . "', `content` = '" . $this->db->escape($description['content']) . "'");
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "business_other_detail WHERE busines_id = '" . (int)$businessId . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "business_other_detail_description WHERE busines_id = '" . (int)$businessId . "'");

		if (isset($data['business_other_details'])) {
			foreach ($data['business_other_details'] as $business_other_detail) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "business_other_detail SET busines_id = '" . (int)$businessId . "', sort_order = '" . (int)$business_other_detail['sort_order'] . "'");
				$other_detail_id = $this->db->getLastId();
				foreach ($business_other_detail['description'] as $language_id => $description) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "business_other_detail_description` SET `other_detail_id` = '" . (int)$other_detail_id . "', `lang_id` = '" . (int)$language_id . "', `busines_id` = '" . (int)$businessId . "', `title` = '" . $this->db->escape($description['title']) . "', `content` = '" . $this->db->escape($description['content']) . "'");
				}
			}
		}
		$this->cache->delete('home.business.' . (int)$this->config->get('config_language_id'));
	}
	public function deleteBusiness($businessId)
	{
		$this->db->query("DELETE FROM `" . DB_PREFIX . "business_description` WHERE busines_id = '" . (int)$businessId . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "busines_images WHERE busines_id = '" . (int)$businessId . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "busines_icons WHERE busines_id = '" . (int)$businessId . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "business` WHERE busines_id = '" . (int)$businessId . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "busines_image_description WHERE busines_id = '" . (int)$businessId . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "busines_icons_description WHERE busines_id = '" . (int)$businessId . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "business_other_detail WHERE busines_id = '" . (int)$businessId . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "business_other_detail_description WHERE busines_id = '" . (int)$businessId . "'");
		$this->cache->delete('home.business.' . (int)$this->config->get('config_language_id'));
	}

	public function getListBusiness($businessId)
	{

		$sql = "SELECT b.* FROM `" . DB_PREFIX . "business` b  WHERE b.busines_id = " . $businessId;
		$query = $this->db->query($sql);
		return $query->row;
	}
	public function getBusinessImages($businessId)
	{
		$businessImageData = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "busines_images WHERE busines_id = '" . (int)$businessId . "' ORDER BY sort_order ASC");
		foreach ($query->rows as $imageDescription) {
			$description_data = [];

			$description_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "busines_image_description` WHERE `img_description_id` = '" . (int)$imageDescription['id'] . "'");

			foreach ($description_query->rows as $description) {
				$description_data[$description['lang_id']] = ['title' => $description['title'], 'content' => $description['content']];
			}

			$businessImageData[] = [
				'description' 				=> $description_data,
				'image'                     => $imageDescription['image'],
				'sort_order'                => $imageDescription['sort_order']
			];
		}
		return $businessImageData;
	}

	public function getBusinessIcons($businessId)
	{
		$businessImageData2 = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "busines_icons WHERE busines_id = '" . (int)$businessId . "' ORDER BY sort_order ASC");
		foreach ($query->rows as $imageDescription2) {
			$description_data2 = [];

			$description_query2 = $this->db->query("SELECT * FROM `" . DB_PREFIX . "busines_icons_description` WHERE `icon_description_id` = '" . (int)$imageDescription2['id'] . "'");

			foreach ($description_query2->rows as $description2) {
				$description_data2[$description2['lang_id']] = ['title' => $description2['title'], 'content' => $description2['content']];
			}

			$businessImageData2[] = [
				'description' 				=> $description_data2,
				'image'                     => $imageDescription2['image'],
				'sort_order'                => $imageDescription2['sort_order']
			];
		}
		return $businessImageData2;
	}
	public function getBusinessOtherDetails($businessId)
	{
		$business_other_detail = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "business_other_detail WHERE busines_id = '" . (int)$businessId . "' ORDER BY sort_order ASC");
		foreach ($query->rows as $other_detail_description) {
			$description_data = [];

			$description_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "business_other_detail_description` WHERE `other_detail_id` = '" . (int)$other_detail_description['id'] . "'");

			foreach ($description_query->rows as $description) {
				$description_data[$description['lang_id']] = ['title' => $description['title'], 'content' => $description['content']];
			}

			$business_other_detail[] = [
				'description' 				=> $description_data,
				'sort_order'                => $other_detail_description['sort_order']
			];
		}
		return $business_other_detail;
	}
	public function getBusinessDescription($businessId)
	{
		$business_description_data = array();
		$sql = "SELECT * FROM `" . DB_PREFIX . "business_description` WHERE business_description.busines_id = " . $businessId;
		$query = $this->db->query($sql);
		foreach ($query->rows as $result) {
			$business_description_data[$result['lang_id']] = array(
				'name'             => $result['name'],
				'short_description'      => $result['short_description'],
				'full_description'      => $result['full_description'],
				'other_d_title'      => $result['other_d_title'],
				'other_d_description'      => $result['other_d_description'],
				'detail_second_description'      => $result['detail_second_description'],
				'meta_keyword'      => $result['meta_keyword'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description']
			);
		}
		return $business_description_data;
	}
	public function getListBusinesses($data)
	{
		$sql = "SELECT bd.*, b.*, sd.title as sector_name 
        FROM `business` b
        LEFT JOIN business_description bd ON b.busines_id = bd.busines_id
        LEFT JOIN sectors_description sd ON sd.sector_id = b.sector_id
        WHERE bd.lang_id = 1 AND sd.lang_id = 1";

		if (isset($data['filter_title']) && ($data['filter_title'] != '')) {
			$sql .= " AND  bd.name LIKE '%" . $data['filter_title'] . "%'";
		}
		$sql .= " ORDER BY b.busines_id";
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


	public function getCsectors()
	{
		$sql = "SELECT sectors.id, sectors_description.title 
				FROM `sectors` 
				LEFT JOIN sectors_description ON sectors.id = sectors_description.sector_id
				WHERE sectors_description.lang_id = 1 AND status = 1
				ORDER BY sectors.sort_order ASC";
				$query = $this->db->query($sql);
				return $query->rows;
	}

	public function updateBusinessStatus($busines_id, $status)
	{
		$sql = "UPDATE `" . DB_PREFIX . "business` SET publish = '" . (int)$status . "' WHERE busines_id = '" . (int)$busines_id . "'";
		$this->db->query($sql);
		return true;
	}
}
