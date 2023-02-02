<?php
require '../vendor/autoload.php';

include("db_connection.php");
$con = db_connect();

$function = $_REQUEST['function'];

switch ($function) {
	case 'userRegistration':
        $firstName = isset($_POST['first_name']) ? $_POST['first_name'] : '';
        $lastName  = isset($_POST['last_name']) ? $_POST['last_name'] : '';
        $email     = isset($_POST['email']) ? $_POST['email'] : '';
        $password  = isset($_POST['password']) ? md5($_POST['password']) : '';

        $sql = mysqli_query($con, " SELECT COUNT(*) AS Total FROM user_registration WHERE email = '".$email."' ");
        $checkEmailExist = mysqli_fetch_assoc($sql);
        
        if($checkEmailExist['Total'] == 0) {
            $insertQuery = "INSERT INTO user_registration (firstname, lastname, email,password) VALUES ('".$firstName."','".$lastName."','".$email."','".$password."')";
            $result = mysqli_query($con, $insertQuery);
            if($result == 1) {
                $jsonResult = array("status" => 1,"msg" => "User registration successfully!!");
            } else {
                $jsonResult = array("status" => 0,"msg" => "Error occured!!");
            }
        } else {
            $jsonResult = array("status" => 2,"msg" => "User email already exists!!");
        }
        echo json_encode($jsonResult);
    break;

    case 'userLogin':
        $email     = isset($_POST['email']) ? $_POST['email'] : '';
        $password  = isset($_POST['password']) ? md5($_POST['password']) : '';

        $sql = mysqli_query($con, " SELECT * FROM user_registration WHERE email = '".$email."' AND password = '".$password."' ");
        $checkuser = mysqli_fetch_array($sql);

        if($checkuser) {
            $id = $checkuser['id'];
            $jsonResult = array("status" => 1,"user_id" => $id,"msg" => "Login successfully");
        } else {
            $jsonResult = array("status" => 0,"msg" => "Email / Password are incorrect or User does not exist!!");
        }
        
        echo json_encode($jsonResult);
    break;

    case 'userProfile':
        $email   = isset($_POST['email']) ? $_POST['email'] : '';
        $mobile  = isset($_POST['mobile']) ? $_POST['mobile'] : '';
        $dob     = isset($_POST['dob']) ? $_POST['dob'] : '';
        $age     = isset($_POST['age']) ? $_POST['age'] : '';
        $gender  = isset($_POST['gender']) ? $_POST['gender'] : '';
        $address = isset($_POST['address']) ? $_POST['address'] : '';

        $client = new MongoDB\Client;
        $projectdb = $client->projectdb;
        $usercollection = $projectdb->users;

        $users = $usercollection->findOne(['email' => $email]);
        
        if(!$users){
            $insertData = $usercollection->insertOne(
                ['email' => $email, 'mobile' => $mobile, 'dob' => $dob, 'age' => $age, 'gender' => $gender, 'address' => $address]
            );

            if($insertData->getInsertedCount() > 0){
                $jsonResult = array("status" => 1,"msg" => "Updated successfully!!");
            }else{
                $jsonResult = array("status" => 0,"msg" => "Error occured!!");            
            }
        }else{
            $updateData = $usercollection->updateOne(
                ['mobile' => $mobile, 'dob' => $dob, 'age' => $age, 'gender' => $gender, 'address' => $address],
                ['$set' => ['email' => $email]]
            );

            if($updateData->getModifiedCount() > 0){
                $jsonResult = array("status" => 1,"msg" => "Updated successfully!!");
            }else{
                $jsonResult = array("status" => 0,"msg" => "Error occured!!");            
            }
        }

        echo json_encode($jsonResult);
    break;

    default:
    #code....
    break;
}


?>