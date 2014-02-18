<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class areaModel extends spModel
{
    public $pk = 'id';
    public $table = 'area';
    
    
    public static function getArea($city_code="")
    {
        $model = spClass("areaModel");
        $rows = array();
        $list = array();
        if($city_code == "")
        {
            
            if($_SESSION['ss_area_list'])
            {
                return $_SESSION['ss_area_list'];
            }
            $rows = $model->findAll('1=1','code asc');
            
            if(@count($rows) > 0)
            {
                foreach($rows as $row)
                {
                    $list[$row['code']] = $row['name'];
                }
            }
            $_SESSION['ss_area_list'] = $list;
            return $list;
        }else
        {
            $rows = $model->findAll(array('citycode'=>$city_code),'code asc');
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
