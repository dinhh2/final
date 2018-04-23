<?php 

class Queue implements iterator {
	public $songs = array();
	
	function addToQueue($song) {
		$this->songs[$song['artist']] = $song['songname'];
	}
	
	public function rewind() {
		reset($this->songs);
	}
	
	public function current() {
		$var = current($this->songs);
		return $var;
	}
	
	public function key() {
		$var = key($this->songs);
		return $var;
	}
	
	public function next() {
		$var = next($this->songs);
		return $var;
	}
	
	public function valid() {
		$key = key($this->songs);
		$var = ($key !== NULL && $key !== FALSE);
		return $var;
	}
} 