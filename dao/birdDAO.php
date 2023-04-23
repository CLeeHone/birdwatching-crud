<?php
require_once('abstractDAO.php');
require_once('./model/bird.php');

class birdDAO extends abstractDAO {
        
    function __construct() {
        try{
            parent::__construct();
        } catch(mysqli_sql_exception $e) {
            throw $e;
        }
    }  
    
    public function getBird($bird_id) {
        $query = 'SELECT * FROM local_birds WHERE bird_id = ?';
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('i', $bird_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            $temp = $result->fetch_assoc();
            $bird = new bird($temp['bird_id'],$temp['common_name'], $temp['latin_name'], $temp['number_of_birds'], $temp['date_observed'], $temp['img']);
            $result->free();
            return $bird;
        }
        $result->free();
        return false;
    }

    public function getBirds() {
        // The query method returns a mysqli_result object
        $result = $this->mysqli->query('SELECT * FROM local_birds');
        $birds = Array();
        
        if($result->num_rows >= 1) {
            while($row = $result->fetch_assoc()) {
                // Create a new Bird object, and add it to the array.
                $bird = new Bird($row['bird_id'], $row['common_name'], $row['latin_name'], $row['number_of_birds'], $row['date_observed'], $row['img']);
                $birds[] = $bird;
            }
            $result->free();
            return $birds;
        }
        $result->free();
        return false;
    }   
    
    public function addBird($bird) {
        
        if(!$this->mysqli->connect_errno) {
            // The query uses the question mark (?) as a
            // placeholder for the parameters to be used
            // in the query.
            // The prepare method of the mysqli object returns
            // a mysqli_stmt object. It takes a parameterized 
            // query as a parameter.
			$query = 'INSERT INTO local_birds (common_name, latin_name, number_of_birds, date_observed, img) VALUES (?,?,?,?,?)'; 
			$stmt = $this->mysqli->prepare($query);
            if($stmt){
                    $common_name = $bird->getCommonName();
			        $latin_name = $bird->getLatinName();
			        $number_of_birds = $bird->getNumberOfBirds();
                    $date_observed = $bird->getDateObserved();
                    $img = $bird->getImage();
                  
			        $stmt->bind_param(
                        'ssiss', // Passing a string, string, int, string, string -> ssiss [1]
				        $common_name,
				        $latin_name,
				        $number_of_birds,
                        $date_observed,
                        $img
			        );    
                    // Execute the statement
                    $stmt->execute();         
                    
                    if($stmt->error){
                        return $stmt->error;
                    } else {
                        return $bird->getCommonName() . ' added successfully!';
                    } 
			}
             else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }
       
        }else {
            return 'Could not connect to Database.';
        }
    }   

    public function updateBird($bird) {

        if(!$this->mysqli->connect_errno) {
            // The query uses the question mark (?) as a
            // placeholder for the parameters to be used
            // in the query.
            // The prepare method of the mysqli object returns
            // a mysqli_stmt object. It takes a parameterized 
            // query as a parameter.
            $query = 'UPDATE local_birds SET common_name=?, latin_name=?, number_of_birds=?, date_observed=?, img=? WHERE bird_id=?';
            $stmt = $this->mysqli->prepare($query);
            if($stmt) {
                    $bird_id = $bird->getId();
                    $common_name = $bird->getCommonName();
			        $latin_name = $bird->getLatinName();
			        $number_of_birds = $bird->getNumberOfBirds();
                    $date_observed = $bird->getDateObserved();
                    $img = $bird->getImage();
                  
			        $stmt->bind_param(
                        'ssissi', // string, string, int, string, string, int [1] 
				        $common_name,
				        $latin_name,
				        $number_of_birds,
                        $date_observed,
                        $img,
                        $bird_id 
			        );    
                    // Execute the statement
                    $stmt->execute();         
                    
                    if($stmt->error) {
                        return $stmt->error;
                    } else {
                        return $bird->getCommonName() . ' updated successfully!';
                    } 
			}
             else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }
       
        }else {
            return 'Could not connect to Database.';
        }
    }   

    public function deleteBird($bird_id) {
        if(!$this->mysqli->connect_errno) {
            $query = 'DELETE FROM local_birds WHERE bird_id=?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('i', $bird_id);
            $stmt->execute();

            if($stmt->error){
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}
// Reference cited:
// [1]  php.net, "PHP: mysqli_stmt::bind_param - Manual," PHP. https://www.php.net/manual/en/mysqli-stmt.bind-param.php (accessed Apr. 05, 2022).
?>

