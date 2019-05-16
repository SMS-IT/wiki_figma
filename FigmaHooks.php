<?php

#ini_set('display_errors', 1);
#error_reporting(-1);

class FigmaHooks {

    # Setup the AnyWikDraw parser function
    public static function efFigmaParserFirstCallInit(Parser &$parser) {
		// xml tag <figma url="xxx">frame</figma>
		foreach ( array( 'figma' ) as $tag ) {
			$parser->setHook( $tag, array( 'FigmaHooks', 'parserHookTag' ) );
		}
    }

	// xml tag <figma url="xxx">frame</figma>
	public static function parserHookTag( $text, $args = array(), $parser ) {
		$out = FigmaHooks::efFigmaParserFunction_Render($parser, $text);
		return $out;
	}
		
	
	// tag
	// <figma width=(optional) height=(optional) >file</figma>
    public static function efFigmaParserFunction_Render( &$parser, $name = null ) {
        global $wgUser, $wgLang, $wgTitle, $wgRightsText, $wgOut, $wgArticlePath, $wgScriptPath, $wgEnableUploads;

        // Don't cache pages with xml tag <figma url="xxx">frame</figma> on it
        $parser->disableCache();
        
        # Validate parameters
        $error = '';
		$name = str_replace(array("\n", "\r", " "), '', $name);		
        if ($name == null || strlen($name) == 0) {
            $error .= '<br>Please specify a name for your figma diagram.';
        }

        if (strlen($error) > 0) {
            $error = '<div style="border:1px solid #000; text-align:center; padding: 10px; display:table;">'.
					'<b>Sorry.</b>'.$error.'<br>'.
                    'Usage: <code><figma><i>figma_frame</i></figma></code><br>'.
                    'Example: <code><figma>figma_frame</figma></code><br>'.
					'</div>';
            return array($error, 'isHTML'=>true, 'noparse'=>true);
        }

		
        # The parser function itself
        # The input parameters are wikitext with templates expanded
        # The output should be wikitext too, but in this case, it is HTML
        #return array("param1 is $param1 and param2 is $param2", 'isHTML');

        $isProtected = $parser->getTitle()->isProtected();
       
        $output = '';
		
		//$output .= FigmaFuncs::figma_liveembed($name);
		$output .= FigmaFuncs::figma_svg2($name);
	
        $return = array($output, 'isHTML'=>true, 'noparse'=>true);
        return $return;
    }
	
	
}
?>