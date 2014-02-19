<?php

if (!defined('TBOWCARDUP')) {
    exit(1);
}

/*
  特别注意：
 */

class navigationModel extends spModel {

    public function loginMenu() {
        $menu = array(
            array(
                "name" => "", //首页
                "controller" => "index",
                "action"=>'main',
                "tid" => 1,
            ),
            
        );
        $menu = array();
        return $menu;
    }

    /**
     * 目录树
     * @param type $position
     * @return array
     * $position:0---前台的目录树
     *           1---后台的目录树
     */
    public function navigationTree($position = 0) {

            $tree = array(
                array(
                    "name" => T('nav_exam'), //题库管理
                    "controller" => "answer",
                    "action" => "index",
                    "mainflag" => 0,
                    "hassub" => 1,
                    "tid" => 1,
					"sid"=>1,
					"subitem"=>array(
                        array(
                            "name" => T("nav_custom_exam"),
                            "controller" => "answer",
                            "action" => "index",
                            "sid" => 1,
                        ),
                        array(
                            "name" => T("nav_bank_exam"),
                            "controller" => "answer",
                            "action" => "bank",
                            "sid" => 2,
                        ),
					),
                ),
                
                array(
                    "name" => T('nav_answer_record'),//答题记录
                    "controller" => "record",
                    "action" => "index",
                    "mainflag" => 0,
                    "hassub" => 1,
                    "tid" => 2,
                    "sid" => 1,
                    "subitem"=>array(
                        array(
                            "name" => T('nav_answer_record'),//答题记录,
                            "controller" => "record",
                            "action" => "index",
                            "sid" => 1,
                        ),
                    ),
                   
                ),
				
                array(
                    "name" => T('nav_system_set'),//系统配置
                    "controller" => "answerType",
                    "action" => "index",
                    "mainflag" => 0,
                    "hassub" => 1,
                    "tid" => 3,
					"sid"=>1,
					"subitem"=>array(
                        array(
                            "name" => T("nav_exam_type"),
                            "controller" => "answerType",
                            "action" => "index",
                            "sid" => 1,
                        ),
					),
                   
                ),
                
                
                
                array(
                    "name" => T('nav_operator_manage'),//管理员管理
                    "controller" => "operator",
                    "action" => "index",
                    "mainflag" => 0,
                    "hassub" => 1,
                    "tid" => 4,
                    "sid" => 1,
                    "subitem" => array(
                        array(
                            "name" => T("nav_operator_manage"),
                            "controller" => "operator",
                            "action" => "index",
                            "sid" => 1,
                        ),
                        array(
                            "name" => T("nav_opt_log"),
                            "controller" => "optLog",
                            "action" => "index",
                            "sid" => 2,
                        ),
                        
                    )
                ),
            );
        

            
            return $tree;
    }

    public function navigationPosition() {
        return array(
            0 => array('name' => T('None'), 'value' => '0'),
            1 => array('name' => T('Top'), 'value' => '1'),
            2 => array('name' => T('Bottom'), 'value' => '2'),
        );
    }

    public function navigationEnabled() {
        return array(
            0 => array('name' => T('On'), 'value' => '1'),
            1 => array('name' => T('Off'), 'value' => '0'),
        );
    }

}
