<?php
class ModelContact extends Model
{


    public function addContact($data)
    {
        $sql = "INSERT INTO " . DB_PREFIX . " enquiries SET 
        first_name ='" . $this->db->escape($data["first_name"]) . "', 
        last_name ='" . $this->db->escape($data["last_name"]) . "', 
        email ='" . $this->db->escape($data["email"]) . "',
        phone ='" . $this->db->escape($data["phone"]) . "',
        message='" . $this->db->escape($data["message"]) . "',	
        enquiry_from ='" . $this->db->escape($data["enquiry_from"]) . "',	
        enquiry_date=NOW()";
        $result =  $this->db->query($sql);
        return $result;
    }

}
