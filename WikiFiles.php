<?php

class WikiFiles {

	// looking for file by name in data base wiki files (base name, not a name in file system) 
	public static function wiki_find_file($filename) {
		$file = wfFindFile($filename);
		return $file;
	}

	// download file into wiki
	// type - mime type of file
	// body - body of file
	// name - filename
	public static function wiki_upload_file($fileName, $fileBody, $fileType = 'text/plain') {
        global $wgRequest, $wgUser;

		$outcome = "";

        $file_len = strlen($fileBody);

        if ($file_len > 0) {
			// creating temp file
            $tmp_name = $_SERVER["DOCUMENT_ROOT"] . "/tmp/tmp_" . $fileName . "_" . rand(0,1000).rand(0,1000);
            $f = fopen($tmp_name, "w");
            fwrite($f, $fileBody);
            fclose($f);

			// generate request
			$wgRequest->setVal('wpDestFile', $fileName);
			$wgRequest->setVal('wpIgnoreWarning', '1');
			$wgRequest->setVal('wpDestFileWarningAck', '1');
			$wgRequest->setVal('wpUploadDescription', "");
			$wgRequest->setVal('action', "");

            $_FILES['wpUploadFile']['name'] = $fileName;
            $_FILES['wpUploadFile']['type'] = $fileType;
            $_FILES['wpUploadFile']['error'] = 0;
            $_FILES['wpUploadFile']['size'] = $file_len;
            $_FILES['wpUploadFile']['tmp_name'] = $tmp_name;
			
            // uploading file to wiki
            $form = UploadBase::createFromRequest($wgRequest, null);
			$outcome = $form->verifyUpload();
            $res = $form->performUpload("", "", true, $wgUser);

			// remove temp file
            if (file_exists($tmp_name)) {
				unlink($tmp_name);
            }
        }
	
        return $outcome;
    }
	
	// processing result and format error string
    public static function wiki_process_upload_result($outcome) {
		$res = "";
		$header = "";
		$errorcode = 200;
		
        // Return outcome along with an appropriate error message to the client
        switch ($outcome['status']) {
            case  UploadBase::SUCCESS :
                $header = 'HTTP/1.0 200 OK';
                //header('Content-Type: text/json');
                $res = '{"success":"true"}';
                break;
                
            case  UploadBase::FILE_TOO_LARGE :
                $header = 'HTTP/1.0 500 Internal Server Error';
                $res = wfMsgHtml( 'largefileserver' );
                break;

            case  UploadBase::EMPTY_FILE :
                $header = 'HTTP/1.0 400 Bad Request';
                $res = wfMsgHtml( 'emptyfile' );
                break;

            case  UploadBase::MIN_LENGTH_PARTNAME :
                $header = 'HTTP/1.0 400 Bad Request';
                $res = wfMsgHtml( 'minlength1' );
                break;

            case  UploadBase::ILLEGAL_FILENAME :
                $header = 'HTTP/1.0 400 Bad Request';
                $res = wfMsgHtml( 'illegalfilename' );
                break;
				
            case  UploadBase::OVERWRITE_EXISTING_FILE :
                $header = 'HTTP/1.0 403 Forbidden';
                $res = 'You may not overwrite the existing file';
                break;

            case  UploadBase::FILETYPE_MISSING :
                $header = 'HTTP/1.0 400 Bad Request';
                $res = 'The type of the uploaded file is not explicitly allowed';
                break;

            case  UploadBase::FILETYPE_BADTYPE :
                $header = 'HTTP/1.0 400 Bad Request';
                $res = 'The type of the uploaded file is explicitly disallowed.';
                break;

            case  UploadBase::VERIFICATION_ERROR :
                $header = 'HTTP/1.0 400 Bad Request';
                $res = 'The uploaded file did not pass server verification: ' . print_r($outcome, true);
                break;

            case  UploadBase::UPLOAD_VERIFICATION_ERROR :
                $header = 'HTTP/1.0 403 Bad Request';
                $res = 'The uploaded file did not pass server verification: ' .
                  $this->_echoDetails($details['error']);
                break;

            default :
                $header = 'HTTP/1.0 500 Internal Server Error';
                $res = 'Function UploadForm:internalProcessUpload returned an unknown code: ' . print_r($outcome, true);
                break;
        }
		
		return $res;
    }
	

    public static function _echoDetails($msg) {
		$res = "";
		
        if (is_array($msg)) {
            foreach ($msg as $submsg) {
                $res .= $this->_echoDetails($submsg);
            }
        } else {
            $res .= '<p>' . $msg . '</p>';
        }
		
		return $res;
    }

	
}

?>