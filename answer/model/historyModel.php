<?php

if (!defined('TBOWCARDUP')) {
    exit(1);
}

/**
 * 病史model
 * @author guohao
 */
class historyModel extends spModel {

    public $pk = 'history_id';
    public $table = 'pest_history';

    const HISTORY_LEVEL_LIGHT = '00';
    const HISTORY_LEVEL_MIDDLE = '01';
    const HISTORY_LEVEL_HARD = '02';

    //新建的验证规则
    var $verifier = array(
        "rules" => array(
            'pest_name' => array(//
                'notnull' => TRUE, // uname不能为空
            ),
            'pest_id' => array(
                'notnull' => TRUE,
            ),
            'year' => array(
                'notnull' => TRUE,
            ),
            'province_code' => array(
                'notnull' => TRUE,
            ),
            'level_code' => array(
                'notnull' => TRUE,
            ),
        ),
        "messages" => array(// 提示信息
            'pest_name' => array(
                'notnull' => "病害名称不能为空",
            ),
            'pest_id' => array(
                'notnull' => '病害编号不能为空',
            ),
            'year' => array(
                'notnull' => '所属年份不能为空',
            ),
            'province_code' => array(
                'notnull' => '所属省份不能为空',
            ),
            'level_code' => array(
                'notnull' => '受灾程度不能为空',
            ),
        )
    );

    public static function queryList($args = array()) {
        //dump($args);exit;
        $rs = array(
            'rows' => array(),
            '_pg_' => array()
        );
        $rs['status'] = 0;
        $rs['desc'] = "ok";

        if (@count($args) == 0) {
            return $rs;
        }
        $params = array();

        $condition = "";
        $crop_id = $GLOBALS['sysparams']['crop_id'];
        $condition = " crop_id='".$crop_id."' ";

        if ($args['year'] != "" && $args['year'] != null) {
            if ($condition != "")
                $condition .= " AND ";
            $condition .= "  year = '" . $args['year'] . "'";
        }

        if ($args['province_code'] != "" && $args['province_code'] != null) {
            if ($condition != "")
                $condition .= " AND ";
            $condition .= "  province_code = '" . $args['province_code'] . "'";
        }

        if ($args['area_code'] != "" && $args['area_code'] != null) {
            if ($condition != "")
                $condition .= " AND ";
            $condition .= "  area_code = '" . $args['area_code'] . "'";
        }

        if ($args['pest_id'] != "" && $args['pest_id'] != null) {
            if ($condition != "")
                $condition .= " AND ";
            $condition .= "  pest_id = '" . $args['pest_id'] . "'";
        }

        if ($args['level_code'] != "" && $args['level_code'] != null) {
            if ($condition != "")
                $condition .= " AND ";
            $condition .= "  area_code = '" . $args['area_code'] . "'";
        }

        if ($args['pest_name'] != "" && $args['pest_name'] != null) {
            if ($condition != "")
                $condition .= " AND ";
            $condition .= "  pest_name like '%" . $args['pest_name'] . "%'";
        }

        //dump($condition);
        $model = spClass("historyModel");

        $rows = $model->spPager($args['_pg_'][0], $args['_pg_'][1])->findAll($condition);



        $rs['rows'] = $rows;

        $rs['_pg_'] = $model->spPager()->getPager();




        return $rs;
    }

    public function getLevelArray() {
        RETURN array(
            self::HISTORY_LEVEL_LIGHT => '轻度',
            self::HISTORY_LEVEL_MIDDLE => '中度',
            self::HISTORY_LEVEL_HARD => '重度',
        );
    }
    
    /**
     * 检测新数据在数据库中的唯一性[pest_id,year,province_code,area_code]
     * @param type $args,$id
     * @return boolean
     * True --unique
     * False -- no unique
     */
    public static function checkHistoryUnique($args,$id=null)
    {
        $model = spClass("historyModel");
        $crop_id = $GLOBALS['sysparams']['crop_id'];
        $condition = " crop_id='".$crop_id."' ";
        if($args['pest_id']) $condition .= " and pest_id='".$args['pest_id']."'";
        if($args['year']) $condition .= " and year='".$args['year']."'";
        if($args['province_code']) $condition .= " and province_code='".$args['province_code']."'";
        if($args['area_code']=="") 
        {
            $condition .= " and area_code=''";
        }else
        {
            $condition .= " and area_code='".$args['area_code']."'";
        }
        if($id!==null)
        {
            $condition .= " and history_id!='".$id."'";
        }
        $cnt = $model->findCount($condition);
        if($cnt!=0)
        {
            return False;
        }
        
        return True;
    }

}