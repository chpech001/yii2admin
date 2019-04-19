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
		}else{
			$link = @mysql_connect($dbhost, $dbuser, $dbpw);
		}
		$this->link = $link;
		mysql_errno($this->link)!=0 && $this->halt("Connect($pconnect) to MySQL ($dbhost,$dbuser) failed");

		$version = $this->server_info();
		if($version > '4.1'){
			$this->set_character('utf8');
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

	function get_one($sql, $type='MYSQL_ASSOC', $buffer=true){
		$r = $this->query($sql,$buffer);
		return mysql_fetch_assoc($r);
		// return mysql_fetch_array($r,$type);
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

    function fetch_array($query, $result_type=1) {
		if($result_type==1){
			return mysql_fetch_array($query);
		}elseif($result_type==2){
			return mysql_fetch_array($query,MYSQL_ASSOC);
		}
	}

	function fetch_row($query, $type=1) {
		if($type==2){
			return mysql_fetch_array($query);
		}
		return mysql_fetch_array($query,MYSQL_ASSOC);
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
	}
}
?>
