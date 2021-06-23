<?php
header('Location: test.php');


include 'db.php';

include 'head.php';

// $dev = false;
$dev = true;



if($_POST['submit_order'] ){
	$i = -1; $j = -1;
	$search_ins = '';
	$addons = [];

	if($_POST['order_adress_time'] AND $param['affiliate']==1){ //  AND $_POST['et']==''
		if($_POST['descr']!='') $_POST['descr'] .= ' / ';
		$_POST['descr'] .= 'Самовывоз в '.$_POST['order_adress_time'];
	}
	if ($_POST['people_amount']){
		if($_POST['descr']!='') $_POST['descr'] .= ' / ';
		$_POST['descr'] .= 'Количество персон '.$_POST['people_amount'];
	}

	if($_POST['pay']){
		if($_POST['descr']!='') $_POST['descr'] .= ' / ';
		$_POST['descr'] .= 'Оплата: '.($_POST['pay']==1?'Наличными':'Безналичными');
	}

	if($_POST['promo']){
		if($_POST['descr']!='') $_POST['descr'] .= ' / ';
		$_POST['descr'] .= 'Промо-код: '.$_POST['promo'];
	}

	if($_POST['street']){
		// $client_address = $_POST['street'].
		// 	($_POST['home']?' д. '.$_POST['home']:'').
		// 	($_POST['apart']?' кв. '.$_POST['apart']:'').
		// 	($_POST['pod']?' под. '.$_POST['pod']:'').
		// 	($_POST['et']?' этаж '.$_POST['et']:'').
		// 	'';

		$client_address = Array(
			'address1' => $_POST['street'].
				($_POST['home']?' д. '.$_POST['home']:''), // Улица и номер дома
			'address2' => ($_POST['apart']?' кв. '.$_POST['apart']:'').
				($_POST['pod']?' под. '.$_POST['pod']:'').
				($_POST['et']?' этаж '.$_POST['et']:'')
				.'', // Дополнительно: подъезд, этаж, квартира и т. д.
			// 'comment' => '', // Комментарий к адресу
		);
	}

	if($_POST['order_cart']) $_POST['order_cart'] = json_decode($_POST['order_cart'],true);
	$_POST['order_sum'] = 0;
	foreach($_POST['order_cart'] as $ct){
		$_POST['order_sum'] += $ct['p']*$ct['c'];
		$summ = $_POST['order_sum']; // Просто посчитаем сумму заказа по данным корзины
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


	// foreach($addons as $search_fid){
	// 	if($search_ins!='') $search_ins .= ', ';
	// 	$search_ins .= $search_fid['addon_i'];
	// }

	// // Узначем dish_fid списка допок
	// if($search_ins!='')
	// if($query_fids = mysqli_query($link, "SELECT dish_id,dish_fid FROM dishes WHERE dish_id IN (".$search_ins.")")){
	// 	$fids=-1; while($row = mysqli_fetch_assoc($query_fids)){ $fids++;
	// 		$a=-1; foreach($addons as $addon){ $a++;
	// 			if($addon['addon_i']==$row['dish_id'] AND !$addon['addon_f']){
	// 				$addons[$a]['addon_f'] = $row['dish_fid'];
	// 			}
	// 		};
	// 		//
	// 		// $product[++$i] = $row['dish_fid'];
	// 		// $product_kol[++$j] = "1";
	// 		// $product_mod[$i] = $addons[$fids]['mode_i'];
	// 		//
	// 		// $product[++$i] = $row['dish_fid'];
	// 		// $product_kol[++$j] = $addons[$row['dish_id']]['count'];
	// 		// $product_mod[$i] = $addons[$row['dish_id']]['mode_i'];
	// 	};
	// }


	// foreach($addons as $addon){
	// 	$product[++$i] = $addon['addon_f'];
	// 	$product_kol[++$j] = $addon['addon_count'];
	// 	$product_mod[$i] = $addon['mode_i'];
	// };


	// Данные заказа
	foreach($_POST as $key => $value){
		if(strpos($key,'submit')!==false OR strpos($key,'order')!==false){}
		else if($value!=''){
			$param[$key] = $value;
		}
	};

	// ###########################################################################
	// ### INTEGRATION / new_order
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
	           	 

	// echo '<pre>';
	// print_r($_POST);
	// echo '</pre>';

	// echo '<pre>';
	// print_r($product);
	// echo '</pre>';

	// echo '<pre>';
	// print_r($product_kol);
	// echo '</pre>';

	// if($product_mod){
	// 	echo '<pre>';
	// 	print_r($product_mod);
	// 	echo '</pre>';
	if($dev){?>
		<div class="success-box quote">
			<h2>Спасибо за заказ!</h2>
			<h3>Оператор свяжется с вами в ближайшее время</h3>
			Вы указали номер телефона: <b><?=$param['phone']?></b>
			<br><br>Обращаем ваше внимание что заказы принимаются ежедневно с 10:00 до 22:00
			<pre>
			</pre>
		</div>
	<?}?>
	<!-- <? if($dev)?> <h2>Данные</h2> -->

	<!-- For api poster -->
	<?$incoming_order = [
	    'spot_id'   => 1,
	    'phone'     => getPhone($param['phone']),
	    'service_mode' => $param['affiliate'] ? $param['affiliate'] : 3, // Создает заказ указанного типа: 1 — в заведении, 2 — навынос, 3 — доставка
	    // 'products'  => [
	    //     [
	    //         'product_id' => 169,
	    //         'count'      => 1
	    //     ],
	    // ],
	    'comment' => $param['descr'],
	    // 'comment' => 'Отменить заказ, тест нового сайта',
	];

	if($param['name']) $incoming_order['first_name'] = $param['name'];
	if($client_address) $incoming_order['client_address'] = $client_address;

	// Стоимость доставки
	if($param['delivery_price'] 
		AND $incoming_order['service_mode']==3
		AND $param['budget']<$param['delivery_free']
	) 
		$incoming_order['delivery_price'] = $param['delivery_price'].'00';

	// echo '<h2>Список</h2>';
	foreach($_POST['order_cart'] as $row){
		if($row){
			$product = Array(
				'product_id' => $row['f'],
				'count' => $row['c'],
			);
			if($row['a']){
				foreach($row['a'] as $mod){
					$product['modification'][] = Array(
						'm' => $mod['f'],
						'a' => $mod['fa']?$mod['fa']:1,
					);
				}
			}
			// if(strpos($row['f'],'m')!==false){
			// 	$product['modification_id'] = substr($row['f'],1);
			// 	$product['product_id'] = substr($row['f'],1);
			// } else
			// 	$product['product_id'] = $row['f'];

			// Проверка на дубли и исправление
			$check = false; $i=0;
			if($incoming_order['products'])
			foreach($incoming_order['products'] as $p){ $i++;
				if($p['product_id']==$product['product_id']){
					$check = true;
					$incoming_order['products'][$i-1]['count'] += $product['count'];
				}
			}
			if(!$check)
				$incoming_order['products'][] = $product;

			// if($dev){
			// 	echo '<pre>';
			// 	print_r($row);
			// 	echo '</pre>';
			// }
		}
	}

	// Допки отдельно как продукты, но сейчас переходим на модификации
	// // echo '<h2>Допки</h2>';
	// foreach($addons as $row){
	// 	if($row){
	// 		$product = Array(
	// 			'product_id' => $row['addon_i'],
	// 			// 'modification_id' => $row['addon_f'],
	// 			'count' => $row['addon_count'],
	// 		);
	// 		$incoming_order['products'][] = $product;
	// 		echo '<pre>';
	// 		print_r($row);
	// 		echo '</pre>';
	// 	}
	// }

				
	// if($dev){
	// 	echo '<h2>Заказ</h2>';
	// 	echo '<pre>';
	// 	// print_r($incoming_order);
	// 	echo '</pre>';
	// }


	// Отправка по интеграции poster
	$url = 'https://joinposter.com/api/incomingOrders.createIncomingOrder'.
		'?token='.$token_poster;
	$data = sendRequest($url, 'post', $incoming_order);
	$data = json_decode($data,true);

	// print_r($data);

	// if($dev){
	// 	echo '<pre>';
	// 	print_r($data); 
	// 	echo '</pre>';
	// }

	// // {"response":{"incoming_order_id":257,"type":1,"spot_id":1,"status":0,"client_id":302,"client_address_id":0,"table_id":null,"comment":"\u041e\u0442\u043c\u0435\u043d\u0438\u0442\u044c \u0437\u0430\u043a\u0430\u0437, \u0442\u0435\u0441\u0442 \u043d\u043e\u0432\u043e\u0433\u043e \u0441\u0430\u0439\u0442\u0430","created_at":"2021-04-22 14:04:20","updated_at":"2021-04-22 14:04:20","transaction_id":null,"service_mode":1,"delivery_price":null,"fiscal_spreading":0,"fiscal_method":"","promotion":null,"delivery_time":"0000-00-00 00:00:00","payment_method_id":null,"first_name":null,"last_name":null,"phone":"79994677108","email":null,"sex":null,"birthday":null,"address":null,"products":[{"io_product_id":905,"product_id":203,"modificator_id":0,"incoming_order_id":257,"count":"1.0000000","price":24900,"created_at":"2021-04-22 14:04:20"},{"io_product_id":906,"product_id":268,"modificator_id":0,"incoming_order_id":257,"count":"1.0000000","price":2900,"created_at":"2021-04-22 14:04:20"},{"io_product_id":907,"product_id":271,"modificator_id":0,"incoming_order_id":257,"count":"1.0000000","price":2900,"created_at":"2021-04-22 14:04:20"}]}}


	// Интеграция с Allbiom.ru
		// $_POST['integration'] = json_decode($incoming_order);
		// $_POST['data'] = $data;
		// print_r($data);
		$lead_data = '';
		foreach($_POST as $key => $value){
			if($lead_data!='') $lead_data .= '&';
			$lead_data .= 'post_'.$key.'='.$value;
		}
		//
		// echo $lead_data;
		$lead_sURL = 'https://allbiom.ru/api/crm_add_lead';
		$lead_sPD = 'secret=3jBeEM1WHJR8gNgTiIb7z1i3nAqCIZXZ'.
			'&shop=1026'.
			'&lead_url='.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].
			'&lead_ip='.$_SERVER['REMOTE_ADDR'].
			'&'.$lead_data;
		$lead_aHTTP = array(
			'http' => array( 'method'  => 'POST', 'header'  => 'Content-type: application/x-www-form-urlencoded;charset=utf-8', 'content' => $lead_sPD )
		);
		$lead_context = stream_context_create($lead_aHTTP);
		$lead_text = file_get_contents($lead_sURL, false, $lead_context);
		
		// $result = json_decode($lead_text);
		// echo '<pre>';
		// print_r($result);
		// echo '</pre>';

	// Array
	// (
	//     [response] => Array
	//         (
	//             [incoming_order_id] => 282
	//             [type] => 1
	//             [spot_id] => 1
	//             [status] => 0
	//             [client_id] => 316
	//             [client_address_id] => 514
	//             [table_id] => 
	//             [comment] => Самовывоз в 19:30 / Оплата: Наличными
	//             [created_at] => 2021-04-28 18:30:26
	//             [updated_at] => 2021-04-28 18:30:26
	//             [transaction_id] => 
	//             [service_mode] => 2
	//             [delivery_price] => 
	//             [fiscal_spreading] => 0
	//             [fiscal_method] => 
	//             [promotion] => 
	//             [delivery_time] => 0000-00-00 00:00:00
	//             [payment_method_id] => 
	//             [first_name] => 
	//             [last_name] => 
	//             [phone] => 79994677109
	//             [email] => 
	//             [sex] => 
	//             [birthday] => 
	//             [address] => Ленинградская
	//             [products] => Array
	//                 (
	//                     [0] => Array
	//                         (
	//                             [io_product_id] => 997
	//                             [product_id] => 213
	//                             [modificator_id] => 142
	//                             [incoming_order_id] => 282
	//                             [count] => 1.0000000
	//                             [price] => 18600
	//                             [created_at] => 2021-04-28 18:30:26
	//                             [modification] => Array
	//                                 (
	//                                     [0] => Array
	//                                         (
	//                                             [m] => 25
	//                                             [a] => 1
	//                                         )

	//                                     [1] => Array
	//                                         (
	//                                             [m] => 26
	//                                             [a] => 1
	//                                         )

	//                                     [2] => Array
	//                                         (
	//                                             [m] => 28
	//                                             [a] => 1
	//                                         )

	//                                 )

	//                         )

	//                     [1] => Array
	//                         (
	//                             [io_product_id] => 998
	//                             [product_id] => 205
	//                             [modificator_id] => 0
	//                             [incoming_order_id] => 282
	//                             [count] => 1.0000000
	//                             [price] => 9900
	//                             [created_at] => 2021-04-28 18:30:26
	//                         )

	//                 )

	//         )

	// )
	// header("Location: index.php");
}

?>

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(79488682, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/79488682" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->