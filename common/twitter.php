<?php

try
{
	include_once(dirname(dirname(__FILE__)) . "/library/api/twitter.php");
	
	$oTwitter = new Twitter();
	
    $Check = $oTwitter->ListTweets('WlzTn5o5UbnS7ud7lK8Jcg','pg9ct6xKUMgmh7PEaVI46o1t8fLAwrDPzoauqsA','419628875-8zsvkYTQ0TjvEMZnzqHgoVz28R3DQHzUK9sDVHxS','pQmktHMJsRwe7UsmWttHX42ILEgoOXRmIunDLY9Km7k', 'camara_sjc', 5); 
    
	if($Check)
    {
        $Json = json_decode($Check, true);
		foreach ($Json as $Status)
		{
			$link = "http://twitter.com/" . $Status['user']['screen_name'] . "/status/" . $Status['id_str'];
			$name = (($Status['retweeted_status']) ? $Status['retweeted_status']['user']['screen_name'] : $Status['user']['screen_name']);
			$image = (($Status['retweeted_status']) ? $Status['retweeted_status']['user']['profile_image_url'] : $Status['user']['profile_image_url']);
			$text = $Status['text'];
			$time = strtotime($Status['created_at']);
			?>
            <li>
            	<a href="<?=$link;?>" target="_blank"><?=$name;?></a>
				<?=$text;?>
            </li>
			<?php
		}
	}
	else
	{
		throw new Exception("");  
	}
	
}
catch(Exception $ex)
{
	?>
	<li><?=utf8_encode("Twitter parece estar indisponível no momento.");?></li>
	<?php
}

?>