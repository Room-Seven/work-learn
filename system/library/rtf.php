<?php
/**
* @package		SITE
* @author		Ron Tayler
* @copyright	2020
*
* Ron Tayler Fox Library
* Набор пользовательских не доработанных функций
*/

/**
* RTF class
*/
class RTF {

	/** 
	 * Установка заголовка на скачивание файла
	 * @param string $file
	*/
	public function file_force_download($file) {
		if(file_exists($file)){
			// сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
			// если этого не сделать файл будет читаться в память полностью!
			if (ob_get_level()) {
				ob_end_clean();
			}
			// заставляем браузер показать окно сохранения файла
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename=' . basename($file));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			// читаем файл и отправляем его пользователю
			readfile($file);
			exit;
		}
	}

	/**
	 * Вывод данных в консоль браузера
	 * @param mixed $var
	 * @param string $label
     * @return string
	*/
	public function cl_print_r($var, $label = ''){
		$str = $this->print_rtf($var, true);
		return "<script>console.group('" . $label . "');console.log('" . $str . "');console.groupEnd();</script>";
	}

    /**
     * Более функциональная замена print_r();
     * @param $file
     * @param mixed $val
     * @param boolean $ret [optional] При true возвращает ответ в переменную, при false выводит информацию на экран. По
     * @param integer $lvl [optional] Параметр только для рекурсии
     * @return string
     */
	public function print_rtf($val,$ret = false,$lvl = 0){
		$return = '';
		switch (gettype($val)){
			case 'array':
			case 'object':
				$return .= gettype($val).'('.count($val).')';
				break;
			default:
				$return .= '('.gettype($val).')';
				break;
		}
		switch (gettype($val)){
			case 'boolean':
				if ($val) {
					$return .= 'True';
				}else{
					$return .= 'False';
				}
				break;
			case 'integer':
			case 'double':
				$return .= $val;
				break;
			case 'string':
				$return .= '"'.str_replace(array("\r\n", "\r", "\n"), '<13>', $val).'"';
				break;
			case 'array':
				$return .= "{"."\n".str_pad('',($lvl+1)*4,' ');
				$array = array();
				foreach ($val as $key => $value) {
					$ret_value = $this->print_rtf($value,true,$lvl+1);
					$array[]=((gettype($key)=='string')?'\''.$key.'\'':'['.$key.']').'=>'.(($ret)?$ret_value:str_replace("\n", '<br>', $ret_value));
				}
				$return .= implode(","."\n".str_pad('',($lvl+1)*4,' '), $array);
				$return .= "\n".str_pad('',$lvl*4,' ').'}';
				break;
			case 'object':
				$return .= "{"."\n".str_pad('',($lvl+1)*4,' ');
				$array = array();
				foreach ($val as $key => $value) {
					$array[]=''.$key.'->'.$this->print_rtf($value,true,$lvl+1);
				}
				$return .= implode(",\n".str_pad('',($lvl+1)*4,' '), $array);
				$return .= "\n".str_pad('',($lvl+1)*4,' ').'}';
				break;
			case 'NULL':
				$return .= 'NULL';
				break;
			default:
				$return .= '{'.gettype($val).'}';
				break;
		}
		if($ret){
			return $return;
		}else{
			echo '<pre>'.$return.'</pre>';
			return 'echo';
		}
	}

	/**
	 * Мгновенный вывод данных без окончания выполнения скрипта
	 * @param string $text
	*/
	public function print_log($text){
		$time = '['.date('H:i:s').':'.str_pad(round((gettimeofday()['usec'])/1000), 3, '0', STR_PAD_LEFT).']';
		echo $time.$text.'<br>';
		flush();
	}

	public function time_last($last_time,$first_time){
	    $time_s = $first_time - $last_time;// Всё в секундах
        $time_i = round($time_s/60);
        $time_h = round($time_i/60);
        $time_d = round($time_h/24);
        $time_w = round($time_d/7);
        // TODO Дальше идут неверные расчёты месяцев и лет
        $time_m = round($time_w/4);
        $time_y = round($time_m/12);
        global $registry;
        if($time_s<60){return 'Только что';}
        elseif($time_i<60){
            return $time_i.' '.$this->int2word($time_i,array('минуту','минуты','минут')).' назад';
        }
        elseif($time_h<24){
            return $time_h.' '.$this->int2word($time_h,array('час','часа','часов')).' назад';
        }
        elseif($time_d<7){
            return $time_d.' '.$this->int2word($time_d,array('день','дня','дней')).' назад';
        }
        elseif($time_w<4){
            return $time_w.' '.$this->int2word($time_w,array('неделя','недели','недель')).' назад';
        }
        elseif($time_m<12){
            return $time_m.' '.$this->int2word($time_m,array('месяц','месяца','месяцев')).' назад';
        }
        else{
            return $time_y.' '.$this->int2word($time_y,array('год','года','лет')).' назад';
        }
    }

    public function int2word($num, $words){
        $num = $num % 100;
        if($num>19){
            $num = $num % 10;
        }
        switch ($num){
            case 1:
                return $words[0];
                break;
            case 2: case 3: case 4:
                return $words[1];
                break;
            default:
                return $words[2];
        }
    }
}