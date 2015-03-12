<html>

 <body>
    <?php
    
    require( "app/HtmlParser.php");
    
    if (array_key_exists('URL', $_POST)) {
    	$html = curl_exec(curl_init($_POST['URL']));
    	echo $html;
    	$parser = new HtmlParser($html);
    	foreach( $parser->tagTable as $tag=>$count ){
    		echo $tag, ":", $count;
    	}
    }
    ?>
	<form action="/" method="post">
		<div><input name="URL" rows="1" cols="60"></input></div>
		<div><input type="submit" value="Fetch HTML"></div>
	</form>
</body>

</html>
