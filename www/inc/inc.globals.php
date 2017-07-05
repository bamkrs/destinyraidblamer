<?php

	$__drbVersion = "&alpha;0.9";

	function __sanitizeNumberValue($val)
	{
		if(empty($val))
			return '0';
		else
			return $val;
	}

?>