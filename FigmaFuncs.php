<?php

class FigmaFuncs {

	//-- live embed
	
	public static $idx = 0;

	public static function figma_liveembed($figma_url) {
		global $wgScriptPath;
		
		$output = "";
		
        $action = isset( $_POST['action'] ) ? $_POST['action'] : "";
		
        if ($action == "parse") {
			$output .= "[FIGMA embed doesn't work in visual editor]";
		} else {			
			$output .= 	
			'<a name="Figma" id="Figma">'.
				'<script src="//code.jquery.com/jquery-1.10.2.js"></script>'.
				'<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>'.    
				'<script type="text/javascript" src="'.$wgScriptPath.'/extensions/Figma/js/figma.js"></script>'.	
				'<link rel="stylesheet" href="'.$wgScriptPath.'/extensions/Figma/css/figma.css">'.
				'<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">'.
				'<link rel="stylesheet" href="/resources/demos/style.css">'.			
				'<script>$(function() {$( "#resizable_'. self::$idx .'" ).resizable({'.
					'stop: function(e,ui) 	'.
					'{'.					
						'var theobject = document.getElementById("resizable_'. self::$idx .'");'.
						'var height2 = theobject.style.height.replace("px","");'.	
						'localStorage.setItem(encodeURI("figmaHeigth_'. $figma_url .'"), height2);'.	  
					'}'.
				'});});</script>'. 
				'<script type="text/javascript">'.
					'var element = document.getElementById("bodyContent");'.
					'var positionInfo = element.getBoundingClientRect();'.

					'var height2 = localStorage.getItem(encodeURI("figmaHeigth_'. $figma_url .'"));'.
					'var width2 = positionInfo.width - 1;'. 
					'if (height2 === null) {'.
					'height2='.htmlspecialchars(600).
					'}'.				

				'document.write(\''.					
					'<div id="resizable_'. self::$idx .'" class="figma-embed" style="border:1px solid #F0F0F0; background:white; padding:3px 5px 5px 3px; width:\'+width2+\'px; height:\'+height2+\'px">'.
						//'<button id="fullScreenbutton" onClick="go2full()">FullScreen</button>'.
						'<iframe style="width:100%; height:100%; border:1px solid #F0F0F0; " class="figma-editor-iframe" src="https://www.figma.com/embed?embed_host=sms-wiki&url=' . $figma_url . '" allowfullscreen ></iframe>'.
					'</div>\'); '.
				'</script>'. 
			'</a>';
					
			self::$idx++;
		}
		
		return $output;
	}
	
	
	public static function figma_svg($figma_url) {
		$output = "";
		$output .= '<div class=figma>';
		
		//-- consts 

		$figma_personal_access_token = "3509-f6ff431d-e3f9-4102-8cb2-ea1072250d6c";
		$figma_api_url = "https://api.figma.com/v1/images/";


		//-- parse full figma image url to parts

		preg_match("/https:\/\/www\.figma\.com\/file\/(.+)\/(.+)?node-id=(.+)/", $figma_url, $params_array);

		$figma_file = $params_array[1];
		$figma_node_id = urldecode($params_array[3]);
		$figma_file_type = "svg";
		//$figma_file_type = "png";
		//$figma_file_type = "jpg";
		$svg_options = "&scale=1";

		if ( $figma_file === null || $figma_node_id  === null) {
			$output .= "wrong params !!!";
			return $output;
		}


		//-- Create a stream to add headers for HTTP GET request
		$opts = array(
		  'http' => array(
			'method' => "GET",
			'header' => "X-Figma-Token: " . $figma_personal_access_token
		  )
		);

		$context = stream_context_create($opts);

		// Open the file using the HTTP headers set above
		$result = file_get_contents( $figma_api_url . $figma_file . "?ids=" . $figma_node_id . "&format=" . $figma_file_type . $svg_options, false, $context);
		$json = json_decode($result, true);
		// $output .= print_r($json, true);

		$imageUrl = $json["images"][$figma_node_id];

		//$output .= $imageUrl;		
		
		if ($figma_file_type == "svg") {
			$output .= '<object type="image/svg+xml" data="' . $imageUrl . '"/>';
		}

		if (($figma_file_type == "png") || ($figma_file_type == "jpg")){
			$output .= '<img src="' . $imageUrl . '" />';
		}
		
		$output .= '</div>';
	    $output .= "<small><i><a href='$figma_url'>$figma_url</a></i></small><br>";
		
		return $output;
	}

	
	
	public static function figma_svg2($figma_url) {
		global $wgArticlePath;
		
		
		$output = "";
		$output .= '<div class=figma>';
		
		$wiki_file_name = FigmaFuncs::figmaFilenameFromUrl($figma_url);
		
		$imgURL = "";
		$image = wfFindFile($wiki_file_name);
		
        if ($image === false) {
			$output .= '<div style="border:2px solid #000; text-align:center;" ><br>Image not found. Press [ UPDATE ] button below.<br><br>' . 
			$wiki_file_name . 
			'<br><br></div>';
        } else {
			//$output .= '<br>'. $wiki_file_name . '<br>';
			//$output .= print_r($image, true);

			$imgURL = $image->getUrl();
			$output .= '<object type="image/svg+xml" data="' . $imgURL . '"></object>';
		}
		
		$output .= '</div>';
		
        $action = isset( $_POST['action'] ) ? $_POST['action'] : "";
        if ($action != "parse") {
			$refreshURL = str_replace('$1', 'Special:FigmaSpecial', $wgArticlePath);
			$refreshURL = "http://" . $_SERVER['HTTP_HOST'] . $refreshURL;
			$refreshURL .= "?url=" . urlencode($figma_url);

			$output .= "<div><small>".
				"<a target=blank href='". $refreshURL ."'>[ UPDATE ]<a/> ".
				"<a target=blank href='$figma_url'>[ Figma ]</a> ".
				"<a target=blank href='/index.php/Image:$wiki_file_name'>[ .svg ]</a> ".
				"</small></div>";
		}
		
		return $output;
	}

	public static function figmaFilenameFromUrl($figma_url) {
		//-- parse full figma image url to parts

		preg_match("/https:\/\/www\.figma\.com\/file\/(.+)\/(.+)?node-id=(.+)/", $figma_url, $params_array);

		$figma_file = $params_array[1];
		$figma_file2 = $params_array[2];
		$figma_node_id = urldecode($params_array[3]);
		$figma_file_type = "svg";
		$svg_options = "&scale=1";

		if ( $figma_file === null || $figma_node_id  === null) {
			$output .= "wrong params !!!";
			return $output;
		}

		// generating filename for wiki by filename in figma
		$wiki_file_name = 'figma_' . $figma_file . '_' . $figma_file2 . '_node_' . $figma_node_id . '.' . $figma_file_type;
		$wiki_file_name = preg_replace( '/[^a-z0-9_\.]+/', '-', strtolower( $wiki_file_name ) );
	
		return $wiki_file_name;
	}
	
}

?>