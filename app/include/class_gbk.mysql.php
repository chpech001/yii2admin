<?php
Class DB {
	var $num = 0;
	var $link=null;

	function DB($dbhost, $dbuser, $dbpw, $dbname, $pconnect=0) {
		$this->connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
	}
	function connect($dbhost, $dbuser, $dbpw, $dbname='', $pconnect=0) {
		if($pconnect){
			$link = @mysql_pconnect($dbhost, $dbuser, $dbpw);
		}
		else{
			$link = @mysql_connect($dbhost, $dbuser, $dbpw);
		}
		$this->link = $link;
		mysql_errno($this->link)!=0 && $this->halt("Connect($pconnect) to MySQL ($dbhost,$dbuser) failed");

		$version = $this->server_info();
		if($version > '4.1'){
			$this->set_character('gbk');
		}
		if($version > '5.0'){
			mysql_query("SET sql_mode=''",$this->link);
		}
		if($dbname) {
			$this->select_db($dbname);
		}
	}
	function close() {
		return mysql_close($this->link);
	}
	function select_db($dbname){
		if (!@mysql_select_db($dbname,$this->link)){
			$this->halt('Cannot use database '.$dbname);
		}
	}
	function set_character($character){
		if(!@mysql_query("SET character_set_connection='{$character}',character_set_results='{$character}',character_set_client=binary",$this->link)){
			$this->halt('Cannot set character '.$character);
		}
	}
	function server_info(){
		return mysql_get_server_info($this->link);
	}
	function query($sql,$buffer=true) {
		if(!$buffer && function_exists('mysql_unbuffered_query')){
			$r = mysql_unbuffered_query($sql,$this->link);
		}else{
			$r = mysql_query($sql,$this->link);
		}
		$this->num++;

		if (!$r) $this->halt('Query Error: ' . $sql);
		return $r;
	}
	function get_one($sql, $type=1, $buffer=true){
		$r = $this->query($sql,$buffer);
		if($type==2){
			return mysql_fetch_array($r);
		}
		return mysql_fetch_array($r,MYSQL_ASSOC);
	}
	function get_all($sql, $type=1, $buffer=true){
		$r = $this->query($sql,$buffer);
		$rows = array();
		for($i=0;$i<1000;$i++){
			$row = $type==2?mysql_fetch_array($r):mysql_fetch_array($r,MYSQL_ASSOC);
			if(!$row) break;
			$rows[] = $row;
		}
		return $rows;
	}
	function fetch_row($r, $type=1) {
		if($type==2){
			return mysql_fetch_array($r);
		}
		return mysql_fetch_array($r,MYSQL_ASSOC);
	}
	function insert($table,$data,$addslashes=true) {
	}
	function update($table,$data,$where,$addslashes=true) {
	}
	function affected_rows() {
		return mysql_affected_rows($this->link);
	}
	function num_rows($r) {
		$rows = mysql_num_rows($r);
		return $rows;
	}
	function free_result($r) {
		return mysql_free_result($r);
	}
	function insert_id() {
		return mysql_insert_id($this->link);
	}
	function halt($msg='') {
		return true;
		global $REQUEST_URI;
		//edit by lws
		$msg = '';
		$sqlerror = mysql_error();
		//$sqlerror = '';
		$sqlerrno = mysql_errno();
		//$sqlerrno = '';
		echo"<html><head><title></title><style type='text/css'>P,BODY{FONT-FAMILY:tahoma,arial,sans-serif;FONT-SIZE:11px;}A { TEXT-DECORATION: none;}a:hover{ text-decoration: underline;}TD { BORDER-RIGHT: 1px; BORDER-TOP: 0px; FONT-SIZE: 16pt; COLOR: #000000;}</style><body>\n\n";
		echo"<table style='TABLE-LAYOUT:fixed;WORD-WRAP: break-word'><tr><td>$msg";
		echo"<br><br><b>The URL Is</b>:<br>http://$_SERVER[HTTP_HOST]$REQUEST_URI";
		echo"<br><br><b>MySQL Server Error</b>:<br>$sqlerror  ( $sqlerrno )";
		echo"</td></tr></table>";
		exit;
	}
}
?>