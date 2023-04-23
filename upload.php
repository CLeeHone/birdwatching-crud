<?php
    // Assignment 2 reuses Lab 6 upload.php script [1]. 
    // This script makes sure an image is successfully uploaded.
    // If image is valid, print 1 back to the JS script. Otherwise, print an error message.
    // Script inspired by Prof. Issa's Week 12 Lecture [2] 27:55-30:20, and [3].
    
    // Declare variable that contains the image folder's name
    $targetDirectory = "imgs/";
    // Declare variable that contains the concatenated directory name and filename
    $targetFile = $targetDirectory . basename($_FILES["file"]["name"]);
    
    // If the upload variable has been set, then:
    if (isset($_POST["upload"])) {
        // Check that the image to be uploaded is valid. If an invalid image or file was provided, the variable $imageSize will contain the value "false" [4].
        // If image is invalid, for example if a text file is attempted to be uploaded, the following method will throw an error back to the JS script.
        $imageSize = getimagesize($_FILES["file"]["tmp_name"]);

        // If the image is valid, the image is moved [5] and a successful message (1) is returned to the JS script. Otherwise, print error message.
        if ($imageSize !== false) {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
                print 1;
            } else {
                print "Error: Image is not a valid size";
            }
        }
    }

    // References cited:
    // [1] C. Lee-Hone, CST8285 - Lab 6 - upload.php. Algonquin College, 2022.
    // [2] S. Issa, "CST8285 - Week 12 Lecture," presented at the CST8285 - Web Programming, Algonquin College, Mar. 28, 2022.
    // [3] W3Schools, "PHP File Upload,"" W3Schools - PHP. https://www.w3schools.com/php/php_file_upload.asp (accessed Mar. 30, 2022). 
    // [4] php.net, "PHP: getimagesize - Manual," PHP. https://www.php.net/manual/en/function.getimagesize.php (accessed Mar. 31, 2022).
    // [5] php.net, "PHP: move_uploaded_file - Manual," PHP. https://www.php.net/manual/en/function.move-uploaded-file.php (accessed Mar. 31, 2022).
?>