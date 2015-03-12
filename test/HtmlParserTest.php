<?php
require 'app/HtmlParser.php';

$test = new HtmlParserTest();
$test->testCountTagsWithValidHtml();
//$test->testCountTagsWithInvalidHtml();

//class HtmlParserTest extends PHPUnit_Framework_TestCase
class HtmlParserTest
{
		
	public function __construct(){}
		
	public function testCountTagsWithValidHtml(){
// 		$validHtml = "<html><head><title>Title</title></head><div id=1></div><div id=2></div></html>";
		$validHtml = "<html><head><title>Title</title></head><div id=1><div id=12></div></div><div id=2><span></span></div></html>";
		$parser = new HtmlParser($validHtml);
		$parser->parse();
		$tagTable = $parser->tagTable;
		assert($tagTable['html'] == 1, "Incorrect html count: " . $tagTable['html']);
		assert($tagTable['head'] == 1, "Incorrect head count: " . $tagTable['head']);
		assert($tagTable['title'] == 1, "Incorrect title count: " . $tagTable['title']);
		assert($tagTable['div'] == 3, "Incorrect div count: " . $tagTable['div']);
		assert($tagTable['span'] == 1, "Incorrect span count: " . $tagTable['span']);
			
	}
	
	public function testCountTagsWithInvalidHtml(){
		$invalidHtml = "<html><head><title>Title</title><div></div></html>";
		$parser = new HtmlParser($invalidHtml);
		try{
			$parser->parse();
			$tagTable = $parser->tagTable;
								
			assert(false, "Invalid HTML excpeiton not thrown");
		} catch (Exception $exception ) {
			// yay	
		}
		
	}
}