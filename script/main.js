(function(){




	var indexes = {
		'420000': 2,
		'420004': 3,
		'420005': 2,
		'420006': 4,
		'420012': 1,
		'420015': 1,
		'420017': 5,
		'420021': 1,
		'420025': 3,
		'420029': 2,
		'420030': 3,
		'420032': 3,
		'420033': 3,
		'420034': 3,
		'420036': 4,
		'420037': 4,
		'420039': 3,
		'420043': 1,
		'420044': 3,
		'420047': 4,
		'420049': 1,
		'420051': 5,
		'420053': 3,
		'420054': 1,
		'420055': 2,
		'420056': 3,
		'420059': 1,
		'420061': 2,
		'420064': 2,
		'420066': 2,
		'420070': 3,
		'420071': 4,
		'420073': 1,
		'420075': 4,
		'420076': 5,
		'420077': 5,
		'420078': 5,
		'420079': 5,
		'420080': 3,
		'420081': 2,
		'420083': 4,
		'420085': 4,
		'420087': 1,
		'420088': 2,
		'420091': 5,
		'420094': 3,
		'420095': 3,
		'420096': 5,
		'420097': 1,
		'420098': 5,
		'420099': 5,
		'420100': 3,
		'420101': 2,
		'420102': 3,
		'420105': 1,
		'420107': 1,
		'420108': 1,
		'420111': 1,
		'420124': 2,
		'420127': 4,
		'420129': 3,
		'420132': 3,
		'420138': 2,
		'420139': 3,
		'420140': 3,
		'420141': 3,
		'421001': 3,
		'422700': 5,
		'422712': 5,
		'422718': 5,
		'422774': 5,
		'420008': 5,
		// new
		'420010': 1,
		'420011': 2,
		'420014': 4,
		'420060': 1,
		'420074': 1,
		'420103': 3,
		'420110': 2,
		'420126': 3,
		'420130': 5,
		'420133': 3,
	};
	
	var promocodes = [
		{
			name: 'test',
			discount: 20
		},
		{
			name: 'test2',
			discount: 10
		}
	]
	
	var pizza = [
		{
			name: 'Пицца 4 Сезона',
			small: 379,
			big: 479
		},
		{
			name: 'Пицца 4 Сыра',
			small: 379,
			big: 449
		},
		{
			name: 'Пицца Азия',
			small: 379,
			big: 479
		},
		{
			name: 'Пицца Гавайская',
			small: 379,
			big: 459
		},
		{
			name: 'Пицца Италия',
			small: 379,
			big: 519
		},
		{
			name: 'Пицца Капричиоза',
			small: 379,
			big: 479
		},
		{
			name: 'Пицца Королевская',
			small: 379,
			big: 519
		},
		{
			name: 'Пицца Маргарита',
			small: 379,
			big: 399
		},
		{
			name: 'Пицца Маринара',
			small: 379,
			big: 479
		},
		{
			name: 'Пицца Мексика',
			small: 379,
			big: 479
		},
		{
			name: 'Пицца Море',
			small: 379,
			big: 479
		},
		{
			name: 'Пицца Мясная',
			small: 379,
			big: 499
		},
		{
			name: 'Пицца Охотничья',
			small: 379,
			big: 499
		},
		{
			name: 'Пицца Пепперони',
			small: 379,
			big: 439
		},
		{
			name: 'Пицца Ранч',
			small: 379,
			big: 419
		},
		{
			name: 'Пицца Римская',
			small: 379,
			big: 449
		},
		{
			name: 'Пицца Тейсти',
			small: 379,
			big: 519
		},
		{
			name: 'Пицца Тоскана',
			small: 379,
			big: 479
		},
		{
			name: 'Пицца Цезарь',
			small: 379,
			big: 499
		},
		{
			name: 'Пицца Чизбургер',
			small: 379,
			big: 479
		},
	]
	
	// Номер тарифа	БЕСПЛАТНАЯ ДОСТАВКА	ПЛАТНАЯ	МИНИМАЛЬНАЯ СУММА 
	var tariffs = {
		1: { free: 600, pay: -1, min: 600 },
		2: { free: 1000, pay: 150, min: 800 },
		3: { free: 1200, pay: 200, min: 1000 },
		4: { free: 1500, pay: 250, min: 1200 },
		5: { free: 2000, pay: 300, min: 1500 },
	};
	
	// ==================================================
	// === AUTOCOMPLETE === */
	// ==================================================
	
	// $.lists = [];
	// $.ajax({ method: 'POST',
	// 	url: 'lists_load.php',
	// 	success: function(data){ data = JSON.parse(data);
	// 		// console.log(data);
	// 		$.lists = data;
	// 		inputsInit();
	// 	},
	// 	error: function(){
	// 		$.message('<h3>Ошибка загрузки списков</h3>Не удалось загрузить списки, попробуйте позже');
	// 	},
	// });
	
	
	function split( val ) {
		return val.split( /;\s*/ );
	}
	function extractLast( term ) {
		return split( term ).pop();
	}
	
	
	// $.fn.searchInputEasy = function(mas){
	// 	$(this)
	// 	.on( "click", function( event ) {
	// 		// $(this).autocomplete('search', ' ');
	// 		onChangeInputs();
	// 	})
	// 	.autocomplete({
	// 		source: mas
	// 	});
	// };
	$.fn.searchInput = function(mas,sets){
		$(this)
		.on( "keydown", function( event ) {
			if ( event.keyCode === $.ui.keyCode.TAB &&
			$( this ).autocomplete( "instance" ).menu.active ) {
				event.preventDefault();
			}
		})
		.on( "click", function( event ) {
			if(sets!='easy') $(this).autocomplete('search', '');
			// onChangeInputs();
		})
		.autocomplete({
			minLength: 2,
			delay: 0,
			source: function( request, response ) {
				// delegate back to autocomplete, but extract the last term
				response( $.ui.autocomplete.filter(
					mas, extractLast( request.term ) ) );
			},
			focus: function() {
				// prevent value inserted on focus
				return false;
			},
			select: function( event, ui ) {
				var terms = split( this.value );
				// remove the current input
				terms.pop();
				// add the selected item
				terms.push( ui.item.value );
				// Указываем условия доставки
				// console.log('select index: '+ui.item.i);
				// console.log(tariffs[indexes[ui.item.i]]);
				getDelivery(tariffs[indexes[ui.item.i]]);
				// add placeholder to get the comma-and-space at the end
				terms.push( "" );
				if(sets=='multi') this.value = terms.join( "; " );
				else this.value = terms[0];
				return false;
			}
		});
	};
	
	var inputsInit = function(){
		// // $('[name="act_place_street"]').searchInputEasy(streets[$('[name="act_place_city"]').val()]);
		// if($.lists && $.lists['attached'] && $.lists['attached'][$('[name="act_place_city"]').val()])
		// 	$('[name="act_place_street"]').searchInput($.lists['attached'][$('[name="act_place_city"]').val()],'easy');
		// else
		// 	$('[name="act_place_street"]').searchInput([],'easy');
	
		// $('[name*="detail"]').each(function(){
		// 	var box = $(this).closest('.multi');
		// 	// var mas = details[box.find('[name*="element"]').val()];
		// 	var mas = [];
		// 	if($.lists && $.lists['attached'] && $.lists['attached'][box.find('[name*="element"]').val()])
		// 		mas = $.lists['attached'][box.find('[name*="element"]').val()];
		// 	if(mas) $(this).searchInput(mas);
		// });
	
		$('[name="street"]').searchInput($.streets,'easy');
	}; inputsInit();
	
	
	// ==================================================
	// === Delivery info === */
	// ==================================================
	function getDelivery(data){
		var box = $('.popup-box .delivery-info');
		box.html('');
		// console.log(data);
		$('<div class="delivery-sum">Минимальная сумма заказа: <b>'+data.min+'</b> руб.</div>').appendTo(box);
		$('<div class="delivery-sum">Сумма заказа для бесплатной доставки: <b>'+data.free+'</b> руб.</div>').appendTo(box);
		// $('<div class="delivery-sum">'+(data.pay!=-1?'Стоимость доставки: <b>'+data.pay+'</b> руб.':'')+'</div>').appendTo(box);
		if(data.pay!=-1){
			$('<div class="delivery-sum">Стоимость доставки: <b>'+data.pay+'</b> руб.</div>').appendTo(box);
			$('<div class="delivery-sum"><input name="delivery_free" type="hidden" value="'+data.free+'"></div>').appendTo(box);
			$('<div class="delivery-sum"><input name="delivery_price" type="hidden" value="'+data.pay+'"></div>').appendTo(box);
		}
	}
	
	
	// ==================================================
	// === SLIDER === */
	// ==================================================
	
	var slider_current = 0;
	var slider_max = $('[slider]').length;
	$('.slider-right').click(function(){
		if(slider_current-1>-slider_max)
			slider_current--;
		else
			slider_current = 0;
		$('.sliders').animate({'margin-left': (slider_current)+'00vw'},500);
		goSliderInterval();
	});
	$('.slider-left').click(function(){
		if(slider_current+1<=0)
			slider_current++;
		else
			slider_current = -slider_max+1;
		$('.sliders').animate({'margin-left': (slider_current)+'00vw'},500);
		goSliderInterval();
	});
	
	var slider_interval = undefined;
	var goSliderInterval = function(){
		clearInterval(slider_interval);
		slider_interval = setInterval(function(){
			$('.slider-right').trigger('click');
		},3000);
	};
	goSliderInterval();
	
	
	// ==================================================
	// === POPUP === */
	// ==================================================
	var popupBox = $('<div class="popup-box">')
	$('<div class="popup-close"></div>').click(function(){
		$('.popup-box').animate({'opacity':'0'},300,function(){ $(this).hide() });
		$('.fix-btns').fadeIn("slow");
	}).appendTo(popupBox);
	$('<div class="popup-wrapper">').appendTo(popupBox);
	popupBox.appendTo('body');
	
	$.fn.popup = function(f){
		if(!f) f=[];
		if(!f.class) f.class='';
		$('.popup-wrapper').attr('class','popup-wrapper');
		$('.popup-wrapper').addClass(f.class).html($(this).html());
		//
		$('.popup-box').show().animate({'opacity':1},300);
		$('.fix-btns').hide();
	};
	
	
	// ==================================================
	// === CART PRE === */
	// ==================================================
	var updatePrice = function(){
		var price = 0;
		$('.popup-box [price]:checked, .popup-box [price]:selected').each(function(){
			price += parseInt($(this).attr('price'));
			// console.log('+'+parseInt($(this).attr('price')));
		});
		// console.log('='+price);
		$('.popup-box .product-price').html(price+' р.');
		// Сохраняем все в textarea для добавления в корзину
		//
	};
	
	// $('.cart-elem .dish-img, .cart-elem .dish-name, .cart-elem .dish-price, .cart-elem.dish-box').click(function(){
	$('.action-add-to-cart').click(function(){
		var elem = $(this);
		var box = $(this).closest('.cart-elem');
		var data = [];
		box.find('[cart-data]').each(function(){
			data[$(this).attr('cart-data')] = JSON.parse($(this).val());
		});

		// console.log(data);
		var price = 0;
		if(data.variants && data.variants.length)
			price = data.variants[0]['variant_price'] ? data.variants[0]['variant_price'] : data.product['price_shop'];
		else
			price = data.product['price_shop'];
		//
		var cart = $('<div>');
		var table = $('<div class="popup-table">');
		var leftBox = $('<div class="popup-left">');
	
		$('<img src="'+data.product['photo_origin']+'">').appendTo(leftBox);
	
		var rightBox = $('<div class="popup-right">');
	
		$('<div class="product-name" dish-fid="'+data.product['product_id']+'">'+data.product['product_name']+'</div>').appendTo(rightBox);
		$('<div class="product-price" cart-var="price">'+price+' р.</div>').appendTo(rightBox);
		// select variants
		var selectVariants = $('<div name="variants" cart-check="select_variants">');
		// var selectVariants = $('<select name="variants" cart-var="select_variants">');
		if(data.variants){
			if(data.variants.length>1)
				$('<label>Варианты блюда:</label>').appendTo(rightBox);
			else
				selectVariants.hide();
			var i=0; data.variants.forEach(function(v){ i++;
				// $('<option value="'+v['variant_id']+'" price="'+v['variant_price']+'">'+
				// '<span>'+(v['variant_diameter']>0?v['variant_diameter']+' см. / ':'')+(v['variant_weight']>0?v['variant_weight']+' гр. / ':'')+v['variant_price']+' р.</span></option>')
				// .appendTo(selectVariants);
				var labelBox = $('<div class="label-box inline select-variants dish-variants" value="'+v['variant_id']+'">');
				$('<input id="v'+v['variant_id']+'" class="hide" type="radio" name="variants" price="'+v['variant_price']+'" variant-fid="'+v['variant_fid']+'" '+(i==1?'checked':'')+'/>').appendTo(labelBox);
				$('<label for="v'+v['variant_id']+'" class="inline">'+
					'<span>'+(v['variant_diameter']>0?v['variant_diameter']+' см.<br>':'')+(v['variant_price']>0?'<b>'+v['variant_price']+'р.</b><br>':'')+(v['variant_weight']>0?v['variant_weight']+'гр.<br>':'')+'</span></label>')
				.appendTo(labelBox);
				labelBox.appendTo(selectVariants);
			});
		} else {
			// $('<option value="0" price="'+data.product['price_shop']+'">'+data.product['price_shop']+' р.</option>').appendTo(selectVariants);
			var labelBox = $('<div class="label-box inline select-variants" value="0">');
			$('<input id="v0" class="hide" type="radio" name="variants" price="'+data.product['price_shop']+'" checked/>').appendTo(labelBox);
			$('<label for="v0" class="inline">'+
				'<span>Единственный вариант</span></label>')
			.appendTo(labelBox);
			labelBox.appendTo(selectVariants);
			selectVariants.hide();
		}
		selectVariants.appendTo(rightBox);
		$('<hr>').appendTo(rightBox);
	
	
		// ==================================================
		// === ДОПКИ === */
	
		var isAddonsRadio = false;
	
		if(data.group_modifications){
			if(data.product['product_name'].indexOf('Поке')!=-1
				|| data.product['product_name'].indexOf('Лапша')!=-1
				// || data.product['isAddonsRadio']
				|| data.product['menu_category_id']==15
			){
				isAddonsRadio = true;
			} else {
				$('<label>Дополнительно:</label>').appendTo(rightBox);
			}
			var selectModGroup = $('<div name="group_modifications" cart-check="select_group_modifications">');
			// data.group_modifications = JSON.parse(data.group_modifications);
			console.log(data.group_modifications[0]['modifications']);
			// modifications: Array(3)
			// 	0:
			// 	brutto: 75
			// 	dish_modification_id: 15
			// 	ingredient_id: 331
			// 	last_modified_time: "2021-03-15 11:29:20"
			// 	name: "Лапша гречневая"
			// 	photo_large: ""
			// 	photo_orig: ""
			// 	photo_small: ""
			// 	price: 0
			// 	type: 10
			data.group_modifications[0]['modifications'].forEach(function(v){
				// if(v['variants']){
					// console.log(v);
					var price_addon = v['price'];
					var variant_addon = v['dish_modification_id'];
					var labelBox = $('<div class="label-box select-variants" value="'+variant_addon+'">');
					$('<label class="select-variants"><input type="'+(isAddonsRadio?'radio':'checkbox')+'" name="group_modifications" price="'+price_addon+'" variant-fid="'+variant_addon+'" dish-id="'+data.product['product_id']+'" '+
						// (v['variants'][0]? 'p1="'+v['variants'][0]['variant_price']+'" f1="'+v['variants'][0]['variant_fid']+'" ' : '')+
						// (v['variants'][1]? 'p2="'+v['variants'][1]['variant_price']+'" f2="'+v['variants'][1]['variant_fid']+'" ' : '')+
						// (v['variants'][2]? 'p3="'+v['variants'][2]['variant_price']+'" f3="'+v['variants'][2]['variant_fid']+'" ' : '')+
						'/><span>'+(v['name']?v['name']:'')+(price_addon?' / '+price_addon+' р.':'')+'</span></label>')
					.appendTo(labelBox);
					labelBox.appendTo(selectModGroup);
				// }
			});
			selectModGroup.appendTo(rightBox);
			$('<hr>').appendTo(rightBox);
		}
	
		// select допки бортиков и теста к пицце
		if(data.addons_only_pizza){
			$('<label>К пицце:</label>').appendTo(rightBox);
			var selectAddons_only_pizza = $('<div name="addons_only_pizza" cart-check="select_addons_only_pizza">');
			data.addons_only_pizza.forEach(function(v){
				if(v['variants']){
					var price_addon = v['variants'][0]['variant_price'];
					var variant_addon = v['variants'][0]['variant_fid'];
					var labelBox = $('<div class="label-box select-variants" value="'+v['variant_id']+'">');
					$('<label class="select-variants"><input type="checkbox" name="addons_only_pizza" price="'+price_addon+'" variant-fid="'+variant_addon+'" dish-id="'+v['dish_id']+'" '+
						(v['variants'][0]? 'p1="'+v['variants'][0]['variant_price']+'" f1="'+v['variants'][0]['variant_fid']+'" ' : '')+
						(v['variants'][1]? 'p2="'+v['variants'][1]['variant_price']+'" f2="'+v['variants'][1]['variant_fid']+'" ' : '')+
						(v['variants'][2]? 'p3="'+v['variants'][2]['variant_price']+'" f3="'+v['variants'][2]['variant_fid']+'" ' : '')+'/><span>'+(v['product_name']?v['product_name']+' / ':'')+(price_addon+' р.')+'</span></label>')
					.appendTo(labelBox);
					labelBox.appendTo(selectAddons_only_pizza);
				}
			});
			selectAddons_only_pizza.appendTo(rightBox);
			$('<hr>').appendTo(rightBox);
		}
	
		// select допки бортиков и теста к пицце
		if(data.addons_pizza){
			$('<label>Дополнительно к пицце:</label>').appendTo(rightBox);
			var selectAddons_pizza = $('<div name="addons_pizza" cart-check="select_addons_pizza">');
			data.addons_pizza.forEach(function(v){
				if(v['variants']){
					var price_addon = v['variants'][0]['variant_price'];
					var labelBox = $('<div class="label-box select-variants" value="'+v['variant_id']+'">');
					$('<label class="select-variants"><input type="checkbox" name="addons_pizza" price="'+price_addon+'" dish-id="'+v['dish_id']+'"/>'+
						'<span>'+(v['product_name']?v['product_name']+' / ':'')+(price_addon+' р.')+'</span></label>')
					.appendTo(labelBox);
					labelBox.appendTo(selectAddons_pizza);
				}
			});
			selectAddons_pizza.appendTo(rightBox);
			$('<hr>').appendTo(rightBox);
		}
		// select допки к роллам
		else if(data.addons_rolls){
			$('<label>Дополнительно к роллам:</label>').appendTo(rightBox);
			var selectAddons_rolls = $('<div name="addons_rolls" cart-check="select_addons_rolls">');
			data.addons_rolls.forEach(function(v){
				if(v){ // ['variants']
					// var price_addon = v['variants'][0]['variant_price'];
					// var labelBox = $('<div class="label-box select-variants" value="'+v['variant_id']+'">');
					// $('<label class="select-variants"><input type="checkbox" name="addons_rolls" price="'+price_addon+'" dish-id="'+v['dish_id']+'"/>'+
					// 	'<span>'+(v['product_name']?v['product_name']+' / ':'')+(price_addon+' р.')+'</span></label>')
					// .appendTo(labelBox);
					// labelBox.appendTo(selectAddons_rolls);
	
					var price_addon = v['price_shop'];
					var labelBox = $('<div class="label-box select-variants" value="'+v['product_id']+'">');
					$('<label class="select-variants"><input type="checkbox" name="addons_rolls" price="'+price_addon+'" dish-id="'+v['product_id']+'"/>'+
						'<span>'+(v['product_name']?v['product_name']+' / ':'')+(price_addon+' р.')+'</span></label>')
					.appendTo(labelBox);
					labelBox.appendTo(selectAddons_rolls);
				}
			});
			selectAddons_rolls.appendTo(rightBox);
			$('<hr>').appendTo(rightBox);
		}
		// select допки
		else if(data.addons){
			$('<label>Дополнительно:</label>').appendTo(rightBox);
			var selectAddons = $('<div name="addons" cart-check="select_addons">');
			data.addons.forEach(function(v){
				if(v['variants']){
					var price_addon = v['variants'][0]['variant_price'];
					var labelBox = $('<div class="label-box select-variants" value="'+v['variant_id']+'">');
					$('<label class="select-variants"><input type="checkbox" name="addons" price="'+price_addon+'" dish-id="'+v['dish_id']+'"/>'+
						'<span>'+(v['product_name']?v['product_name']+' / ':'')+(price_addon+' р.')+'</span></label>')
					.appendTo(labelBox);
					labelBox.appendTo(selectAddons);
				}
			});
			selectAddons.appendTo(rightBox);
			$('<hr>').appendTo(rightBox);
		}
		//
		$('<div class="button btn cart-popup-add">Добавить в корзину</div>').appendTo(rightBox);
		$('<div class="product-desc">'+data.product['ingredients_list']+'</div>').appendTo(rightBox);
		leftBox.appendTo(table);
		rightBox.appendTo(table);
		table.appendTo(cart);
		cart.popup();
		$('[name="variants"] input[type="radio"]').on('change',function(){
			var num = parseInt($(this).closest('[cart-check]').find('input:checked').closest('.select-variants').index())+1;
			// $('.popup-box select option').each(function(){
			// 	var value = parseInt($(this).attr('p'+num));
			// 	if(value){
			// 		$(this).attr('price',value);
			// 		var old_text = $(this).html().split(' / ');
			// 		$(this).html(old_text[0]+' / '+value+' р.');
			// 	}
			// });
			$('.popup-box .select-variants').each(function(){
				var price = parseInt($(this).find('[price]').attr('p'+num));
				var fid = parseInt($(this).find('[price]').attr('f'+num));
				// var value = parseInt($(this).find('[price]').attr('value'));
				if(price){
					// console.log(price,num);
					$(this).find('[price]').attr('price',price);
					$(this).find('[price]').attr('variant-fid',fid);
					$(this).closest('[price]').attr('val',num);
					var old_text = $(this).find('span').text().split(' / ');
					$(this).find('span').html(old_text[0]+' / '+price+' р.');
				}
			});
		});
		$('.popup-box select, .popup-box input[type="checkbox"], .popup-box input[type="radio"]').on('change',updatePrice);
		funcClickCartPopupAdd();
	});
	
	
	// ==================================================
	// === CART INIT === */
	// ==================================================
	if($.cookie('gurmani_cart'))
		$.cart = JSON.parse($.cookie('gurmani_cart'));
	else $.cart = [];
	
	var funcUpdateCart = function(){
		var btn = $('.fix-btns').find('.btn-cart');
		var sum = 0;
		var counts = 0;
		// console.log($.cart);
		$.cart.forEach(function(row){
			if(row){
				sum += parseInt(row.p*row.c);
				counts += parseInt(row.c);
			}
		});
		btn.find('.cart-sum').text('= '+sum+' р.');
		btn.find('.cart-count').text(counts);
		$.cookie('gurmani_cart', JSON.stringify($.cart), { expires: 7 });
		$('.popup-box .cart-sum').html('Итого: '+sum+'р.');
		$('.popup-box [name="budget"]').val(sum); // to allbiom
		$('.popup-box [name="order_cart"]').val(JSON.stringify($.cart));
	}; funcUpdateCart();

	// TODO: В куки много не влазиет, может перейти на $_SESSION?
	
	
	// ==================================================
	// === CART SHOW === */
	// ==================================================
	$('.btn-cart').click(function(){
		var div = $('<div>');
		var cart = $('<form method="POST" action="/order.php">');
		$('<div class="cart-title">Оформление заказа</div>').appendTo(cart);
		var i=-1; $.cart.forEach(function(ct){ i++;
			if(ct){
				var col = $('<div class="cart-col cart--fix" cart-id="'+i+'">');
				$('<div class="col-img"><img src="'+ct.i+'"></div>').appendTo(col);
				var colName = $(`<div class="col-name col--fix"> <span class="check-name">${ct.n}</span></div>`); colName.appendTo(col);
				if(ct.d) $('<div class="col-desc">'+ct.d+'</div>').appendTo(colName);
				var addons_text = '';
				if(ct.a) ct.a.forEach(function(addon){
					addons_text += '+ '+addon.d+'<br>';
				});
				$('<div class="col-addons">'+addons_text+'</div>').appendTo(colName);
				if(ct.n.includes('Пицца')) {
					$(`
					<select class="cart__select">
						<option value="1">33 см</option>
						<option value="0">25 см</option>
					</select>
				`).appendTo(colName);
				}
				//
				$('<div class="col-count"><input class="count" type="number" value="'+ct.c+'"></div>').appendTo(col);
				$('<div class="col-price price-change" price-one="'+ct.p+'">'+(ct.p*ct.c)+'р.</div>').appendTo(col);
				// Удаление
				var colDelete = $('<div class="col-delete">');
				$('<div class="cart-elem-delete">').appendTo(colDelete);
				colDelete.appendTo(col);
				// Рендеринг строки
				col.appendTo(cart);
			}
		});
		$('<div class="cart-col"><div class="col-price cart-sum count-price big"></div></div>').appendTo(cart);
		$('<div class="cart-inp"><textarea type="text" name="order_cart" class="hide"></textarea></div>').appendTo(cart);
		$('<div class="cart-inp"><label>Имя:</label><input type="text" name="name" placeholder="Ваше имя" class="w-100"></div>').appendTo(cart);
		$('<div class="cart-inp"><label>Телефон:</label><input type="number" name="phone" placeholder="Номер телефона" pattern="[789][0-9]{10}" class="w-100" required></div>').appendTo(cart);
		$('<div class="cart-inp"><label>Количество персон:</label><select type="number" name="people_amount" placeholder="Количество персон" class="w-100" required><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option></select></div>').appendTo(cart);
		// Доставка
		var pointsBox = $('<div class="cart-inp"></div>');
			$('<label>Получение заказа:</label>').appendTo(pointsBox);
			$('<label class="select-label"><input type="radio" name="affiliate" value="3" checked>Доставка по указанному адресу</label>').appendTo(pointsBox);
			$('<label class="select-label"><input type="radio" name="affiliate" value="2">Казань, Оренбургский тракт, 8в (самовывоз)</label>').appendTo(pointsBox);
			// $('<label class="select-label"><input type="radio" name="affiliate" value="1">Казань, Оренбургский тракт, 8в (в заведении)</label>').appendTo(pointsBox);
		pointsBox.appendTo(cart);
	
		$('<div class="cart-inp adress-data">'+
				'<label>Адрес:</label>'+
				'<div class="chapter-box">'+
					'<div class="chapter-cell"><input type="text" name="street" placeholder="Улица" required></div>'+
				'</div>'+
			'</div>').appendTo(cart);
		$('<div class="cart-inp adress-data">'+
				'<div class="chapter-box">'+
					'<div class="chapter-cell"><input type="text" name="home" placeholder="Дом" required></div>'+
					'<div class="chapter-cell"><input type="text" name="apart" placeholder="Квартира"></div>'+
					'<div class="chapter-cell"><input type="text" name="pod" placeholder="Подъезд"></div>'+
					'<div class="chapter-cell"><input type="text" name="et" placeholder="Этаж"></div>'+
				'</div>'+
			'</div>').appendTo(cart);
	
		var deliveryInfo = $('<div class="delivery-info quote adress-data">Выберете улицу из списка и здесь появятся условия доставки для вас</div>');
		deliveryInfo.appendTo(cart);
	
	
		// $('<div class="cart-inp adress-time"><label>Время самовывоза:</label><br><input type="text" name="order_adress_time" placeholder="Во сколько планируете забрать" class="w-100" required></div>').appendTo(cart);
		var selectWrapper = $('<div class="cart-inp adress-time">');
		$('<label>Время самовывоза:</label>').appendTo(selectWrapper);
		var selectTime	= $('<select name="order_adress_time">');
			var date = new Date();
			var curHours = date.getHours();
			var curMinutes = date.getMinutes();
			// console.log(curHours, curMinutes);
			var beginHours = curHours+1;
			for(var i=beginHours; i<22; i++){
				if(i>curHours+1 || curMinutes<30){
					if(i>=curHours+2){
						$('<option value="'+i+':00">'+i+':00</option>').appendTo(selectTime);
						// console.log(i+':00');
					}
					$('<option value="'+i+':30">'+i+':30</option>').appendTo(selectTime);
					// console.log(i+':30');
				}
			}
		selectTime.appendTo(selectWrapper);
		selectWrapper.appendTo(cart);
	
		// // Стоимость доставки
		// $('<div class="text"><label>Стоимость доставки:</label>'+
		// 	'<ul>'+
		// 		'<li>с. Высокая гора - доставка от 500р. </li>'+
		// 		'<li>пос. Дербышки - доставка от 500р. </li>'+
		// 	// '</ul>'+
		// 	// '<label>Минимальная сумма заказа:</label> <br>'+
		// 	// '<ul>'+
		// 		'<li>По Казани до 5 км - от 800 р.</li>'+
		// 		'<li>До 10 км - от 1000р. </li>'+
		// 		'<li>До 15 км - от 1200р. </li>'+
		// 		'<li>До 20 км - от 1500р. </li>'+
		// 		'<li>До 25 км - от 2000р.</li>'+
		// 	'</ul>'+
		// 	'<p>* подробности уточняйте у оператора</p></div>').appendTo(cart);
	
		// Тип оплаты
		var payType = $('<div class="cart-inp"></div>');
			$('<label>Тип оплаты:</label>').appendTo(payType);
			$('<label class="select-label"><input type="radio" name="pay" value="1" checked>Наличными</label>').appendTo(payType);
			$('<label class="select-label"><input type="radio" name="pay" value="2">Безналичными</label>').appendTo(payType);
		payType.appendTo(cart);
	
		// Промо-код
		$('<div class="cart-inp"><label>Промо-код:</label><input type="text" name="promo" placeholder="Промо-код" class="w-100 promocode_handler"></div>').appendTo(cart);
	
		
	
		// Комментарий к заказу
		$('<div class="cart-inp"><label>Комментарий к заказу:</label><textarea type="text" name="descr" placeholder="Комментарий..." class="w-100"></textarea></div>').appendTo(cart);
		
		// Сумма заказа
		$('<div class="cart-col"><div class="col-price count-price cart-sum big"></div></div>').appendTo(cart);
		$('<input class="count_summ" type="hidden" name="budget">').appendTo(cart);
	
		// Кнопка заказать
		$('<div class="cart-inp"><input type="submit" name="submit_order" value="Заказать" class="w-100"></div>').appendTo(cart);
	
		// Акция фото в соц. сетях
		$('<div class="quote">Не распространяется на сеты и не суммируются с другими акциями. Подробности уточняйте у оператора</div>')
		.appendTo(cart);
	
		cart.appendTo(div);
	
		div.popup({class: 'popup-order'});
		funcUpdateCart();
		$('.popup-box .cart-elem-delete').click(function(){
			var index = parseInt($(this).closest('.cart-col').attr('cart-id'));
			delete $.cart[index];
			$(this).closest('.cart-col').remove();
			var cart_count=0; $.cart.forEach(function(row){  if(row) cart_count++;  });
			if(cart_count==0){
				$.cart = [];
				$('.popup-box .popup-close').trigger('click');
			}
			funcUpdateCart();
		});
		$('.popup-box .col-count input[type="number"]').on('change',function(){
			var count = $(this).val();
			if(count<0){
				count = 0;
				$(this).val(0);
			}
			var index = parseInt($(this).closest('.cart-col').attr('cart-id'));
			var priceDiv = $(this).closest('.cart-col').find('[price-one]');
			var priceOne = parseInt(priceDiv.attr('price-one'));
			priceDiv.html(priceOne*count+'р.');
			$.cart[index].c = parseInt(count);
			funcUpdateCart();
		});
		$('.adress-time').hide();
		$('.popup-box input[name="affiliate"]').on('change',function(){
			var index = $(this).closest('.select-label').index();
			if(index==1){
				$('.adress-data').show(300);
				$('.adress-time').hide(300);
				$('.adress-data').find('input').attr('required','true');
				$('.adress-time').find('input').attr('required',null);
			} else {
				$('.adress-data').hide(300);
				$('.adress-time').show(300);
				$('.adress-data').find('input').attr('required',null);
				$('.adress-time').find('input').attr('required','true');
			}
		});
	
		$('.promocode_handler').change(checkCart)
		$('.count').change(checkCart)

		function checkCart() {

			let countPrice = $('.count_summ').val()

			promocodes.find((el) => {
	
				let finalSum = Math.round(countPrice - (countPrice * el.discount / 100))

				if (el.name === $('.promocode_handler').val()) {
					$('.count-price').html(`Итого: ${finalSum}р.`)
				}
			});

		}


		
		inputsInit();
	});
	
	
	
	// ==================================================
	// === CART ADD === */
	// ==================================================
	
	var funcClickCartPopupAdd = function(){
		$('.cart-popup-add').click(function(){
			var box = $(this).closest('.popup-box');
			// box.find('[cart-select]').each(function(){
			// 	var key = $(this).attr('cart-select');
			// 	var val = $(this).val() || undefined;
			// 	// var value = '';// $(this).find(':selected, :checked').closest('option, label').text();
			// 	var value = $(this).find(':checked').closest('.inline').find('span').text();
			// 	if(!value) $(this).find(':selected, :checked').each(function(){
			// 		value += $(this).closest('option, label').text()+'\n';
			// 	});
			// 	console.log('['+key+']['+val+'] '+value);
			// });
			var addons = [];
			box.find('[cart-check]').each(function(){
				var key = $(this).attr('cart-check');
				var val = $(this).val() || undefined;
				var b = $(this).find(':checked').closest('.inline');
				// var value = b.find('span').text();
				$(this).find(':selected, :checked').each(function(){
					var e = $(this).closest('.select-variants').find('[dish-id]');
					var value = $(this).closest('option, label').text();
					val = $(this).closest('.label-box').attr('value');
					if(value) 
						addons.push({
							'd': value.split(' / ')[0],
							'i': e.attr('dish-id'),
							'f': e.attr('variant-fid'),
						});
					// TODO: cart.push({}); // Для интеграции нужно добавлять как отдельные блюда
				});
				// console.log('['+key+']['+val+'] '+value);
			});
			$.cart.push({
				'f': box.find('[dish-fid]:first').attr('dish-fid'),
				'v': box.find('.dish-variants').find('[type="radio"]:checked').attr('variant-fid') || 0,
				'i': $('.popup-box  img:first').attr('src'),
				'n': box.find('.product-name').text(),
				// 'd': box.find('.product-desc').text(),
				'a': addons,
				'p': parseInt(box.find('.product-price').text()),
				'c': 1,
				// TODO: Вариант тоже передать, чтобы понимать размеры пиццы в корзине
			});
			// console.log($.cart);
			// console.log('--------------');
			funcUpdateCart();
			$('.popup-box .popup-close').trigger('click');
		});
		ym(79488682, 'reachGoal', 'addCart');
	}; funcClickCartPopupAdd();
	
	
	var funcClickCartLightAdd = function(){
		$('.cart-light-add').click(function(){
			var box = $(this).closest('.dish-box');
			var addons = [];
			// TODO: Проверка на существования такогоже простого блюда без описания и увеличение его кол-ва
			$.cart.push({
				'f': box.attr('dish-fid'),
				'v': 0,
				'i': box.find('.photo').attr('content'),
				'n': box.find('.name').text(),
				// 'd': box.find('.dish-desc').text() || '',
				'a': addons,
				'p': parseInt(box.find('.dish-price').text()),
				'c': 1,
			});
			funcUpdateCart();
			$('.btn-cart').css({
				'transform': 'scale(1.5) rotate(2deg)',
			});
			setTimeout(function(){
				$('.btn-cart').css({
					'transform': 'none',
				});
			},500);
		});
		ym(79488682, 'reachGoal', 'addCart');
	}; funcClickCartLightAdd();
	
	
	// // ==================================================
	// // === VARIANTS DISH === */
	// // ==================================================
	// $('.chapter-add').click(function(){
	// 	var elem = $(this);
	// 	var i = parseInt(elem.attr('variant'));
	// 	if(i<3){
	// 		elem.attr('variant',++i);
	// 		elem.before('<div class="chapter-box dashed">'+
	// 			'<div class="chapter-weight chapter-cell">'+
	// 				'<label>Артикул api:</label>'+
	// 				'<input type="number" name="variant_fid_'+i+'" value="" placeholder="Api ID">'+
	// 			'</div>'+
	// 			'<div class="chapter-weight chapter-cell">'+
	// 				'<label>Вес:</label>'+
	// 				'<input type="number" name="variant_weight_'+i+'" value="" placeholder="Вес, гр.">'+
	// 			'</div>'+
	// 			'<div class="chapter-diameter chapter-cell">'+
	// 				'<label>Диаметр:</label>'+
	// 				'<input type="number" name="variant_diameter_'+i+'" value="" placeholder="Диаметр, см.">'+
	// 			'</div>'+
	// 			'<div class="chapter-price chapter-cell">'+
	// 				'<label>Цена:</label>'+
	// 				'<input type="number" name="variant_price_'+i+'" value="" placeholder="Цена, руб.">'+
	// 			'</div>'+
	// 		'</div>');
	// 		if(i==3)
	// 			elem.remove();
	// 	}
	// });
	
	
	
	// ==================================================
	// === MENU === */
	// ==================================================
	$('.btn-menu').click(function(){
		$('.menu-mob').toggleClass('hide');
	});
	// $('.menu a').click(function(){
	// 	$('.btn-menu').trigger('click');
	// });
	
	
	
	})(jQuery);

	document.querySelector('.categories__button').addEventListener('click', () => {
		document.querySelector('.caterogies').classList.toggle('categories--active')
		console.log('asdsad')
	})
