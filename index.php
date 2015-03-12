<html>

 <body>
    <?php
    
    require( "app/HtmlParser.php");
    
    if (array_key_exists('URL', $_POST)) {
    	$html = file_get_contents(htmlspecialchars($_POST['URL']));
    	$html = file_get_contents("www.google.com");
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
