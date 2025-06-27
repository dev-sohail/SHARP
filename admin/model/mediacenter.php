<?php
class ModelMediaCenter extends Model
{
	public function addMediaCenter($data)
	{
		$uploadedbanner_image = $this->handleUploadedImage($_FILES["banner_image"]);
		$uploadedthumbnail_image = $this->handleUploadedImage($_FILES["thumbnail"]);
		$status = (int)$data['status'];
		$publish_date = $this->db->escape($data['publish_date']);
		$sortOrder = (int)$data['sort_order'];
		$insertQuery = "INSERT INTO `" . DB_PREFIX . "media_center` SET 
        banner_image = '" . $uploadedbanner_image . "', 
        thumbnail = '" . $uploadedthumbnail_image . "', 
        publish = '" . $status . "',
        publish_date = '" . $publish_date . "',
		date_added = NOW(),
		date_modified = NOW(),
        sort_order = '" . $sortOrder . "'";
		$this->db->query($insertQuery);
		$mediaCenterId = $this->db->getLastId();
		foreach ($data['media_center_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$title = $this->db->escape($languageValue['title']);
			$description = $this->db->escape($languageValue['description']);
			$short_description = $this->db->escape($languageValue['short_description']);
			$meta_title = $this->db->escape($languageValue['meta_title']);
			$meta_keyword = $this->db->escape($languageValue['meta_keyword']);
			$meta_description = $this->db->escape($languageValue['meta_description']);
			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "media_center_description SET 
            media_center_id = '" . (int)$mediaCenterId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
            short_description = '" . $short_description . "',
			meta_title = '" . $meta_title . "',
			meta_keyword = '" . $meta_keyword . "',
			meta_description = '" . $meta_description . "',
			description = '" . $description . "'";
			$this->db->query($insertDescriptionQuery);
			if ($languageId == '1') {
				$seoTitle = $title;
			}
		}
		$this->load_model('seourl');
		$seourl = trim($data['seo_url']);
		if ($seourl) {
			$keyword = $this->model_seourl->seoUrl($seourl);
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
		$this->db->query("INSERT INTO " . DB_PREFIX . "aliases SET slog = 'mediacenter/detail', url = '" . $this->db->escape($keyword) . "', slog_id = '" . $mediaCenterId . "'");
	 	$this->cache->delete('home.media_center_data');
	 	return $mediaCenterId;
	 }
	 private function handleUploadedImage($file)
	 {
		 if (empty($file['name'])) {
			 return "";
		 }
		 $targetDirectory = DIR_IMAGE . "mediacenter/";
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
	public function editMediaCenter($media_center_id, $data)
	{
		if (!empty($_FILES["banner_image"]["name"])) {
			$banner_image = $this->handleUploadedImage($_FILES["banner_image"]);
			$updateQuery = "UPDATE `" . DB_PREFIX . "media_center` SET
			banner_image = '" . $banner_image . "'
			WHERE media_center_id = '" . (int)$media_center_id . "'";
			$this->db->query($updateQuery);
		}
		if (!empty($_FILES["thumbnail"]["name"])) {
			$thumbnail = $this->handleUploadedImage($_FILES["thumbnail"]);
			$updateQuery = "UPDATE `" . DB_PREFIX . "media_center` SET thumbnail = '" . $thumbnail . "' 
			WHERE media_center_id = '" . (int)$media_center_id . "'";
			$this->db->query($updateQuery);
		}
		$status = (int)$data['status'];
		$sortOrder = (int)$data['sort_order'];
		$publish_date = $this->db->escape($data['publish_date']);
		$updateQuery = "UPDATE `" . DB_PREFIX . "media_center` SET
		publish = '" . $status . "', 
		date_modified = NOW(),
		publish_date = '" . $publish_date . "',
        sort_order = '" . $sortOrder . "'
        WHERE media_center_id = '" . (int)$media_center_id . "'";
		$this->db->query($updateQuery);
		$deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "media_center_description WHERE media_center_id = '" . (int)$media_center_id . "'";
		$this->db->query($deleteDescriptionQuery);
		foreach ($data['media_center_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$title = $this->db->escape($languageValue['title']);
			$description = $this->db->escape($languageValue['description']);
			$short_description = $this->db->escape($languageValue['short_description']);
			$meta_title = $this->db->escape($languageValue['meta_title']);
			$meta_keyword = $this->db->escape($languageValue['meta_keyword']);
			$meta_description = $this->db->escape($languageValue['meta_description']);
			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "media_center_description SET 
            media_center_id = '" . (int)$media_center_id . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
            short_description = '" . $short_description . "',
			meta_title = '" . $meta_title . "',
			meta_keyword = '" . $meta_keyword . "',
			meta_description = '" . $meta_description . "',
            description = '" . $description . "'";
			$this->db->query($insertDescriptionQuery);
			if ($languageId == '1') {
				$seoTitle = $title;
			}
		}
		$this->load_model('seourl');
		$seourl = trim($data['seo_url']);
		$results = $this->db->query("SELECT * FROM aliases WHERE slog='mediacenter/detail' AND slog_id='" . $media_center_id . "'");
		if ($seourl) {
			$keyword = $this->model_seourl->seoUrl($seourl);
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
			$this->db->query("UPDATE aliases SET url='" . $keyword . "' WHERE slog='mediacenter/detail' AND slog_id='" . $media_center_id . "'");
		} else {
			$this->db->query("INSERT INTO aliases SET url='" . $keyword . "',slog='mediacenter/detail',slog_id='" . $media_center_id . "'");
		}
		$this->cache->delete('home.media_center_data');
	}

	public function deleteMediaCenter($media_center_id)
	{
		$this->db->query("DELETE FROM `" . DB_PREFIX . "media_center_description` WHERE media_center_id = '" . (int)$media_center_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "media_center` WHERE media_center_id = '" . (int)$media_center_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "aliases WHERE slog='mediacenter/detail' AND slog_id = '" . (int)$media_center_id . "'");
		$this->cache->delete('home.media_center_data');
	}
	public function getMediaCenter($media_center_id)
	{
		$sql = "SELECT mc.*,a.url as seo_url,a.slog_id FROM `" . DB_PREFIX . "media_center` mc LEFT JOIN aliases a ON a.slog_id = mc.media_center_id AND a.slog = 'mediacenter/detail' WHERE mc.media_center_id = " . $media_center_id;
		$query = $this->db->query($sql);
		return $query->row;
	}
	public function getMediaCenterDescriptions($media_center_id)
	{
		$media_center_description_data = array();
		$sql = "SELECT * FROM `" . DB_PREFIX . "media_center_description` mcd WHERE mcd.media_center_id = " . $media_center_id;
		$query = $this->db->query($sql);
		foreach ($query->rows as $result) {
			$media_center_description_data[$result['lang_id']] = array(
				'title'             		=> $result['title'],
				'short_description'      	=> $result['short_description'],
				'description'     	=> $result['description'],
				'meta_keyword'      		=> $result['meta_keyword'],
				'meta_title'       			=> $result['meta_title'],
				'meta_description' 			=> $result['meta_description']
			);
		}
		return $media_center_description_data;
	}
	public function getMediaCenters($data)
	{
		$sql = "SELECT mcd.*, mc .* FROM `media_center` mc
				LEFT JOIN media_center_description mcd ON mc.media_center_id = mcd.media_center_id
				WHERE mcd.lang_id = 1 ORDER BY mc.media_center_id";
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " DESC";
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function updateMediaCenterStatus($media_center_id, $publish)
	{
		$sql = "UPDATE `" . DB_PREFIX . "media_center` SET publish = '" . (int)$publish . "' WHERE media_center_id = '" . (int)$media_center_id . "'";
        $this->db->query($sql);
        return true;
	}
}
