<?php
/*
*	此版本的脚本，优点是无用的正则匹配次数少，缺点是代码较多，查找时间长
*/
	/*
	*@Description:根据http状态码输出信息
	*
	*/
	class getNumberAndResource{
		/*
		*@Description:被打开的文件名
		*
		*/
		public $fileName = 'C:/AppServ/www/homework4/access_8022.log';
		//public $fileName = 'C:/AppServ/www/homework4/test.txt';
		/*
		*@Description:匹配http状态码的正则
		*
		*/
		public $searchOne = "/\"3\d{2}\"/";
		public $searchTwo = "/\"4\d{2}\"/";
		public $searchThree = "/\"5\d{2}\"/";

		/*
		*@Description:计算时间
		*@Return:
		*/
		function microtime(){
			list($usec, $sec) = explode(' ', microtime());
			return ($usec+$sec);
		}

		/*
		*@Description:将一个文件读进一个数组中
		*@Return:$file
		*/
		private function getDataArray(){
			$file = file($this->fileName);
			return $file;
		}

		/*
		*@Description:Run()执行函数
		*
		*/
		public function Run(){
			$time_start = $this->microtime();
			$table = $this->tableMake();
			for($i=0; $i<3;$i++){
				echo $table[$i];
			}
			$time_end = $this->microtime();
			echo "查询时间为：".($time_end - $time_start);
		}

		/*
		*@Description:组装table
		*
		*/
		private function tableMake(){
			$x = 0;//计算个数
			$y = 0;//计算个数
			$z = 0;//计算个数
			$file = $this->getDataArray();
			$table = array($tableOne, $tableTwo, $tableThree);

			$table['0'] = '<table border="1"><tr><td>nubmer</td><td>status</td><td>resource</td></tr>';
			$table['1'] = '<table border="1"><tr><td>nubmer</td><td>status</td><td>resource</td></tr>';
			$table['2'] = '<table border="1"><tr><td>nubmer</td><td>status</td><td>resource</td></tr>';
			foreach($file as $key => $value){
				if(preg_match($this->searchOne,$value)){
					$dataArray = explode(' ',$value);
					$number = count($dataArray);
					if( $number == 12 ){
						$table['0'] .= '<tr><td>'.++$x.'</td><td>'.$dataArray['6'].'</td><td>'.$dataArray['8'].'</td></tr>';
					}else{
						$table['0'] .= '<tr><td>'.++$x.'</td><td>'.$dataArray['8'].'</td><td>'.$dataArray['6'].'</td></tr>';
					}
				}elseif(preg_match($this->searchTwo,$value)){
					$dataArray = explode(' ',$value);
					$number = count($dataArray);
					if( $number == 12 ){
						$table['1'] .= '<tr><td>'.++$y.'</td><td>'.$dataArray['6'].'</td><td>'.$dataArray['8'].'</td></tr>';
					}elseif($number == 13){
						if(($dataArray['7'] == "\"400\"")){
							$table['1'] .= '<tr><td>'.++$y.'</td><td>'.$dataArray['7'].'</td><td>'.$dataArray['6'].'</td></tr>';
						}else{
							$table['1'] .= '<tr><td>'.++$y.'</td><td>'.$dataArray['8'].'</td><td>'.$dataArray['6'].'</td></tr>';
						}
					}elseif($number == 16){
						if(($dataArray['10'] == "\"404\"") || ($dataArray['10'] == "\"499\"")){
							$table['1'] .= '<tr><td>'.++$y.'</td><td>'.$dataArray['10'].'</td><td>'.$dataArray['6'].'</td></tr>';
						}else{
							$table['1'] .= '<tr><td>'.++$y.'</td><td>'.$dataArray['8'].'</td><td>'.$dataArray['6'].'</td></tr>';
						}
					}
					else{
						$table['1'] .= '<tr><td>'.++$y.'</td><td>'.$dataArray['8'].'</td><td>'.$dataArray['6'].'</td></tr>';
					}
				}elseif(preg_match($this->searchThree,$value)){
					$dataArray = explode(' ',$value);
					$number = count($dataArray);
					if( $number == 12 ){
						$table['2'] .= '<tr><td>'.++$z.'</td><td>'.$dataArray['6'].'</td><td>'.$dataArray['8'].'</td></tr>';
					}else{
						$table['2'] .= '<tr><td>'.++$z.'</td><td>'.$dataArray['8'].'</td><td>'.$dataArray['6'].'</td></tr>';
					}
				}
			}
			$table['0'] .= '<tr><td>total:</td><td>'.$x.'</td></tr></table>';
			$table['1'] .= '<tr><td>total:</td><td>'.$y.'</td></tr></table>';
			$table['2'] .= '<tr><td>total:</td><td>'.$z.'</td></tr></table>';
			return $table;
		}
	}
	$test = new getNumberAndResource();
	$test->Run();
?>