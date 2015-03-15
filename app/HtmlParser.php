<?php
require 'RecursiveDOMIterator.php';
class HtmlParser
{
	/**
	 * @var string
	 */
	private $originalHtml;
	public $tagTable = array();
	private $doc;
	
	
	public function __construct($originalHtml)
	{
		$this->originalHtml = $originalHtml;
		$this->doc = new DOMDocument();
		$this->doc->loadHTML($this->originalHtml);
	}
	
	public function tagTable(){
		return $this->tagTable;
	}
	
	public function originalHtml(){
		return $this->originalHtml;
	}
	
	public function parse() {
// 		if(!$this->doc->validate()){
// 			// TODO: HTMLPurifier stuff here
// 			// otherwise:
// 			// throw new Exception( "Invalid HTML");
// 		}
		
		// PLEASE NOTE: rather than implement my own DOM traversal recursion
		// I have used an Iterator implemented by GitHub user salathe 
		$docIter = new RecursiveIteratorIterator(
				new RecursiveDOMIterator($this->doc),
				RecursiveIteratorIterator::SELF_FIRST);
		
		foreach($docIter as $node) {
			$this->tagTable[$node->tagName]++;
			
		}
	}
	
	public function annotate() {
		$encodedHtml = htmlspecialchars($this->originalHtml);
		
// 		$openTagPattern = "/\&lt;(\/?)(\w*)[\s\=\'\"\d]*\&gt;/";
// 		$replacement = "<span id=$2>&lt;$1$2&gt;</span>";
		//$openTagPattern = "/\&lt;(\w*)[^\&]*\&gt;(.*)\&lt;\/(\w*)&gt;/";
		//$replacement = "<span id=$1>&lt;$1&gt;</span>$2<span id=$1>&lt;/$3&gt;</span>";
		
		
// 		$openTagPattern = "/\&lt;(\w*)([\s\=\'\"\d]*)\&gt;/";
// 		$openTagReplacement = "<span id=$1$2>&lt;$1&gt;</span>";
		
// 		$closeTagPattern = "/\&lt;\/(\w*)\&gt;/";
// 		$closeTagReplacement = "<span id=$1>&lt;$1&gt;</span>";
		
		// match on "<tagname" or "<tagname attr=x" or "</tagname"
		$openTagPattern = "/\&lt;(\/?)(\s*\w*)/";
		// and replace with "<span id=tagname><tagname" 
		$openTagReplacement = "<span class=$2>&lt;$1$2";
		
		// match on ">"
		$closeTagPattern = "/\&gt;/";
		// and replace with "></span>"
		$closeTagReplacement = "&gt;</span>";
		
		$annotatedHtml = preg_replace($openTagPattern, $openTagReplacement, $encodedHtml);
		$annotatedHtml = preg_replace($closeTagPattern, $closeTagReplacement, $annotatedHtml);
		
		return $annotatedHtml;
		
	}
}