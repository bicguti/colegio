<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(__FILE__) .'/Classes/PHPExcel.php';
/**
* 
*/
class Excel extends PHPExcel
{
	function __construct()
	{
		parent::__construct();
	}
}