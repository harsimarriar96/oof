<?PHP

include("../db_connect.php");
$mysqli = connect();

if(isset($_GET['getskin'])) {
	$data = json_decode(file_get_contents("php://input"));
	$p = intval($mysqli->real_escape_string($data->page));
	$race = intval($mysqli->real_escape_string($data->race));
	$gender = intval($mysqli->real_escape_string($data->gender));
	$weight = intval($mysqli->real_escape_string($data->weight));
	$category = intval($mysqli->real_escape_string($data->category));
	
	if($race != -1)
	{
		$extend .= " AND race = $race";
	}
	if($gender != -1)
	{
		$extend .= " AND gender = $gender";
	}
	if($weight != -1)
	{
		$extend .= " AND weight = $weight";
	}
	if($category != -1)
	{
		$extend .= " AND category = $category";
	}
	
	$sql="SELECT * FROM `skin` WHERE id=1".$extend;
	$result = $mysqli->query($sql);
	$num = $result->num_rows;
	
	$items_per_page=36;
	$offset=($p - 1)*$items_per_page;
	$rows=$num;
	$pages=ceil($rows / $items_per_page);
	
	$json_data['panigation']=array(
		"rows"=>$rows,
		"maxSize"=>$items_per_page,
		"pages"=>$pages
	);
	
	$sql="SELECT * FROM `skin` WHERE id=1".$extend . " LIMIT " . $offset . "," . $items_per_page;
	$result = $mysqli->query($sql);
	$num = $result->num_rows;
	
	if($num){
		
		while($rs=$result->fetch_object()){
		
			$json_data['data'][]=array(
				"id"=>$rs->id,
			);
		}
	}
	
	$json= json_encode($json_data);
	echo $json;
	exit;
}
else if(isset($_GET['setskin'])){
	
	$data = json_decode(file_get_contents("php://input"));
	$skinid = $mysqli->real_escape_string($data->skinid);
	$user = $data->userdata;
	$charid = $data->characterid;
	
	$result = AccessOwner($user, $charid);

	if($result['success'])
	{
		update("characters",array("Model"=>$skinid),"`ID`=" . $charid);
	}
    exit;
}
/*
	
	$items_per_page=10;
	$offset=($p - 1)*$items_per_page;

	$row_result=$mysqli->query("SELECT COUNT(*) FROM `ucp_messages` WHERE `Recipient` = $userid");
	$res=$row_result->fetch_row();
	
	$rows=$res[0];
	$pages=ceil($rows / $items_per_page);
	
	$json_data['panigation']=array(
		"rows"=>$rows,
		"maxSize"=>$items_per_page,
		"pages"=>$pages
	);

*/
?>