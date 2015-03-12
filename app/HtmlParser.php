<?php
require 'RecursiveDOMIterator.php';
class HtmlParser
{
	/**
	 * @var string
	 */
	private $originalHtml;
	public $tagTable = array();
	
	
	public function __construct($originalHtml)
	{
		$this->originalHtml = $originalHtml;
	}
	
	public function tagTable(){
		return $this->tagTable;
	}
	
	public function parse()
	{
		$doc = new DOMDocument();
		$doc->loadHTML($this->originalHtml);
		
// 		if(!$doc->validate()){
// 			// TODO: HTMLPurifier stuff here
// 			// otherwise:
// 			// throw new Exception( "Invalid HTML");
// 		}
		
		// PLEASE NOTE: rather than implement my own DOM traversal recursion
		// I have used an Iterator implemented by GitHub user salathe 
		$docIter = new RecursiveIteratorIterator(
				new RecursiveDOMIterator($doc),
				RecursiveIteratorIterator::SELF_FIRST);
		
		foreach($docIter as $node) {
			$this->tagTable[$node->tagName]++;
			
		}
	}
	
}