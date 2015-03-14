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
	
	public function parse()
	{
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
	
	
}