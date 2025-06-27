<?php
class ModelBanner extends Model
{
	public function addBanner($data)
	{
		$defaultImageFileName = "no_image-100x100.png";
		$uploadedImageFileName = $defaultImageFileName;

		if (!empty($_FILES["image"]["name"])) {
			$targetDirectory = DIR_IMAGE . "banner/";
			$targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
			if (!is_dir($targetDirectory)) {
				mkdir($targetDirectory, 0755);
			}
			move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
			$uploadedImageFileName = $this->db->escape($_FILES["image"]["name"]);
		}
		$status = (int)$data['status'];
		$sortOrder = (int)$data['sort_order'];
		$url = $this->db->escape($data['url']);
		$insertQuery = "INSERT INTO `" . DB_PREFIX . "banner` SET 
        image = '" . $uploadedImageFileName . "', 
        url = '" . $url . "', 
        status = '" . $status . "',
		date_added = NOW(),
		date_modified = NOW(),
        sort_order = '" . $sortOrder . "'";
		$this->db->query($insertQuery);
		$banner_id = $this->db->getLastId();
		foreach ($data['banner_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$title = $this->db->escape($languageValue['title']);
			$name = $this->db->escape($languageValue['title']);
			$description = $this->db->escape($languageValue['description']);
			$meta_title = $this->db->escape($languageValue['meta_title']);
			$meta_keyword = $this->db->escape($languageValue['meta_keyword']);
			$meta_description = $this->db->escape($languageValue['meta_description']);

			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "banner_description SET 
            banner_id = '" . (int)$banner_id . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
            name = '" . $name . "',
			meta_title = '" . $meta_title . "',
			meta_keyword = '" . $meta_keyword . "',
			meta_description = '" . $meta_description . "',
            description = '" . $description . "'";
			$this->db->query($insertDescriptionQuery);
		}
	}
	public function editBanner($banner_id, $data)
	{
		$targetDirectory = DIR_IMAGE . "banner/";
		$imageFileName = '';
		if (!empty($_FILES["image"]["name"])) {
			$imageFileName = $_FILES["image"]["name"];
			$targetFile = $targetDirectory . basename($imageFileName);
			move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
			$imageFileName = $this->db->escape($imageFileName);
		}
		if (!empty($imageFileName)) {
			$updateImageQuery = "UPDATE `" . DB_PREFIX . "banner` SET 
            image = '" . $imageFileName . "' 
            WHERE banner_id = '" . (int)$banner_id . "'";
			$this->db->query($updateImageQuery);
		}
		$status = (int)$data['status'];
		$sortOrder = (int)$data['sort_order'];
		$url = $this->db->escape($data['url']);
		$updateQuery = "UPDATE `" . DB_PREFIX . "banner` SET
        status = '" . $status . "',
		url = '" . $url . "',
		date_modified = NOW(),
        sort_order = '" . $sortOrder . "'
        WHERE banner_id = '" . (int)$banner_id . "'";
		$this->db->query($updateQuery);
		$deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "banner_description WHERE banner_id = '" . (int)$banner_id . "'";
		$this->db->query($deleteDescriptionQuery);
		foreach ($data['banner_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$title = $this->db->escape($languageValue['title']);
			$meta_title = $this->db->escape($languageValue['meta_title']);
			$meta_keyword = $this->db->escape($languageValue['meta_keyword']);
			$meta_description = $this->db->escape($languageValue['meta_description']);
			$name = $this->db->escape($languageValue['title']);
			$description = $this->db->escape($languageValue['description']);
			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "banner_description SET 
            banner_id = '" . (int)$banner_id . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
			name = '" . $name . "',
			meta_title = '" . $meta_title . "',
			meta_keyword = '" . $meta_keyword . "',
			meta_description = '" . $meta_description . "',
            description = '" . $description . "'";
			$this->db->query($insertDescriptionQuery);
		}
	}
	public function deleteBanner($id)
	{
		$this->db->query("DELETE FROM `" . DB_PREFIX . "banner_description` WHERE banner_id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "banner` WHERE banner_id = '" . (int)$id . "'");
	}
	public function getBanner($id)
	{
		$sql = "SELECT * FROM `" . DB_PREFIX . "banner` WHERE banner_id = " . $id;
		$query = $this->db->query($sql);
		return $query->row;
	}



	public function getBannerDescriptions($id)
	{
		$banner_description_data = array();
		$sql = "SELECT * FROM `" . DB_PREFIX . "banner_description` WHERE banner_description.banner_id = " . $id;
		$query = $this->db->query($sql);
		foreach ($query->rows as $result) {
			$banner_description_data[$result['lang_id']] = array(
				'title'             => $result['title'],
		        'meta_title'        => $result['meta_title'],
				'meta_keyword'      => $result['meta_keyword'],
				'meta_description'  => $result['meta_description'],
				'description'       => $result['description']
			);
		}
		return $banner_description_data;
	}
	public function getBanners($data)
	{
		 $sql = "SELECT banner_description.*, banner.* FROM `banner` 
				LEFT JOIN banner_description on banner.banner_id = banner_description.banner_id
				WHERE banner_description.lang_id = 1 ORDER BY banner.banner_id";
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " DESC";
		}

		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function updateBannerStatus($id, $status) {
		$this->db->query("UPDATE " . DB_PREFIX . "banner SET status = '" . (int)$status . "' WHERE banner_id = '" . (int)$id . "'");
	}
	
}
