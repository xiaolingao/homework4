<?php
/*
*	此版本的脚本，优点是代码较少，查找的时间短，缺点是无用的正则匹配次数多
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
		public $search = array("/\"3\d{2}\"/", "/\"4\d{2}\"/", "/\"5\d{2}\"/");

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
			$table = array($tableOne, $tableTwo, $tableThree);
			$file = $this->getDataArray();
			for($i=0; $i<3;$i++){
				$table[$i] = $this->tableMake($file,$this->search[$i]);
			}
			return $table;
		}

		/*
		*@Description:组装table
		*
		*/
		private function tableMake($file,$search){
			$x = 0;
			$table = '<table border="1"><tr><td>nubmer</td><td>status</td><td>resource</td></tr>';
			$array = preg_grep($search,$file);
			foreach($array as $key => $value){
				$dataArray = explode(' ',$value);
				$number = count($dataArray);
				if($number == 12){
					$table .= '<tr><td>'.++$x.'</td><td>'.$dataArray['6'].'</td><td>'.$dataArray['8'].'</td></tr>';
				}elseif($number == 13){
					if(($dataArray['7'] == "\"400\"")){
						$table .= '<tr><td>'.++$x.'</td><td>'.$dataArray['7'].'</td><td>'.$dataArray['6'].'</td></tr>';
					}else{
						$table .= '<tr><td>'.++$x.'</td><td>'.$dataArray['8'].'</td><td>'.$dataArray['6'].'</td></tr>';
					}
				}elseif($number == 16){
					if(($dataArray['10'] == "\"404\"") || ($dataArray['10'] == "\"499\"")){
						$table .= '<tr><td>'.++$x.'</td><td>'.$dataArray['10'].'</td><td>'.$dataArray['6'].'</td></tr>';
					}else{
						$table .= '<tr><td>'.++$x.'</td><td>'.$dataArray['8'].'</td><td>'.$dataArray['6'].'</td></tr>';
					}
				}else{
					$table .= '<tr><td>'.++$x.'</td><td>'.$dataArray['8'].'</td><td>'.$dataArray['6'].'</td></tr>';
				}
			}
			$table .= '<tr><td>total:</td><td>'.$x.'</td></tr></table>';
			return $table;
		}
	}
	$test = new getNumberAndResource();
	$time_start = $test->microtime();
	$table = $test->Run();
	for($i=0; $i<3;$i++){
		echo $table[$i];
	}
	$time_end = $test->microtime();
	echo "查询时间为：".($time_end - $time_start);
?>