<?php
  				$username = "joylesswhtppl";
  				$num = 5;

  				$feed = "http://search.twitter.com/search.json?q=from:" . $username . "&amp;rpp=" . $num;

  				$newfile = dirname(__FILE__)."/twitternew.json";
  				$file = dirname(__FILE__)."/twitter.json";

  				copy($feed, $newfile);

  				$oldcontent = @file_get_contents($file);
  				$newcontent = @file_get_contents($newfile);

  				if($oldcontent != $newcontent) {
  				copy($newfile, $file);
  				}
  				$tweets = @file_get_contents($file);

  				$tweets = json_decode($tweets);

  				echo "<ul id=\"twitterfeeder\">";
  				for($x=0;$x<$num;$x++) {
    				$str = ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]","<a href=\"\\0\">\\0</a>", $tweets->results[$x]->text);
    				$pattern = '/[#|@][^\s]*/';
    				preg_match_all($pattern, $str, $matches);	

    				foreach($matches[0] as $keyword) {
        				$keyword = str_replace(")"," ",$keyword);
        				$link = str_replace("#","%23",$keyword);
        				$link = str_replace("@","",$keyword);     
      				if(strstr($keyword,"@")) {
        				$search = "<a href=\"http://twitter.com/$link\"  target=\"_blank\">$keyword</a>";
      				} else {
        				$link = urlencode($link);
        				$search = "<a href=\"http://twitter.com/#search?q=$link\" class=\"spec\">$keyword</a>";        
      				}
      				$str = str_replace($keyword, $search, $str);  
    				}
    				echo "<li>".$str."</li>\n";  
  				}
  				echo "</ul>";

?>      