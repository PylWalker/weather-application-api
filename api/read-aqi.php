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
	  
	// query cities
	if(isset($_GET['name'])){
		$stmt = $city->readExactly($_GET['name']);

		$num = $stmt->rowCount();
		  
		// check if more than 0 record found
		if($num>0){
		    $row = $stmt->fetch(PDO::FETCH_ASSOC);
			$lat = $row['lat'];
			$lon = $row['lon'];

			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, "api.airvisual.com/v2/nearest_city?lat=$lat&lon=$lon&key=de046840-5f47-4cbb-ba0f-88aa14e712fe");
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($curl);
			curl_close($curl);

			$response = json_decode($output, true);
			
			$data = array();
			$coord = array("lat"=>$lat, "lon"=>$lon);
			$data['coord'] = $coord;
			$data['aqi'] = $response['data']['current']['pollution']['aqius'];
			if($data['aqi'] <= 50){
				$data['quality'] = "Tốt";
				$data['warning'] = "Không ảnh hưởng đến sức khởe";
			} elseif ($data['aqi'] <= 100) {
				$data['quality'] = "Trung Bình";
				$data['warning'] = "Ở mức chấp nhận được - Nhóm nhạy cảm lên hạn chế thời gian ra ngoài";
			} elseif ($data['aqi'] <= 150) {
				$data['quality'] = "Kém";
				$data['warning'] = "Ảnh hưởng xấu đến sức khỏe Nhóm nhạy cảm - Nhóm nhạy cảm lên hạn chế thời gian ra ngoài";
			} elseif ($data['aqi'] <= 200) {
				$data['quality'] = "Xấu";
				$data['warning'] = "Ở mức chấp nhận được - Nhóm nhạy cảm lên hạn chế ra ngoài";
			} elseif ($data['aqi'] <= 300) {
				$data['quality'] = "Rất Xấu";
				$data['warning'] = "Cảnh báo sức khỏe khẩn cấp - Ảnh hướng đến tất cả cư dân";
			} else {
				$data['quality'] = "Nguy Hại";
				$data['warning'] = "Báo động: Có thể ảnh hưởng nghiêm trọng đến sức khỏe mọi người";
			}
			$main = $response['data']['current']['pollution']['mainus'];
			switch ($main) {
				case 'p2':
					$data['main'] = "Bụi mịn PM 2.5";
					break;
				case 'p1':
					$data['main'] = "Bụi mịn PM 10";
					break;
				case 'o3':
					$data['main'] = "Ozone mặt đất";
					break;
				case 'n2':
					$data['main'] = "Nitrogen dioxide (NO2)";
					break;
				case 's2':
					$data['main'] = "Sulfur dioxide (SO2)";
					break;
				case 'co':
					$data['main'] = "Carbon monoxide (CO)";
					break;
			}
			$note = aray

			echo json_encode($data, JSON_UNESCAPED_UNICODE);
		} else {
	  
		    // set response code - 404 Not found
		    http_response_code(404);
		  
		    // tell the user no products found
		    echo json_encode(
		        array("message" => "No cities found.")
		    );
		}
	} elseif(isset($_GET['lat']) && isset($_GET['lon'])) {
		$lat = $_GET['lat'];
		$lon = $_GET['lon'];

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, "api.airvisual.com/v2/nearest_city?lat=$lat&lon=$lon&key=de046840-5f47-4cbb-ba0f-88aa14e712fe");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($curl);
		curl_close($curl);

		$response = json_decode($output, true);
		
		$data = array();
		$coord = array("lat"=>$lat, "lon"=>$lon);
		$data['coord'] = $coord;
		$data['aqi'] = $response['data']['current']['pollution']['aqius'];
		if($data['aqi'] <= 50){
			$data['quality'] = "Tốt";
			$data['warning'] = "Không ảnh hưởng đến sức khởe";
		} elseif ($data['aqi'] <= 100) {
			$data['quality'] = "Trung Bình";
			$data['warning'] = "Ở mức chấp nhận được - Nhóm nhạy cảm lên hạn chế thời gian ra ngoài";
		} elseif ($data['aqi'] <= 150) {
			$data['quality'] = "Kém";
			$data['warning'] = "Ảnh hưởng xấu đến sức khỏe Nhóm nhạy cảm - Nhóm nhạy cảm lên hạn chế thời gian ra ngoài";
		} elseif ($data['aqi'] <= 200) {
			$data['quality'] = "Xấu";
			$data['warning'] = "Ở mức chấp nhận được - Nhóm nhạy cảm lên hạn chế ra ngoài";
		} elseif ($data['aqi'] <= 300) {
			$data['quality'] = "Rất Xấu";
			$data['warning'] = "Cảnh báo sức khỏe khẩn cấp - Ảnh hướng đến tất cả cư dân";
		} else {
			$data['quality'] = "Nguy Hại";
			$data['warning'] = "Báo động: Có thể ảnh hưởng nghiêm trọng đến sức khỏe mọi người";
		}
		$main = $response['data']['current']['pollution']['mainus'];
		switch ($main) {
			case 'p2':
				$data['main'] = "Bụi mịn PM 2.5";
				break;
			case 'p1':
				$data['main'] = "Bụi mịn PM 10";
				break;
			case 'o3':
				$data['main'] = "Ozone mặt đất";
				break;
			case 'n2':
				$data['main'] = "Nitrogen dioxide (NO2)";
				break;
			case 's2':
				$data['main'] = "Sulfur dioxide (SO2)";
				break;
			case 'co':
				$data['main'] = "Carbon monoxide (CO)";
				break;
		}

		echo json_encode($data, JSON_UNESCAPED_UNICODE);
	} else {

	    // set response code - 404 Not found
	    http_response_code(404);
	  
	    // tell the user no cities found
	    echo json_encode(
	        array("message" => "No params found.")
	    );	
	}