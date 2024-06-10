<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?\Bitrix\Main\Loader::includeModule('iblock');

// Найдем дни, месяца и годы
for($i=1; $i<=31; $i++){
	$arResult["DAYS"][] = $i;
}

for($i=1; $i<=12; $i++){
	$arResult["MONTHS"][] = $i;
}

for($i=1920; $i<date("Y"); $i++){
	$arResult["YEARS"][] = $i;
}

// Запрос на пользовательские поля типа список
$rsGender = CUserTypeEntity::GetList(array(), array(
	"USER_TYPE_ID" => "enumeration"
));
while($arGender = $rsGender->Fetch())
	$arrFields[$arGender["ID"]] = $arGender["FIELD_NAME"];
foreach($arrFields as $key => $value) {
	$rsGender = CUserFieldEnum::GetList(array(), array(
		"USER_FIELD_ID" => $key,
	));
	while($arGender = $rsGender->Fetch()) {
		$arResult["FIELDS"][$arrFields[$arGender["USER_FIELD_ID"]]][$arGender["VALUE"]] = $arGender["ID"];
	}
}

if($secID = $_SESSION["SESS_AUTH"]["SZ_BONUS_CARD_SECTION"]) { // Режим редактирования данных привязанной карты
	$arBlock = getIblockIDbyCode("aspro_mshop_bonuses");
	$objSection = new CIBlockSection;
	$arSection = $objSection->GetList(
		array(),
		array("IBLOCK_ID" => $arBlock["aspro_mshop_bonuses"]["ID"], "UF_CARD_NUMBER" => $_SESSION["SESS_AUTH"]["SZ_BONUS_CARD"]),
		false,
		array("UF_*"))->Fetch();
	$arResult["DATA"]["NAME"] = $arSection["NAME"];
	$arResult["DATA"]["CARD_NUMBER"] = $arSection["UF_CARD_NUMBER"];
	$arResult["DATA"]["UF_PHONE"] = $arSection["UF_PHONE"];
	$arResult["DATA"]["UF_EMAIL"] = $arSection["UF_EMAIL"];
	$arResult["DATA"]["ACCOUNT_VALUE"] = floor($_SESSION["SESS_AUTH"]["SZ_ACCOUNT_VALUE"]);
	$arResult["DATA"]["UF_NEW_DATE_LAST"] = $arSection["UF_NEW_DATE_LAST"];
	$arResult["DATA"]["UF_CODEWORD"] = $arSection["UF_CODEWORD"];
	$arResult["DATA"]["UF_OTHER_HOBBY"] = $arSection["UF_OTHER_HOBBY"];
	$arResult["DATA"]["BIRTHDAY"] = explode(".", $arSection["UF_BIRTHDAY"]);
	$arResult["DATA"]["UF_GENDER"] = $arSection["UF_GENDER"];
	$arResult["DATA"]["UF_VK"] = $arSection["UF_VK"];
	$arResult["DATA"]["UF_FB"] = $arSection["UF_FB"];
	$arResult["DATA"]["UF_OK"] = $arSection["UF_OK"];
	$arResult["DATA"]["UF_OTHER_SOCIAL"] = $arSection["UF_OTHER_SOCIAL"];
	$arResult["DATA"]["UF_HUNTING"] = $arSection["UF_HUNTING"];
	$arResult["DATA"]["UF_FISHING"] = $arSection["UF_FISHING"];
	$arResult["DATA"]["UF_TRAVEL"] = $arSection["UF_TRAVEL"];
	$arResult["DATA"]["UF_COLLECTING"] = $arSection["UF_COLLECTING"];
	$arResult["DATA"]["UF_NEEDLEWORK"] = $arSection["UF_NEEDLEWORK"];
	$arResult["DATA"]["UF_COOKERY"] = $arSection["UF_COOKERY"];
	$arResult["DATA"]["UF_SPORT"] = $arSection["UF_SPORT"];
	$arResult["DATA"]["UF_BEEKEEPING"] = $arSection["UF_BEEKEEPING"];
	$arResult["DATA"]["UF_SUBSCRIBE"] = $arSection["UF_SUBSCRIBE"];
}
$this->IncludeComponentTemplate();?>