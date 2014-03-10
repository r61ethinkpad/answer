<?php

if (!defined('TBOWCARDUP')) {
    exit(1);
}

class customerStatusModel extends spModel {

    public $pk = 'id';
    public $table = 'customer_status';

    public static function GetOneByUserIdAndTerm($user_id,$term){
        $model = spClass("customerStatusModel");
        return $model->find("user_id=$user_id and term=$term");
    }

    public static function Add($row){
        $model = spClass("customerStatusModel");
        return $model->create($row);
    }
    /**
    params $files: array('status'=>$status,'total_record'=>$total_record);
     **/
    public static function upd($user_id,$term,$files){
        $model = spClass("customerStatusModel");
        return $model->update(array('user_id'=>$user_id,'term'=>$term),$files);
    }

    public function getStatus($user_id,$term){
        $model=self::GetOneByUserIdAndTerm($user_id,$term);
        if($model){
            return json_decode($model['status']);
        }else{
            return false;
        }
    }

    public function init($user_id,$term,$type){
        $model=self::GetOneByUserIdAndTerm($user_id,$term);
        if($model){
            $status=json_decode($model['status']);
            $status->type=$type;
            //$status->question=1;
            $status->point=1;
            $status->right=0;
            $status->wrong=0;
            $status->total_right=0;
            $status->total_wrong=0;
            $status->records="0|0|0|0|0|0|0|0|0|0";
            self::upd($user_id,$term,array('status'=>json_encode($status)));
        }else{
            $status=array(
                'type'=>$type,
                //'question'=>1,
                'point'=>1,
                'right'=>0,
                'wrong'=>0,
                'total_right'=>0,
                'total_wrong'=>0,
                'round'=>0,
                'records'=>"0|0|0|0|0|0|0|0|0|0",
            );
            $row=array('user_id'=>$user_id,'term'=>$term,'status'=>json_encode($status),'total_count'=>'0','draw_count'=>'0','record_time'=>date("Y-m-d H:i:s"));
            self::Add($row);
        }
        return self::GetOneByUserIdAndTerm($user_id,$term);
    }

    public function addOne($user_id,$term){
        $model=self::GetOneByUserIdAndTerm($user_id,$term);
        if($model){
            return self::upd($user_id,$term,array('total_count'=>$model['total_count']+1));
        }else{
            return false;
        }
    }
}