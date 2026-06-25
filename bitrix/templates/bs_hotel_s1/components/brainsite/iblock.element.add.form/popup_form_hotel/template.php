<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(false);



?>
<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/design/settings_final.php"); ?>
<script>
var SITE_TEMPLATE_PATH = "<?=SITE_TEMPLATE_PATH?>";
var COMPONENT_PATH_FORM_HOTEL ='<?=$templateFolder ?>';

</script>
<div class="header3 <?=(count($arResult["ERRORS"]) > 0 || !empty($arResult["MESSAGE"])) ? "hidden":"" ?>"><?=GetMessage("FORM_HEADER") ?></div>
<?

if (!empty($arResult["ERRORS"])):?>
	<?ShowError(implode("<br />", $arResult["ERRORS"]))?>
<?endif;
if ($arResult["MESSAGE"] <> ''):?>
	<div class="form_result">
		<?ShowNote($arResult["MESSAGE"])?>
		<div class="air p20"></div>
		<div class="text-center">
			<a class="btn" data-fancybox-close="" href="javascript:void(0);">Закрыть</a>
		</div>
	</div>
<?endif?>
<form name="iblock_add_<?=$arParams["AJAX_OPTION_ADDITIONAL"]?>" class="popup_form popup_form_hotel <?=(count($arResult["ERRORS"]) > 0 || !empty($arResult["MESSAGE"])) ? "hidden":"" ?>" action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data">
	<?=bitrix_sessid_post()?>
	<?if ($arParams["MAX_FILE_SIZE"] > 0):?><input type="hidden" name="MAX_FILE_SIZE" value="<?=$arParams["MAX_FILE_SIZE"]?>" /><?endif?>
		<?if (is_array($arResult["PROPERTY_LIST"]) && !empty($arResult["PROPERTY_LIST"])):?>
			
			<input type="hidden" name="IBLOCK_ID" value="<?=$arParams["IBLOCK_ID"] ?>">
			
			<input type="hidden" name="IBLOCK_CATEG_ID" value="">
			<input type="hidden" name="IBLOCK_ROOMS_ID" value="">
			<input type="hidden" name="CATEG_ID" value="">
			<input type="hidden" name="ROOM_ID" value="">
			
			<?if ($GLOBALS['OPTION_USE_CAPTCHA']=="Y"){
				
				?><input value="" type="hidden" name="recaptcha_response" id="recaptcha<?=$arParams['IBLOCK_ID']?>"><?	
			}
			?>
			
						
			<?
			if (array_search($arResult["PRICE_ID"], $arResult["PROPERTY_LIST"])!==false)
			unset($arResult["PROPERTY_LIST"][array_search($arResult["PRICE_ID"], $arResult["PROPERTY_LIST"])]);
			?>
			
			<?
			/*Заполняем название источника из настроек модуля SOURCE_NAME*/
			if ($arParams["SOURCE_NAME"]!='' && $arResult["SOURCE_NAME_ID"]>0){ ?>
				<input data-code="SOURCE_NAME" class="hidden" name="PROPERTY[<?=$arResult["SOURCE_NAME_ID"] ?>][0]" size="30" value="<?=$arParams["SOURCE_NAME"] ?>">
				<?
				if (array_search($arResult["SOURCE_NAME_ID"], $arResult["PROPERTY_LIST"])!==false)
				unset($arResult["PROPERTY_LIST"][array_search($arResult["SOURCE_NAME_ID"], $arResult["PROPERTY_LIST"])]);
			} 
			?>
			
			<?foreach ($arResult["PROPERTY_LIST"] as $propertyID):?>
			<div class="form_field form_field_<?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["CODE"] ?>">
						<?
						$attr=array();
						
						//Назначаем placeholder
						$placeholder=$arResult["PROPERTY_LIST_FULL"][$propertyID]['HINT']!='' ? $arResult["PROPERTY_LIST_FULL"][$propertyID]['HINT']: $arResult["PROPERTY_LIST_FULL"][$propertyID]['NAME'];
						
						/* print '!!!'.$propertyID; */
						
						if ($arParams['PLACEHOLDER_'.$propertyID]!='')
						$placeholder=$arParams['PLACEHOLDER_'.$propertyID];
						
						
						
						if($arResult["PROPERTY_LIST_FULL"][$propertyID]['IS_REQUIRED']=="Y" || $propertyID=='NAME' || in_array($propertyID, $arParams['PROPERTY_CODES_REQUIRED']))
						{
							if ($placeholder!='') $placeholder.=' *';
							$attr[]="required";
						}
						
						if ($placeholder!='') $attr[]='placeholder="'.$placeholder.'"';
							
						
						$attr[]='data-code="'.$arResult["PROPERTY_LIST_FULL"][$propertyID]["CODE"].'"';
					
						
						if ($arParams['LABEL_HIDE']!="Y"):
						?>
							<label><?if (intval($propertyID) > 0):?><?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["NAME"]?><?else:?><?=!empty($arParams["CUSTOM_TITLE_".$propertyID]) ? $arParams["CUSTOM_TITLE_".$propertyID] : GetMessage("IBLOCK_FIELD_".$propertyID)?><?endif?><?if(in_array($propertyID, $arResult["PROPERTY_REQUIRED"])):?><span class="starrequired">*</span><?endif?></label>
						<?endif?>
						
						<?
											
						if (intval($propertyID) > 0)
						{
							if (
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] == "T"
								&&
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"] == "1"
							)
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] = "S";
							elseif (
								(
									$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] == "S"
									||
									$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] == "N"
								)
								&&
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"] > "1"
							)
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] = "T";
						}
						elseif (($propertyID == "TAGS") && CModule::IncludeModule('search'))
							$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] = "TAGS";

						if ($arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE"] == "Y")
						{
							$inputNum = ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0) ? count($arResult["ELEMENT_PROPERTIES"][$propertyID]) : 0;
							$inputNum += $arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE_CNT"];
						}
						else
						{
							$inputNum = 1;
						}

						if($arResult["PROPERTY_LIST_FULL"][$propertyID]["GetPublicEditHTML"])
							$INPUT_TYPE = "USER_TYPE";
						else
							$INPUT_TYPE = $arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"];
						
							
						
						
						
						switch ($INPUT_TYPE):
							case "USER_TYPE":
								for ($i = 0; $i<$inputNum; $i++)
								{
									if ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0)
									{
										$value = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["~VALUE"] : $arResult["ELEMENT"][$propertyID];
										$description = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["DESCRIPTION"] : "";
									}
									elseif ($i == 0)
									{
										$value = intval($propertyID) <= 0 ? "" : $arResult["PROPERTY_LIST_FULL"][$propertyID]["DEFAULT_VALUE"];
										$description = "";
									}
									else
									{
										$value = "";
										$description = "";
									}
									
									
								if ($arResult["PROPERTY_LIST_FULL"][$propertyID]["USER_TYPE"]=="Date")
								{
										?>
										<script type="text/javascript">
										$(function(){
			
											$.datepicker.regional['ru'] =
											{
												closeText: 'Закрыть',
												prevText: '&#x3c;Пред',
												nextText: 'След&#x3e;',
												currentText: 'Сегодня',
												monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
												'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
												monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
												'Июл','Авг','Сен','Окт','Ноя','Дек'],
												dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
												dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
												dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
												dateFormat: 'dd.mm.yy',
												firstDay: 1,
												isRTL: false
											};
			
			
											$.datepicker.setDefaults($.extend($.datepicker.regional["ru"]));
			
												$(".popup_form #<?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["CODE"] ?>").datepicker({		
													minDate: '<?=date('d.m.Y', strtotime('NOW')) ?>',
													maxDate: '<?=date('d.m.Y', strtotime('+1 year')) ?>',
												});
			                              
										});
										</script>
												<input id="<?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["CODE"] ?>" <?=implode(" ",$attr)?> type="text" name="PROPERTY[<?=$propertyID?>][<?=$i?>]" size="<?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["COL_COUNT"]; ?>" value="<?=$value?>" />
												<?
												/*print_r($arResult["PROPERTY_LIST_FULL"][$propertyID]);*/
												
												
									}
									else
									{
										echo call_user_func_array($arResult["PROPERTY_LIST_FULL"][$propertyID]["GetPublicEditHTML"],
											array(
												$arResult["PROPERTY_LIST_FULL"][$propertyID],
												array(
													"VALUE" => $value,
													"DESCRIPTION" => $description,
												),
												array(
													"VALUE" => "PROPERTY[".$propertyID."][".$i."][VALUE]",
													"DESCRIPTION" => "PROPERTY[".$propertyID."][".$i."][DESCRIPTION]",
													"FORM_NAME"=>"iblock_add",
												),
											));
									}
												
								}
							break;
							case "TAGS":
								$APPLICATION->IncludeComponent(
									"bitrix:search.tags.input",
									"",
									array(
										"VALUE" => $arResult["ELEMENT"][$propertyID],
										"NAME" => "PROPERTY[".$propertyID."][0]",
										"TEXT" => 'size="'.$arResult["PROPERTY_LIST_FULL"][$propertyID]["COL_COUNT"].'"',
									), null, array("HIDE_ICONS"=>"Y")
								);
								break;
							case "HTML":
								$LHE = new CHTMLEditor;
								$LHE->Show(array(
									'name' => "PROPERTY[".$propertyID."][0]",
									'id' => preg_replace("/[^a-z0-9]/i", '', "PROPERTY[".$propertyID."][0]"),
									'inputName' => "PROPERTY[".$propertyID."][0]",
									'content' => $arResult["ELEMENT"][$propertyID],
									'width' => '100%',
									'minBodyWidth' => 350,
									'normalBodyWidth' => 555,
									'height' => '200',
									'bAllowPhp' => false,
									'limitPhpAccess' => false,
									'autoResize' => true,
									'autoResizeOffset' => 40,
									'useFileDialogs' => false,
									'saveOnBlur' => true,
									'showTaskbars' => false,
									'showNodeNavi' => false,
									'askBeforeUnloadPage' => true,
									'bbCode' => false,
									'siteId' => SITE_ID,
									'controlsMap' => array(
										array('id' => 'Bold', 'compact' => true, 'sort' => 80),
										array('id' => 'Italic', 'compact' => true, 'sort' => 90),
										array('id' => 'Underline', 'compact' => true, 'sort' => 100),
										array('id' => 'Strikeout', 'compact' => true, 'sort' => 110),
										array('id' => 'RemoveFormat', 'compact' => true, 'sort' => 120),
										array('id' => 'Color', 'compact' => true, 'sort' => 130),
										array('id' => 'FontSelector', 'compact' => false, 'sort' => 135),
										array('id' => 'FontSize', 'compact' => false, 'sort' => 140),
										array('separator' => true, 'compact' => false, 'sort' => 145),
										array('id' => 'OrderedList', 'compact' => true, 'sort' => 150),
										array('id' => 'UnorderedList', 'compact' => true, 'sort' => 160),
										array('id' => 'AlignList', 'compact' => false, 'sort' => 190),
										array('separator' => true, 'compact' => false, 'sort' => 200),
										array('id' => 'InsertLink', 'compact' => true, 'sort' => 210),
										array('id' => 'InsertImage', 'compact' => false, 'sort' => 220),
										array('id' => 'InsertVideo', 'compact' => true, 'sort' => 230),
										array('id' => 'InsertTable', 'compact' => false, 'sort' => 250),
										array('separator' => true, 'compact' => false, 'sort' => 290),
										array('id' => 'Fullscreen', 'compact' => false, 'sort' => 310),
										array('id' => 'More', 'compact' => true, 'sort' => 400)
									),
								));
								break;
							case "T":
								for ($i = 0; $i<$inputNum; $i++)
								{

									if ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0)
									{
										$value = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE"] : $arResult["ELEMENT"][$propertyID];
									}
									elseif ($i == 0)
									{
										$value = intval($propertyID) > 0 ? "" : $arResult["PROPERTY_LIST_FULL"][$propertyID]["DEFAULT_VALUE"];
									}
									else
									{
										$value = "";
									}
								?>
						<textarea cols="<?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["COL_COUNT"]?>" rows="<?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"]?>" name="PROPERTY[<?=$propertyID?>][<?=$i?>]"><?=$value?></textarea>
								<?
								}
							break;

							case "S":
							case "N":
								for ($i = 0; $i<$inputNum; $i++)
								{
									if ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0)
									{
										$value = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE"] : $arResult["ELEMENT"][$propertyID];
									}
									elseif ($i == 0)
									{
										$value = intval($propertyID) <= 0 ? "" : $arResult["PROPERTY_LIST_FULL"][$propertyID]["DEFAULT_VALUE"];

									}
									else
									{
										$value = "";
									}
								?>
								<input <?=implode(" ",$attr)?> type="text" name="PROPERTY[<?=$propertyID?>][<?=$i?>]" size="<?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["COL_COUNT"]; ?>" value="<?=$value?>" /><br /><?
								if($arResult["PROPERTY_LIST_FULL"][$propertyID]["USER_TYPE"] == "DateTime"):?><?
									$APPLICATION->IncludeComponent(
										'bitrix:main.calendar',
										'',
										array(
											'FORM_NAME' => 'iblock_add',
											'INPUT_NAME' => "PROPERTY[".$propertyID."][".$i."]",
											'INPUT_VALUE' => $value,
										),
										null,
										array('HIDE_ICONS' => 'Y')
									);
									?><br /><small><?=GetMessage("IBLOCK_FORM_DATE_FORMAT")?><?=FORMAT_DATETIME?></small><?
								endif;
								}
							break;

							case "F":
								for ($i = 0; $i<$inputNum; $i++)
								{
									$value = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE"] : $arResult["ELEMENT"][$propertyID];
									?>
						<input type="hidden" name="PROPERTY[<?=$propertyID?>][<?=$arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] : $i?>]" value="<?=$value?>" />
						<input type="file" size="<?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["COL_COUNT"]?>"  name="PROPERTY_FILE_<?=$propertyID?>_<?=$arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] : $i?>" /><br />
									<?

									if (!empty($value) && is_array($arResult["ELEMENT_FILES"][$value]))
									{
										?>
					<input type="checkbox" name="DELETE_FILE[<?=$propertyID?>][<?=$arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] : $i?>]" id="file_delete_<?=$propertyID?>_<?=$i?>" value="Y" /><label for="file_delete_<?=$propertyID?>_<?=$i?>"><?=GetMessage("IBLOCK_FORM_FILE_DELETE")?></label><br />
										<?

										if ($arResult["ELEMENT_FILES"][$value]["IS_IMAGE"])
										{
											?>
					<img src="<?=$arResult["ELEMENT_FILES"][$value]["SRC"]?>" height="<?=$arResult["ELEMENT_FILES"][$value]["HEIGHT"]?>" width="<?=$arResult["ELEMENT_FILES"][$value]["WIDTH"]?>" border="0" /><br />
											<?
										}
										else
										{
											?>
					<?=GetMessage("IBLOCK_FORM_FILE_NAME")?>: <?=$arResult["ELEMENT_FILES"][$value]["ORIGINAL_NAME"]?><br />
					<?=GetMessage("IBLOCK_FORM_FILE_SIZE")?>: <?=$arResult["ELEMENT_FILES"][$value]["FILE_SIZE"]?> b<br />
					[<a href="<?=$arResult["ELEMENT_FILES"][$value]["SRC"]?>"><?=GetMessage("IBLOCK_FORM_FILE_DOWNLOAD")?></a>]<br />
											<?
										}
									}
								}

							break;
							case "L":

								if ($arResult["PROPERTY_LIST_FULL"][$propertyID]["LIST_TYPE"] == "C")
									$type = $arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE"] == "Y" ? "checkbox" : "radio";
								else
									$type = $arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE"] == "Y" ? "multiselect" : "dropdown";

								switch ($type):
									case "checkbox":
									case "radio":
										foreach ($arResult["PROPERTY_LIST_FULL"][$propertyID]["ENUM"] as $key => $arEnum)
										{
											$checked = false;
											if ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0)
											{
												if (is_array($arResult["ELEMENT_PROPERTIES"][$propertyID]))
												{
													foreach ($arResult["ELEMENT_PROPERTIES"][$propertyID] as $arElEnum)
													{
														if ($arElEnum["VALUE"] == $key)
														{
															$checked = true;
															break;
														}
													}
												}
											}
											else
											{
												if ($arEnum["DEF"] == "Y") $checked = true;
											}

											?>
							<input type="<?=$type?>" name="PROPERTY[<?=$propertyID?>]<?=$type == "checkbox" ? "[".$key."]" : ""?>" value="<?=$key?>" id="property_<?=$key?>"<?=$checked ? " checked=\"checked\"" : ""?> /><label for="property_<?=$key?>"><?=$arEnum["VALUE"]?></label><br />
											<?
										}
									break;

									case "dropdown":
									case "multiselect":
									?>
							<select name="PROPERTY[<?=$propertyID?>]<?=$type=="multiselect" ? "[]\" size=\"".$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"]."\" multiple=\"multiple" : ""?>">
								<option value=""><?echo GetMessage("CT_BIEAF_PROPERTY_VALUE_NA")?></option>
									<?
										if (intval($propertyID) > 0) $sKey = "ELEMENT_PROPERTIES";
										else $sKey = "ELEMENT";

										foreach ($arResult["PROPERTY_LIST_FULL"][$propertyID]["ENUM"] as $key => $arEnum)
										{
											$checked = false;
											if ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0)
											{
												foreach ($arResult[$sKey][$propertyID] as $elKey => $arElEnum)
												{
													if ($key == $arElEnum["VALUE"])
													{
														$checked = true;
														break;
													}
												}
											}
											else
											{
												if ($arEnum["DEF"] == "Y") $checked = true;
											}
											?>
								<option value="<?=$key?>" <?=$checked ? " selected=\"selected\"" : ""?>><?=$arEnum["VALUE"]?></option>
											<?
										}
									?>
							</select>
									<?
									break;

								endswitch;
							break;
						endswitch;?>
			</div>
			<?endforeach;?>
			<?if($arParams["USE_CAPTCHA"] == "Y" && $arParams["ID"] <= 0):?>
				<tr>
					<td><?=GetMessage("IBLOCK_FORM_CAPTCHA_TITLE")?></td>
					<td>
						<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
						<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
					</td>
				</tr>
				<tr>
					<td><?=GetMessage("IBLOCK_FORM_CAPTCHA_PROMPT")?><span class="starrequired">*</span>:</td>
					<td><input type="text" name="captcha_word" maxlength="50" value=""></td>
				</tr>
			<?endif?>
		</tbody>
		<?endif?>			
		
		<?if($arParams["LICENSE_SHOW"] == "Y" && $arParams["ID"] <= 0):?>
			<div class="clear"></div>
			<div class="licence_block styled_switch checkbox_style">
				<div>
				<input id="licenses_popup_CALLBACK<?=$arParams['AJAX_ID'] ?>" name="licenses_popup" required="" value="Y" aria-required="true" type="checkbox">
				<label for="licenses_popup_CALLBACK<?=$arParams['AJAX_ID'] ?>"><?=GetMessage("FORM_AGREEMENT") ?></label>
				</div>
			</div>
			<div class="clear"></div>
		<?endif?>
		
		<div class="clear"></div>
					<div class="text-center">
						<div class="btn_container ripple">
							<a class="btn send_form_wrapper" href="javascript:void(0);"><?=GetMessage("IBLOCK_FORM_SUBMIT")?></a>
						</div>
					</div>
					
					<div class="text-center" style="display: none;"><div class="btn_container ripple"><input class="submit_input" type="submit" class="btn" name="iblock_submit<?=$arParams['AJAX_OPTION_ADDITIONAL'] ?>" value="<?=GetMessage("IBLOCK_FORM_SUBMIT")?>" /></div></div>
					
					
					<?if ($arParams["LIST_URL"] <> ''):?>
						<input type="submit" name="iblock_apply" value="<?=GetMessage("IBLOCK_FORM_APPLY")?>" />
						<input
							type="button"
							name="iblock_cancel"
							value="<? echo GetMessage('IBLOCK_FORM_CANCEL'); ?>"
							onclick="location.href='<? echo CUtil::JSEscape($arParams["LIST_URL"])?>';"
						>
					<?endif?>
	</table>
</form>
