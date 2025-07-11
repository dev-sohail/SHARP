<?php
class ModelTest extends Model
{
    public function getVideo($video_id)
    {
        $query = "SELECT v.* FROM " . DB_PREFIX . "video1 v WHERE v.video_id = '" . (int)$video_id . "'";
        $query = $this->db->query($query);
        return $query->row;
        // try {
        //     $query = "SELECT resumetime, video_url FROM video1 WHERE video_id = '" . (int)$video_id . "'";
        //     $query = $this->db->query($query);
        //     return $query->row;
        // } catch (Exception $e) {
        //     error_log('ModelTest getVideo error: ' . $e->getMessage());
        //     return false;
        // }
    }

    public function saveResumetime($video_id, $resumetime)
    {
        $query = "UPDATE " . DB_PREFIX . "video1 v SET v.resumetime = '" . (float)$resumetime . "' WHERE v.video_id = '" . (int)$video_id . "'";
        $query = $this->db->query($query);
        return $query->row;
        // try {
        //     $query = "UPDATE video1 SET resumetime = '".(float)$resumetime."' WHERE video_id = '" . (int)$video_id . "'";
        //     $query = $this->db->query($query);
        //     return $query->row;
        // } catch (Exception $e) {
        //     error_log('ModelTest saveResumetime error: ' . $e->getMessage());
        //     return false;
        // }
    }
}
