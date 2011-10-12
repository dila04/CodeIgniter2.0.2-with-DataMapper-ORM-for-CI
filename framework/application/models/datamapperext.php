<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class DataMapperExt extends DataMapper {
    function __construct($id = NULL) {
        parent::__construct($id);
    }

	function _save($posts)
	{
		$CI =& get_instance();
		if (is_array($posts))
		{
			foreach ($posts as $key=>$value)
			{
				$this->$key = $CI->security->xss_clean($value);
			}
			return $this->save();
		}
	}

}