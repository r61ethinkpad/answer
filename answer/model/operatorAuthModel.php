<?php
//if (!defined('TBOWCARDUP')) { exit(1);}

class operatorAuthModel extends spModel
{
	public $pk = 'auth_id';//org_id user_id auth_id
	public $table = 'operator_auth';
}