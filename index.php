<html>
<head>
<link rel="stylesheet" type="text/css" href="css/style.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
// click handler
$(document).ready(function(){
	$("span").click(
		function() {
			$("span").css("background", "white"); // unhighlight previously clicked tag
			$("#htmlContent").css("background", "white"); // unhighlight html
			$(this).css("background", "yellow"); // highlight currently clicked tag
			
			// highlight in html		
			var searchString = $(this).html();
			$("." + searchString).css("background", "yellow"); // highlight in html
		
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
		curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, true);
    	$html = curl_exec($curlHandler);
    	
    	
    	// error handling
		if (curl_error($c))
			die(curl_error($c));
		$status = curl_getinfo($c, CURLINFO_HTTP_CODE);
		curl_close($curlHandler);
		
       	$parser = new HtmlParser($html);
    	$parser->parse();
    ?>
    <div id="tags">
	<?php
    	foreach( $parser->tagTable as $tag=>$count ){
    		echo "<p><span id='tag'>", $tag, "</span>: (", $count, ")</p>", PHP_EOL;
    	}
    ?>
 	</div>
 	
 	<div id="htmlContent">
 	<?php 
    	echo $parser->annotate(); 
    }
    ?>
    </div>
    
    <div id="theForm">
 	<form action="/" method="post">
		<div><input name="URL" rows="1" cols="60"></input></div>
		<div><input type="submit" value="Fetch HTML"></div>
	</form>
	</div>
	
</body>

</html>
