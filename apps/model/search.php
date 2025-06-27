<?php
class ModelSearch extends Model
{

    public function getSearch($s = "", $data = array())
    {


        $sql = "SELECT AllData.* 
        FROM (
            SELECT al.url ,pt.program_id as id,cat.title AS category_title,pt.title,pt.short_description
            FROM ptprograms AS pt 
            LEFT JOIN category AS cat ON pt.category_id = cat.category_id 
            LEFT JOIN (SELECT program_id, SUM(quantity) AS quantity FROM booking GROUP BY program_id) AS b 
            ON pt.program_id = b.program_id 
            LEFT  JOIN aliases AS al ON al.slog_id = pt.program_id AND al.slog ='ptprograms' 
            WHERE pt.publish = '1'
            UNION
            SELECT al.url , b.id as id,bcat.title AS category_title,bdesc.title,bdesc.short_description
            FROM blog AS b 
            LEFT JOIN blog_category AS bcat ON b.category = bcat.ID 
            LEFT JOIN blog_description AS bdesc ON bdesc.id = bdesc.blog_id 
            LEFT  JOIN aliases AS al ON al.slog_id = b.id AND al.slog in('news-agency','pages')
            WHERE b.publish = '1') as AllData  
            WHERE  AllData.title LIKE '%$s%' OR AllData.short_description LIKE '$s%'";
       $sql .= " GROUP BY AllData.url ORDER BY AllData.Title";
       
        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 3;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }


       

        $query = $this->db->query($sql);
        //dump($query->rows);

        return $query->rows;
    }


    public function getSearchTotal($s = "")
    {


        $sql = "SELECT AllData.* 
        FROM (
            SELECT al.url ,pt.program_id as id,cat.title AS category_title,pt.title,pt.short_description
            FROM ptprograms AS pt 
            LEFT JOIN category AS cat ON pt.category_id = cat.category_id  
            LEFT JOIN (SELECT program_id, SUM(quantity) AS quantity FROM booking GROUP BY program_id) AS b 
            ON pt.program_id = b.program_id 
            LEFT  JOIN aliases AS al ON al.slog_id = pt.program_id AND al.slog ='ptprograms' 
            WHERE pt.publish = '1'
            UNION
            SELECT al.url , b.id as id,bcat.title AS category_title,bdesc.title,bdesc.short_description
            FROM blog AS b 
            LEFT JOIN blog_category AS bcat ON b.category = bcat.ID 
            LEFT JOIN blog_description AS bdesc ON bdesc.id = bdesc.blog_id 
            LEFT  JOIN aliases AS al ON al.slog_id = b.id AND al.slog in('news-agency','pages')
            WHERE b.publish = '1') as AllData  
            WHERE  AllData.title LIKE '%$s%' OR AllData.short_description LIKE '$s%'";
            $sql .= " GROUP BY AllData.url ORDER BY AllData.Title";


       

        $query = $this->db->query($sql);
        
        $data['total']= count($query->rows);
        

        return $data;
    }
}
