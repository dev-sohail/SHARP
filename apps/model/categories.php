<?php

class ModelCategories extends Model
{
    public function getCategories($data = array())
    {
        $sql = "
        SELECT 
            cp.category_id AS category_id,
            cd1.title AS title, 
            cd1.short_description as description,
            cd1.meta_description as meta_description,
            a.url as seo_url,
            c1.parent_id,
            c1.sort_order,
            c1.image,
            c1.status
        FROM 
            `" . DB_PREFIX . "category_path` cp
        LEFT JOIN 
            `" . DB_PREFIX . "category` c1 
            ON cp.category_id = c1.category_id
        LEFT JOIN 
            `" . DB_PREFIX . "category` c2 
            ON cp.path_id = c2.category_id
        LEFT JOIN 
            `" . DB_PREFIX . "aliases` a 
            ON a.slog_id = cp.category_id
        LEFT JOIN 
            `" . DB_PREFIX . "category_description` cd1 
            ON cp.path_id = cd1.category_id
        LEFT JOIN 
            `" . DB_PREFIX . "category_description` cd2 
            ON cp.category_id = cd2.category_id
        WHERE 
            cd1.lang_id = '" . (int)$this->config->get('config_language_id') . "'
            AND cd2.lang_id = '" . (int)$this->config->get('config_language_id') . "'
        ";
        if (!empty($data['filter_title'])) {
            $sql .= " AND `cd2`.`title` LIKE '" . $this->db->escape('%' . $data['filter_title'] . '%') . "'";
        }
        
        // $sql .= "";
        $sql .= " GROUP BY `c1`.`category_id`";

        $sql .= " ORDER BY `c1`.`category_id`";

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

    public function getCategory($categoryId)
    {
        $sql = "SELECT 
            c.*, 
            cd.*, 
            a.url AS seo_url,
            (SELECT GROUP_CONCAT(`cd1`.`title` ORDER BY `level` SEPARATOR ' > ') 
                FROM `" . DB_PREFIX . "category_path` `cp` 
                LEFT JOIN `" . DB_PREFIX . "category_description` `cd1` ON (`cp`.`path_id` = `cd1`.`category_id`)
                WHERE `cp`.`category_id` = `c`.`category_id` AND `cd1`.`lang_id` = '" . (int)$this->config->get('config_language_id') . "' 
                GROUP BY `cp`.`category_id`) AS `path`
            FROM `" . DB_PREFIX . "category` c
            LEFT JOIN `" . DB_PREFIX . "aliases` a 
            ON a.slog_id = c.category_id 
            AND a.slog = 'category_id=" . (int)$categoryId . "'
            LEFT JOIN `" . DB_PREFIX . "category_description` cd 
            ON cd.category_id = c.category_id 
            AND cd.lang_id = '" . (int)$this->config->get('config_language_id') . "'
            WHERE 
            c.status = '1' 
            AND cd.lang_id = '" . (int)$this->config->get('config_language_id') . "'
            AND c.category_id = '" . (int)$categoryId . "'";

        $query = $this->db->query($sql);
        return $query->row;
    }

    public function getSubCategories($parentId = 0)
    {
        $sql = "SELECT 
            c.*, 
            cd.*, 
            a.url AS seo_url, 
            cd.title AS category_title
            FROM `" . DB_PREFIX . "category` c
            LEFT JOIN `" . DB_PREFIX . "aliases` a 
            ON a.slog_id = c.category_id 
            AND a.slog = 'category_id=" . (int)$categoryId . "'
            LEFT JOIN `" . DB_PREFIX . "category_description` cd 
            ON cd.category_id = c.category_id 
            AND cd.lang_id = '" . (int)$this->config->get('config_language_id') . "'
            WHERE 
            c.status = '1' 
            AND cd.lang_id = '" . (int)$this->config->get('config_language_id') . "'
            AND c.parent_id = '" . (int)$parentId . "'
            ORDER BY c.sort_order ASC, c.category_id DESC";

        $query = $this->db->query($sql);
        return $query->rows;
    }
    public function getSubCategory($categoryId)
    {
        return $this->getCategory($categoryId);
    }
}
