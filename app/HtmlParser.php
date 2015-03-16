<?php
require 'RecursiveDOMIterator.php'; // attribution: https://github.com/salathe/spl-examples/wiki/RecursiveDOMIterator

class HtmlParser
{
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
	
	public function parseTags() {
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
			if($node != ""){
				$this->tagTable[$node->tagName]++;
			}			
		}
	}
	
	public function wrapTagsInSpansWithClasses() {
		$encodedHtml = htmlspecialchars($this->originalHtml);
		
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