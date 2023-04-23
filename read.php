<?php
// Include birdDAO file
require_once('./dao/birdDAO.php');
$birdDAO = new birdDAO(); 

// Check existence of bird_id parameter before processing further
if(isset($_GET["bird_id"]) && !empty(trim($_GET["bird_id"]))) {
    // Get URL parameter
    $bird_id =  trim($_GET["bird_id"]);
    $bird = $birdDAO->getBird($bird_id);
            
    // Check if the bird object has an image associated with it. If so, include the image.
    if($bird->getImage()) {
        // Retrieve individual field value
        $common_name = $bird->getCommonName();
        $latin_name = $bird->getLatinName();
        $number_of_birds = $bird->getNumberOfBirds();
        $date_observed = $bird->getDateObserved();
        $img = $bird->getImage();
    // If no image has been uploaded, use placeholder image.    
    } else if (!$bird->getImage()) {
        $common_name = $bird->getCommonName();
        $latin_name = $bird->getLatinName();
        $number_of_birds = $bird->getNumberOfBirds();
        $date_observed = $bird->getDateObserved();
        // If no image was associated with the entry, print a generic "no-image" image.
        // I created the "Image unavailable" picture using InkScape. 
        $img = "unavailable.png"; 
    } else {
        // URL doesn't contain valid bird_id. Redirect to error page
        header("location: error.php");
        exit();
    }
} else {
    // URL doesn't contain bird_id parameter. Redirect to error page
    header("location: error.php");
    exit();
} 

// Close connection
$birdDAO->getMysqli()->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
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
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>Common Name</label>
                        <p><b><?php echo $common_name; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Latin Name</label>
                        <p><b><?php echo $latin_name; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Number of Birds Observed</label>
                        <p><b><?php echo $number_of_birds; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Date Observed</label>
                        <p><b><?php echo $date_observed; ?></b></p>
                    </div>
                    <div class="form-group">
                        <img src="imgs/<?php echo $img ?>" width="350"> <!-- get file name from database variable $img-->
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>