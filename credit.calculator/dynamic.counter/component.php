<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
global $DB;
/** @global CUser $USER */
global $USER;
/** @global CMain $APPLICATION */
global $APPLICATION;

// Подготовка данных
// ИБ-справочник для "срок+процент"
$arParams["IBLOCK_TYPE"] = trim($arParams["IBLOCK_TYPE"]);
$arParams["IBLOCK_ID"] = intval($arParams["IBLOCK_ID"]);
$arResult["CALCULATOR"]["AMOUNT"]["MIN"] = $arParams["AMOUNT_MIN"] ? intval($arParams["AMOUNT_MIN"]) : 1000;  
$arResult["CALCULATOR"]["AMOUNT"]["DEFAULT"] = $arParams["AMOUNT_DEFAULT"] ? intval($arParams["AMOUNT_DEFAULT"]) : 5000;
$arResult["CALCULATOR"]["AMOUNT"]["MAX"] = $arParams["AMOUNT_MAX"] ? intval($arParams["AMOUNT_MAX"]) : 30000;
$arResult["CALCULATOR"]["AMOUNT"]["STEP"] = $arParams["AMOUNT_STEP"] ? intval($arParams["AMOUNT_STEP"]) : 1000;
// Готовим карту периодов (месяцы)
$arResult["CALCULATOR"]["PERIOD"]["MONTH"]["MIN"] = $arParams["PERIOD_MIN"] ? intval($arParams["PERIOD_MIN"]) : 1; 
$arResult["CALCULATOR"]["PERIOD"]["MONTH"]["MAX"] = $arParams["PERIOD_MAX"] ? intval($arParams["PERIOD_MAX"]) : 12;
// Готовим карту периодов (дни)
$arResult["CALCULATOR"]["PERIOD"]["DAY"]["MIN"] = $arParams["PERIOD_MIN"] ? intval($arParams["PERIOD_MIN"]) : 1;
$arResult["CALCULATOR"]["PERIOD"]["DAY"]["MAX"] = $arParams["PERIOD_TYPE"] == "F" ? $arParams["PERIOD_MAX"]*30 : $arParams["PERIOD_MAX"];
//
$arResult["CALCULATOR"]["PERIOD"]["DEFAULT"] = $arParams["PERIOD_DEFAULT"] ? intval($arParams["PERIOD_DEFAULT"]) : 3;
if($arParams["USE_CUSTOM_PERCENT"] == "Y") {
	foreach($arParams["CUSTOM_PERCENT"] as $str) {
		$array = explode(";", $str);
		$array = array("VALUE" => $array[0], "TEXT" => $array[1], "HINT" => $array[2]);
		$arResult["CALCULATOR"]["PERCENT"]["MAP"][] = $array;
	}
	$arResult["CALCULATOR"]["PERCENT"]["DEFAULT"] = $arResult["CALCULATOR"]["PERCENT"]["MAP"][0]["VALUE"];
	$arResult["CALCULATOR"]["PERCENT"]["MONTH"] = $arResult["CALCULATOR"]["PERCENT"]["DEFAULT"];
	$arResult["CALCULATOR"]["PERCENT"]["DAY"] = $arResult["CALCULATOR"]["PERCENT"]["DEFAULT"];
} else {
	$arResult["CALCULATOR"]["PERCENT"]["MONTH"] = $arParams["PERCENT_MONTH"] ? floatval($arParams["PERCENT_MONTH"]) : 30;
	$arResult["CALCULATOR"]["PERCENT"]["DAY"] = $arParams["PERCENT_DAY"] ? floatval($arParams["PERCENT_DAY"]) : 300;
}
// Подсчитаем изначальный коэффициент
$arResult["CALCULATOR"]["COEFF"] = $arParams["PERIOD_TYPE"] == "M" ? 12 : 365;
// Получим дефолтный процент
$arResult["CALCULATOR"]["PERCENT"]["DEFAULT"] = !$arResult["CALCULATOR"]["PERCENT"]["DEFAULT"] ? ($arParams["PERIOD_TYPE"] == "M" ? $arResult["CALCULATOR"]["PERCENT"]["MONTH"] : $arResult["CALCULATOR"]["PERCENT"]["DAY"]) : $arResult["CALCULATOR"]["PERCENT"]["DEFAULT"];
// Получим единицу измерения периода (вывод на экран)
$arResult["CALCULATOR"]["PERIOD"]["TEXT"] = $arParams["PERIOD_TYPE"] == "M" ? getWord($arResult["CALCULATOR"]["PERIOD"]["DEFAULT"], "месяц", "месяца", "месяцев") : getWord($arResult["CALCULATOR"]["PERIOD"]["DEFAULT"], "день", "дня", "дней");
// Вычислим первоначально сумму по дефолтным данным
$arResult["CALCULATOR"]["TOTAL"] = round($arResult["CALCULATOR"]["AMOUNT"]["DEFAULT"] * ($arResult["CALCULATOR"]["PERCENT"]["DEFAULT"] / ($arResult["CALCULATOR"]["COEFF"] * 100) + $arResult["CALCULATOR"]["PERCENT"]["DEFAULT"] / ($arResult["CALCULATOR"]["COEFF"] * 100) / (pow(1 + $arResult["CALCULATOR"]["PERCENT"]["DEFAULT"] / ($arResult["CALCULATOR"]["COEFF"] * 100), $arResult["CALCULATOR"]["PERIOD"]["DEFAULT"])-1)));
$arResult["CALCULATOR"]["TOTAL"] *= $arResult["CALCULATOR"]["PERIOD"]["DEFAULT"];
// Вычислим дату погашения
$arResult["CALCULATOR"]["DATE"] = date('d.m.Y', $arParams["PERIOD_TYPE"] == "M" ? addDayMonth(0, $arResult["CALCULATOR"]["PERIOD"]["DEFAULT"]) : addDayMonth($arResult["CALCULATOR"]["PERIOD"]["DEFAULT"], 0));

// Составим список сумм
if($arParams["USE_INPUT_AMOUNT"] == "L") {
	$i=$arResult["CALCULATOR"]["AMOUNT"]["MIN"];
	while($i<=$arResult["CALCULATOR"]["AMOUNT"]["MAX"]){
		$arResult["CALCULATOR"]["AMOUNT_LIST"][$i] = $i." рублей";
		$i+=$arResult["CALCULATOR"]["AMOUNT"]["STEP"];
	}
}
// Составим список периодов погашения
if($arParams["SHOW_PERIOD_LIST"] == "Y") {
	$i = $arParams["PERIOD_TYPE"] == "M" ? $arResult["CALCULATOR"]["PERIOD"]["MONTH"]["MIN"] : $arResult["CALCULATOR"]["PERIOD"]["DAY"]["MIN"];
	$periodMax = $arParams["PERIOD_TYPE"] == "M" ? $arResult["CALCULATOR"]["PERIOD"]["MONTH"]["MAX"] : $arResult["CALCULATOR"]["PERIOD"]["DAY"]["MAX"];
	while($i<=$periodMax){
		$str = $arParams["PERIOD_TYPE"] == "M" ? getWord($i, "месяц", "месяца", "месяцев") : getWord($i, "день", "дня", "дней");
		$arResult["CALCULATOR"]["PERIOD_LIST"][$i] = $i." ".$str;
		$i++;
	}
}

$this->IncludeComponentTemplate();
