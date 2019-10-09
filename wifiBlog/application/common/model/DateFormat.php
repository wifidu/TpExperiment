<?php
	namespace app\common\model;
	
	class DateFormat{
		public $time;
		
		public function __construct($time){
			$this->time = $time;
		}

		public function __toString(){
			if(empty($this->time) || $this->time < 0){
				return '';
			}

			$diff = time() - $this->time;
			if($diff <= 0 || $diff < 60){
				return '刚刚';
			}

			$mins = floor($diff/60);
			$hours = floor($diff/3600);
			$days = floor($diff/86400);
			$months = floor($diff/2592000);
			$years = floor($diff/86400/365);

			if($mins < 30){
				return $mins.'分钟前';
			}else if($min >= 30 && $mins < 60){
				return '一小时内';
			}else if($hours >= 1 && $hours < 24){
				return $hours.'小时前';
			}else if($days >= 1 && $days < 30){
				return $days.'天前';
			}else if($months >= 1 && $months < 12){
				return $years.'年前';
			}
			return '';
		}
	}
?>
