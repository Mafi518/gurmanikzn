<?php

include 'db.php';

// Акции загружаем

// https://joinposter.com/api/clients.getPromotions?token=741029:89174511381b0a0f01b06e4293737bff
$lead_sURL = 'https://joinposter.com/api/clients.getPromotions?token='.$token_poster;
$lead_sPD = '';
$lead_aHTTP = array(
	'http' => array( 'method'  => 'GET', 'header'  => 'Content-type: application/x-www-form-urlencoded;charset=utf-8', 'content' => $lead_sPD )
);
$lead_context = stream_context_create($lead_aHTTP);
$lead_text = file_get_contents($lead_sURL, false, $lead_context);
$promotions = json_decode($lead_text,true);

// echo '<pre>';
// print_r($promotions);
// echo '</pre>';

// Продукт синхронизируем в базе

// https://joinposter.com/api/menu.getProducts?token=
$lead_sURL = 'https://joinposter.com/api/menu.getProducts?token='.$token_poster;
$lead_sPD = '';
$lead_aHTTP = array(
	'http' => array( 'method'  => 'GET', 'header'  => 'Content-type: application/x-www-form-urlencoded;charset=utf-8', 'content' => $lead_sPD )
);
$lead_context = stream_context_create($lead_aHTTP);
$lead_text = file_get_contents($lead_sURL, false, $lead_context);
$data = json_decode($lead_text,true);


foreach($data['response'] as $row){
	$product_cols = [
		'category_name',
		'product_id',
		'menu_category_id',
		'product_name',
		'hidden',
		'photo',
		'photo_origin',
		'price_shop',
		'out_netto',
		'ingredients_list',
		'group_modifications',
	];

	if($row['photo']){
		$row['photo'] = 'https://joinposter.com'.$row['photo'];
		$row['photo_origin'] = 'https://joinposter.com'.$row['photo_origin'];
	}
	// echo $row['price'][1].'<br>';
	if($row['price'] AND $row['price'][1]>0)
		$row['price_shop'] = $row['price'][1]/100;
	$row['out_netto'] = $row['out'];

	$row['ingredients_list'] = '';
	// TODO: Сортировка по structure_netto
	if($row['ingredients'])
	foreach($row['ingredients'] as $inds){
		if(strpos($inds['ingredient_name'],'СП ')===false){ // Исключаем крышки и прочее лишнее
			if($row['ingredients_list']!='') $row['ingredients_list'] .= ', ';
			$row['ingredients_list'] .= trim($inds['ingredient_name']);
		}
	}

	$row['ingredients_list'] = $row['product_production_description'];


	// echo 'Состав: '.$row['ingredients_list'].'<br><br>';
	// echo '<pre>';
	// print_r($row['modifications']);
	// echo '</pre>';
	if($row['group_modifications']){
		echo '<pre>';
		print_r($row['group_modifications']);
		echo '</pre>';
		$row['group_modifications'] = json_encode($row['group_modifications']);
	}

	if($query_exist = mysqli_query($link,"SELECT product_id FROM products WHERE product_id='".$row['product_id']."'")){
		if(mysqli_num_rows($query_exist)!=0){
			$sql = "UPDATE products SET ".setSqlCols($row,$product_cols)." WHERE product_id='".$row['product_id']."'";
			if($query_update = mysqli_query($link,$sql)){
				// echo $sql.'<br>';
			} else echo 'error_sql - '.$sql.'<br>';
		} else {
			$product_cols[] = 'product_id';
			$sql = "INSERT INTO products SET ".setSqlCols($row,$product_cols);
			if($query_insert = mysqli_query($link,$sql)){
				// echo $sql.'<br>';
			} else echo 'error_sql - '.$sql.'<br>';
		}
	} else echo 'error_mysql';

	// echo '<pre>';
	// print_r($row);
	// echo '</pre>';
}

echo 'updated success!';

// echo '<pre>';
// print_r($data);
// echo '</pre>';

// CREATE TABLE `products` (
// 	`product_id` int(11),
// 	`product_name` varchar(96),
// 	`hidden` tinyint(3),
// 	`menu_category_id` int(11),
// 	`category_name` varchar(11),
// 	`photo` varchar(256),
// 	`photo_origin` varchar(256),
// 	`price_shop` int(11),
// 	`out` float,
// 	`ingredients_list` text,
//     `product_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
//     `product_date_edit` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
//     PRIMARY KEY (`product_id`)
// ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

?>