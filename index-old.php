<?php

include 'db.php';

include 'head.php';

// $secret_frontpad_api_test = 'rE5AATNhKT4TRa66F5h8GQSA6azAsTzGin7H7HTGrHn6Kh3eb8bHNY7FYt5barHiEFYBbD8s9kkHzaQA8S7HB5dhi7iikYzRreesGdKGrZeNZY9YB7t32z98tihF7FiiKrDfyaQK2TkHDis5fKS67S5r4aYZF68diBiFD2enGsZ9Ed4KRHEKny4eyK53F36RneiR6r5BGRB9TsHz3b8bA2hTAaH53EHbHYTD9K5GnsG8HetzfsBGdKnDK2';

// $secret_frontpad_api_main = '3Sz6tQtQ3h3f9KEeyAee2GQ2ihHF3GzRnYHGA4in9ay9N3d7khaaSQ24ZzyN5TrfE3R4R4dQ4BNDnSzD4ADGbrz3NTBFBSN5FsYif329nBDEf368kyFnN5bkKESait5SKN4TDRTRdhhk8bhiAQA9GDie65eei9ZZNNFbskTyz4Ht5SFsy5r4tD8ntbtFaerQSZR89ztyn4RfHhA6bQZzdTKAZ6529hBS6dR6D8nS362Adise3bD6ZbtG7i';

if($_POST['submit_order']){

	$i = -1; $j = -1;
	$search_ins = '';
	$addons = [];

	if($_POST['order_adress_time'] AND $_POST['et']==''){
		if($_POST['descr']!='') $_POST['descr'] .= ' / ';
		$_POST['descr'] .= 'Самовывоз '.$_POST['order_adress_time'];
	}

	if($_POST['order_pay_type']){
		if($_POST['descr']!='') $_POST['descr'] .= ' / ';
		$_POST['descr'] .= 'Оплата '.$_POST['order_pay_type'];
	}

	if($_POST['order_cart']) $_POST['order_cart'] = json_decode($_POST['order_cart'],true);
	$_POST['order_sum'] = 0;
	foreach($_POST['order_cart'] as $ct){
		$_POST['order_sum'] += $ct['p']*$ct['c']; // Просто посчитаем сумму заказа по данным корзины
		if(($ct['f'] OR $ct['i']) AND $ct['c']>0){
			$product[++$i] = $ct['v'] ? $ct['v'] : $ct['f'];
			$product_kol[++$j] = $ct['c'];
		}
		// Формируем список всех допок (dish_id)
		if($ct['a'] AND count($ct['a'])>0){
			foreach($ct['a'] as $addon){
				$addons[] = Array (
					'mode_i' => $i,
					'addon_i' => $addon['i'],
					'addon_f' => $addon['f'],
					'addon_count' => $ct['c'],
				);
				// $addons[$addon['i']]['addon_i'] = $addon['i'];
				// $addons[$addon['i']]['mode_i'] = $i;
				// if(!$addons[$addon['i']]['count']) $addons[$addon['i']]['count'] = 0;
				// 	$addons[$addon['i']]['count'] += $ct['c'];
			}
		}
	};


	foreach($addons as $search_fid){
		if($search_ins!='') $search_ins .= ', ';
		$search_ins .= $search_fid['addon_i'];
	}

	// Узначем dish_fid списка допок
	if($search_ins!='')
	if($query_fids = mysqli_query($link, "SELECT dish_id,dish_fid FROM dishes WHERE dish_id IN (".$search_ins.")")){
		$fids=-1; while($row = mysqli_fetch_assoc($query_fids)){ $fids++;
			$a=-1; foreach($addons as $addon){ $a++;
				if($addon['addon_i']==$row['dish_id'] AND !$addon['addon_f']){
					$addons[$a]['addon_f'] = $row['dish_fid'];
				}
			};
			//
			// $product[++$i] = $row['dish_fid'];
			// $product_kol[++$j] = "1";
			// $product_mod[$i] = $addons[$fids]['mode_i'];
			//
			// $product[++$i] = $row['dish_fid'];
			// $product_kol[++$j] = $addons[$row['dish_id']]['count'];
			// $product_mod[$i] = $addons[$row['dish_id']]['mode_i'];
		};
	}


	foreach($addons as $addon){
		$product[++$i] = $addon['addon_f'];
		$product_kol[++$j] = $addon['addon_count'];
		$product_mod[$i] = $addon['mode_i'];
	};


	// Данные заказа
	foreach($_POST as $key => $value){
		if(strpos($key,'submit')!==false OR strpos($key,'order')!==false){}
		else if($value!=''){
			$param[$key] = $value;
		}
	};

	// ###########################################################################
	// ### FRONTPAD / new_order
	// ###########################################################################
	// Задача. Отправить заказ в котором сок и пицца с двумя модификаторами: сыр и бекон.

	//артикулы товаров
	// $product[0] = "1001";	//Пицца 					/ Канада ролл
	// $product[1] = "1006";	//Добавка к пицце - сыр
	// $product[2] = "1007";	//Добавка к пицце - бекон
	// $product[3] = "1003";	//Сок 						/ Сяке ролл
	 
	//количество товаров
	// $product_kol[0] = "1";
	// $product_kol[1] = "1";
	// $product_kol[2] = "1";
	// $product_kol[3] = "1";
	 
	//модификаторы, если есть 
	// $product_mod[1] = "0";  //товар с ключом 1 является модификатором товара с ключом 0
	// $product_mod[2] = "0";  //товар с ключом 2 является модификатором товара с ключом 0
	           	 
	if($_SESSION['user_id']==1){
		echo '<pre>';
		print_r($addons);
		echo '</pre>';

		echo '<pre>';
		print_r($_POST);
		echo '</pre>';

		echo '<pre>';
		print_r($product);
		echo '</pre>';

		echo '<pre>';
		print_r($product_kol);
		echo '</pre>';

		if($product_mod){
			echo '<pre>';
			print_r($product_mod);
			echo '</pre>';
		}

		echo '<pre>';
		print_r($param);
		echo '</pre>';
	}

	//детали заказа в кодировке utf-8
	$param['secret'] = $secret_frontpad_api_main;	//ключ api
	// $param['street']  = urlencode("Мира");		//улица
	// $param['home']	= "17"; 				//дом
	// $param['apart']	= "6";	 			//квартира
	// $param['phone'] = "79000000001";		//телефон
	// $param['descr']	= urlencode("Быстрее!"); 	//комментарий
	// $param['name']	= urlencode("Иван"); 		//имя клиента

	//подготовка запроса				
	foreach ($param as $key => $value) { 
		$data .= "&".$key."=".$value;
	}

	// $tags = array(1,5);				//отметки заказа
	// if($tags) {
	// 	foreach ($tags as $key => $value){
	// 			$data .= "&tags[".$key."]=".$value."";
	// 	}
	// }

	//содержимое заказа
	foreach ($product as $key => $value){ 
		$data .= "&product[".$key."]=".$value."";
		$data .= "&product_kol[".$key."]=".$product_kol[$key].""; 
		if(isset($product_mod[$key])) { 
			$data .= "&product_mod[".$key."]=".$product_mod[$key].""; 
		} 
	} 

	//отправка
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://app.frontpad.ru/api/index.php?new_order");
	curl_setopt($ch, CURLOPT_FAILONERROR, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$result = curl_exec($ch);
	curl_close($ch);
	 
	//результат
	$result = json_decode($result,true);
	if($_SESSION['user_id']==1){
		echo '<pre>';
		print_r($result);
		echo '</pre>';
	}
	if($result['result']=='success'){
		echo '<div class="wrapper order-success">
			<div class="done-box">
				Ваш заказ #'.$result['order_number'].' на сумму '.$_POST['order_sum'].' руб. успешно оформлен!
			</div>
		</div>';
	}
	// echo $result;
	// {"result":"success","order_id":1170,"order_number":6}

}

	// echo '<div class="done-box">';
	// 	echo '<pre>';
	// 	print_r($_POST);
	// 	echo '</pre>';
	// echo '</div>';

// ###########################################################################
// ### FRONTPAD / get_products
// ###########################################################################
if($_SESSION['user_id'] AND $_GET['update_dishes']==1){
	// $sURL = 'https://app.frontpad.ru/api/index.php?get_products';
	// $sPD = 'secret='.$secret_frontpad_api; // Данные POST
	// $aHTTP = array(
	//     'http' => array( 'method'  => 'POST', 'header'  => 'Content-type: application/x-www-form-urlencoded;charset=utf-8', 'content' => $sPD )
	// );
	// $context = stream_context_create($aHTTP);
	// $result_text = file_get_contents($sURL, false, $context);
	// $front_dishes = json_decode(file_get_contents($sURL, false, $context), true);
	$data = 'secret='.$secret_frontpad_api_main;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://app.frontpad.ru/api/index.php?get_products");
	curl_setopt($ch, CURLOPT_FAILONERROR, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$result = curl_exec($ch);
	curl_close($ch);
	$front_dishes = json_decode($result,true);
	// echo '<div class="done-box">';
	// 	echo '<pre>';
	// 	print_r($front_dishes);
	// 	echo '</pre>';
	// echo '</div>';
	//
	$base_dishes = [];
	$i=-1; if($front_dishes && $front_dishes['product_id']) foreach($front_dishes['product_id'] as $key => $value){ $i++;
		$base_dishes[$i] = Array(
			'dish_id' => $front_dishes['product_id'][$i],
			'dish_name' => $front_dishes['name'][$i],
			'dish_price' => $front_dishes['price'][$i],
		);
		// sql
		$ex = explode(' ',$front_dishes['name'][$i]);
		$ex_name = substr($front_dishes['name'][$i],0,-3);
		$query_dish = mysqli_query($link, "SELECT * FROM dishes WHERE dish_fid='".$front_dishes['product_id'][$i]."' LIMIT 1");
		$query_name = mysqli_query($link, "SELECT * FROM dishes WHERE dish_name='".$ex_name."' LIMIT 1");
		if($ex[count($ex)-1]=='24' OR $ex[count($ex)-1]=='32' OR $ex[count($ex)-1]=='42'){
			// Если это вариант пиццы
			$query_variant = mysqli_query($link, "SELECT * FROM dishes_variants WHERE variant_fid='".$front_dishes['product_id'][$i]."' LIMIT 1");
			if(mysqli_num_rows($query_variant)>0){
				mysqli_query($link, "UPDATE dishes_variants SET variant_name='".$front_dishes['name'][$i]."', variant_price='".$front_dishes['price'][$i]."' WHERE variant_fid='".$front_dishes['product_id'][$i]."'");
			} else {
				// Создаем блюдо, если его нету
				if(mysqli_num_rows($query_name)==0)
					mysqli_query($link, "INSERT INTO dishes SET dish_name='".$ex_name."', dish_chapter=5"); // , dish_price='".$front_dishes['price'][$i]."', dish_fid='".$front_dishes['product_id'][$i]."'
				// Создаем вариант, прикрепляем к нужному блюду
				$query_need = mysqli_query($link, "SELECT * FROM dishes WHERE dish_name='".$ex_name."' LIMIT 1");
				$need = mysqli_fetch_assoc($query_need);
				mysqli_query($link, "INSERT INTO dishes_variants SET variant_name='".$front_dishes['name'][$i]."', variant_price='".$front_dishes['price'][$i]."' ".
					", variant_diameter='".$ex[count($ex)-1]."', variant_fid='".$front_dishes['product_id'][$i]."'".
					", variant_did='".$need['dish_id']."'");
			}
		} else {
			// Иначе, как обычное блюдо
			if(mysqli_num_rows($query_dish)>0){
				mysqli_query($link, "UPDATE dishes SET dish_name='".$front_dishes['name'][$i]."', dish_price='".$front_dishes['price'][$i]."' WHERE dish_fid='".$front_dishes['product_id'][$i]."'");
			} else {
				mysqli_query($link, "INSERT INTO dishes SET dish_chapter='0', dish_name='".$front_dishes['name'][$i]."', dish_price='".$front_dishes['price'][$i]."', dish_fid='".$front_dishes['product_id'][$i]."'");
			}
		}
	}
	echo '<pre>';
	print_r($base_dishes);
	echo '</pre>';
}

	// Array
	// (
	//     [result] => success
	//     [product_id] => Array
	//         (
	//             [0] => 1001
	//             [1] => 1002
	//             [2] => 1003
	//             [3] => 1005
	//             [4] => 1004
	//             [5] => 1007
	//             [6] => 1006
	//         )

	//     [name] => Array
	//         (
	//             [0] => Канада ролл
	//             [1] => Каппа ролл
	//             [2] => Сяке ролл
	//             [3] => Маргарита
	//             [4] => Вегетарианская
	//             [5] => Соевый соус
	//             [6] => Палочки
	//         )

	//     [price] => Array
	//         (
	//             [0] => 240
	//             [1] => 60
	//             [2] => 90
	//             [3] => 310
	//             [4] => 420
	//             [5] => 0
	//             [6] => 0
	//         )

	// )



echo '<div class="block-slider">';
	echo '<div class="block-shadow"></div>';
	echo '<div class="slider-left"></div>';
	echo '<div class="slider-right"></div>';

	echo '<div class="sliders-overflow">';
	echo '<div class="sliders">';
		echo '<div slider="1" style="background-image: url(../images/slider1.jpg)">';
			echo '<div class="block-wrapper">';
				echo '<h1>Том Ям</h1>';
				echo '<a href="#" class="btn">Заказать огненный Том Ям</a>';
			echo '</div>';
		echo '</div>';
		echo '<div slider="2"  style="background-image: url(../images/slider2.jpg)">';
			echo '<div class="block-wrapper">';
				echo '<h1>Пицца недели</h1>';
				echo '<a href="#" class="btn">Доставить со скидкой 20%</a>';
			echo '</div>';
		echo '</div>';
		echo '<div slider="3"  style="background-image: url(../images/slider3.jpg)">';
			echo '<div class="block-wrapper">';
				echo '<h1>Роллы недели</h1>';
				echo '<a href="#" class="btn">Доставить со скидкой 20%</a>';
			echo '</div>';
		echo '</div>';
	echo '</div>'; // .sliders
	echo '</div>'; // .sliders-overflow

echo '</div>';

$variants = Array();
$query_variants = mysqli_query($link, "SELECT * FROM dishes_variants ORDER BY variant_price");
while($row = mysqli_fetch_assoc($query_variants)){
	$variants[$row['variant_did']][] = $row;
}

$addons = Array();
$query_addons = mysqli_query($link, "SELECT * FROM dishes WHERE dish_chapter='9'");
while($row = mysqli_fetch_assoc($query_addons)){
	foreach($variants as $variant){
		foreach($variant as $v){
			if($row['dish_id']==$v['variant_did']){
				$row['variants'][] = $v;
			}
		}
	}
	$addons[] = $row;
}

$addons_only_pizza = Array();
$query_addons = mysqli_query($link, "SELECT * FROM dishes WHERE dish_chapter='13'");
while($row = mysqli_fetch_assoc($query_addons)){
	foreach($variants as $variant){
		foreach($variant as $v){
			if($row['dish_id']==$v['variant_did']){
				$row['variants'][] = $v;
			}
		}
	}
	$addons_only_pizza[] = $row;
}

$addons_rolls = Array();
$query_addons = mysqli_query($link, "SELECT * FROM dishes WHERE dish_chapter='14'");
while($row = mysqli_fetch_assoc($query_addons)){
	foreach($variants as $variant){
		foreach($variant as $v){
			if($row['dish_id']==$v['variant_did']){
				$row['variants'][] = $v;
			}
		}
	}
	$addons_rolls[] = $row;
}

$addons_pizza = Array();
$query_addons = mysqli_query($link, "SELECT * FROM dishes WHERE dish_chapter='15'");
while($row = mysqli_fetch_assoc($query_addons)){
	foreach($variants as $variant){
		foreach($variant as $v){
			if($row['dish_id']==$v['variant_did']){
				$row['variants'][] = $v;
			}
		}
	}
	$addons_pizza[] = $row;
}

$query_chapters = mysqli_query($link, "SELECT * FROM dishes_chapters WHERE chapter_num<>0 OR chapter_id=0 ORDER BY chapter_num");
while($chapter = mysqli_fetch_assoc($query_chapters)){
	$query_dishes = mysqli_query($link, "SELECT * FROM dishes WHERE dish_chapter='".$chapter['chapter_id']."'");
	if(mysqli_num_rows($query_dishes)>0 AND ($chapter['chapter_id']!=0 OR $_SESSION['user_id'])){
		echo '<a href="" name="block-'.$chapter['chapter_id'].'"></a>';
		echo '<h2>'.$chapter['chapter_title'].'</h2>'; // '.($_SESSION['user_id']?'contenteditable="true"':'').'
		echo '<div class="block-wrapper">';

		while($dish = mysqli_fetch_assoc($query_dishes)){
			echo '<div class="dish-box" dish-fid="'.$dish['dish_fid'].'" chapter-id="'.$chapter['chapter_id'].'">';
				if($_SESSION['user_id'])
					echo '<a href="/admin?edit_dish='.$dish['dish_id'].'" class="edit"></a>';
				echo '<div class="dish-wrapper cart-elem">';
					$dish['dish_photo'] = ($dish['dish_photos']?explode(', ',$dish['dish_photos'])[0]:'images/dish.png');
					echo '<div class="dish-img"><img src="'.($dish['dish_photos']?explode(', ',$dish['dish_photos'])[0]:'images/dish.png').'"></div>';
					echo '<div class="dish-name">'.$dish['dish_name'].'</div>';
					echo '<div class="dish-price">'.($variants[$dish['dish_id']]?$variants[$dish['dish_id']][0]['variant_price']:$dish['dish_price']).' р.</div>';
					if($dish['dish_chapter']>5)
						echo '<div class="btn cart-light-add">Добавить</div>';
					//
					echo '<textarea cart-data="variants" class="hide">'.json_encode($variants[$dish['dish_id']]).'</textarea>';
					echo '<textarea cart-data="product" class="hide">'.json_encode($dish).'</textarea>';
					// if($dish['dish_chapter']!=9 AND $dish['dish_chapter']!=12)
					if(in_array($dish['dish_chapter'], [9,10,11,12]) === FALSE)
						echo '<textarea cart-data="addons" class="hide">'.json_encode($addons).'</textarea>';
					if($dish['dish_chapter']==5)
						echo '<textarea cart-data="addons_only_pizza" class="hide">'.json_encode($addons_only_pizza).'</textarea>';
					if(in_array($dish['dish_chapter'], [1,2,3,4,16]))
						echo '<textarea cart-data="addons_rolls" class="hide">'.json_encode($addons_rolls).'</textarea>';
					if($dish['dish_chapter']==5)
						echo '<textarea cart-data="addons_pizza" class="hide">'.json_encode($addons_pizza).'</textarea>';
					// foreach($variants as $v){
					// 	echo '<div class="hide" cart-data="variant_price"></div>';
					// }
				echo '</div>';
			echo '</div>';
		}

		echo '</div>'; // .block-wrapper
	}
};


// echo '<h2>СУШИ</h2>';
// echo '<div class="block-wrapper">';


// echo '<div class="dish-box">';
// 	echo '<div class="dish-wrapper">';
// 		echo '<div class="dish-img"><img src="images/dish.png"></div>';
// 		echo '<div class="dish-name">Суши Океан</div>';
// 		echo '<div class="dish-price">320 р.</div>';
// 	echo '</div>';
// echo '</div>';

// echo '<div class="dish-box">';
// 	echo '<div class="dish-wrapper">';
// 		echo '<div class="dish-img"><img src="images/dish.png"></div>';
// 		echo '<div class="dish-name">Суши Океан</div>';
// 		echo '<div class="dish-price">320 р.</div>';
// 	echo '</div>';
// echo '</div>';

// echo '<div class="dish-box">';
// 	echo '<div class="dish-wrapper">';
// 		echo '<div class="dish-img"><img src="images/dish.png"></div>';
// 		echo '<div class="dish-name">Суши Океан</div>';
// 		echo '<div class="dish-price">320 р.</div>';
// 	echo '</div>';
// echo '</div>';

// echo '</div>'; // .block-wrapper




include 'footer.php';

?>