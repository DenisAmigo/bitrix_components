<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Данные по бонусной карте");
if(!$USER->isAuthorized()){LocalRedirect(SITE_DIR.'auth');} else {
	$arBlock = getIblockIDbyCode("aspro_mshop_bonuses");
?>
<div class="left_block">
	 <?$APPLICATION->IncludeComponent(
		"bitrix:menu",
		"left_menu",
		array(
			"ALLOW_MULTI_SELECT" => "N",
			"CHILD_MENU_TYPE" => "left",
			"DELAY" => "N",
			"MAX_LEVEL" => "1",
			"MENU_CACHE_GET_VARS" => array(),
			"MENU_CACHE_TIME" => "3600",
			"MENU_CACHE_TYPE" => "A",
			"MENU_CACHE_USE_GROUPS" => "Y",
			"ROOT_MENU_TYPE" => "left",
			"USE_EXT" => "N"
		)
	);?>
	<?$APPLICATION->IncludeComponent(
		"csn:bonuses.user",
		"",
		array(
			"OLD_DATE_EXPIRED" => "22.09.2016"
		)
	);?>
</div>
<div class="right_block">
	<?$APPLICATION->IncludeComponent(
		"csn:bonuses.form",
		"",
		array()
	);?>
</div>
<?}?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>