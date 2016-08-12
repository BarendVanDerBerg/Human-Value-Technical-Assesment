<?php 
/*
Date: 12 August 2016

Author: Barend Van Der Berg
Email: bjvanderberg0123@hotmail.co.uk
Cell: 082 449 2763

TAsk: Human Value Technical Assesment
Language: PHP
File: 1 0f 1
Contains:	ORM class
			UserMOdel class
Description:	This file contains CRUD (Create Read Update Delete) functions that can be called to manipulate a database.
*/
class ORM {

	//creates a record
	function CREATE($email,$username,$password,$firstname,$surname,$cellnum){

		$servername = "localhost:8081";
		$username = "root";
		$password = " ";
		$dbname = "users";

		// Creates connection to the database
		$conn = mysqli_connect($servername, $username, $password, $dbname);
		// Checks if connection was succesful
		if (!$conn) {
    		echo "Connection failed: " . mysqli_connect_error();
		}		

		//SQL statement to use on the server
		$sql = "INSERT INTO humanTable(Firstname,Surname,Username,Password,Email,CellNum) VALUES ('$firstname','$surname','$username','$password','$email','$cellnum');";

		//executes the SQL statement, if the record was addes succesfully without network or syntax errors it will print 'Record Added'
		if (mysqli_query($conn, $sql)) {
    		echo "Record Added";
		} else {
			//if there was a problem with the syntax or the values it wil print the below
    		echo "There was an error with: " . $sql . "<br>" . mysqli_error($conn);
		}		

		//closes the connection
		mysqli_close($conn);
	}

	//reads all the records from the database
	function READ(){

		$servername = "localhost:8081";
		$username = "root";
		$password = " ";
		$dbname = "users";

		// Creates connection to the database
		$conn = mysqli_connect($servername, $username, $password, $dbname);
		// Checks if connection was succesful
		if (!$conn) {
    		echo "Connection failed: " . mysqli_connect_error();
		}	

		//SQL statement to use on the server
		$sql = "SELECT * FROM humanTable;";

		//submits the query to the server and saves to variable $results
		$results = mysqli_query($conn, $sql);

		//if the database returns a value there will be rows, if there is one row it should be printed
		if (mysqli_num_rows($results) > 0 ) {
			//While loop to run through all the rows/records that was retrieved from the database
			while ($row = mysqli_fetch_assoc($results)) {
				echo "---------------------------------------<br>" ."Name: ".$row["Firstname"]."<br>Surname: ".$row["Surname"]."<br>Username: ".$row["Username"]."<br>Email: ".$row["Email"]."<br>Cell Number: ".$row["CellNum"]."<br>";
			}
		} else {
			//This will be printed if there are no results
			echo "No Results Found";
		}

		//closes the connection to the database
		mysqli_close($conn);

	}

	//updates a record in the database
	function UPDATE($email,$username,$password,$firstname,$surname,$cellnum){

		$servername = "localhost:8081";
		$username = "root";
		$password = " ";
		$dbname = "users";

		// Creates connection to the database
		$conn = mysqli_connect($servername, $username, $password, $dbname);
		// Checks if connection was succesful
		if (!$conn) {
    		echo "Connection failed: " . mysqli_connect_error();
		}	

		//SQL statement to use on the server
		$sql = "UPDATE humanTable SET Password = '$password', Firstname = '$firstname', Surname = '$surname', CellNum = $cellnum WHERE Email = '$email' OR Username = '$username';";

		//checks if the query was succesful
		if (mysqli_query($conn, $sql)) {
			//prints this if it was succesful
    		echo "Your record has been updated";
		} else {
			//prints this if the query was unsucessfull
    		echo "There was an error updating your record: " . mysqli_error($conn)."<br>Please contact the developer, <br>Ccell: 0824492763 <br>Email: bjvanderberg0123@hotmail.co.uk";
		}

		//closes the connection tothe database
		mysqli_close($conn);
	}

	//deletes a record in the database
	function DELETE($email){

		$servername = "localhost:8081";
		$username = "root";
		$password = " ";
		$dbname = "users";

		// Creates connection to the database
		$conn = mysqli_connect($servername, $username, $password, $dbname);
		// Checks if connection was succesful
		if (!$conn) {
    		echo "Connection failed: " . mysqli_connect_error();
		}	

		//SQL statement to use on the server
		$sql = "DELETE FROM humanTable WHERE Email = '$email';";

		//checks if the query was succesful
		if (mysqli_query($conn, $sql)) {
			//prints this if it was succesful
    		echo "Your record has been removed from the database";
		} else {
			//prints this if the query was unsucessfull
    		echo "There was an error removing your record: " . mysqli_error($conn)."<br>Please contact the developer, <br>Ccell: 0824492763 <br>Email: bjvanderberg0123@hotmail.co.uk";
		}

		//closes the connection to the database
		mysqli_close($conn);
	}
}

class UserModel extends ORM {
	if ($_POST) {
			$firstname = $_POST['firstname'];
			$surname = $_POST['surtname'];
			$username = $_POST['username'];
			$password = $_POST['password'];

			//email validator
			if (empty($_POST["email"])) {
    			//prints this if email field is empty
    			echo "Email is required";
  			} else {
    			$email = test_input($_POST["email"]);
    			//function to check if all the necesary email characters are present
    			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      				echo "Invalid email format"; 
    			}
  			}

			$cellNum = $_POST['cellNum'];

			//parses data to the function CREATE()
			CREATE($firstname,$surname,$username,$password,$email,$cellNum);
		}
}

?>