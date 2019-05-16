<?php

ini_set('display_errors', 1);
error_reporting(-1);

class FigmaSpecial extends SpecialPage {

    static $version = "0.01";

	function __construct() {
        parent::__construct( 'FigmaSpecial' );

        $this->mUploadDescription = '';
        $this->mLicense = '';
        $this->mUploadCopyStatus = '';
        $this->mUploadSource = '';
        $this->mWatchthis = false;

	}
	
	
	function execute( $par ) {
		//-- consts 
		$figma_personal_access_token = "3509-f6ff431d-e3f9-4102-8cb2-ea1072250d6c";
		$figma_api_url = "https://api.figma.com/v1/images/";


		$output = "<br> -- updating figma image --";

		$figma_url = $_GET['url'];
		$output .= "<br> figma url: " . $figma_url;
		
		$wiki_file_name = FigmaFuncs::figmaFilenameFromUrl($figma_url);
		$output .= "<br> wiki file name for figma: " . $wiki_file_name;


		//-- parse full figma image url to parts

		preg_match("/https:\/\/www\.figma\.com\/file\/(.+)\/(.+)?node-id=(.+)/", $figma_url, $params_array);

		$figma_file = $params_array[1];
		$figma_file2 = $params_array[2];
		$figma_node_id = urldecode($params_array[3]);
		$figma_file_type = "svg";
		$svg_options = "&scale=1";

		$figma_api_request = $figma_api_url . $figma_file . "?ids=" . $figma_node_id . "&format=" . $figma_file_type . $svg_options;
		$output .= "<br> figma api request: " . $figma_api_request;


		//-- Create a stream to add headers for HTTP GET request
		$opts = array(
		  'http' => array(
			'method' => "GET",
			'header' => "X-Figma-Token: " . $figma_personal_access_token
		  )
		);
		$context = stream_context_create($opts);

		//-- Open the file using the HTTP headers set above
		$result = file_get_contents( $figma_api_request, false, $context);
		$json = json_decode($result, true);
		//$output .= print_r($json, true);

		$imageUrl = $json["images"][$figma_node_id];
		$output .= "<br>image remote url: " . "<a href=\"$imageUrl\">$imageUrl</a>";


		//-- get image content
		$img_content = file_get_contents( $imageUrl );
		$output .= "<br><hr><br>";
		$output .= print_r($img_content, true);


		//-- save image to wiki
		$saveres = WikiFiles::wiki_upload_file($wiki_file_name, $img_content, 'image/svg+xml');
		$output .= "<br><hr><br>";
		$output .= "save image to wiki: " . print_r($saveres, true);

		echo $output;
		exit();
	}

}

?>