<?php
// Include birdDAO file
require_once('./dao/birdDAO.php');
 
// Define variables and initialize with empty values
$common_name = $latin_name = $number_of_birds = $date_observed = $img = "";
$common_name_err = $latin_name_err = $number_of_birds_err = $date_observed_err = "";
$birdDAO = new birdDAO(); 

// Processing form data when form is submitted
if(isset($_POST["bird_id"]) && !empty($_POST["bird_id"])) {
    // Get hidden input value
    $bird_id = $_POST["bird_id"];
    
    // Validate bird's common name
    $input_common_name = trim($_POST["common_name"]);
    if(empty($input_common_name)) {
        $common_name_err = "Please enter the bird's common name.";
    } elseif(!filter_var($input_common_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $common_name = $input_common_name;
    }
    
    // Validate bird's latin name
    $input_latin_name = trim($_POST["latin_name"]);
    if(empty($input_latin_name)) {
        $latin_name_err = "Please enter the bird's latin name.";
    } elseif(!filter_var($input_latin_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $latin_name_err = "Please enter a valid name.";
    } else {
        $latin_name = $input_latin_name;
    }
    
    // Validate number of birds entered. Entry must be greater than 0 and a valid number (Strings, ex. "five", are not accepted).
    $input_bird_number = trim($_POST["number_of_birds"]);
    if(empty($input_bird_number)) {
        $number_of_birds_err = "Please enter the number of birds observed.";     
    } elseif(!ctype_digit($input_bird_number)) {
        $number_of_birds_err = "Please enter a number greater than 0.";
    } else {
        $number_of_birds = $input_bird_number;
    }

    // Validate date entered. Taught myself to use DateTime objects using PHP documentation [1]
    $input_date = trim($_POST["date_observed"]);
    // Create DateTime object from input date [1]
    $input_date_formatted = new DateTime($input_date);
    // Create DateTime object representing the current date [1]
    $current_date = new DateTime("now");

    if(empty($input_date)) {
        $date_observed_err = "Please enter the observation date.";     
     // Date entered by user must be in the past (smaller or equal to current date). Otherwise, prevent submission of the form and set error message.    
    } elseif($input_date_formatted > $current_date) {
        $date_observed_err = "Please enter a past date. Cannot enter a future bird observation.";
    } else {
        $date_observed = $input_date;
    }

    // Validate image entered. If no image was uploaded, set value in database to NULL. Uploading an image is optional, and therefore no error message
    // is produced. 
    $uploaded_image = trim($_POST["image"]);
    if(empty($uploaded_image)) {
        $img = NULL;
    } else {
        $img = $uploaded_image;
    }
    
    // Check input errors before inserting in database. If all are empty, then form is submitted.
    if(empty($common_name_err) && empty($latin_name_err) && empty($number_of_birds_err) && empty($date_observed_err)){   
        $bird = new Bird($bird_id, $common_name, $latin_name, $number_of_birds, $date_observed, $img);
        $result = $birdDAO->updateBird($bird);
        echo '<br><h6 style="text-align:center">' . $result . '</h6>';   
        header( "refresh:2; url=index.php" ); 
        // Close connection
        $birdDAO->getMysqli()->close();
    }

} else {
    // Check existence of id parameter before processing further
    if(isset($_GET["bird_id"]) && !empty(trim($_GET["bird_id"]))) {
        // Get URL parameter
        $bird_id =  trim($_GET["bird_id"]);
        $bird = $birdDAO->getBird($bird_id);
                
        if($bird) {
            // Retrieve individual field value
            $common_name = $bird->getCommonName();
            $latin_name = $bird->getLatinName();
            $number_of_birds = $bird->getNumberOfBirds();
            $date_observed = $bird->getDateObserved();
            $img = $bird->getImage();
        } else {
            // URL doesn't contain valid id. Redirect to error page
            header("location: error.php");
            exit();
        }
    } else {
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
    // Close connection
    $birdDAO->getMysqli()->close();
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the bird observation record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Common Name</label>
                            <input type="text" name="common_name" class="form-control <?php echo (!empty($common_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $common_name; ?>">
                            <span class="invalid-feedback"><?php echo $common_name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Latin Name</label>
                            <textarea name="latin_name" class="form-control <?php echo (!empty($latin_name_err)) ? 'is-invalid' : ''; ?>"><?php echo $latin_name; ?></textarea>
                            <span class="invalid-feedback"><?php echo $latin_name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Number of Birds Observed</label>
                            <input type="text" name="number_of_birds" class="form-control <?php echo (!empty($number_of_birds_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $number_of_birds; ?>">
                            <span class="invalid-feedback"><?php echo $number_of_birds_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Observation Date</label>
                            <input type="text" name="date_observed" class="form-control <?php echo (!empty($date_observed_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $date_observed; ?>">
                            <span class="invalid-feedback"><?php echo $date_observed_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Image File Name</label>
                            <input type="text" name="image" id="imageName" class="form-control" value="<?php echo $img; ?>" readonly>
                        </div>
                        <input type="hidden" name="bird_id" value="<?php echo $bird_id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>

                    <!-- modal and upload button --> 
                    <div class="container">
                        <div class="row justify-content-md-center">
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <button class="btn btn-light mb-3 float-right" data-toggle="modal" data-target="#uploadModal">Upload</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModal" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Upload</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="file" accept="image/*" id="imageFile"> 
                                            <p id="uploadError"></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" onclick="uploadFile()">Upload</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>

<!--
References cited:
[1] php.net, "PHP: DateTime::diff - Manual," PHP. https://www.php.net/manual/en/datetime.diff.php (accessed Apr. 11, 2022).
-->