<?php 
	$jsonFile = 'films.json';
	$jsonData = json_decode(file_get_contents($jsonFile), true);

	foreach ($jsonData as $id => $row) {
		foreach ($row['entry'] as $key => $value) {
			var_dump($value['im:name']['label']);
		}
	}
 ?>