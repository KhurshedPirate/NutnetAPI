<?php
    
if (isset($_POST['Upload'])){
    
    $dbhost = "localhost";
    $dbuser = "id16133763_dbuser";
    $dbpass = "ssss1111SSSS!!!!!";
    $db = "id16133763_db";
         
    $mysqli = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
    if ($mysqli->connect_errno) {
        printf("Не удалось подключиться: %s\n", $mysqli->connect_error);
        exit();
    }
    //deleting current table
    $url= "https://api.apispreadsheets.com/data/7910/?query=deletefrom7910whereAge>0";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($curl);

    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);
    
    //adding new data
	$url = "https://api.apispreadsheets.com/data/7914";
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	
    $query2 = $mysqli->query("SELECT id, name, surname, age FROM users where age >=18 ");
    
    	while($row = $query2->fetch_assoc()){			
			$postJSON = json_encode(["data"=>["name"=>$row['name'], "surname"=>$row['surname'],"age"=>$row['age']]]);
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $postJSON);
			
			curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
			
			$result = curl_exec($curl);
				}	
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postJSON);
	
	curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
	
	$result = curl_exec($curl);
	
	$http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	
	echo '<a href = "https://docs.google.com/spreadsheets/d/14nbXahzFDT7L4D0l3A359-_MI40MJvyaIe_GrP71wPk"> Open the doc</a>';		echo "<p>Success</p>";
	
	
}
else {
        
    $dbhost = "localhost";
    $dbuser = "id16133763_dbuser";
    $dbpass = "ssss1111SSSS!!!!!";
    $db = "id16133763_db";
         
    $mysqli = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
    if ($mysqli->connect_errno) {
        printf("Не удалось подключиться: %s\n", $mysqli->connect_error);
        exit();
    }
        
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $age = intval($_POST['age']);
    
    
    if($name && $surname && $age){
    	$query = $mysqli->query("INSERT INTO users VALUES(NULL, '$name', '$surname', '$age')");
    
    	$query2 = $mysqli->query("SELECT id, name, surname, age FROM users");
    
    	while($row = $query2->fetch_assoc()){
    		$users['id'][] = $row['id'];
    		$users['name'][] = $row['name'];
    		$users['surname'][] = $row['surname'];
    		$users['age'][] = $row['age'];
    	}
    	$message = 'Все хорошо';
    }else{
    	$message = 'Не удалось записать и извлечь данные';
    }


    $out = array(
    	'message' => $message,
    	'users' => $users
    );

    header('Content-Type: text/json; charset=utf-8');

    echo json_encode($out);
}
?>