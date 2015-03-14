<html>
<head>
<link rel="stylesheet" type="text/css" href="css/style.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
var previouslyClicked;
$(document).ready(function(){
	$("p").click(
		function() {
			if( $(this) !== previouslyClicked ){
				previouslyClicked.css("background", "white");
				previouslyClicked = $(this);
				$(this).css("background", "yellow");
			}
		} 
	);
});
</script>
</head>

 <body>
 	<div id="header">
 	Slack Exercise
 	</div>
    <?php
    
    require( "app/HtmlParser.php");
    
    if (array_key_exists('URL', $_POST)) {
    	
    	$curlHandler = curl_init($_POST['URL']);
//     	$curlHandler = curl_init('http://www.pockettactics.com');
		curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, true);
    	$html = curl_exec($curlHandler);
    	
       	$parser = new HtmlParser($html);
    	$parser->parse();
    ?>
    <div id="tags">
	<?php
    	foreach( $parser->tagTable as $tag=>$count ){
    		echo "<p>", $tag, ":", $count, "</p>", PHP_EOL;
    	}
    ?>
 	</div>
 	
 	<div id="htmlContent">
 	<?php 
    	curl_close($curlHandler);
    	
    	echo htmlspecialchars($html);
    }
    ?>
    </div>
    
	<form action="/" method="post">
		<div><input name="URL" rows="1" cols="60"></input></div>
		<div><input type="submit" value="Fetch HTML"></div>
	</form>
</body>

</html>
