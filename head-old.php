<html>
<head>
	<meta name="viewport" content="width=device-width">
	<title>Служба доставки "Mozzarella" / MozzarellaKZN.ru</title>
	<meta name="description" content="Закажи доставку пиццы и роллов в Казани прямо на сайте!">
	<link rel="stylesheet" href="style/style.css<?php echo '?'.$hash ?>">
	<link rel="stylesheet" href="style/fonts/ProximaNova/stylesheet.css">
	<link rel="shortcut icon" href="images/favicon2.png" type="image/png">
</head>
<body>


<?php

if($_SESSION['user_id'])
	echo '<a href="/admin" class="btn btn-block two-style">Админ-панель</a>';

// ###################################################
// ### HEADER mobile
// ###################################################
echo '<div class="block-header mobile">';
	echo '<div class="header-logo">';
			// echo '<img src="images/logo2.jpg" width="128">';
		echo '<a href="/" class="logo-img"></a>';
	echo '</div>';
	echo '<div class="header-title">';
		echo 'Служба доставки<br>"Mozzarella"'; 
	echo '</div>';
	echo '<div class="header-phone">
		<a href="tel:88005502457">8 (800) 550-24-57</a>
		<div class="city">Казань</div>
		<a href="tel:89376252920">203-29-20</a>
		<div class="city">пос. Дербышки</div>
		<a href="tel:89376254083">203-40-83</a>
		<div class="city">с. Высокая гора</div>
	</div>';
echo '</div>';


// ###################################################
// ### HEADER desktop
// ###################################################
echo '<div class="block-header desktop">';
	echo '<div class="header-left">';
			// echo '<img src="images/logo2.jpg" width="128">';
		echo '<a href="/" class="logo-img"></a>';
	echo '</div>';
	echo '<div class="header-title">';
		echo 'Служба доставки<br>"MOZZARELLA"'; 
	echo '</div>';
	echo '<div class="header-phone">
			Казань, 8 (800) 550-24-57<br>
			пос. Дербышки, 203-29-20<br>
			с. Высокая гора, 203-40-83<br>
	</div>';
echo '</div>';


// ###################################################
// ### МЕНЮ И КОРЗИНА
// ###################################################
echo '<div class="fix-btns">';
	echo '<div class="btn-menu"></div><br>';
	echo '<div class="btn-cart">';
		echo '<div class="cart-count">0</div>';
		echo '<div class="cart-sum">= 0 р.</div>';
	echo '</div>';
echo '</div>';

echo '<div class="menu hide">';
	echo '<div class="align-center">';
		echo '<div href="/" class="logo-img"></div>';
		$query_menu = mysqli_query($link, "SELECT * FROM dishes_chapters ORDER BY chapter_num");
		while($chapter = mysqli_fetch_assoc($query_menu)){
			echo '<a href="/#block-'.$chapter['chapter_id'].'">'.$chapter['chapter_title'].'</a>';
		};
		echo '<div class="btns-social">
			<a rel="nofollow" target="_blank" href="https://instagram.com/mozzarellakzn" class="btn-icon icon-inst"></a>
			<a rel="nofollow" target="_blank" href="https://vk.com/mozzarellakzn" class="btn-icon icon-vk"></a>
		</div>';
		echo '<div class="menu-desc">
			ПН-ЧТ 10:00-21:30<br>
			ПТ 10:00-22:30<br>
			СБ 11:00-22:30<br>
			ВС 11:00-21:30<br>
		</div>';
	echo '</div>';
			// <br>
			// * прием заказов останавливается<br> за 30 мин. до закрытия
echo '</div>';


?>