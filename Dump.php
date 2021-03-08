<?php 


class Dump
{
	private $count = 0;
	public $html;

    public function dumpData($args){
    	$this->html .= $this->header();
		$this->html .= $this->d($args);
		$this->html .= $this->footer();
		return $this->html;
	}

	public function d($variables)
	{

		foreach ($variables as $key => $value){
			$isObj = is_object($value);
			$isArray = is_array($value);
			$isKeyString = is_string($key);
			$isKeyInt = is_integer($key);
			$isValueString = is_string($value);
			$isValueInt = is_integer($value);
			if ($isObj || $isArray) 
			{
				$total =  $isArray ? count($value) : count(get_object_vars($value));
				$this->html .= "<span class='child'>";
				$this->html .= "<span class=' ".($isKeyString ? "str":"").($isKeyInt ? "int":"")."'>$key</span>";
				$this->html .= "<span class='character'> => </span> ".($isArray ? "Array":"Object" ).": <span class='int'>$total</span>";

				$this->html .= "<span class='arrow'></span>";
				$this->html .= "<span class='character bracket-open'>".($isArray ? " [":" {" )."</span>";
				$this->d($value);
				$this->html .= "<span class='character'>".($isArray ? " ]":"}" )."</span>";
				$this->html .= "</span>";
			}
			else
			{
				$this->html .= "<span class='child'>
					  <span class='key ".($isKeyString ? "str":"").($isKeyInt ? "int":"")."'>$key</span>
					  <span class='character'> => </span>
					  <span class='value ".($isValueString ? "str":"").($isValueInt ? "int":"")."'>$value</span>
					  </span>";
			}	
			$this->count +1;
			if ($this->count > 500) {
				$this->html .= $this->footer();
				echo $this->html;
				exit;
			}
		}
		
		
	}

	public function header()
	{
		return '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title>Document</title><style>*{padding-left:0px;font:13px/18px monospace}
		.parent{position:relative;}.child{display:block;position:relative;left:15px;border-left:1px dotted gray;padding-left: 15px;}.str{color:#0B7500;}.int{color:#1A01CC;}.str::after{content:"\""}.str::before{content:"\""}.character{color:;}.arrow{width:20px;height:18px;position:absolute;left:-2px;top:1px;z-index:5;background-image:url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAgAAAAICAYAAADED76LAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAD1JREFUeNpiYGBgOADE%2F3Hgw0DM4IRHgSsDFOzFInmMAQnY49ONzZRjDFiADT7dMLALiE8y4AGW6LoBAgwAuIkf%2F%2FB7O9sAAAAASUVORK5CYII%3D");background-repeat:no-repeat;background-position:center center;display:block;opacity:0.5;-webkit-transform:rotate(0deg);}</style></head><body>';	
	}

	public function footer()
	{
		return '<footer></footer></body></html>';	
	}


}
function dd(){
	$dump = new Dump;
	$args = func_get_args();
	echo $dump->dumpData($args);
	exit;
}



