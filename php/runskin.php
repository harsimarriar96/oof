<?PHP
include("db_connect.php");
date_default_timezone_set('Asia/Bangkok');
$mysqli = connect();


$o = file_get_contents("skin.json");
$o = json_decode($o);

foreach($o as $object) {
	for($i=0;$i < sizeof($object); $i++)
	{

		$insertdata = array(
			"id"=>$object[$i]->id,
			"name"=>$object[$i]->name,
			"race"=>$object[$i]->race,
			"gender"=>$object[$i]->gender,
			"weight"=>$object[$i]->weight,
			"category"=>$object[$i]->category,
		);
		insert("skin",$insertdata);
	}
}




?>