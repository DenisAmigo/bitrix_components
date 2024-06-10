<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Счетчики");
?>

<div class="col-md-6">
<?$APPLICATION->IncludeComponent(
	"csn:dynamic.counter", 
	"dynamic.counter", 
	array(
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"FILE_PATH" => "/include/counters/",
		"FONT_STYLE_HEADER" => "18px;#000",
		"FONT_STYLE_UNIT" => "18px;#000",
		"FONT_STYLE_VALUE" => "21px;#f00",
		"HEADER_TEXT" => "Число займов за сегодня",
		"IDENTIFIER" => "zaym",
		"PERIOD" => "04:00;20",
		"TIME_STEP" => "60",
		"UNIT_TEXT" => "",
		"USE_AUTO_STEP" => "Y",
		"VALUES_FROM" => "1;3",
		"VALUES_STEP" => "32;78",
		"VALUES_TO" => "100;150",
		"COMPONENT_TEMPLATE" => "dynamic.counter",
		"RESULT_RATIO" => "N"
	),
	false
);?>
</div>
<div class="col-md-6">
<?$APPLICATION->IncludeComponent(
	"csn:dynamic.counter", 
	"dynamic.counter", 
	array(
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"FILE_PATH" => "/include/counters/",
		"FONT_STYLE_HEADER" => "18px;#000",
		"FONT_STYLE_UNIT" => "18px;#000",
		"FONT_STYLE_VALUE" => "21px;#f00",
		"HEADER_TEXT" => "Общая сумма займов за сегодня",
		"IDENTIFIER" => "summa",
		"PERIOD" => "04:00;20",
		"TIME_STEP" => "60",
		"UNIT_TEXT" => "руб.",
		"USE_AUTO_STEP" => "Y",
		"VALUES_FROM" => "1000;3000",
		"VALUES_STEP" => "32;78",
		"VALUES_TO" => "2400000;3000000",
		"COMPONENT_TEMPLATE" => "dynamic.counter",
		"RESULT_RATIO" => "N"
	),
	false
);?>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>