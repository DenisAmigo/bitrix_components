<?
/* Инструкция для верстальщика
Ни в коем случае не удалять/изменять следующие id элементов (на них завязан js-функционал):
- range-slider-amount
- range-slider-period
- amount_val (вывод текущей суммы)
- amount_input (ввод/список сумм)
- period_val (вывод текущего периода)
- period_input (список с периодами)
- period_text (вывод фразы периода)
- total_val (вывод расчета)
- date_val (вывод даты погашения)
- period_check (радиогруппа-переключатели)
- percent_check (радиогруппа-переключатели)
Не удалять data-event="jqm" и data-param-id - завязка на аспро-форму

Класс tabs-period завязан на верстку, а вот label с классом active используется в скриптах в качестве дополнительного признака стилизации. Чтобы это работало, не стоит лейблы вытаскивать из родителя.
Класс calculator не удалять (отвалится formstyler), но можно комбинировать
Верстать элементы ползунка можно по генерируемым классам (найти самому по F12), но в шаблонном файле стиля (style.css)
Остальные элементы верстаются по своим классам (где пусто - дописываются по желанию), при необходимости оборачиваются во что-то еще на свой вкус
*/
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery-ui.min.js");
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/jquery-ui/jquery-ui.min.css');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/jquery.formstyler.js');
$APPLICATION->SetadditionalCSS(SITE_TEMPLATE_PATH . '/css/jquery.formstyler.css');
$APPLICATION->SetadditionalCSS(SITE_TEMPLATE_PATH . '/css/jquery.formstyler.theme.css');
$uID = "bx_".rand(100000, 999999);
?>
<div class="calculator" id="<?=$uID?>">
	<!--Переключатель типов периода, если установлен полный режим отображения-->
	<? if($arParams["PERIOD_TYPE"] == "F") {?>
		<form class="col-md-12 tabs-period">
			<label class="active"><input type="radio" checked="checked" name="period_check" value="D"> Дни</label>
			<label><input type="radio" name="period_check" value="M"> Месяцы</label>
		</form>
	<?}?>
	<!--Сумма кредита-->
	<div class="col-md-3">
		<div class="header">Выберите сумму</div>
		<span id="amount_val" class="param"><?=number_format($arResult["CALCULATOR"]["AMOUNT"]["DEFAULT"], 0, '.', ' ')?></span> <span class="">рублей</span>
		<div id="range-slider-amount"></div>
		<? if($arParams["USE_INPUT_AMOUNT"] == "S") {?>
			<br/>
			<input type="text" id="amount_input" <?=($arParams["USE_FORMSTYLER"] == "Y") ? "class='styler'" : ""?> value="<?=$arResult["CALCULATOR"]["AMOUNT"]["DEFAULT"]?>"/> <span>рублей</span>
		<?}?>
		<? if($arParams["USE_INPUT_AMOUNT"] == "L") {?>
			<br/>
			<select id="amount_input">
				<? foreach($arResult["CALCULATOR"]["AMOUNT_LIST"] as $sum=>$value){?>
				<option value="<?=$sum?>"<?=($sum == $arResult["CALCULATOR"]["AMOUNT"]["DEFAULT"]) ? " selected" : ""?>><?=number_format($value, 0, '.', ' ')." рублей"?></option>
				<?}?>
			</select>
		<?}?>
	</div>
	<!--Срок-->
	<div class="col-md-3">
		<div class="header">Выберите срок</div>
		<span id="period_val" class="param"><?=$arResult["CALCULATOR"]["PERIOD"]["DEFAULT"]?></span> <span id="period_text" class=""><?=$arResult["CALCULATOR"]["PERIOD"]["TEXT"]?></span>
		<div id="range-slider-period"></div>
		<? if($arParams["SHOW_PERIOD_LIST"] == "Y") {?>
			<br/>
			<select id="period_input">
				<? foreach($arResult["CALCULATOR"]["PERIOD_LIST"] as $period=>$value){?>
				<option value="<?=$period?>"<?=($period == $arResult["CALCULATOR"]["PERIOD"]["DEFAULT"]) ? " selected" : ""?>><?=$value?></option>
				<?}?>
			</select>
		<?}?>
	</div>
	<!--Инфо для итога-->
	<div class="col-md-3">
		<div class="header">Сумма к возврату</div>
		<span id="total_val" class="param"><?=number_format($arResult["CALCULATOR"]["TOTAL"], 0, '.', ' ')?></span> <span class="">руб.</span>
		<? if($arParams["SHOW_DATE_PAY"] == "Y") {?>
			<div class="header">Дата погашения</div>
			<span id="date_val" class="param"><?=$arResult["CALCULATOR"]["DATE"]?></span>
		<?}?>
	</div>

	<!--Зона вывода кнопки заказа-->
	<? if($arParams["SHOW_BUTTON"] == "Y"){?>
		<div class="col-md-3">
			<span data-event="jqm" data-param-id="<?=$arParams["IBLOCK_ID"]?>" data-name="buy">
				<button class="btn btn-primary"><span><?=$arParams["BUTTON_TITLE"]?></span></button>
			</span>
		</div>
	<?}?>

	<!--Зона вывода радиопереключателей-->
	<? if($arParams["USE_CUSTOM_PERCENT"] == "Y"){?>
		<form class="col-md-12">
			<? foreach($arResult["CALCULATOR"]["PERCENT"]["MAP"] as $percent){?>
				<label<?=$arResult["CALCULATOR"]["PERCENT"]["DEFAULT"] == $percent["VALUE"] ? ' class="active"' : ''?> title="<?=$percent["HINT"]?>"><input type="radio"<?=$arResult["CALCULATOR"]["PERCENT"]["DEFAULT"] == $percent["VALUE"] ? ' checked="checked"' : ''?> name="percent_check" value="<?=$percent["VALUE"]?>"> <?=$percent["TEXT"]?></label>
			<?}?>
		</form>
	<?}?>
</div>

<script>
	<? if($arParams["USE_FORMSTYLER"] == "Y"){?>
		$('.calculator select').styler();
	<?}?>
	$(function() {
		var minAmount = <?=$arResult["CALCULATOR"]["AMOUNT"]["MIN"]?>,
			maxAmount = <?=$arResult["CALCULATOR"]["AMOUNT"]["MAX"]?>,
			defAmount = <?=$arResult["CALCULATOR"]["AMOUNT"]["DEFAULT"]?>,
			stepAmount = <?=$arResult["CALCULATOR"]["AMOUNT"]["STEP"]?>,
			minPeriodMonth = <?=$arResult["CALCULATOR"]["PERIOD"]["MONTH"]["MIN"]?>,
			minPeriodDay = <?=$arResult["CALCULATOR"]["PERIOD"]["DAY"]["MIN"]?>,
			maxPeriodMonth = <?=$arResult["CALCULATOR"]["PERIOD"]["MONTH"]["MAX"]?>,
			maxPeriodDay = <?=$arResult["CALCULATOR"]["PERIOD"]["DAY"]["MAX"]?>,
			defPeriod = <?=$arResult["CALCULATOR"]["PERIOD"]["DEFAULT"]?>,
			percent = <?=$arResult["CALCULATOR"]["PERCENT"]["DEFAULT"]?>,
			percentMonth = <?=$arResult["CALCULATOR"]["PERCENT"]["MONTH"]?>,
			percentDay = <?=$arResult["CALCULATOR"]["PERCENT"]["DAY"]?>,
			coeff = <?=$arResult["CALCULATOR"]["COEFF"]?>,
			periodType = '<?=$arParams["PERIOD_TYPE"]?>',
			useInputAmount = '<?=$arParams["USE_INPUT_AMOUNT"]?>',
			useInputPeriod = '<?=$arParams["SHOW_PERIOD_LIST"]?>',
			uID = '#<?=$uID?>',
			objParent = $(uID);

		// ползунки ui
		var sliderAmount = objParent.find('#range-slider-amount'),
			sliderPeriod = objParent.find('#range-slider-period');

		sliderAmount.slider({
			range: 'min',
			min: minAmount,
			max: maxAmount,
			value: defAmount,
			step: stepAmount,
			animate: 'slow',
			slide: function (event, ui) {
				objParent.find('#amount_val').html(new Intl.NumberFormat().format(ui.value));
				objParent.find('#total_val').html(new Intl.NumberFormat().format(calcTotalSum(ui.value, sliderPeriod.slider('value'), percent, coeff)));
				if (useInputAmount != 'N')
					objParent.find('#amount_input').val(ui.value).trigger('refresh');
			},
			change: function (event, ui) {
				objParent.find('#amount_val').html(new Intl.NumberFormat().format(ui.value));
				objParent.find('#total_val').html(new Intl.NumberFormat().format(calcTotalSum(ui.value, sliderPeriod.slider('value'), percent, coeff)));
			}
		});

		sliderPeriod.slider({
			range: 'min',
			min: periodType == 'M' ? minPeriodMonth : minPeriodDay,
			max: periodType == 'M' ? maxPeriodMonth : maxPeriodDay,
			value: defPeriod,
			step: 1,
			animate: 'slow',
			slide: function (event, ui) {
				objParent.find('#period_val').html(ui.value);
				objParent.find('#total_val').html(new Intl.NumberFormat().format(calcTotalSum(sliderAmount.slider('value'), ui.value, percent, coeff)));
				objParent.find('#date_val').html(periodType == 'M' ? addDayMonth(0, ui.value) : addDayMonth(ui.value, 0));
				objParent.find('#period_text').html(periodType == 'M' ? getWord(ui.value, 'месяц', 'месяца', 'месяцев') : getWord(ui.value, 'день', 'дня', 'дней'));
				if (useInputPeriod == 'Y') {
					objParent.find('#period_input').val(ui.value).trigger('refresh');
				}
			},
			change: function (event, ui) {
				objParent.find('#period_val').html(ui.value);
				objParent.find('#total_val').html(new Intl.NumberFormat().format(calcTotalSum(sliderAmount.slider('value'), ui.value, percent, coeff)));
				objParent.find('#date_val').html(periodType == 'M' ? addDayMonth(0, ui.value) : addDayMonth(ui.value, 0));
				objParent.find('#period_text').html(periodType == 'M' ? getWord(ui.value, 'месяц', 'месяца', 'месяцев') : getWord(ui.value, 'день', 'дня', 'дней'));
			}
		});

		// реализация ручного ввода суммы/выбора из списка
		objParent.find('#amount_input').on("keyup change", function(){
			sliderAmount.slider('value', $(this).val());
		});

		// реализация выбора из списка срока
		objParent.find('#period_input').on("change", function(){
			sliderPeriod.slider('value', $(this).val());
		});

		// реализация смены типа периода погашения
		objParent.find('input[name=period_check]').on("change", function(){
			var type = $(this).val();
			$(this).parents().find('label').toggleClass('active');
			if (type == 'M') {
				periodType = 'M';
				coeff = 12;
				percent = percentMonth;
				reloadSelectBox(objParent.find('#period_input'), defPeriod, minPeriodMonth, maxPeriodMonth);
				sliderPeriod.slider({max: maxPeriodMonth, value: defPeriod});
			}
			if (type == 'D') {
				periodType = 'D';
				coeff = 356;
				percent = percentDay;
				reloadSelectBox(objParent.find('#period_input'), defPeriod, minPeriodDay, maxPeriodDay);
				sliderPeriod.slider({max: maxPeriodDay, value: defPeriod});
			}
		});

		// реализация смены процентов
		objParent.find('input[name=percent_check]').on("change", function(){
			var val = $(this).val();
			percent = val;
			percentMonth = val;
			percentDay = val;
			sliderAmount.slider('value', sliderAmount.slider('option', 'value'));
		});

		function reloadSelectBox(select, value, min, max) {
			select.empty();
			for (i = min; i <= max; i++) {
				var str = periodType == 'M' ? getWord(i, 'месяц', 'месяца', 'месяцев') : getWord(i, 'день', 'дня', 'дней');
				select.append($('<option value="' + i + '">' + i + ' ' + str + '</option>'));
			}
			select.val(value).trigger('refresh');
		}

		// мега-функция подсчета полной суммы кредита (ПСК)
		function calcTotalSum(amount, period, percent, coeff) {
			var total = amount * (percent / (coeff * 100) + percent / (coeff * 100) / (Math.pow(1 + percent / (coeff * 100), period) - 1)) * period;
			return total.toFixed();
		}

		// добавление одного или нескольких календарных дней/месяцев
		function addDayMonth(numd, numm) {
			var time = new Date(),
				d = time.getDate(),			// день
				m = time.getMonth() + 1,	// месяц
				y = time.getFullYear();		// год

			// Прибавить день(и)
			d += numd;
			while (d > 32 - new Date(y, m - 1, 32).getDate()) {
				d = d - (32 - new Date(y, m - 1, 32).getDate());
				m++;
			}

			// Прибавить месяц(ы)
			m += numm;

			if (m > 12) {
				y += Math.floor(m / 12);
				m = m % 12;
				// Дополнительная проверка на декабрь
				if (!m) {
					m = 12;
					y--;
				}
			}

			// Это последний день месяца?
			var t = 32 - new Date(y, m - 1, 32).getDate();
			if (d > t) {
				d = t;
			}

			// Дописываем нуль в начало
			if (String(d).length < 2)
				d = "0" + d;

			if (String(m).length < 2)
				m = "0" + m;

			// Вернуть новую дату
			return d + '.' + m + '.' + y;
		}

		// Склонение числительных
		function getWord(count, form1, form2, form3) {
			var count = Math.abs(count) % 100,
				lcount = count % 10;
			if (count >= 11 && count <= 19) return (form3);
			if (lcount >= 2 && lcount <= 4) return (form2);
			if (lcount == 1) return (form1);
			return form3;
		}
	});
</script>