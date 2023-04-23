<?php require_once('./dao/birdDAO.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="bird">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Bird Observation Log</h2>
                        <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Bird </a>
                    </div>
                    <?php
                        $birdDAO = new birdDAO();
                        $birds = $birdDAO->getBirds();
                        
                        if($birds) {
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Common Name</th>";
                                        echo "<th>Latin Name</th>";
                                        echo "<th>Number Observed</th>";
                                        echo "<th>Observation Date</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                foreach($birds as $bird) {
                                    echo "<tr>";
                                        echo "<td>" . $bird->getId(). "</td>";
                                        echo "<td>" . $bird->getCommonName() . "</td>";
                                        echo "<td>" . $bird->getLatinName() . "</td>";
                                        echo "<td>" . $bird->getNumberOfBirds() . "</td>";
                                        echo "<td>" . $bird->getDateObserved() . "</td>";
                                        echo "<td>";
                                            echo '<a href="read.php?bird_id='. $bird->getId() .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="update.php?bird_id='. $bird->getId() .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="delete.php?bird_id='. $bird->getId() .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                   
                    // Close connection
                    $birdDAO->getMysqli()->close();
                    include 'footer.php';
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>

<!-- 

Student Name:  Chloe Lee-Hone
Student Number: 041023578
Course: CST8285_311
Lab Professor: Alem Legesse
Date: 12/04/2022
Description: This project simulates a bird observation database for bird watchers. Users can add, modify, and delete bird observations. Each observation must include the common name, the latin name, the number of 
                birds observed, the date of observation, and a picture of the bird itself (optional). This information, entered by a user on the front end, is sent to the backend and stored in a database upon submission. 
                This project reuses code written in Lab 6, notably the upload.php and script.js files. It also relies on the code provided in CST8285's Week 12 (w12sample-phpdb.zip) [17].

All references cited (Unordered. Please refer to each page for ordered references):
    [1] C. Lee-Hone, CST8285 - Lab 6 - script.js. Algonquin College, 2022.
    [2] C. Lee-Hone, CST8285 - Lab 6 - upload.php. Algonquin College, 2022.
    [3] php.net, "PHP: DateTime::diff - Manual," PHP. https://www.php.net/manual/en/datetime.diff.php (accessed Apr. 11, 2022).
    [4] C. Lee-Hone, CST8285 - Lab 6 - upload.php. Algonquin College, 2022.
    [5] S. Issa, "CST8285 - Week 12 Lecture," presented at the CST8285 - Web Programming, Algonquin College, Mar. 28, 2022.
    [6] W3Schools, "PHP File Upload,"" W3Schools - PHP. https://www.w3schools.com/php/php_file_upload.asp (accessed Mar. 30, 2022). 
    [7] php.net, "PHP: getimagesize - Manual," PHP. https://www.php.net/manual/en/function.getimagesize.php (accessed Mar. 31, 2022).
    [8] php.net, "PHP: move_uploaded_file - Manual," PHP. https://www.php.net/manual/en/function.move-uploaded-file.php (accessed Mar. 31, 2022).
    [9] user: Fred K, "Form submit - Values of disabled inputs will not be submitted - Stack Overflow," Stack Overflow, May 08, 2013. https://stackoverflow.com/questions/1355728/values-of-disabled-inputs-will-not-be-submitted (accessed Apr. 08, 2022).
    [10] GianLuca and Netgloo, "Disabling an input field in a form and sending data," Netgloo Blog, May 31, 2014. https://blog.netgloo.com/2014/05/31/disabling-an-input-field-in-a-form-and-sending-data/ (accessed Apr. 08, 2022).
    [11] Avibase, "Ottawa bird checklist - Avibase - Bird Checklists of the World," Avibase - The World Bird Database. https://avibase.bsc-eoc.org/checklist.jsp?region=CAonoc&list=howardmoore (accessed Apr. 05, 2022).
    [12] php.net, "PHP: mysqli_stmt::bind_param - Manual," PHP. https://www.php.net/manual/en/mysqli-stmt.bind-param.php (accessed Apr. 05, 2022).
    [13] F. Cone, A Peregrine Falcon Perched on a Tree Branch. 2020. Accessed: Apr. 12, 2022. [Photography]. Available: https://www.pexels.com/photo/a-peregrine-falcon-perched-on-a-tree-branch-5247923/
    [14] J. Pishyari, Wilds Ducks Paddling on in Icy Lake. 2021. Accessed: Apr. 12, 2022. [Photography]. Available: https://www.pexels.com/photo/wilds-ducks-paddling-on-in-icy-lake-7102264/
    [15] B. Sayles, Flock of Canada geese soaring in sky during migration. 2021. Accessed: Apr. 12, 2022. [Photography]. Available: https://www.pexels.com/photo/flock-of-canada-geese-soaring-in-sky-during-migration-7651244/
    [16] T. Nord, Photo of Northern Cardinal Perched on Brown Tree Branch. 2020. Accessed: Apr. 12, 2022. [Photography]. Available: https://www.pexels.com/photo/photo-of-northern-cardinal-perched-on-brown-tree-branch-3647326/
    [17] S. Issa, w12sample-phpdb.zip. Algonquin College, 2022.

-->