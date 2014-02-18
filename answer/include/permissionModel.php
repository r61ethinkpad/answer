<?php

if (!defined('TBOWCARDUP')) {
    exit(1);
}

class permissionModel extends spModel {

    public function getAdminNoCheckCA() {
        $ca = array(
            'main' => 'ALL',
            'notice' => 'ALL',
            'advice' => array('showButton', 'showAdvice', 'adviceSubmit'),
        );
        return $ca;
    }

    public function getCorpNoCheckCA() {
        $ca = array(
            'main' => 'ALL',
            'notice' => 'ALL',
            'appCenter' => 'ALL',
            'advice' => array('showButton', 'showAdvice', 'adviceSubmit'),
            'software' => array('index', 'queryList', 'download'),
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
                'description' => '系统日志',
                'children' => array(
                    'optLog/index', 'optLog/queryList', //系统日志
                )
            ),
            'operator_view' => array(
                'module' => 'operator',
                'description' => '操作员查看',
                'children' => array(
                    'operator/index', 'operator/queryList',
                    'operator/showStruct', 'operator/showStandard',
                    'operator/operEdit', 'operator/operAuth')
            ),
            'operator_manage' => array(
                'module' => 'operator',
                'description' => '操作员管理',
                'children' => array(
                    'operator/index', 'operator/queryList',
                    'operator/showStruct', 'operator/showStandard',
                    'operator/operNew', 'operator/operSave',
                    'operator/operEdit', 'operator/operUpdate',
                    'operator/operPasswd', 'operator/passwdSave',
                    'operator/freeze', 'operator/unfreeze',
                    'operator/operDel', 'operator/delAll',
                    'operator/operAuth', 'operator/authUpdate',)
            ),
            'org_manage' => array(
                'module' => 'org',
                'description' => T('title_org') . '基本信息管理',
                'children' => array(
                    'org/index',
                    'org/orgEdit',
                    'org/orgUpdate',
                )
            ),
            'struct_view' => array(
                'module' => 'org',
                'description' => T('title_department') . '查看',
                'children' => array(
                    'struct/index',
                    'struct/getNode',
                    'struct/nodeInfo',
                )
            ),
            'struct_manage' => array(
                'module' => 'org',
                'description' => T('title_department') . '管理',
                'children' => array(
                    'struct/index',
                    'struct/getNode',
                    'struct/addNode',
                    'struct/nodeCreate',
                    'struct/nodeInfo',
                    'struct/nodeDel',
                    'struct/nodeEdit',
                    'struct/nodeUpdate',
                    'struct/nodeMove',
                    'struct/toggleNode',
                )
            ),
            'user_post_manage' => array(
                'module' => 'org',
                'description' => '职位管理',
                'children' => array(
                    'userPost/index',
                    'userPost/queryList',
                    'userPost/positionNew',
                    'userPost/posDel',
                )
            ),
            'custom_manage' => array(
                'module' => 'custom_area',
                'description' => '自定义行政区管理',
                'children' => array(
                    'customArea/index',
                    'customArea/queryList',
                    'customArea/areaNew',
                    'customArea/areaCreate',
                    'customArea/areaEdit',
                    'customArea/areaUpdate',
                    'customArea/areaRange',
                    'customArea/areaSave',
                    'customArea/getCity',
                    'customArea/getArea',
                    'customArea/areaDel',
                    'customArea/delAll',
                )
            ),
        
            'user_manage' => array(
                'module' => 'user',
                'description' => '用户管理',
                'children' => array(
                    'user/index',
                    'user/index1',
                    'user/queryList',
                    'user/userEdit',
                    'user/userUpdate',
                    'user/userInfo',
                    'user/userDelete',
                    //'user/userFreeze',
                    //'user/userUnfreeze',
                    'user/unactive',
                    
                    'user/userAdd',
                    'user/userCreate',
                    
                    'user/userSet',
                    'user/userSetSave',
                    
                    'orgUser/orguserList',
                    'orgUser/membAdd',
                    'orgUser/membCreate',
                    'orgUser/userSearch',
                    'orgUser/membMove',
                    'orgUser/userArrDelete',
                    'orgUser/userDelete',
                    'struct/getNode',
                    'struct/toggleNode',
                    
                    //用户的区域划分和用户足迹
                    'userRegion/index',
                    'userRegion/queryList',
                    'userRegion/regionNew',
                    'userRegion/regionCreate',
                    'userRegion/getCity',
                    'userRegion/getArea',
                    'userRegion/getCustomArea',
                    'userRegion/regionDel',
                    'userRegion/regionMap',
                    'userRegion/getMapData',
                    
                    'locus/userLocus',
                    'locus/showUserLocus',
                    
                )
            ),
            'batch_manage' => array(
                'module' => 'user',
                'description' => '企业成员批量导入',
                'children' => array(
                    'userBatch/userImport',
                    'userBatch/batchCreate',
                    'userBatch/openTmpDown',
                )
            ),
            
            'notice_view' => array(
                'module' => 'system',
                'description' => '公告查看',
                'children' => array(
                    'notice/index', 'notice/queryList',
                    'notice/detail',
                ),
            ),
            'notice_manage' => array(
                'module' => 'system',
                'description' => '公告管理',
                'children' => array(
                    'notice/index', 'notice/queryList',
                    'notice/detail', 'notice/create',
                    'notice/edit', 'notice/delete',
                    'notice/batchDel', 'notice/down'
                ),
            ),
            
            'monitor_manage' => array(
                'module' => 'system',
                'description' => '用户监控配置',
                'children' => array(
                    'monitor/index', 'monitor/queryList',
                    'monitor/detail',
                    'monitor/add',
                    'monitor/create',
                    'monitor/edit',
                    'monitor/update',
                    'monitor/delete',
                    
                ),
            ),
            
            'user_bit' => array(
                'module' => 'report',
                'description' => '成员点滴',
                'children' => array(
                    'bit/index', 'bit/queryList',
                    'bit/view',
                    'bit/showBigPicture'
                ),
            ),
            'user_locus' => array(
                'module' => 'report',
                'description' => '成员足迹',
                'children' => array(
                    'locus/index', 'locus/showLocus',
                 
                ),
            ),
//            'user_report_position' => array(
//                'module' => 'report',
//                'description' => '成员定位分析',
//                'children' => array(
//                    //成员定位分析
//                    'position/index', 'position/queryList',
//                    'struct/getNode',
//                ),
//            ),
//            
//            'user_report_pos_detail' => array(
//                'module' => 'report',
//                'description' => '成员详细定位分析',
//                'children' => array(
//                    
//                    //成员的详细定位分析
//                    'position/userDetail', 'position/queryDetail',
//                    'struct/getNode',
//                   
//                ),
//            ),
            
            'user_report_visit' => array(
                'module' => 'report',
                'description' => T('report_position_detail'),
                'children' => array(
                   
                    //成员的访客统计
                    'visit/index','visit/queryList',
                    'visit/selectNode',
                    'struct/getNode',
                   
                ),
            ),
            
            'user_report_across' => array(
                'module' => 'report',
                'description' => T('report_across_alarm'),
                'children' => array(
                   
                    //成员的跨区统计
                    'acrossRegion/index','acrossRegion/queryList',
                    'struct/getNode',
                ),
            ),
            
            'user_report_summary' => array(
                'module' => 'report',
                'description' => T('report_position_summary'),
                'children' => array(
                   
                    //成员的跨区统计
                    'position/summary','position/querySummary',
                    'struct/getNode',
                ),
            ),
            
            'user_report_locate' => array(
                'module' => 'report',
                'description' => T('report_locate_detail'),
                'children' => array(
                   
                    //成员的跨区统计
                    'position/locate','position/queryLocate',
                    'struct/getNode',
                ),
            ),
            
//            'user_report' => array(
//                'module' => 'report',
//                'description' => '成员统计报表',
//                'children' => array(
//                    //成员定位分析
//                    'position/index', 'position/queryList',
//                    //成员的详细定位分析
//                    'position/userDetail', 'position/queryDetail',
//                    //成员的访客统计
//                    'visit/index','visit/queryList',
//                    //成员的跨区统计
//                    'acrossRegion/index','acrossRegion/queryList',
//                ),
//            ),
        );
        return $permission;
    }

}