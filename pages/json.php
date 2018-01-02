<?php
class response{
	public static function json($code,$total='',$data=array()){
		if(!is_numeric($code)){
			return '';
		}
		$result =array(
			'code'=>$code,
			'total'=>$total,
			'dataList'=>$data
		);
		echo json_encode($result);
		exit;
	}
}
?>