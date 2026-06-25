<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);

$map_type=2;
if (isset($GLOBALS["PAGE_BLOCK_MAP"]))
$map_type=$GLOBALS["PAGE_BLOCK_MAP"];


if ($arParams['COORDS']=='') print '<h2>'.GetMessage("MAP_NO_COORDS").'</h2>';
?>							
							<script>
							    ymaps.ready(init);
							    function init()
							    {
							
							    	 myMap = new ymaps.Map("map", {
							    		 	center: [<?=$arParams['COORDS']?>],
							    	        zoom: 13,
							    	        controls: [],
							    	        behaviors: ['drag']
							    	    });
							
							    	    myCollection = new ymaps.GeoObjectCollection();
							
							    	    myMap.controls.add('zoomControl', {
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
							    	    	$content=str_replace("\n", '<br>', $content);
							    	    	$content=str_replace("\r", '', $content);
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
									    	myMap.geoObjects.add( myCollection );
									    	myMap.setCenter(coords, 16);
											
											var position = myMap.getGlobalPixelCenter();
					
											if ($(window).width()<768)
											{
												myMap.behaviors.disable('drag');
												myMap.behaviors.disable('multiTouch');
											}
										    
							
							
							    }
							</script>
							<?
							$use_css_filter=false;
							if (!isset($GLOBALS["OPTION_PAGE_BLOCK_MAP_MARKER_CSS_FILTER"]) || $GLOBALS["OPTION_PAGE_BLOCK_MAP_MARKER_CSS_FILTER"]=="Y")
							$use_css_filter=true;
							?>
							<div class="map_wrapper">
								<div class="map <?=$use_css_filter ? "css_filter":"" ?>">
									<div class="bg"></div>
									<div id="map" style="height: 600px; border-top: 1px solid #CCCCCC;"></div>
								</div>
							</div>