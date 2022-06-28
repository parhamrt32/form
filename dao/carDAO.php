<?php
// load abstractDAO
require_once('abstractDAO.php');
// load car model
require_once('./model/car.php');

//carDAO class that extends abstractDAO
class carDAO extends abstractDAO{
    function __construct() {
        try{
            // call super class
            parent::__construct();
            //catch any connection to database error
        } catch(mysqli_sql_exception $e){
            throw $e;
        }
    } 
    //get a single car
    public function getCar($carId){
        $query = 'SELECT * FROM cars WHERE id = ?';
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('i', $carId);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            $temp = $result->fetch_assoc();
            $car = new car($temp['id'],$temp['name'], $temp['year'], $temp['image']);
            $result->free();
            return $car;
        }
        $result->free();
        return false;
    }

    // get a array of all the available cars
    public function getCars(){
        //The query method returns a mysqli_result object
        $result = $this->mysqli->query('SELECT * FROM cars');
        $cars = Array();
        
        if($result->num_rows >= 1){
            while($row = $result->fetch_assoc()){
                //Create a new car object, and add it to the array.
                $car = new Car($row['id'], $row['name'], $row['year'], $row['image']);
                $cars[] = $car;
            }
            $result->free();
            return $cars;
        }
        $result->free();
        return false;
    }   

    // function add new car to database
    public function addCar($car){
        
        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
            //The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized 
            //query as a parameter.
			$query = 'INSERT INTO cars (name, year, image) VALUES (?,?,?)';
			$stmt = $this->mysqli->prepare($query);
            if($stmt){
                    $name = $car->getName();
			        $year = $car->getYear();
			        $image = $car->getImage();
                   
                  
			        $stmt->bind_param('sis', 
				        $name,
				        $year,
				        $image
			        );    
                    //Execute the statement
                    $stmt->execute();         
                    
                    if($stmt->error){
                        return $stmt->error;
                    } else {
                        return $car->getName() . ' added successfully!';
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

    //function to update existing car
    public function updateCar($car){
        
        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
            //The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized 
            //query as a parameter.
            $query = "UPDATE cars SET name=?, year=?, image=? WHERE id=?";
            $stmt = $this->mysqli->prepare($query);
            if($stmt){
                    $id = $car->getId();
                    $name = $car->getName();
			        $year = $car->getYear();
			        $image = $car->getImage();
                  
			        $stmt->bind_param('sisi', 
				        $name,
				        $year,
				        $image,
                        $id
			        );    
                    //Execute the statement
                    $stmt->execute();         
                    
                    if($stmt->error){
                        return $stmt->error;
                    } else {
                        return $car->getName() . ' updated successfully!';
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

    //function to delete existing car
    public function deleteCar($carId){
        if(!$this->mysqli->connect_errno){
            $query = 'DELETE FROM cars WHERE id = ?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('i', $carId);
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