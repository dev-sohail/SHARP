<?php
class ModelBlogs extends Model
{
	public function addBlog($data)
	{
		$sortOrder = $this->db->escape($data['sort_order']);
		$publish = $this->db->escape($data['publish']);
		$publish_date = $this->db->escape($data['publish_date']);
		$thumb_image = $this->handleUploadedImage($_FILES["thumb_image"]);
		$banner_image = $this->handleUploadedImage($_FILES["banner_image"]);
		$insertblogQuery = "INSERT INTO `" . DB_PREFIX . "blogs` SET 
		publish_date = '" . $publish_date . "', 
		thumb_image = '" . $thumb_image . "', 
		banner_image = '" . $banner_image . "', 
		publish = '" . $publish . "',  
        added_date = NOW(),
		modify_date = NOW(),
		sort_order = '" . $sortOrder . "'";
		$this->db->query($insertblogQuery);
		$blogId = $this->db->getLastId();
		foreach ($data['blog_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$title = $this->db->escape($languageValue['title']);
			$author  = $this->db->escape($languageValue['author']);
			$short_description = $this->db->escape($languageValue['short_description']);
			$description = $this->db->escape($languageValue['description']);
			$meta_keywords = $this->db->escape($languageValue['meta_keywords']);
			$meta_title = $this->db->escape($languageValue['meta_title']);
			$meta_description = $this->db->escape($languageValue['meta_description']);
			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "blog_description SET 
            blog_id = '" . (int)$blogId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
            author = '" . $author  . "',
            short_description = '" . $short_description . "',
            description = '" . $description . "',
            meta_keywords = '" . $meta_keywords . "',
            meta_title = '" . $meta_title . "',
            meta_description = '" . $meta_description . "'";
			$this->db->query($insertDescriptionQuery);
			if ($languageId == 1) {
				$seoTitle = $title;
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
		}
		$this->db->query("INSERT INTO " . DB_PREFIX . "aliases SET slog = 'blogs/detail', url = '" . $this->db->escape($keyword) . "', slog_id = '" . $blogId . "'");
	}
	private function handleUploadedImage($file)
	{
		if (empty($file['name'])) {
			return "";
		}
		$targetDirectory = DIR_IMAGE . "blogs/";
		$filename = time() . ' - ' . rand() . ' - ' . $file["name"];
		$targetFile = $targetDirectory . $filename;
		if (!is_dir($targetDirectory)) {
			mkdir($targetDirectory, 0755, true);
		}
		move_uploaded_file($file["tmp_name"], $targetFile);
		return $this->db->escape($filename);
	}
	public function editBlog($blogId, $data)
	{
		$sortOrder = $this->db->escape($data['sort_order']);
		$publish = $this->db->escape($data['publish']);
		$publish_date = $this->db->escape($data['publish_date']);
		$thumb_image = $this->db->escape($data['thumb_image']);
		if (!empty($_FILES["thumb_image"]["name"])) {
			$this->deleteImage($blogId, 'thumb_image');
			$thumb_image = $this->handleUploadedImage($_FILES["thumb_image"]);
		}
		$banner_image = $this->db->escape($data['banner_image']);
		if (!empty($_FILES["banner_image"]["name"])) {
			$this->deleteImage($blogId, 'banner_image');
			$banner_image = $this->handleUploadedImage($_FILES["banner_image"]);
		}
		$updateFaqQuery = "UPDATE `" . DB_PREFIX . "blogs` SET
		thumb_image = '" . $thumb_image . "', 
		banner_image = '" . $banner_image . "', 
		publish = '" . $publish . "', 
		publish_date = '" . $publish_date . "', 
		sort_order = '" . $sortOrder . "',
		modify_date = NOW()
	    WHERE id = '" . (int)$blogId . "'";
		$this->db->query($updateFaqQuery);
		$deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "blog_description WHERE blog_id = '" . (int)$blogId . "'";
		$this->db->query($deleteDescriptionQuery);
		foreach ($data['blog_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$title = $this->db->escape($languageValue['title']);
			$author = $this->db->escape($languageValue['author']);
			$short_description = $this->db->escape($languageValue['short_description']);
			$description = $this->db->escape($languageValue['description']);
			$meta_keywords = $this->db->escape($languageValue['meta_keywords']);
			$meta_title = $this->db->escape($languageValue['meta_title']);
			$meta_description = $this->db->escape($languageValue['meta_description']);
			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "blog_description SET 
            blog_id = '" . (int)$blogId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
            author = '" . $author  . "',
            short_description = '" . $short_description . "',
            description = '" . $description . "',
            meta_keywords = '" . $meta_keywords . "',
            meta_title = '" . $meta_title . "',
            meta_description = '" . $meta_description . "'";
			$this->db->query($insertDescriptionQuery);
			if ($languageId == 1) {
				$seoTitle = $title;
			}
		}
		$this->load_model('seourl');
		$results = $this->db->query("SELECT * FROM aliases WHERE slog='blogs/detail' AND slog_id='" . $blogId . "'");
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
			$this->db->query("UPDATE aliases SET url='" . $keyword . "' WHERE slog='blogs/detail' AND slog_id='" . $blogId . "'");
		} else {
			$this->db->query("INSERT INTO aliases SET url='" . $keyword . "',slog='blogs/detail',slog_id='" . $blogId . "'");
		}
	}
	public function deleteBlog($id)
	{
		$this->deleteImage($id);
		$this->db->query("DELETE FROM `" . DB_PREFIX . "blog_description` WHERE blog_id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "blogs` WHERE id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "aliases` WHERE slog='blogs/detail' AND  slog_id = '" . (int)$id . "'");
	}
	public function deleteImage($id, $params = '')
	{
		$targetDirectory = DIR_IMAGE . "blogs/";
		$hotelImageData = array();
		$query = $this->db->query("SELECT thumb_image,banner_image FROM " . DB_PREFIX . "blogs WHERE id = '" . (int)$id . "'");
		$image = $query->row;
		if ($params == 'thumb_image') {
			$filePath = $targetDirectory . $image['thumb_image'];
			if (file_exists($filePath)) {
				unlink($filePath);
			}
		} else if ($params == 'banner_image') {
			$filePath = $targetDirectory . $image['banner_image'];
			if (file_exists($filePath)) {
				unlink($filePath);
			}
		} else {
			$filePath = $targetDirectory . $image['thumb_image'];
			if (file_exists($filePath)) {
				unlink($filePath);
			}
			$filePath = $targetDirectory . $image['banner_image'];
			if (file_exists($filePath)) {
				unlink($filePath);
			}
		}
	}
	public function getBlog($id)
	{
		$sql = "SELECT b.* ,a.url as seo_url FROM `" . DB_PREFIX . "blogs` b
		LEFT JOIN aliases a ON a.slog_id = b.id AND a.slog='blogs/detail' 
		WHERE b.id = " . $id;
		$query = $this->db->query($sql);
		return $query->row;
	}
	public function getBlogDescription($id)
	{
		$slider_description_data = array();
		$sql = "SELECT * FROM `" . DB_PREFIX . "blog_description` WHERE blog_description.blog_id = " . $id;
		$query = $this->db->query($sql);
		foreach ($query->rows as $result) {
			$slider_description_data[$result['lang_id']] = array(
				'title'       => $result['title'],
				'author'       => $result['author'],
				'short_description'       => $result['short_description'],
				'description'       => $result['description'],
				'meta_keywords'       => $result['meta_keywords'],
				'meta_title'       => $result['meta_title'],
				'meta_description'       => $result['meta_description']
			);
		}
		return $slider_description_data;
	}
	public function getBlogs($data)
	{
		$sql = "SELECT blog_description.*, blogs.* FROM `blogs` 
		LEFT JOIN blog_description on blogs.id = blog_description.blog_id
		WHERE blog_description.lang_id = 1 ORDER BY blogs.id";
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " DESC";
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}
	public function getTotalBlogs()
	{
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "blogs`");
		return $query->row['total'];
	}

	public function updateBlogsStatus($blog_id, $status)
	{
		$sql = "UPDATE `" . DB_PREFIX . "blogs` SET publish = '" . (int)$status . "' WHERE id = '" . (int)$blog_id . "'";
		$this->db->query($sql);
	}
}
