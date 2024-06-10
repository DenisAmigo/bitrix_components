<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
\Bitrix\Main\Loader::includeModule('iblock');
$objSection = new CIBlockSection();

switch ($_REQUEST["METHOD"]) {
	case "GET_BALANCE":
		if($_REQUEST["CARD_NUMBER"]) {
			$arBlock = getIblockIDbyCode("aspro_mshop_bonuses");
			$arSection = $objSection->GetList(
				array("SORT" => "ASC"),
				array("IBLOCK_ID" => $arBlock["aspro_mshop_bonuses"]["ID"], "UF_CARD_NUMBER" => $_REQUEST["CARD_NUMBER"], "UF_BIRTHDAY" => $_REQUEST["DATE_BIRTH"]),
				false,
				array("XML_ID", "ID", "NAME", "UF_CARD_NUMBER", "UF_SUM", "UF_CARD_NEW_NUMBER")
			)->Fetch();
			if($arSection) {
				$text = '<h4>Бонусы старой бонусной программы</h4><div class="info">';
				$text .= '<div><span>Бонусных рублей</span><span>'.$arSection["UF_SUM"].'</span></div>';
				$text .= '<div><span>Бонусные рубли действительны до</span><span>'.$arParams["VALID_DATE_OLD"].'</span></div>';
				$text .= '<div><span>Владелец карты</span><span>'.$arSection["NAME"].'</span></div>';
				$text .= '<p>Вы можете использовать бонусы СТАРОЙ ПРОГРАММЫ только в розничных магазинах в размере 5% от цены</p></div>';
				$text .= '<a class="button big_btn bold type_block">Вступить в новую программу «СОЮЗНИК»</a>';
				echo $text;
			} else {
				$text = '<font color="#FF0000">Бонусная карта не найдена.</font>';
				echo $text;
			}
		}
		break;
	case "GET_SMS_CODE":
		if($_REQUEST["PHONE_NUMBER"]) {
			if(CModule::IncludeModule("imaginweb.sms")) {
				$sms = new CIWebSMS;
				$phone = $_REQUEST["PHONE_NUMBER"];
				$rand = rand(1000, 9999);
				$_SESSION["CODE_ACTIVATION"] = $rand;
				$text = "Ваш код активации: ".$rand;
				$sms->Send($phone, $text);
				echo $rand;
			}
		}
		break;
	case "CHECK_SMS_CODE":
		if($_REQUEST["SMS_CODE"] == $_SESSION["CODE_ACTIVATION"])
			$text = '<font color="#00FF00">Активация пройдена.</font>'; else $text = '<font color="#FF0000">Активация не пройдена.</font>';
		unset($_SESSION["CODE_ACTIVATION"]);
		echo $text;
		break;
}