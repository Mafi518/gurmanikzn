<?php


echo '<div class="footer-map">';
	echo '<script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Acbb8d27c57a1cb4a974e861a3cba388cf588cb7589ed121dcbadf190d2e10f95&amp;width=100%25&amp;height=520&amp;lang=ru_RU&amp;scroll=true"></script>';
echo '</div>';


echo '<div class="footer">';
	// echo '<div class="header-logo">';
	// 	echo '<div class="logo-img"></div>';
	// echo '</div>';
	echo '<div class="footer-left">';
		echo '<div class="footer-phone">
			<a href="tel:88005502457">8 (800) 550-24-57</a>
			<div class="city">Казань</div>
			<a href="tel:89376252920">203-29-20</a>
			<div class="city">пос. Дербышки</div>
			<a href="tel:89376254083">203-40-83</a>
			<div class="city">с. Высокая гора</div>
		</div>';
		echo '<div class="btns-social">
			<a rel="nofollow" target="_blank" href="https://instagram.com/mozzarellakzn" class="btn-icon icon-inst"></a>
			<a rel="nofollow" target="_blank" href="https://vk.com/mozzarellakzn" class="btn-icon icon-vk"></a>
		</div>';
		echo '<a href="mailto:mozzarella.kazan@yandex.ru">mozzarella.kazan@yandex.ru</a>';
	echo '</div>';
	echo '<div class="footer-center">';
		echo '<div class="footer-title">Служба доставки<br>"Mozzarella"</div>';
		echo '<div class="logo-img"></div>';
		echo '<div class="desc">От души и со вкусом!</div>';
	echo '</div>';
			// Казань, 8 (800) 550-24-57<br>
			// пос. Дербышки, 8 (937) 625-29-20<br>
			// с. Высокая гора, 8 (937) 625-40-83<br>
			// <br>
	echo '<div class="footer-right">';
		echo 'ПН-ЧТ 10:00-21:30<br>
			ПТ 10:00-22:30<br>
			СБ 11:00-22:30<br>
			ВС 11:00-21:30<br>';
		echo '<p>
			ИП Гарбера Р.А.<br>
			ИНН 166016398893<br>
			ОГРНИП 314169001600090<br>
		</p>';
	echo '</div>';
			// <br>
			// * прием заказов останавливается<br> за 30 мин. до закрытия
echo '</div>';


?>

<script src="script/jquery.js"></script>
<script src="script/jquery.cookie.js"></script>
<script src="script/main.js<?php echo '?'.$hash ?>"></script>

</body></html>