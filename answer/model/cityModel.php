<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class cityModel extends spModel
{
    public $pk = 'id';
    public $table = 'city';
    
    
    
    public static function getCity($province_code="")
    {
        
        
        $model = spClass("cityModel");
        $rows = array();
        $list = array();
        if($province_code == "")
        {
            if($_SESSION['ss_city_list'])
            {
                return $_SESSION['ss_city_list'];
            }
            
            $rows = $model->findAll('1=1','code asc');
            if(@count($rows) > 0)
            {
                foreach($rows as $row)
                {
                    $list[$row['code']] = $row['name'];
                }
            }
            $_SESSION['ss_city_list'] = $list;
            return $list;
        }else
        {
            $rows = $model->findAll(array('provincecode'=>$province_code),'code asc');
        }
        
        if(@count($rows) > 0)
        {
            foreach($rows as $row)
            {
                $list[$row['code']] = $row['name'];
            }
        }
        
        return $list;
    }
}
?>
