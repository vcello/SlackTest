<?php
require 'app/HtmlParser.php';

$test = new HtmlParserTest();
$test->testCountTagsWithValidHtml();
//$test->testCountTagsWithInvalidHtml();
$test->testAnnotateSimpleHtml();
$test->testAnnotateComplexHtml();

//class HtmlParserTest extends PHPUnit_Framework_TestCase
class HtmlParserTest
{
		
	public function __construct(){}
		
	public function testCountTagsWithValidHtml(){

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
	
	public function testAnnotateSimpleHtml(){
		$validHtml = "<html><body></body></html>";
		
		// The output of htmlspecialchars($validHtml) looks like:
		// &lt;html&gt;&lt;body&gt;&lt;/body&gt;&lt;/html&gt;
		
		// So the expected annotated output should look like:
		// <span id=html>&lt;html&gt;</span>
		// <span id=body>&lt;body&gt;</span>
		// <span id=body>&lt;/body&gt;</span>
		// <span id=html>&lt;/html&gt;</span>
		
		$expectedAnnotatedHtml = "<span id=html>&lt;html&gt;</span><span id=body>&lt;body&gt;</span><span id=body>&lt;/body&gt;</span><span id=html>&lt;/html&gt;</span>";
		$parser = new HtmlParser($validHtml);
		$annotatedHtml = $parser->annotate();
		
		assert($annotatedHtml == $expectedAnnotatedHtml, "Simple annotations failed");
		
	}	
	
	public function testAnnotateComplexHtml(){
		$validHtml = "<html><body><div id='aDiv'></div></body></html>";
		
		// The output of htmlspecialchars($validHtml) looks like:
		// &lt;html&gt;&lt;body&gt;&lt;div id='aDiv'&gt;&lt;/div&gt;&lt;/body&gt;&lt;/html&gt;
		
		// So the expected annotated output should look like:
		// <span id=html>&lt;html&gt;</span>
		// <span id=body>&lt;body&gt;</span>
		// <span id=div>&lt;div id='aDiv'&gt;</span>
		// <span id=div>&lt;/div&gt;</span>
		// <span id=body>&lt;/body&gt;</span>
		// <span id=html>&lt;/html&gt;</span>
		
		$expectedAnnotatedHtml = "<span id=html>&lt;html&gt;</span><span id=body>&lt;body&gt;</span><span id=div>&lt;div id='aDiv'&gt;</span><span id=div>&lt;/div&gt;</span><span id=body>&lt;/body&gt;</span><span id=html>&lt;/html&gt;</span>";
        $parser = new HtmlParser($validHtml);
		$annotatedHtml = $parser->annotate();
		
		echo PHP_EOL, htmlspecialchars($validHtml), PHP_EOL, PHP_EOL;	
		echo $annotatedHtml, PHP_EOL, PHP_EOL;
		
		assert($annotatedHtml == $expectedAnnotatedHtml, "Complex annotations failed");

	}
}