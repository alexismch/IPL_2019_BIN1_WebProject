<?php
	class GlobalFunctions {
		public function __construct() {
		
		}
		
		public function clean($string) {
			$string = strtolower($string);
			$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens
			$string = iconv('utf-8','ASCII//IGNORE//TRANSLIT', $string); // Removes special accents letters
			$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars
			return rtrim($string,"- "); // Removes last - if exists
		}


	}