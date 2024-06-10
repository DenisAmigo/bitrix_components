<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?$arBlock = getIblockIDbyCode("aspro_mshop_tizers_bonuses")?>
<div class="container">
	<div class="questionnaire-container border_block">
		<form>
			<div class="col-left-8">
				<div class="column-wide">
					<div class="form-control">
						<label><span>Номер Вашего бонусного счета</span></label>
						<input disabled placeholder="Номер карты" type="text" class="inputtext orange" name="CARD_NUMBER" required="" style="font-weight: 800" value="<?=$arResult["DATA"]["CARD_NUMBER"]?>" size="0">
					</div>
				</div>
				<div class="column-small">
					<div class="form-control">
						<label><span>Дата рождения владельца карты</span></label>
						<select disabled name="CARD_DAY">
							<?foreach($arResult["DAYS"] as $day) {?>
								<option value="<?=$day?>" <?=$arResult["DATA"]["BIRTHDAY"][0] == $day?" selected":""?>><?=$day?></option>
							<?}?>
						</select>
						<select disabled name="CARD_MONTH">
							<?foreach($arResult["MONTHS"] as $month) {?>
								<option value="<?=$month?>" <?=$arResult["DATA"]["BIRTHDAY"][1] == $month?" selected":""?>><?=$month?></option>
							<?}?>
						</select>
						<select disabled name="CARD_YEAR">
							<?foreach($arResult["YEARS"] as $year) {?>
								<option value="<?=$year?>" <?=$arResult["DATA"]["BIRTHDAY"][2] == $year?" selected":""?>><?=$year?></option>
							<?}?>
						</select>
					</div>
				</div>
				<div class="clear"></div>
				<div class="bonuses-info">
					<div class="column-wide">
						<div class="form-control">
							<label class="fs14"><span>Бонусных рублей</span></label>
							<label class="fs14"><span>Бонусные рубли действительны до</span></label>
						</div>
					</div>
					<div class="column-small">
						<div class="form-control small-info">
							<label class="fs14"><span class="bonuses orange"><?=$arResult["DATA"]["ACCOUNT_VALUE"]?></span></label>
							<label class="fs14"><span><?=$arResult["DATA"]["UF_NEW_DATE_LAST"]?></span></label>
						</div>
					</div>
				</div>
				<div class="clear"></div>
				<div class="bonuses-info">
					<div class="form-control">
						<label>Фамилия Имя Отчество<span class="star">*</span></label>
						<input required="" type="text" name="NAME" maxlength="50" value="<?=$arResult["DATA"]["NAME"]?>" aria-required="true">
					</div>
					<div class="form-control">
						<label>Телефон<span class="star">*</span></label>
						<input disabled required="" type="text" name="UF_PHONE" class="phone valid" maxlength="255" value="<?=$arResult["DATA"]["UF_PHONE"]?>" aria-required="true" aria-invalid="false">
					</div>
					<div class="form-control">
						<label>E-mail<span class="star">*</span></label>
						<input disabled required="" type="text" name="UF_EMAIL" maxlength="50" value="<?=$arResult["DATA"]["UF_EMAIL"]?>" aria-required="true" aria-invalid="false" class="valid">
					</div>
					<div class="form-control filter">
						<input type="checkbox" name="UF_SUBSCRIBE" id="UF_SUBSCRIBE_id" value="<?=$arResult["FIELDS"]["UF_SUBSCRIBE"][1]?>" <?=$arResult["DATA"]["UF_SUBSCRIBE"]?" checked":""?>/>
						<label for="UF_SUBSCRIBE_id">Я хочу быть в курсе новинок, скидок и спецпредложений магазинов «СОЮЗ»</label>
					</div>
					<div class="activate-account">
						<div class="form-control">
							<label><span>Код активации на ваш мобильный телефон&nbsp;</span></label>
							<a class="button big_btn bold type_block get-sms-code">Получить код активации</a>
						</div>
						<div class="form-control">
							<div style="width: 45%; float: left;">
								<input type="text" placeholder="Введите код" name="SMS_CODE"/>
							</div>
							<div style="width: 50%; float: right;">
								<a class="button big_btn bold type_block activate">Сохранить изменения</a>
							</div>
						</div>
						<div class="response" style="padding-top: 10px; display: inline-block;"></div>
					</div>
				</div>
			</div>
			<div class="col-right-4">
				<div class="form-control" style="margin-bottom: 22px;">
					<label><span>Кодовое слово</span></label>
					<input type="text" id="codeword" class="inputtext" name="UF_CODEWORD" required="" value="<?=$arResult["DATA"]["UF_CODEWORD"]?>" aria-required="true">
				</div>
				<div class="form-control" style="visibility: hidden;">
					<label class="fs14"><span>Бонусных рублей</span></label>
					<label class="fs14"><span>Бонусные рубли действительны до</span></label>
				</div>
				<div class="form-control inlineBlock">
					<label class="orange">В каких социальных сетях вы зарегистрированы:</label>
					<div class="column-wide first filter">
						<input type="checkbox" name="UF_VK" id="UF_VK_id" value="<?=$arResult["FIELDS"]["UF_VK"][1]?>" <?=$arResult["DATA"]["UF_VK"]?" checked":""?>/>
						<label for="UF_VK_id">ВКонтакте</label><br/>
						<input type="checkbox" name="UF_FB" id="UF_FB_id" value="<?=$arResult["FIELDS"]["UF_FB"][1]?>" <?=$arResult["DATA"]["UF_FB"]?" checked":""?>/>
						<label for="UF_FB_id">Facebook</label>
					</div>
					<div class="column-small second filter">
						<input type="checkbox" name="UF_OK" id="UF_OK_id" value="<?=$arResult["FIELDS"]["UF_OK"][1]?>" <?=$arResult["DATA"]["UF_OK"]?" checked":""?>/>
						<label for="UF_OK_id">Одноклассники</label><br/>
						<input type="checkbox" name="UF_OTHER_SOCIAL" id="UF_OTHER_SOCIAL_id" value="<?=$arResult["FIELDS"]["UF_OTHER_SOCIAL"][1]?>" <?=$arResult["DATA"]["UF_OTHER_SOCIAL"]?" checked":""?>/>
						<label for="UF_OTHER_SOCIAL_id">Прочие</label>
					</div>
				</div>
				<div class="form-control inlineBlock">
					<label class="orange">Ваше любимое занятие:</label>
					<div class="column-wide first filter">
						<input type="checkbox" name="UF_HUNTING" id="UF_HUNTING_id" value="<?=$arResult["FIELDS"]["UF_HUNTING"][1]?>" <?=$arResult["DATA"]["UF_HUNTING"]?" checked":""?>/>
						<label for="UF_HUNTING_id">Охота</label><br/>
						<input type="checkbox" name="UF_FISHING" id="UF_FISHING_id" value="<?=$arResult["FIELDS"]["UF_FISHING"][1]?>" <?=$arResult["DATA"]["UF_FISHING"]?" checked":""?>/>
						<label for="UF_FISHING_id">Рыбалка</label><br/>
						<input type="checkbox" name="UF_TRAVEL" id="UF_TRAVEL_id" value="<?=$arResult["FIELDS"]["UF_TRAVEL"][1]?>" <?=$arResult["DATA"]["UF_TRAVEL"]?" checked":""?>/>
						<label for="UF_TRAVEL_id">Путешествия/туризм</label><br/>
						<input type="checkbox" name="UF_COLLECTING" id="UF_COLLECTING_id" value="<?=$arResult["FIELDS"]["UF_COLLECTING"][1]?>" <?=$arResult["DATA"]["UF_COLLECTING"]?" checked":""?>/>
						<label for="UF_COLLECTING_id">Коллекционирование</label><br/>
						<label for="UF_OTHER_HOBBY_id" style="padding-left: 23px;">Другое (укажите):</label>
					</div>
					<div class="column-small second filter">
						<input type="checkbox" name="UF_NEEDLEWORK" id="UF_NEEDLEWORK_id" value="<?=$arResult["FIELDS"]["UF_NEEDLEWORK"][1]?>" <?=$arResult["DATA"]["UF_NEEDLEWORK"]?" checked":""?>/>
						<label for="UF_NEEDLEWORK_id">Рукоделие</label><br/>
						<input type="checkbox" name="UF_BEEKEEPING" id="UF_BEEKEEPING_id" value="<?=$arResult["FIELDS"]["UF_BEEKEEPING"][1]?>" <?=$arResult["DATA"]["UF_BEEKEEPING"]?" checked":""?>/>
						<label for="UF_BEEKEEPING_id">Бортничество</label><br/>
						<input type="checkbox" name="UF_COOKERY" id="UF_COOKERY_id" value="<?=$arResult["FIELDS"]["UF_COOKERY"][1]?>" <?=$arResult["DATA"]["UF_COOKERY"]?" checked":""?>/>
						<label for="UF_COOKERY_id">Кулинария</label><br/>
						<input type="checkbox" name="UF_SPORT" id="UF_SPORT_id" value="<?=$arResult["FIELDS"]["UF_SPORT"][1]?>" <?=$arResult["DATA"]["UF_SPORT"]?" checked":""?>/>
						<label for="UF_SPORT_id">Спорт</label><br/>
						<input type="text" class="inputtext" name="UF_OTHER_HOBBY" id="UF_OTHER_HOBBY_id" value="<?=$arResult["DATA"]["UF_OTHER_HOBBY"]?>" style="padding-top: 1px; padding-bottom: 1px;">
					</div>
				</div>
				<div class="form-control gender filter">
					<label class="inlineBlock">Пол:</label>
					<input type="checkbox" name="UF_GENDER" id="UF_GENDER_MALE_id" value="<?=$arResult["FIELDS"]["UF_GENDER"]["м"]?>" <?=($arResult["DATA"]["UF_GENDER"] == $arResult["FIELDS"]["UF_GENDER"]["м"] || empty($arResult["DATA"]["UF_GENDER"])) ? " checked" : ""?>/>
					<label class="" for="UF_GENDER_MALE_id">м</label>
					<input type="checkbox" name="UF_GENDER" id="UF_GENDER_FEMALE_id" value="<?=$arResult["FIELDS"]["UF_GENDER"]["ж"]?>" <?=($arResult["DATA"]["UF_GENDER"] == $arResult["FIELDS"]["UF_GENDER"]["ж"]) ? " checked" : ""?>/>
					<label class="" for="UF_GENDER_FEMALE_id">ж</label>
				</div>
				<div class="form-control">
					<a href="/catalog/" class="button big_btn bold type_block">Приступить к покупкам</a>
				</div>
			</div>
		</form>
	</div>
</div>
<script>
	$('.questionnaire-container .gender input[type=checkbox]').unbind().click(function(e) {
		$('.questionnaire-container .gender input[type=checkbox]').removeAttr('checked');
		$(this).attr('checked', 'checked');
	});
	$('.bonuses-checked a.check_balance').unbind().click(function(e) {
		e.preventDefault();
		var number = $('input[name=CARD_NUMBER]').val(),
			date = $('select[name=CARD_DAY]').val()+"."+$('select[name=CARD_MONTH]').val()+"."+$('select[name=CARD_YEAR]').val();
		getBalanceAccount(number, date)
	});
	$('.activate-account a.get-sms-code').unbind().click(function(e) {
		e.preventDefault();
		var phone = $('input[name=SMS_PHONE_NUMBER]').val();
		getSMSCode(phone)
	});
	$('.activate-account a.activate').unbind().click(function(e) {
		e.preventDefault();
		var code = $('input[name=SMS_CODE]').val();
		activatePhone(code)
	});
	function getBalanceAccount(number, date) {
		var script = '<?=$templateFolder?>/ajax.php';
		$.post(
			script,
			{
				METHOD: 'GET_BALANCE',
				CARD_NUMBER: number,
				DATE_BIRTH: date
			},
			function (data) {
				$('.bonuses-checked .response').html(data);
			}
		);
	}
	function getSMSCode(phone) {
		var script = '<?=$templateFolder?>/ajax.php';
		$.post(
			script,
			{
				METHOD: 'GET_SMS_CODE',
				PHONE_NUMBER: phone
			},
			function (data) {
				console.log(data);
			}
		);
	}
	function activatePhone(code) {
		var script = '<?=$templateFolder?>/ajax.php';
		$.post(
			script,
			{
				METHOD: 'CHECK_SMS_CODE',
				SMS_CODE: code
			},
			function (data) {
				$('.activate-account .response').html(data);
			}
		);
	}

</script>