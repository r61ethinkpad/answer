<?php

if (!defined('TBOWCARDUP')) {
    exit(1);
}

/**
 * 答题游戏的控制器
 * @author: guohao
 */
class game extends tbController {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 病害列表
     */
    public function index() {

        

        $this->exam_types = spClass("examTypeModel")->queryArray();
        dump($this->exam_types);
        $this->displayPartial("game/index.html");
    }
    
    public function enterGame()
    {
        $this->displayPartial("game/index.html");
    }
	
}