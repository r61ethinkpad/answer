<?php

if (!defined('TBOWCARDUP')) {
    exit(1);
}

class permissionModel extends spModel {

    public function getAdminNoCheckCA() {
        $ca = array(
            'main' => 'ALL',
        );
        return $ca;
    }


//=============================================================	
    public function getSysModule() {
        $module = $GLOBALS['dataconfig']['sys_module'];
        return $module;
        
    }

    public function getCorpPermission() {
        $permission = array(
            
            'system_optlog' => array(
                'module' => 'system',
                'description' => '系统日志查看',
                'children' => array(
                    'optLog/index', 'optLog/queryList', //系统日志
                )
            ),
            'operator_manage' => array(
                'module' => 'operator',
                'description' => '管理员管理',
                'children' => array(
                    'operator/index', 'operator/queryList',
                    
                    'operator/operNew', 'operator/operSave',
                    'operator/operEdit', 'operator/operUpdate',
                    'operator/operPasswd', 'operator/passwdSave',
                    'operator/freeze', 'operator/unfreeze',
                    'operator/operDel', 
                    'operator/operAuth', 'operator/authUpdate',)
            ),
            'custom_exam_manage' => array(
                'module' => 'exam',
                'description' => '自定义题库管理',
                'children' => array(
                    'answer/index',
                    'answer/queryList',
                    'answer/create',
                    'answer/save',
                    'answer/edit',
                    'answer/update',
                    'answer/del',
                    'answer/detail',
                    //batch import data
                    'answer/batch',
                    'answer/batchCreate',
                    'answer/openTmpDown',
                )
            ),
            'bank_exam_manage' => array(
                'module' => 'exam',
                'description' => '银行题库管理',
                'children' => array(
                    'answer/bank',
                    'answer/queryList',
                    'answer/create',
                    'answer/save',
                    'answer/edit',
                    'answer/update',
                    'answer/del',
                    'answer/detail',
                    
                    //batch import data
                    'answer/batch',
                    'answer/batchCreate',
                    'answer/openTmpDown',
                )
            ),
            'answer_record_view' => array(
                'module' => 'record',
                'description' => '用户答题记录查看',
                'children' => array(
                    'record/index',
                    'record/queryList',
                )
            ),
            'exam_type_manage' => array(
                'module' => 'system',
                'description' => '题库分类管理',
                'children' => array(
                    'answerType/index',
                    'answerType/queryList',
                    
                    'answerType/create',
                    'answerType/save',
                    'answerType/del'
                )
            ),
            
            'game_manage' => array(
                'module' => 'game',
                'description' => '答题游戏管理',
                'children' => array(
                    'game/index',
                    'game/next',
                )
            ),
        );
        return $permission;
    }

}