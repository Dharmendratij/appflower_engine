<?php

class StringUtil {
    public static function startsWith($str, $prefix) {
        return strpos($str, $prefix) === 0;
    }

    public static function endsWith($str, $end) {
        return strcmp(substr($str, strlen($str) - strlen($end)), $end) === 0;
    }

    /**
     * Returns true when the needle in inside haystack.
     */
    public static function isIn($needle, $haystack) {
        return false !== strstr($haystack, $needle);
    }
    
	public static function hasTags($str) {
		return preg_match("/<[\/]*[^>]+>/",$str);
    }
    
	public static function hasEntities($str) {
		return preg_match("/\&[a-z0-9]+;/",$str);
    }
    
	public static function removeTags($str) {
		return preg_replace("/<[\/]*[^>]+>/","",$str);
    }
    
	public static function removeTagsAndEntities($str) {
		/* first remove hidden content with it's tags too */
		$str = self::removeHiddenContent($str);
		/*************************************************/
		
		$str = preg_replace('/(<[^>]+>)/','',$str);		
		return html_entity_decode($str, ENT_QUOTES);
    }
    
	public static function removeNewlines($str) {
		return str_replace("\n","",$str);
    }
    /**
     * method to remove the drill filter hidden value tag on exports
     */
	public static function removeHiddenContent($str){
	    $str = preg_replace('/<div class="ux-grid-filter-hidden-value">(.*)<\/div>/','',$str);
	    return $str;
    }
    
}

