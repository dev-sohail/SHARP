<?php

class ModelCareers extends Model
{
    public function getCareers($data = array())
    {
        $sql = "SELECT c.*, cd.*, dd.title as department_name, a.url as seo_url, ld.title as location_title, cd.title as career_title 
                FROM careers c 
                LEFT JOIN `" . DB_PREFIX . "aliases` a ON a.slog_id = c.id AND a.slog = 'careers/detail'
                LEFT JOIN career_description cd ON cd.career_id = c.id AND cd.lang_id = '" . $this->config->get('config_language_id') . "'
                LEFT JOIN locations l ON FIND_IN_SET(l.id, c.location_id) AND l.publish = 1
                LEFT JOIN location_description ld ON ld.location_id = l.id AND ld.lang_id = '" . $this->config->get('config_language_id') . "'
                LEFT JOIN departments d ON FIND_IN_SET(d.id, c.department_id) 
                LEFT JOIN departments_description dd ON dd.department_id = d.id AND dd.lang_id = '" . $this->config->get('config_language_id') . "'
                WHERE c.publish = '1' AND cd.lang_id = '" . $this->config->get('config_language_id') . "'";

        if (!empty($data['filter_department'])) {
            $sql .= " AND FIND_IN_SET('" . (int)$data['filter_department'] . "', c.department_id)";
        }

        if (!empty($data['filter_location'])) {
            $sql .= " AND FIND_IN_SET('" . (int)$data['filter_location'] . "', c.location_id)";
        }

        if (!empty($data['filter_title'])) {
            $sql .= " AND cd.title LIKE '" . $this->db->escape('%' . $data['filter_title'] . '%') . "'";
        }
        $sql .= " GROUP BY c.id";
        $sql .= " ORDER BY c.sort_order ASC, c.id DESC";
        if (isset($data['start']) || isset($data['limit'])) {
            $sql .= " LIMIT " . (int)$data['start'] . ", " . (int)$data['limit'];
        }
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getTotalCareers($data)
    {
        $sql = "SELECT COUNT(DISTINCT c.id) AS total 
                FROM careers c 
                LEFT JOIN `" . DB_PREFIX . "aliases` a ON a.slog_id = c.id AND a.slog = 'careers/detail'
                LEFT JOIN career_description cd ON cd.career_id = c.id AND cd.lang_id = '" . $this->config->get('config_language_id') . "'
                LEFT JOIN locations l ON FIND_IN_SET(l.id, c.location_id) AND l.publish = 1
                LEFT JOIN location_description ld ON ld.location_id = l.id AND ld.lang_id = '" . $this->config->get('config_language_id') . "'
                LEFT JOIN departments d ON FIND_IN_SET(d.id, c.department_id)
                LEFT JOIN departments_description dd ON dd.department_id = d.id AND dd.lang_id = '" . $this->config->get('config_language_id') . "'
                WHERE c.publish = '1' AND cd.lang_id = '" . $this->config->get('config_language_id') . "'";

        if (!empty($data['filter_department'])) {
            $sql .= " AND FIND_IN_SET('" . (int)$data['filter_department'] . "', c.department_id)";
        }
        if (!empty($data['filter_location'])) {
            $sql .= " AND FIND_IN_SET('" . (int)$data['filter_location'] . "', c.location_id)";
        }
        if (!empty($data['filter_title'])) {
            $sql .= " AND cd.title LIKE '" . $this->db->escape('%' . $data['filter_title'] . '%') . "'";
        }
        $query = $this->db->query($sql);
        return $query->row['total'];
    }

    public function getCareerDetails($careerId)
    {
        $sql = "SELECT c.*,cd.*, a.url as seo_url ,ld.title as location_title, dd.title as department_name FROM careers c 
        LEFT JOIN `" . DB_PREFIX . "aliases`a ON a.slog_id = c.id AND a.slog = 'careers/detail'
        LEFT JOIN career_description cd ON cd.career_id = c.id AND cd.lang_id = '" . $this->config->get('config_language_id') . "'
        LEFT JOIN locations l ON FIND_IN_SET(l.id, c.location_id) AND l.publish = 1
        LEFT JOIN location_description ld ON ld.location_id =l.id AND ld.lang_id = '" . $this->config->get('config_language_id') . "'
        LEFT JOIN departments d ON FIND_IN_SET(d.id, c.department_id) 
        LEFT JOIN departments_description dd ON dd.department_id =d.id AND dd.lang_id = '" . $this->config->get('config_language_id') . "'
        WHERE c.publish = '1' AND cd.lang_id = '" . $this->config->get('config_language_id') . "' AND c.id='" . $careerId . "'";
        $query = $this->db->query($sql);
        $result = $query->row;
        return $result;
    }
    public function getRelatedCareer($careerId)
    {
        $sql = "SELECT c.*,cd.*, a.url as seo_url ,ld.title as location_title FROM careers c 
        LEFT JOIN `" . DB_PREFIX . "aliases`a ON a.slog_id = c.id AND a.slog = 'careers/detail'
        LEFT JOIN career_description cd ON cd.career_id = c.id AND cd.lang_id = '" . $this->config->get('config_language_id') . "'
        LEFT JOIN locations l ON FIND_IN_SET(l.id, c.location_id) 
        LEFT JOIN location_description ld ON ld.location_id =l.id AND ld.lang_id = '" . $this->config->get('config_language_id') . "'
        LEFT JOIN departments d ON FIND_IN_SET(d.id, c.department_id) 
        LEFT JOIN departments_description dd ON dd.department_id =d.id AND dd.lang_id = '" . $this->config->get('config_language_id') . "'
        WHERE c.publish = '1' AND cd.lang_id = '" . $this->config->get('config_language_id') . "'";
        if ($careerId) {
            $sql .= " AND  c.id != '" . (int)$careerId . "'";
        }
        $sql .= " GROUP BY c.id";
        $sql .= " ORDER BY c.sort_order, c.id DESC";
        $query = $this->db->query($sql);
        $careers = $query->rows;
        return $careers;
    }

    public function getLocations()
    {
                $sql = "SELECT * FROM `" . DB_PREFIX . "locations` l
                LEFT JOIN `" . DB_PREFIX . "location_description` ld 
                ON ld.location_id = l.id 
                WHERE l.publish = '1' 
                AND ld.lang_id = '" . $this->config->get('config_language_id') . "'
                ORDER BY l.sort_order ASC";
                $query = $this->db->query($sql);
                return $query->rows;
    } 
    

    public function addCareerEnquiry($data)
    {
        $subject = $this->db->escape($data['subject']);
        $name = $this->db->escape($data['name']);
        $email = $this->db->escape($data['email']);
        $phone = $this->db->escape($data['phone']);
        $career_id = $this->db->escape($data['career_id']);
        $address = $this->db->escape($data['address']);
        $nationality = $this->db->escape($data['nationality']);
        $position = $this->db->escape($data['position']);
        $enquiry_from = $this->db->escape($data['enquiry_from']);
        $cv_file = $this->handleUploadedImage($_FILES["cv_file"]);
        $insertSliderQuery = "INSERT INTO `" . DB_PREFIX . "career_inquiries` SET 
		career_id = '" . $career_id . "', 
		name = '" . $name . "', 
		email = '" . $email . "', 
		phone = '" . $phone . "', 
		subject = '" . $subject . "', 
		address = '" . $address . "', 
		nationality = '" . $nationality . "', 
		position = '" . $position . "', 
		cv_file = '" . $cv_file . "', 
		enquiry_from = '" . $enquiry_from . "',
        date_added = NOW()";
        $this->db->query($insertSliderQuery);
        return $cv_file;
    }
    private function handleUploadedImage($file)
    {
        if (empty($file['name'])) {
            return "";
        }
        $targetDirectory = DIR_IMAGE . "careers/cvs/";
        $filename = time() . rand() . $file["name"];
        $targetFile = $targetDirectory . $filename;
        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }
        move_uploaded_file($file["tmp_name"], $targetFile);
        return $this->db->escape($filename);
    }
}