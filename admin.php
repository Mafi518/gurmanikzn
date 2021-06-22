<?php

include 'db.php';

include 'head.php';


echo '<div class="wrapper">';

if($_POST['submit_login']){
	if($_POST['password']=='a3DeS1q' OR $_COOKIE['mozzarellakzn_hash']=='true'){
		$_SESSION['user_id'] = 1;
		setcookie("mozzarellakzn_hash", 'true', time()+60*60*24*30, '/');
	}
}

// Добавление блюда
if($_POST['submit_dish_add'] AND $_SESSION['user_id']){
	if($_POST['dish_name']=='')
		echo '<div class="error-box">Укажите название блюда</div>';
	else if($_POST['dish_chapter']==0)
		echo '<div class="error-box">Выберите категорию блюда</div>';
	else {
		$variants = Array();
		$sets = ''; foreach($_POST as $key => $value){
			if($key!='submit_dish_add'){
				$ex = explode('_',$key);
				if($ex[2]>0 AND $ex[2]<=3){
					$variants[$ex[2]][$ex[0].'_'.$ex[1]] = $value;
				} else {
					if($sets && $sets!='') $sets .= ', ';
					$sets .= $key."='".$value."'";
				}
			}
		};
		// echo '<div class="done-box">';
		// 	echo '<pre>';
		// 	print_r($variants);
		// 	echo '</pre>';
		// echo '</div>';
		// if(1==1){
		if(mysqli_query($link, "INSERT INTO dishes SET ".$sets)){
			// echo '<div class="done-box">';
			// 	echo $sets;
			// echo '</div>';
			$id = mysqli_insert_id($link);
			foreach($variants as $v){
				mysqli_query($link, "INSERT INTO dishes_variants SET variant_did='".$id."', variant_weight='".$v['variant_weight']."', variant_diameter='".$v['variant_diameter']."', variant_price='".$v['variant_price']."'");
			};
			// header('Location: /admin'); exit();
		} else {
			echo '<div class="error-box">';
				echo $sets;
			echo '</div>';
		}
	}; // errors
}

// Редактирование. Сохранение изменений блюд
if($_GET['edit_dish'] AND $_POST['submit_dish_edit'] AND $_SESSION['user_id']){
	if($_POST['dish_name']=='')
		echo '<div class="error-box">Укажите название блюда</div>';
	else if($_POST['dish_chapter']==0)
		echo '<div class="error-box">Выберите категорию блюда</div>';
	else {
		$variants = Array();
		$sets = ''; foreach($_POST as $key => $value){
			if(strpos($key,'submit')!==false OR strpos($key,'date')!==false OR strpos($key,'_id')!==false){}
			else {
				$ex = explode('_',$key);
				if($ex[2]>0 AND $ex[2]<=3){
					$variants[$ex[2]][$ex[0].'_'.$ex[1]] = $value;
				} else {
					if($sets && $sets!='') $sets .= ', ';
					$sets .= $key."='".$value."'";
				}
			}
		};
		// echo '<div class="done-box">';
		// 	echo '<pre>';
		// 	print_r($variants);
		// 	echo '</pre>';
		// echo '</div>';
		if(mysqli_query($link, "UPDATE dishes SET ".$sets." WHERE dish_id='".$_GET['edit_dish']."'")){
			$id = $_GET['edit_dish'];
			foreach($variants as $v){ 
				if($v['variant_vid'])
					mysqli_query($link, "UPDATE dishes_variants SET variant_did='".$id."', variant_fid='".$v['variant_fid']."', ".
						"variant_weight='".$v['variant_weight']."', variant_diameter='".$v['variant_diameter']."', variant_price='".$v['variant_price']."' ".
						" WHERE variant_id='".$v['variant_vid']."'");
				else
					mysqli_query($link, "INSERT INTO dishes_variants SET variant_did='".$id."', variant_fid='".$v['variant_fid']."', ".
						"variant_weight='".$v['variant_weight']."', variant_diameter='".$v['variant_diameter']."', variant_price='".$v['variant_price']."' ".
						"");
			};
			// header('Location: /admin?edit_dish='.$_GET['edit_dish']); exit();
		} else {
			echo '<div class="error-box">';
				echo $sets;
			echo '</div>';
		}
	}; // errors
}
// Редактирование. Вывод данных
else if($_GET['edit_dish'] AND $_SESSION['user_id']){
	$query_dish = mysqli_query($link, "SELECT * FROM dishes WHERE dish_id='".$_GET['edit_dish']."' LIMIT 1");
	if(mysqli_num_rows($query_dish)>0){
		$row = mysqli_fetch_assoc($query_dish);
		foreach($row as $key => $value){
			$_POST[$key] = $value;
		};
	}
}
// Редактирование. Удаление блюда
if($_GET['edit_dish'] AND $_POST['submit_dish_delete_check'] AND $_SESSION['user_id']){
	echo '<form method="POST" class="error-box w-100">';
		echo '<p>Вы уверены, что хотите безвозвратно удалить блюдо ['.$_GET['edit_dish'].'] '.$_POST['dish_name'].'?</p>';
		echo '<input type="submit" name="submit_dish_delete" value="Удалить блюдо">';
	echo '</form>';
} else if($_GET['edit_dish'] AND $_POST['submit_dish_delete'] AND $_SESSION['user_id']){
	if(mysqli_query($link, "DELETE FROM dishes WHERE dish_id='".$_GET['edit_dish']."'")){
		header('Location: /admin'); exit();
	} else {
		echo '<div class="error-box">';
			echo 'Ошибка: Не удалось удалить блюдо';
		echo '</div>';
	}
}


// Добавление категории
if($_POST['submit_chapter_add'] AND $_POST['chapter_title']!='' AND $_SESSION['user_id']){
	$sets = ''; foreach($_POST as $key => $value){
		if($key!='submit_chapter_add'){
			if($sets && $sets!='') $sets .= ', ';
			$sets .= $key."='".$value."'";
		}
	};
	if(mysqli_query($link, "INSERT INTO dishes_chapters SET ".$sets)){
		header('Location: /admin#chapters_new'); exit();
	} else {
		echo '<div class="error-box">';
			echo $sets;
		echo '</div>';
	}
}


// Изменение категорий
if($_POST['submit_chapters_save'] AND $_SESSION['user_id']){
	$chapters = Array();
	$sets = ''; foreach($_POST as $key => $value){
		if($key!='submit_chapters_save'){
			if($sets && $sets!='') $sets .= ', ';
			$sets .= $key."='".$value."'";
			$ex = explode('_',$key);
			$chapters[$ex[2]][$ex[0].'_'.$ex[1]] = $value;
		}
	};
	foreach($chapters as $row){
		$sets = ''; foreach($row as $key => $value){
			if($key!='chapter_id'){
				if($sets && $sets!='') $sets .= ', ';
				$sets .= $key."='".$value."'";
			}
		};
		// echo "UPDATE INTO dishes_chapters SET ".$sets." WHERE chapter_id='".$row['chapter_id']."'<br>";
		mysqli_query($link, "UPDATE dishes_chapters SET ".$sets." WHERE chapter_id='".$row['chapter_id']."'");
	}
	header('Location: /admin#chapters_list'); exit();
	// echo '<div class="done-box">';
	// 	// echo $sets;
	// 	echo '<pre>';
	// 	print_r($chapters);
	// 	echo '</pre>';
	// echo '</div>';
	// if(mysqli_query($link, "INSERT INTO dishes_chapters SET ".$sets)){
	// 	header('Location: /admin'); exit();
	// } else {
	// 	echo '<div class="error-box">';
	// 		echo $sets;
	// 	echo '</div>';
	// }
}


// ###################################################
// ### ПРОВЕРКА НА СЕССИЮ АДМИНА
// ###################################################
if(!$_SESSION['user_id']){
	echo '<h2>Вход для модератора сайта</h2>';
	echo '<div class="block-wrapper align-center">';
		echo '<form method="POST" class="w-30">';
			echo '<input type="password" name="password" class="w-100" placeholder="Пароль от админ-панели"><br>';
			echo '<input type="submit" name="submit_login" value="Войти">';
		echo '</div>';
	echo '</div>';
}
else {
	// ###################################################
	// ### БЛЮДА
	// ###################################################
	if($_GET['edit_dish'])
		echo '<h2>Редактирование блюда</h2>';
	else
		echo '<h2>Добавление блюд</h2>';
	echo '<div class="block-wrapper align-center">';
		echo '<form method="POST" class="w-50">';
			echo '<label>Категория:</label>';
			echo '<select name="dish_chapter">';
				$query_chapters = mysqli_query($link, "SELECT * FROM dishes_chapters ORDER BY chapter_num");
				echo '<option value="0">Выберите категорию</option>';
		    	while($row = mysqli_fetch_assoc($query_chapters)){
					echo '<option value="'.$row['chapter_id'].'" '.($_POST['dish_chapter']==$row['chapter_id']?'selected':'').'>'.($row['chapter_num']?$row['chapter_num'].'.':'[скрыто]').' '.$row['chapter_title'].'</option>';
		    	};
			echo '</select>';
			echo '<label>Название блюда:</label>';
			echo '<input type="text" name="dish_name" placeholder="Название" value="'.$_POST['dish_name'].'"><br>';
			echo '<label>Артикул api:</label>';
			echo '<input type="number" name="dish_fid" placeholder="ID артикула для заказа frontpad" value="'.$_POST['dish_fid'].'"><br>';
			echo '<div class="upload-box">
				<input add-in-list="dish_photos" type="file" class="hide" />
				<div class="overflow overflow-photos-mini">
					<div class="photos-list overflow-box" photos-out="dish_photos"></div>
				</div>
				<a class="upload-btn btn mini" name="profile_upload_photo">Добавить фото</a>
				<input name="dish_photos" type="text" class="hide" photos-in="dish_photos" value="'.$_POST['dish_photos'].'" />
			</div>';
			// echo '<label>Вес, гр:</label>';
			// echo '<input type="text" name="dish_weight" placeholder="Вес блюда" value="'.$_POST['dish_weight'].'"><br>';
			// echo '<label>Цена, руб:</label>';
			// echo '<input type="text" name="dish_price" placeholder="Цена в рублях" value="'.$_POST['dish_price'].'"><br>';
			// Варианты блюда
			// echo '<label>Варианты блюда</label>';
			// echo '<input type="text" name="variant_name_'.$row['dish_id'].'" value="'.$row['dish_num'].'" placeholder="Наименование варианта">';
			$variant_i = 0;
			$query_variants = mysqli_query($link, "SELECT * FROM dishes_variants WHERE variant_did='".$_GET['edit_dish']."' ORDER BY variant_price");
		    while($row = mysqli_fetch_assoc($query_variants) OR $variant_i<1){
				$variant_i++;
				echo '<input type="hidden" name="variant_vid_'.$variant_i.'" value="'.$row['variant_id'].'">';
				echo '<div class="chapter-box dashed">';
					echo '<div class="chapter-weight chapter-cell">';
						echo '<label>Артикул api:</label>';
						echo '<input type="number" name="variant_fid_'.$variant_i.'" value="'.($row['variant_fid']?$row['variant_fid']:$_POST['dish_fid']).'" placeholder="Api ID">';
					echo '</div>';
					echo '<div class="chapter-weight chapter-cell">';
						echo '<label>Вес:</label>';
						echo '<input type="number" name="variant_weight_'.$variant_i.'" value="'.$row['variant_weight'].'" placeholder="Вес, гр.">';
					echo '</div>';
					echo '<div class="chapter-diameter chapter-cell">';
						echo '<label>Диаметр:</label>';
						echo '<input type="number" name="variant_diameter_'.$variant_i.'" value="'.$row['variant_diameter'].'" placeholder="Диаметр, см.">';
					echo '</div>';
					echo '<div class="chapter-price chapter-cell">';
						echo '<label>Цена:</label>';
						echo '<input type="number" name="variant_price_'.$variant_i.'" value="'.($row['variant_price']?$row['variant_price']:$_POST['dish_price']).'" placeholder="Цена, руб.">';
					echo '</div>';
				echo '</div>';
			}
			if($variant_i<3){
				echo '<div class="chapter-box dashed chapter-add" variant="'.$variant_i.'">';
					echo '<div class="align-center">Добавить вариант</div>';
				echo '</div>';
			}
			//
			echo '<label>Состав:</label>';
			echo '<textarea type="text" name="dish_structure" placeholder="Ингредиенты">'.$_POST['dish_structure'].'</textarea>';
			echo '<label>Описание:</label>';
			echo '<textarea type="text" name="dish_desc" placeholder="Полное описание">'.$_POST['dish_desc'].'</textarea>';
			//
			if($_GET['edit_dish']){
				echo '<input type="submit" name="submit_dish_edit" value="Сохранить изменения">';
				echo '<br><br>';
				echo '<input type="submit" name="submit_dish_delete_check" value="Удалить блюдо" class="red">';
			} else
				echo '<input type="submit" name="submit_dish_add" value="Добавить блюдо">';
		echo '</form>';
	echo '</div>';


	// ###################################################
	// ### КАТЕГОРИИ
	// ###################################################
	echo '<h2>Категории блюд</h2>';

	echo '<div class="block-wrapper align-center">';

		echo '<a name="chapters_list"></a>';
		echo '<h3>Список и порядок категорий</h3>';

		echo '<form method="POST" class="w-50">';
			$query_chapters_edit = mysqli_query($link, "SELECT * FROM dishes_chapters ORDER BY chapter_num");
			while($row = mysqli_fetch_assoc($query_chapters_edit)){
				echo '<div class="chapter-box">';
					echo '<div class="chapter-count">';
						echo '<input type="number" name="chapter_num_'.$row['chapter_id'].'" value="'.$row['chapter_num'].'" placeholder="№">';
						echo '<input type="hidden" name="chapter_id_'.$row['chapter_id'].'" value="'.$row['chapter_id'].'">';
					echo '</div>';
					echo '<div class="chapter-title">';
						echo '<input type="text" name="chapter_title_'.$row['chapter_id'].'" value="'.$row['chapter_title'].'" placeholder="Наименование категории" '.($row['chapter_disabled']?'disabled':'').'>';
					echo '</div>';
				echo '</div>';
			};
			echo '<input type="submit" name="submit_chapters_save" value="Сохранить категории">';
		echo '</form>';

		echo '<a name="chapters_new"></a>';
		echo '<h3>Новая категория</h3>';

		echo '<form method="POST" class="w-50">';
			echo '<div class="chapter-box">';
				echo '<div class="chapter-count">';
					echo '<input type="number" name="chapter_num" placeholder="№">';
				echo '</div>';
				echo '<div class="chapter-title">';
					echo '<input type="text" name="chapter_title" placeholder="Наименование категории">';
				echo '</div>';
			echo '</div>';
			//
			echo '<input type="submit" name="submit_chapter_add" value="Добавить категорию">';
		echo '</form>';

	echo '</div>';

}

echo '</div>';

include 'footer.php';

?>