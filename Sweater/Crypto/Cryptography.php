<?php

namespace Sweater\Crypto;

trait Cryptography {
	
	private $strCharacterSet = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789`~@#$()_+-={}|[]:,.";

	function generateRandomKey() {
		$strKeyLength = mt_rand(7, 10);
		$strRandomKey = "";

		foreach(range(0, $strKeyLength) as $strCurrentLength) {
			$strRandomKey .= substr($this->strCharacterSet, mt_rand(0, strlen($this->strCharacterSet)), 1);
		}

		return $strRandomKey;
	}

	function encryptPassword($strPassword, $strMD5 = true) {
		if($strMD5 !== false) {
			$strPassword = md5($strPassword);
		}

		$strHash = substr($strPassword, 16, 16) . substr($strPassword, 0, 16);
		return $strHash;
	}

	function getLoginHash($strPassword, $strRandomKey) {
		$strHash = $this->encryptPassword($strPassword, false);
		$strHash .= $strRandomKey;
		$strHash .= 'Y(02.>\'H}t":E1';
		$strHash = $this->encryptPassword($strHash);

		return $strHash;
	}
	
}

?>
