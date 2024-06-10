<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arCurrentValues */
/** @global CUserTypeManager $USER_FIELD_MANAGER */
/** @var array $arIBlockProperty */

if(!\Bitrix\Main\Loader::includeModule("iblock"))
	return;

$arIBlockType = CIBlockParameters::GetIBlockTypes();

$arIBlock = array();
$rsIBlock = CIBlock::GetList(array("sort" => "asc"), array("TYPE" => $arCurrentValues["IBLOCK_TYPE"], "ACTIVE"=>"Y"));
while($arr=$rsIBlock->Fetch())
	$arIBlock[$arr["ID"]] = "[".$arr["ID"]."] ".$arr["NAME"];

$arComponentParameters = array(
	"GROUPS" => array(
		"CREDIT_SETTINGS" => array(
			"SORT" => 110,
			"NAME" => "Настройки периодов погашения",
		),
	),
	"PARAMETERS" => array(
		"IBLOCK_TYPE" => array(
			"NAME" => "Тип инфоблока для веб-форм АСПРО",
			"TYPE" => "LIST",
			"VALUES" => $arIBlockType,
			"REFRESH" => "Y",
		),
		"IBLOCK_ID" => array(
			"NAME" => "Веб-форма АСПРО для оформления займа (кредита)",
			"TYPE" => "LIST",
			"ADDITIONAL_VALUES" => "Y",
			"VALUES" => $arIBlock,
			"REFRESH" => "Y",
		),
		"AMOUNT_MIN" => array(
			"PARENT" => "BASE",
			"NAME" => "Минимальная сумма кредита (в рублях)",
			"TYPE" => "STRING",
			"DEFAULT" => "1000",
		),
		"AMOUNT_MAX" => array(
			"PARENT" => "BASE",
			"NAME" => "Максимальная сумма кредита (в рублях)",
			"TYPE" => "STRING",
			"DEFAULT" => "30000",
		),
		"AMOUNT_STEP" => array(
			"PARENT" => "BASE",
			"NAME" => "Шаг ползунка суммы (в рублях)",
			"TYPE" => "STRING",
			"DEFAULT" => "1000",
		),
		"AMOUNT_DEFAULT" => array(
			"PARENT" => "BASE",
			"NAME" => "Исходное значение суммы (в рублях)",
			"TYPE" => "STRING",
			"DEFAULT" => "5000",
		),
		"BUTTON_TITLE" => array(
			"NAME" => "Надпись на кнопке оформления кредита",
			"TYPE" => "STRING",
		),
		"SHOW_BUTTON" => array(
			"NAME" => "Показывать кнопку оформления кредита",
			"TYPE" => "CHECKBOX",
		),
		"USE_FORMSTYLER" => array(
			"NAME" => "Использовать расширенную стилизацию элментов управления",
			"TYPE" => "CHECKBOX",
		),
		"SHOW_DATE_PAY" => array(
			"NAME" => "Выводить дату погашения",
			"TYPE" => "CHECKBOX",
		),
		"USE_INPUT_AMOUNT" => array(
			"PARENT" => "BASE",
			"NAME" => "Использовать ввод суммы",
			"TYPE" => "LIST",
			"VALUES" => array(
				"N" => "не использовать",
				"S" => "с помощью поля ввода",
				"L" => "с помощью выпадающего списка",
			),
			"DEFAULT" => "N",
		),
		"SHOW_PERIOD_LIST" => array(
			"PARENT" => "BASE",
			"NAME" => "Показывать список сроков погашения",
			"TYPE" => "CHECKBOX",
		),
		"PERIOD_TYPE" => array(
			"PARENT" => "CREDIT_SETTINGS",
			"NAME" => "Расчёт кредита вести в",
			"TYPE" => "LIST",
			"VALUES" => array(
				"D" => "днях",
				"M" => "месяцах",
				"F" => "использовать оба варианта",
			),
			"REFRESH" => "Y",
			"DEFAULT" => "M",
		),
		"PERIOD_DEFAULT" => array(
			"PARENT" => "CREDIT_SETTINGS",
			"NAME" => "Исходное значение срока (по умолчанию - в днях, если не выбрано иное)",
			"TYPE" => "STRING",
			"DEFAULT" => "3",
		),
		"PERIOD_MIN" => array(
			"PARENT" => "CREDIT_SETTINGS",
			"NAME" => "Минимальный срок кредита (в месяцах)",
			"TYPE" => "STRING",
			"DEFAULT" => "1",
		),
		"PERIOD_MAX" => array(
			"PARENT" => "CREDIT_SETTINGS",
			"NAME" => "Максимальный срок кредита (в месяцах или в днях в зависимости от выбранного периода)",
			"TYPE" => "STRING",
			"DEFAULT" => "12",
		),
		"USE_CUSTOM_PERCENT" => array(
			"PARENT" => "CREDIT_SETTINGS",
			"NAME" => "Использовать таблицу процентов",
			"TYPE" => "CHECKBOX",
			"REFRESH" => "Y",
		),
		"CUSTOM_PERCENT" => array(
			"PARENT" => "CREDIT_SETTINGS",
			"NAME" => "Таблица процентов (годовое значение;отображаемое;подсказка)",
			"TYPE" => "STRING",
			"MULTIPLE" => "Y",
		),
		"PERCENT_DAY" => array(
			"PARENT" => "CREDIT_SETTINGS",
			"NAME" => "Годовой процент % по умолчанию (используется для расчёта в днях)",
			"TYPE" => "STRING",
			"DEFAULT" => "300",
		),
		"PERCENT_MONTH" => array(
			"PARENT" => "CREDIT_SETTINGS",
			"NAME" => "Годовой процент % по умолчанию (используется для расчёта в месяцах)",
			"TYPE" => "STRING",
			"DEFAULT" => "30",
		),
	),
);

// Этот хитрый ход поможет исключить ненужные поля в зависимости от значения в списке
if($arCurrentValues["PERIOD_TYPE"] == "M") {
	unset($arComponentParameters["PARAMETERS"]["PERCENT_DAY"]);
}
if($arCurrentValues["PERIOD_TYPE"] == "D") {
	unset($arComponentParameters["PARAMETERS"]["PERCENT_MONTH"]);
}
if(!isset($arCurrentValues["USE_CUSTOM_PERCENT"]) || $arCurrentValues["USE_CUSTOM_PERCENT"] == "N") {
	unset($arComponentParameters["PARAMETERS"]["CUSTOM_PERCENT"]);
}
if($arCurrentValues["USE_CUSTOM_PERCENT"] == "Y") {
	unset($arComponentParameters["PARAMETERS"]["PERCENT_DAY"]);
	unset($arComponentParameters["PARAMETERS"]["PERCENT_MONTH"]);
}
