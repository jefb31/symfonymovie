<?php 
        // $filmsSql = fopen('films.sql', 'a+');
   		// $jsonFile = file_get_contents("films.json", FILE_USE_INCLUDE_PATH);
	    // $jsonData = json_decode($jsonFile, true);
        // $films = $jsonData["feed"]["entry"];
        // foreach($films as $key => $value) {
        //     // echo '<br>'.$key.' <br>';
        //     // echo $value['im:name']['label'];         
        //     fputs($filmsSql, $value['im:name']['label']).'<br>';                
        // }
        // fclose($filmsSql);
?>


<?php

$jsonFile = 'films.json';
$jsonData = json_decode(file_get_contents($jsonFile), true);

// Iterate through JSON and build INSERT statements
foreach ($jsonData as $id=>$row) {
    foreach ($row['entry'] as $key => $value) {
        echo "INSERT INTO `films`(`title`, `summary`, `duration`, `director`, `category`, `releaseDate`, `poster`, `available`)
        VALUES ('".strip_quotes($value['im:name']['label'])."',
            '".strip_quotes($value['summary']['label'])."',
            '".strip_quotes($value['link']['1']['im:duration']['label']/1000)."',
            '".strip_quotes($value['im:artist']['label'])."',
            '".strip_quotes($value['category']['attributes']['label'])."',
            '".strip_quotes($value['im:releaseDate']['label'])."',
            '".strip_quotes($value['im:image']['2']['label'])."',
            '".strip_quotes(true)."');" . "\n";
        }

}

function strip_quotes($string){
    return str_replace("'", " ", $string);
}
?>