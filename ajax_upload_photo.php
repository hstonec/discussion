<div class="form-group">
            <label for="photo">Photo:</label>
            <label class="radio-inline"><input type="radio" id="photodefault" name="photochoice" value="1" checked>Use Default</label>
            <label class="radio-inline"><input type="radio" id="photoupload" name="photochoice" value="2">Upload</label>
            <input type="file" class="form-control hide" id="photo">
          </div>
		  
		  
		  
		  $("#photodefault").change(function() {
        if ($(this).prop("checked"))
            $("#photo").addClass("hide");
    });
    $("#photoupload").change(function() {
        if ($(this).prop("checked"))
            $("#photo").removeClass("hide");
    });
	
	
	
	 &&
    isset($_POST["photochoice"])
	
	,
                         $_POST["photochoice"]
						 
	if ($photochoice == "" || ($photochoice != "1" && $photochoice != "2"))
        return "Photo Upload Choice is empty or invalid!";
		
		
		//verify upload file
    if ($photochoice == "2") {
        if (!isset($_FILES["photo"]))
            return "Didn't receive any file.";
        if (gettype($_FILES["photo"]["error"]) == "array")
            return "Only accept one file!";
        $res = isValidUploadFile($_FILES["photo"]["error"]);
        if ($res !== true)
            return $res;
        $res = isValidImage($_FILES["photo"]["name"]);
        if ($res !== true)
            return $res;
        $photoDir = "photo/";
        $filePath = $photoDir.$username.".".pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
        if (file_exists($filePath))
            unlink($filePath);
        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $filePath))
            return "Fail to move file, please contact administrator!";
    } else
        $filePath = "photo/default.png";