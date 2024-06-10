<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
 
$arComponentDescription = array(
	"NAME" => GetMessage("NAME"),
	"DESCRIPTION" => GetMessage("DESCRIPTION"),
	"ICON" => "/images/news-list.gif",
	"CACHE_PATH" => "Y",
	"PATH" => array(
		"ID" => "CSN",
		"NAME" => "CSN",
		'SORT'	=> 30,
	),
	"COMPLEX" => "N"
);
?>