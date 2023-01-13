<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

Class form_option {

	var $option_text;
	var $option_value;
	var $temp1;
	var $temp2;


	public function Month($A, $B, $fd, $td) {
		$aa = str_replace('.','',$A);
		$bb = str_replace('.','',$B);
		$total  = "<input type=\"text\" name='".$aa."' value='".$fd."' id=\"{$aa}\" class=\"{$aa} frm-calendar width80\" placeholder=\"검색시작일\" />";
		$total .= " ~ ";
		$total .= "<input type=\"text\" name=\"{$bb}\" value='".$td."' id=\"{$bb}\" class=\"{$bb} frm-calendar width80\" placeholder=\"검색종료일\" />";
		$total .= "&nbsp;<button type=\"button\" class='sch_M' onclick=\"SetToDays('".$A."', '".$B."'); \">오늘</button>&nbsp;";
		$total .= "<button type=\"button\" class='sch_M' onclick=\"SetPrevMonthDays('".$A."', '".$B."'); \">전월</button>&nbsp;";
		$total .= "<button type=\"button\" class='sch_M' onclick=\"SetCurrentMonthDays('".$A."', '".$B."');  \">당월</button>&nbsp;";
		$total .= "<button type=\"button\" class='sch_M' onclick=\"SetWeek_befor('".$A."', '".$B."'); \">지난주</button>&nbsp;";
		$total .= "<button type=\"button\" class='sch_M' onclick=\"SetWeek('".$A."', '".$B."'); \">이번주</button>";
		return $total;
	}

	function var_mode($m, $arr) {

		// 배열오류이면...
		if(!is_array($arr)) {
			$arr = array ("msg"=>"배열오류");
		 }
        
		$text = implode("|", $arr);
		$value = implode("|", array_keys($arr));
        
		switch($m) {
			case "A" : // key, value
				$t = $text;
				$v = $value;
			break;
			case "B" : // value, value
				$t = $text;
				$v = $text;
			break;
			default : // key, value
				$t = $text;
				$v = $value;
			break;
		}
		$this->option_text = $t;
		$this->option_value = $v;
	}

	// 검색박스 검색조건 셀렉트 박스 생성 ('선택', name, id, cass, value, required='')
	function Select($title='', $s_name, $s_id='', $s_class='', $s_val, $required='') {

		if($title) {
			$data1 = explode("|", $title."|".$this->option_text);
			$data2 = explode("|", "|".$this->option_value);
		} else {
			$data1 = explode("|", $this->option_text);
			$data2 = explode("|", $this->option_value);
		}

		$this->temp1 = $data1;
		$this->temp2 = $data2;

		for($i=0; $i < count($data1); $i++){ $dataA[$i] = trim($data1[$i]); }
		for($i=0; $i < count($data2); $i++){ $dataB[$i] = trim($data2[$i]); }
		
		$opt = "";
        for($i=0; $i < count($data2); $i++){
			$selected = ( $s_val == $dataB[$i] )? "selected":"";
			$opt .="<option value='".$dataB[$i]."' ".$selected.">".$dataA[$i]."</option>";
        }
        
        if($s_id) {
            $id = "id='{$s_id}'";
        }

		$rst = "<select name='".$s_name."' {$id} class='".$s_class."' ".$required.">";
		$rst .= $opt;
		$rst .= "</select>";
		return $rst;
	}

	function Radio($title='', $s_name, $s_id='', $s_class='', $s_val) {

		$data1 = explode("|", $this->option_text);
		$data2 = explode("|", $this->option_value);
        
		$data1 = array_values($data1);
		$data2 = array_values($data2);

        $this->temp1 = $data1;
		$this->temp2 = $data2;

	  	for($i=0; $i < count($data1); $i++){
              $dataA[$i]=$data1[$i];
        }

  		for($i=0; $i < count($data2); $i++){
              $dataB[$i]=$data2[$i];
        }

		$result = "<div class='option-radio-div'>";
		for($i=0; $i < count($data2); $i++){
			$checked = ($s_val == $dataB[$i]) ? "checked" : "";
			$result .= "<input type='radio' name='$s_name' class='$s_class' id='{$s_id}[$i]' value='$dataB[$i]' $checked />";
			$result .= "<label for='{$s_id}[$i]'> $dataA[$i]</label>&nbsp;&nbsp;";
		}
		$result .= "</div>";
		return $result;
	}

	function Checkbox($title='', $s_name, $s_id, $s_class, $s_val){
		
		$data1 = explode("|", $this->option_text);
		$data2 = explode("|", $this->option_value);		
		
		for($i=0; $i < count($data1); $i++) {
			$dataA[$i] = $data1[$i];
		}

		for($i=0; $i < count($data2); $i++) {
			$dataB[$i] = $data2[$i];
		}

		$check = explode(",", $s_val);
		$result ="<ul>";
		$j=0;
	
		for($i = 0; $i < count($data2); $i++) {
			
			if($dataB[$i] == $check[$j]) {
				$checked = "checked";
				$j++;
			}
			else {
				$checked = "";
			}

			$result .= "<li><label class='hand'><input type='checkbox' value='{$dataB[$i]}' name='{$s_name}[]' $checked class='{$s_class} hand'/>{$dataA[$i]}</label></li>";
		}
		$result .="</ul>";

		return $result;
	}

	// (name, id, class, DB값, 시작숫자, 종료숫자, 증가수, TEXT값)
	function Int($title, $name, $id, $class, $val, $start, $end, $plus, $txt='') {
		
		$id = ($id) ? "id='{$id}'" : "";
		$result = "<select name='{$name}' {$id} class='{$class}'>";
		$result .= ($title) ? "<option>{$title}</option>" : "";

		for($i = $start; $i <= $end; $i += $plus){
			$selected = ($val == $i) ? "selected" : "";
			$result .= "<option value='{$i}' {$selected}>{$i}{$txt}</option>";
		}
		
		$result .= "</select>";

		return $result;
	}
}
?>