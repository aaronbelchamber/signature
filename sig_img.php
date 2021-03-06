<?
# Send json string to this handler within the SRC attribute of an HTML IMG tag
# <img src="/includes/sig_img.php?json=<?=$main_sig_url?>" />
# $main_sig_url is JSON string generated by the jQuery signature plug-in and is in this format:

# Example of json string format genrated by kbwood's signature
/*
$json='{"lines":[[[64.48,19.45],[65.48,16.45],[65.48,10.45],[65.48,8.45],[65.48,7.45],[64.48,7.45],[63.48,7.45],[60.48,7.45],[53.48,10.45],[46.48,16.45],[37.48,24.45],[29.48,33.45],[24.48,40.45],[21.48,45.45],[21.48,47.45],[21.48,48.45],[21.48,50.45],[22.48,52.45],[26.48,56.45],[34.48,60.45],[44.48,64.45],[55.48,63.45],[69.48,54.45],[78.48,45.45],[82.48,37.45],[83.48,33.45],[83.48,31.45],[81.48,31.45],[80.48,30.45],[79.48,30.45],[76.48,32.45],[70.48,37.45],[64.48,44.45],[57.48,50.45],[52.48,56.45],[52.48,58.45],[52.48,59.45],[53.48,60.45],[55.48,60.45],[61.48,60.45],[70.48,56.45],[75.48,54.45]],[[129.48,37.45],[127.48,41.45],[124.48,49.45],[120.48,54.45],[118.48,59.45],[119.48,56.45],[122.48,45.45],[125.48,30.45],[127.48,14.45],[129.48,3.45],[129.48,1.45],[132.48,1.45],[136.48,6.45],[144.48,12.45],[148.48,15.45],[149.48,17.45],[147.48,19.45],[141.48,22.45],[136.48,25.45],[131.48,26.45],[129.48,26.45],[129.48,27.45],[129.48,29.45],[135.48,33.45],[142.48,41.45],[148.48,47.45],[147.48,48.45],[146.48,49.45],[146.48,50.45],[148.48,53.45],[149.48,54.45],[146.48,54.45],[139.48,54.45],[134.48,54.45],[132.48,54.45],[131.48,54.45],[131.48,55.45],[133.48,56.45],[135.48,56.45],[138.48,56.45],[139.48,56.45],[140.48,56.45]]]}';
*/


$json=urldecode($_REQUEST['json']);

header ("Content-type: image/png");
$im = @imagecreatetruecolor(240, 75) or die ("Cannot Initialize new GD image stream");

imagesetthickness($im,2);
imageantialias($im, true);

$background_color = imagecolorallocate ($im, 255, 255, 255);
$text_color = imagecolorallocate ($im,0,0,0);

imagefill($im,0,0,$background_color);


# There's probably an easier way to clean/parse the JSON string, but this works, too
$json_arr=explode("[",$json);
$rmv=array('"',"'","{","}","[");


#  Extract JSON
for($i=0;$i<count($json_arr);$i++)
{
	$el=$json_arr[$i];
	
	$el=str_ireplace($rmv,'',$el);	
	$el_arr=explode(",",$el);
	
	$x=$el_arr[0];
	$y=$el_arr[1];
			
	if ($x!='')
		{	
			$cnt++;
			
			if (substr_count("]",$y)>1)	{	$cnt=1;	}
			
			$y=str_replace("]","",$y);
			
			if ($cnt==1)
				{
					$x1=$x;
					$y1=$y;	
				}
				
			if ($cnt==2)
				{
					 $x2=$x;
					 $y2=$y;
					 imageline ($im,round($x1),round($y1),round($x),round($y),$text_color);
					 
					 $cnt=1;
					 $x1=$x2;
					 $y1=$y2;
				}
		}
		else {$cnt=0;}
}

imagepng($im);
