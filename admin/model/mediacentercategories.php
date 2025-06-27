<?php
class ModelMediaCenterCategories extends Model
{
	public function addMediaCenterCategories($data)
	{
		$status = (int)$data['status'];
		$sortOrder = (int)$data['sort_order'];
		$parent_id = (int)$data['parent_id'];
		$insertQuery = "INSERT INTO `" . DB_PREFIX . "media_center_categories` SET 
        publish = '" . $status . "',
        parent_id = '" . $parent_id . "',
		date_added = NOW(),
		date_modified = NOW(),
        sort_order = '" . $sortOrder . "'";

		$this->db->query($insertQuery);
		$mcCategoryId = $this->db->getLastId();


		foreach ($data['mc_categories_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$title = $this->db->escape($languageValue['title']);
			$description = $this->db->escape($languageValue['description']);
			$meta_title = $this->db->escape($languageValue['meta_title']);
			$meta_keyword = $this->db->escape($languageValue['meta_keyword']);
			$meta_description = $this->db->escape($languageValue['meta_description']);


			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "mc_categories_description SET 
            mc_category_id = '" . (int)$mcCategoryId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
            description = '" . $description . "',
			meta_title = '" . $meta_title . "',
			meta_keyword = '" . $meta_keyword . "',
			meta_description = '" . $meta_description . "'";

			$this->db->query($insertDescriptionQuery);
		}


		// MySQL Hierarchical Data Closure Table Pattern
		$level = 0;
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "mc_category_path` WHERE `mc_category_id` = '" . (int)$data['parent_id'] . "' ORDER BY `level` ASC");

		foreach ($query->rows as $result) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "mc_category_path` SET `mc_category_id` = '" . (int)$mcCategoryId . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

			$level++;
		}
		$this->db->query("INSERT INTO `" . DB_PREFIX . "mc_category_path` SET `mc_category_id` = '" . (int)$mcCategoryId . "', `path_id` = '" . (int)$mcCategoryId . "', `level` = '" . (int)$level . "'");
		$this->cache->delete('home.mediacategories');
	}


	public function editMediaCenterCategories($mcCategoryId, $data)
	{


		$status = (int)$data['status'];
		$sortOrder = (int)$data['sort_order'];
		$parent_id = (int)$data['parent_id'];

		$updateCaseStudyQuery = "UPDATE `" . DB_PREFIX . "media_center_categories` SET
		publish = '" . $status . "',
		parent_id = '" . $parent_id . "',
		date_modified = NOW(),
        sort_order = '" . $sortOrder . "'
        WHERE mc_category_id = '" . (int)$mcCategoryId . "'";
		$this->db->query($updateCaseStudyQuery);
		$deleteDescriptionQuery = "DELETE FROM " . DB_PREFIX . "mc_categories_description WHERE mc_category_id = '" . (int)$mcCategoryId . "'";
		$this->db->query($deleteDescriptionQuery);

		foreach ($data['mc_categories_description'] as $languageId => $languageValue) {
			$languageId = (int)$languageId;
			$title = $this->db->escape($languageValue['title']);
			$description = $this->db->escape($languageValue['description']);
			$meta_title = $this->db->escape($languageValue['meta_title']);
			$meta_keyword = $this->db->escape($languageValue['meta_keyword']);
			$meta_description = $this->db->escape($languageValue['meta_description']);



			$insertDescriptionQuery = "INSERT INTO " . DB_PREFIX . "mc_categories_description SET 
            mc_category_id = '" . (int)$mcCategoryId . "',
            lang_id = '" . $languageId . "',
            title = '" . $title . "',
            description = '" . $description . "',
			meta_title = '" . $meta_title . "',
			meta_keyword = '" . $meta_keyword . "',
			meta_description = '" . $meta_description . "'";
			$this->db->query($insertDescriptionQuery);
		}
		// MySQL Hierarchical Data Closure Table Pattern
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "mc_category_path` WHERE `path_id` = '" . (int)$mcCategoryId . "' ORDER BY `level` ASC");

		if ($query->rows) {
			foreach ($query->rows as $category_path) {
				$this->db->query("DELETE FROM `" . DB_PREFIX . "mc_category_path` WHERE `mc_category_id` = '" . (int)$category_path['mc_category_id'] . "' AND `level` < '" . (int)$category_path['level'] . "'");
				
				$path = array();
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "mc_category_path` WHERE `mc_category_id` = '" . $parent_id . "' ORDER BY `level` ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "mc_category_path` WHERE `mc_category_id` = '" . (int)$category_path['mc_category_id'] . "' ORDER BY `level` ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Combine the paths with a new level
				$level = 0;

				foreach ($path as $path_id) {
					$this->db->query("REPLACE INTO `" . DB_PREFIX . "mc_category_path` SET `mc_category_id` = '" . (int)$category_path['mc_category_id'] . "', `path_id` = '" . (int)$path_id . "', `level` = '" . (int)$level . "'");

					$level++;
				}
			}
		} else {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "mc_category_path` WHERE `mc_category_id` = '" . (int)$mcCategoryId . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "mc_category_path` WHERE `mc_category_id` = '" . (int)$data['parent_id'] . "' ORDER BY `level` ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "mc_category_path` SET `mc_category_id` = '" . (int)$mcCategoryId . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "mc_category_path` SET `mc_category_id` = '" . (int)$mcCategoryId . "', `path_id` = '" . (int)$mcCategoryId . "', `level` = '" . (int)$level . "'");
		}

		$this->cache->delete('home.mediacategories');
	}

	public function deleteMediaCenterCategories($mcCategoryId)
	{
		$this->db->query("DELETE FROM `" . DB_PREFIX . "mc_category_path` WHERE `mc_category_id` = '" . (int)$mcCategoryId . "'");

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "mc_category_path` WHERE `path_id` = '" . (int)$mcCategoryId . "'");

		foreach ($query->rows as $result) {
			$this->deleteMediaCenterCategories($result['mc_category_id']);
		}
		$this->db->query("DELETE FROM `" . DB_PREFIX . "mc_categories_description` WHERE mc_category_id = '" . (int)$mcCategoryId . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "media_center_categories` WHERE mc_category_id = '" . (int)$mcCategoryId . "'");
		$this->cache->delete('home.mediacategories');
	}

	public function getMediaCenterCategory(int $mcCategoryId): array
	{
		$query = $this->db->query("SELECT DISTINCT *, (SELECT GROUP_CONCAT(`cd1`.`title` ORDER BY `level` SEPARATOR ' > ') FROM `" . DB_PREFIX . "mc_category_path` `cp` LEFT JOIN `" . DB_PREFIX . "mc_categories_description` `cd1` ON (`cp`.`path_id` = `cd1`.`mc_category_id` AND `cp`.`mc_category_id` != `cp`.`path_id`) WHERE `cp`.`mc_category_id` = `c`.`mc_category_id` AND `cd1`.`lang_id` = '" . (int)$this->config->get('config_language_id') . "' GROUP BY `cp`.`mc_category_id`) AS `path` FROM `" . DB_PREFIX . "media_center_categories` `c` LEFT JOIN `" . DB_PREFIX . "mc_categories_description` `cd2` ON (`c`.`mc_category_id` = `cd2`.`mc_category_id`) WHERE `c`.`mc_category_id` = '" . (int)$mcCategoryId . "' AND `cd2`.`lang_id` = '" . (int)$this->config->get('config_language_id') . "'");
		return $query->row;
	}


	public function getMediaCenterCategoryDescriptions($mcCategoryId)
	{
		$mc_categories_description_data = array();
		$sql = "SELECT * FROM `" . DB_PREFIX . "mc_categories_description` ccd WHERE ccd.mc_category_id = " . $mcCategoryId;
		$query = $this->db->query($sql);
		foreach ($query->rows as $result) {
			$mc_categories_description_data[$result['lang_id']] = array(
				'title'             => $result['title'],
				'description'        => $result['description'],
				'meta_keyword'      => $result['meta_keyword'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description']
			);
		}
		return $mc_categories_description_data;
	}
	public function getMediaCenterCategories($data = array())
	{
		$sql = "SELECT `cp`.`mc_category_id` AS `mc_category_id`, GROUP_CONCAT(`cd1`.`title` ORDER BY `cp`.`level` SEPARATOR ' > ') AS `title`, `c1`.`parent_id`, `c1`.`sort_order`, `c1`.`publish` FROM `" . DB_PREFIX . "mc_category_path` `cp` LEFT JOIN `" . DB_PREFIX . "media_center_categories` `c1` ON (`cp`.`mc_category_id` = `c1`.`mc_category_id`) LEFT JOIN `" . DB_PREFIX . "media_center_categories` `c2` ON (`cp`.`path_id` = `c2`.`mc_category_id`) LEFT JOIN `" . DB_PREFIX . "mc_categories_description` `cd1` ON (`cp`.`path_id` = `cd1`.`mc_category_id`) LEFT JOIN `" . DB_PREFIX . "mc_categories_description` `cd2` ON (`cp`.`mc_category_id` = `cd2`.`mc_category_id`) WHERE `cd1`.`lang_id` = '" . (int)$this->config->get('config_language_id') . "' AND `cd2`.`lang_id` = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_title'])) {
			$sql .= " AND `cd2`.`title` LIKE '" . $this->db->escape('%' . $data['filter_title'] . '%') . "'";
		}

		$sql .= " GROUP BY `cp`.`mc_category_id`";

		
		$sql .= " ORDER BY `c1`.`mc_category_id`";
		

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " DESC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getPath(int $mc_category_id): array
	{
		$query = $this->db->query("SELECT `mc_category_id`, `path_id`, `level` FROM `" . DB_PREFIX . "mc_category_path` WHERE `mc_category_id` = '" . (int)$mc_category_id . "'");

		return $query->rows;
	}


	public function updateMediaCategoryStatus($mc_category_id, $publish)
	{
		$sql = "UPDATE `" . DB_PREFIX . "media_center_categories` SET publish = '" . (int)$publish . "' WHERE mc_category_id = '" . (int)$mc_category_id . "'";
        $this->db->query($sql);
        return true;
	}
}
