<html>
<head>
	<title>Browntape Test Twitter</title>
</head>
<body>
<form action="#" method="POST">
<label>Search : <input type="text" name="keyword" placeholder="Enter Keyword "></label>
<input type="submit">
    
</form>
<?php
error_reporting(1);
ini_set('display_errors', 1);

require "autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['keyword'])) {

	$config_file='config.json';//config file for keys

	if(!file_exists($config_file)){

		echo 'config file missing';
		die();
	}
	else{

		
		$config_contents=file_get_contents($config_file);
		$config=json_decode($config_contents,true);

		$keyword=$_POST['keyword'];

		$connection = new TwitterOAuth($config['consumer_key'], $config['consumer_key_secret'], $config['$access_token'], $config['access_token_secret']);
		$connection->setTimeouts(10, 15);//change time out to 15

		$tweets = $connection->get("search/tweets", array("q" => $keyword,"count" => "10"));// send keyword to search
		
		if ($connection->getLastHttpCode() == 200) {
    	
    		// connected

			echo "<ol start='1'>";
                foreach ($tweets as $tweet) {

                	
                	    foreach ($tweet as $twt) {

            	    		
            	    		if($twt->user->profile_image_url != NULL && $twt->text != NULL){

            	    			echo '<br>';
            	    	    	echo "<li>".'<img src="'.$twt->user->profile_image_url.'"/>'.$twt->text.'</li>';
                            	echo '<br>';
            	    		
            	    		}
            	    		
                   	    	    
                        }// single result forloop end
                    

                }//tweets forloop end
            echo '<ol>';


		}else{
	
	    	// Handle error case
			echo 'Connection error';
		}//error handling end

	}// check for config file end

}// check post request end


?>
</body>
</html>