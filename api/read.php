<?php
	// required headers
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	  
	// include database and object files
	include_once 'Database.php';
	include_once 'City.php';
	  
	// instantiate database and product object
	$database = new Database();
	$db = $database->getConnection();
	  
	// initialize object
	$city = new City($db);
	  
	// query products
	if(isset($_GET['name'])){
		$stmt = $city->read($_GET['name']);
		$num = $stmt->rowCount();
		  
		// check if more than 0 record found
		if($num>0){
		  
		    // products array
		    $cities_arr = array();
		  
		    // retrieve our table contents
		    // fetch() is faster than fetchAll()
		    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
		    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		        // extract row
		        // this will make $row['name'] to
		        // just $name only
		        extract($row);
		  
		        $city_item=array(
		            "id" => $id,
		            "name" => $name,
		            "country" => "Việt Nam",
		            "lat" => $lat,
		            "lon" => $lon
		        );
		  
		        array_push($cities_arr, $city_item);
		    }
		  
		    // set response code - 200 OK
		    http_response_code(200);
		  
		    // show cities data in json format
		    echo json_encode($cities_arr, JSON_UNESCAPED_UNICODE);
		} else{
	  
		    // set response code - 404 Not found
		    http_response_code(404);
		  
		    // tell the user no products found
		    echo "null";
		}
	} else {

	    // set response code - 404 Not found
	    http_response_code(404);
	  
	    // tell the user no products found
	    echo "null";
	}
?>