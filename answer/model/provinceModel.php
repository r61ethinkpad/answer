<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class provinceModel extends spModel
{
    public $pk = 'id';
    public $table = 'province';
    
    
    public static function getProvince()
    {
        
        if($_SESSION['ss_province_list'])
        {
            return $_SESSION['ss_province_list'];
        }
        
        $model = spClass("provinceModel");
        
        $rows =  $model->findAll('',' code asc');
        
        $list = array();
        
        foreach($rows as $row)
        {
            $list[$row['code']] = $row['name'];
        }
        $_SESSION['ss_province_list'] = $list;
        return $list;
    }
}
?>
