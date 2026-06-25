<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);

$map_type=2;
if (isset($GLOBALS["PAGE_BLOCK_MAP"]))
$map_type=$GLOBALS["PAGE_BLOCK_MAP"];


if ($arParams['COORDS']=='') print '<h2>'.GetMessage("MAP_NO_COORDS").'</h2>';
?>
							<script>
							    ymaps.ready(init2);
							    function init2 ()
							    {
							
							    	 myMap2 = new ymaps.Map("map2", {
							    		 	center: [<?=$arParams['COORDS']?>],
							    	        zoom: 13,
							    	        controls: [],
							    	        behaviors: ['drag']
							    	    });
							
							    	    myCollection = new ymaps.GeoObjectCollection();
							
							    	    myMap2.controls.add('zoomControl', {
							    	        float: 'none',
							    	        position: {
							    	            right: 10,
							    	            top: 5
							    	        }
							    	    });
							
							    	    	coords = [<?=$arParams['COORDS']?>];
							    	    	
							    	    	<?
							    	    	$baloon_content="";
							    	    	
							    	    	$filename=$_SERVER["DOCUMENT_ROOT"].SITE_DIR."include/logo.php";
							    	    	$handle = fopen($filename, "rb");
							    	    	$content = fread($handle, filesize($filename));
							    	    	$content=str_replace(array("\r", "\n"), '', $content);
							    	    	if ($content!="") $baloon_content.="<div class=\"logo\">".str_replace("<?=SITE_DIR ?>", SITE_DIR, $content)."</div>";
							    	    	
							    	    	$baloon_content.='<h4>'.$arParams['FORM_HEADER'].'</h4>';
							    	    	
							    	    	$filename=$_SERVER["DOCUMENT_ROOT"].SITE_DIR."include/address.php";
							    	    	$handle = fopen($filename, "rb");
							    	    	$content = fread($handle, filesize($filename));
							    	    	$content=str_replace(array("\r", "\n"), '<br>', $content);
							    	    	if ($content!="") $baloon_content.="<div>".$content."</div>";
							    	    	
							    	    	$filename=$_SERVER["DOCUMENT_ROOT"].SITE_DIR."include/phone1.php";
							    	    	$handle = fopen($filename, "rb");
							    	    	$content = fread($handle, filesize($filename));
							    	    	$content=str_replace("\n", '<br>', $content);
							    	    	$content=str_replace("\r", '', $content);
							    	    	if ($content!="") $baloon_content.="<div>".$content."</div>";

							    	    	
							    	    	$filename=$_SERVER["DOCUMENT_ROOT"].SITE_DIR."include/phone2.php";
							    	    	if(filesize($filename)) 
							    	    	{
								    	    	$handle = fopen($filename, "rb");
								    	    	$content = fread($handle, filesize($filename));
								    	    	$content=str_replace("\n", '<br>', $content);
							    	    		$content=str_replace("\r", '', $content);
								    	    	if ($content!="") $baloon_content.="<div>".$content."</div>";
							    	    	}
							    	    	
							    	    	$filename=$_SERVER["DOCUMENT_ROOT"].SITE_DIR."include/phone3.php";
							    	    	if(filesize($filename))
							    	    	{
							    	    		$handle = fopen($filename, "rb");
							    	    		$content = fread($handle, filesize($filename));
							    	    		$content=str_replace("\n", '<br>', $content);
							    	    		$content=str_replace("\r", '', $content);
							    	    		if ($content!="") $baloon_content.="<div>".$content."</div>";
							    	    	}
							    	    	
							    	    	$filename=$_SERVER["DOCUMENT_ROOT"].SITE_DIR."include/email.php";
							    	    	$handle = fopen($filename, "rb");
							    	    	$content = fread($handle, filesize($filename));
							    	    	$content=str_replace("\n", '<br>', $content);
							    	    	$content=str_replace("\r", '', $content);
							    	    	if ($content!="") $baloon_content.="<div>".$content."</div>";
							    	    	
							    	    	if ($baloon_content!="") $baloon_content='<div class="baloon_content">'.$baloon_content.'<div class="air p30"></div><a class="fancybox btn ripple small" data-comment="Заказ звонка" href="#popup_callback">Заказать звонок</a></div>';
							    	    	?>
							
								            myPlacemark = new ymaps.Placemark([coords[0], coords[1]], {
									        	balloonContent: '<?=$baloon_content ?>'
									        }, {
									        //draggable: true,
									        iconLayout: 'default#image',
							                iconImageHref: '<?=SITE_DIR ?>include/images/map_marker.png',
							                iconImageSize: [92, 116],
							                iconImageOffset: [-45, -90],
									        });
							
									    	myCollection.add(myPlacemark);
											myMap2.geoObjects.add( myCollection );
											myMap2.setCenter(coords, 16);
											
											var position = myMap2.getGlobalPixelCenter();
											
											<?if ($map_type==2) {?>
											if ($(window).width()>=768)
											myMap2.setGlobalPixelCenter([ position[0] + 200, position[1]]);
											<?} ?>
											
											//myMap2.setBounds( myCollection.getBounds(), {useMapMargin: true});
							               
											if ($(window).width()<768)
											{
												myMap2.behaviors.disable('drag');
												myMap2.behaviors.disable('multiTouch');
											}
										    
							
							
							    }
							</script>
							<?
							$use_css_filter=false;
							if (!isset($GLOBALS["OPTION_PAGE_BLOCK_MAP_MARKER_CSS_FILTER"]) || $GLOBALS["OPTION_PAGE_BLOCK_MAP_MARKER_CSS_FILTER"]=="Y")
							$use_css_filter=true;
							?>
							<div class="map_form <?=$use_css_filter ? "css_filter":"" ?>">
								<div class="bg"></div>
								<div id="map2" style="height: 600px; border-top: 1px solid #CCCCCC;">
									
									<?if ($map_type==2) {?>
									<div class="content_container d-none d-md-block">
										<div class="form_container d-flex">
											<div class="form align-self-center">
												<h2 class="styled2"><?=$arParams['FORM_HEADER'] ?></h2>
												
												<div class="address iconfont_container flex-grow-1">
													<?$APPLICATION->IncludeFile(SITE_DIR."include/address.php");?>
												</div>
												
												<div class="phone iconfont_a_container">
													<?$APPLICATION->IncludeFile(SITE_DIR."include/phone1.php");?>
												</div>
												
												<?if(filesize($_SERVER["DOCUMENT_ROOT"].SITE_DIR."include/phone2.php")) {?>
												<div class="phone iconfont_a_container">
													<?$APPLICATION->IncludeFile(SITE_DIR."include/phone2.php");?>
												</div>
												<?} ?>
												
												<?if(filesize($_SERVER["DOCUMENT_ROOT"].SITE_DIR."include/phone3.php")) {?>
												<div class="phone iconfont_a_container">
													<?$APPLICATION->IncludeFile(SITE_DIR."include/phone3.php");?>
												</div>
												<?} ?>
												
												<?if(filesize($_SERVER["DOCUMENT_ROOT"].SITE_DIR."include/email.php")) {?>
												<div class="email iconfont_a_container flex-grow-1 d-none d-md-block">
													<?$APPLICATION->IncludeFile(SITE_DIR."include/email.php");?>
												</div>
												<?} ?>
												<div class="social">
													<?require($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/design/footer/include/social.php");?>
												</div>
												
												<div class="air p10"></div>
												<div class="callback"><a class="fancybox btn ripple" data-comment="Заказ звонка" href="#popup_callback"><?=GetMessage("MAP_CALLBACK_BTN_TEXT") ?></a></div>
												
											</div>
										</div>
									</div>
									<?} ?>
									
								</div>
							</div>