<?php
if( !function_exists('wtf') ) {
	function wtf( $obj ) {
		echo '<pre>';
		print_r( $obj );
		echo '</pre>';
	}
}
if( !function_exists('get_course_code') ) {
	function get_course_code( $topic_name ) {
		return substr( md5($topic_name .'_'. time()), -6 );
	}
}

if( !function_exists('get_answer_code') ) {
	function get_answer_code( $topic_name ) {
		return substr( md5($topic_name .'_'. time()), -15 );
	}
}

if( !function_exists('random_string') ) {
	function random_string($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%&*(){}[]';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
}

?>