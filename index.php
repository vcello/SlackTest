<html>

 <body>
    <?php
    
    require( "app/HtmlParser.php");
    
    if (array_key_exists('URL', $_POST)) {
    	
    	$curlHandler = curl_init($_POST['URL']);
//     	$curlHandler = curl_init('http://www.pockettactics.com');
		curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, true);
    	$html = curl_exec($curlHandler);
    	
       	$parser = new HtmlParser($html);
    	$parser->parse();
    	foreach( $parser->tagTable as $tag=>$count ){
    		echo $tag, ":", $count, PHP_EOL;
    	}
    	curl_close($curlHandler);
    	
    	echo htmlspecialchars($html);
    }
    ?>
	<form action="/" method="post">
		<div><input name="URL" rows="1" cols="60"></input></div>
		<div><input type="submit" value="Fetch HTML"></div>
	</form>
</body>

</html>
