<?php
class ModelFooter extends Model
{
    public function getFooterMenu($region)
    {
        $sql = "SELECT m.*, md.* 
                FROM menus AS m
                JOIN menus_description AS md ON m.id = md.menu_id
                WHERE md.lang_id ='" . $this->config->get('config_language_id') . "' AND  m.status = '1' AND m.region ='" . $region . "' 
                ORDER BY m.sort_order ASC;";
                $query = $this->db->query($sql);
                return $query->rows;
      }

    // public function getFooterBusinessesMenu()
    // {
    //     $sql = "SELECT b.*, bd.*
    //             FROM business AS b
    //             JOIN business_description AS bd ON b.busines_id = bd.busines_id
    //             WHERE bd.lang_id ='" . $this->config->get('config_language_id') . "' AND  b.publish = '1' 
    //             GROUP BY b.busines_id
    //             ORDER BY b.sort_order ASC LIMIT 8;";
    //             $query = $this->db->query($sql);
    //             return $query->rows;
    //   }

 }
