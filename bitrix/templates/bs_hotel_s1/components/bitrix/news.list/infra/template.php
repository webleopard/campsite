<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

$block_name="infra";
$page_block=GetMessage("INDEX_PAGE_BLOCK")[$block_name];

$block_header="";
if (isset($GLOBALS["OPTION_PAGE_BLOCK_CUSTOM_HEADER_".$block_name])) $block_header=$GLOBALS["OPTION_PAGE_BLOCK_CUSTOM_HEADER_".$block_name];
else
$block_header=$page_block["header"]!="" ? $page_block["header"]:$page_block["name"];

$header_tag="h1";
if ($arParams["HEADER_H2"]=="Y") $header_tag="h2";

/*ID блока с категориями*/
$IBLOCK_ID_CATEGORY=0;
$properties = CIBlockProperty::GetList(Array("SORT"=>"ASC"), Array("CODE"=>"INFRA_CATEGORY", "IBLOCK_ID"=>$arParams["IBLOCK_ID"]));
while($property = $properties->Fetch())
{
	$IBLOCK_ID_CATEGORY=$property["LINK_IBLOCK_ID"];
}

/*Категории с заполненными объектами*/
$infra_categs=array();
$arFilter = Array("IBLOCK_ID"=>$IBLOCK_ID_CATEGORY, "ACTIVE"=>"Y");
$res_categ = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false);
while($ob_categ = $res_categ->GetNextElement())
{
	$cnt_objects = CIBlockElement::GetList(Array(), array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arParams["IBLOCK_ID"], "PROPERTY_INFRA_CATEGORY"=>$ob_categ->fields["ID"]), false, false);
	if ($cnt_objects->SelectedRowsCount()>0)
	{
		$arFields = $ob_categ->GetFields();
		$arProps = $ob_categ->GetProperties();
		
		$img_detail=CFile::GetPath($arFields["DETAIL_PICTURE"]);
		$arFields['img_detail']=$img_detail;
		
		$infra_categs[$arFields["ID"]]=$item=array_merge($arFields, $arProps);
	}
	
}



?>
<div class="infra_wrapper">

<<?=$header_tag ?> class="page_block_header"><?=$block_header ?></<?=$header_tag ?>>

<div class="infra_menu d-flex flex-wrap justify-content-center justify-content-xl-start all_selected">
<?
/*Категории*/
foreach ($infra_categs as $infra_categ)
{
	$html_color=($infra_categ["BACKGROUND_COLOR"]["VALUE"]!='' ? $infra_categ["BACKGROUND_COLOR"]["VALUE"] : "#CCCCCC");
	
	$img='';
	if ($infra_categ["PREVIEW_PICTURE"]>0)
	$img=CFile::GetPath($infra_categ["PREVIEW_PICTURE"]);
	$infra_categ['img']=$img;
	
	if ($infra_categ["DETAIL_PICTURE"]>0)
	$img_detail=CFile::GetPath($infra_categ["DETAIL_PICTURE"]);
	$infra_categ['img_detail']=$img_detail;

	?>
	<div class="item d-flex" data-id="<?=$infra_categ["ID"] ?>">
		<div class="img d-flex justify-content-center <?=$infra_categ["SVG_ICON_CLASS"]["VALUE"] ?>" style="background-color: <?=$html_color ?>">
			<div class="d-flex align-self-center">
				<?
				if ($infra_categ["SVG_ICON"]["VALUE"]>0){ 
					$img=CFile::GetPath($infra_categ["SVG_ICON"]["VALUE"]);
				?>
				<?=file_get_contents($_SERVER["DOCUMENT_ROOT"].$img) ?>
				<?} ?>
			</div>
		</div>
		<div class="name align-self-center"><?=$infra_categ["NAME"] ?></div>
		<a class="href" href="javascript:void(0);"></a>
	</div>
	<?
	
	
}
?>
</div>

<div class="air p10"></div>

<div class="infra_map_container">
	<div id="infra_map" class="infra_map" style="height:400px;"></div>	
</div>		

</div>	

	<script>
		    ymaps.ready(init_infra);
		    function init_infra ()
		    {
		    	 	myMap_infra = new ymaps.Map("infra_map", {
		    		 	center: [57.968190, 56.157882],
		    	        zoom: 10,
		    	        controls: [],
		    	        behaviors: ['drag'],
		    	        margin: [50,50,50,50]
		    	    });
		
		    	    myCollection = new ymaps.GeoObjectCollection();
		    	    myCollectionCustom = new ymaps.GeoObjectCollection(); /*Маркеры вне категорий*/
		    	    
					<?foreach ($infra_categs as $cat){?>
		    	    	myCollection<?=$cat['ID'] ?> = new ymaps.GeoObjectCollection();
		    	    <?} ?>
		    	    
		    	    myMap_infra.controls.add('zoomControl', {
		    	        float: 'none',
		    	        position: {
		    	            right: 10,
		    	            top: 5
		    	        }
		    	    });
		
		    	    <?
    	    	   foreach($arResult["ITEMS"] as $arItem):?>
					<?
						$i++;
						
						$house_id=$file_id=0;
						
						$arFilter = Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'], "ID"=>$arItem['ID']);
						$res = CIBlockElement::GetList(Array(), $arFilter, false, false, array('property_ADDRESS', 'property_INFRA_CATEGORY', 'property_COORDS', 'property_MARKER_IMAGE', 'property_MARKER_OFFSET'));
						while($ob = $res->GetNextElement())
						{
							$coords=$ob->fields['PROPERTY_COORDS_VALUE'];
							$custom_image=$ob->fields['PROPERTY_MARKER_IMAGE_VALUE'];
							$address=$ob->fields['PROPERTY_ADDRESS_VALUE'];
							
							$custom_image_offset=$ob->fields['PROPERTY_MARKER_OFFSET_VALUE'];
							
							$infra_category_id=$ob->fields['PROPERTY_INFRA_CATEGORY_VALUE'];
							if (!$infra_category_id>0) $infra_category_id='Custom';
						}
						
						if ($infra_category_id=="Custom" || isset($infra_categs[$infra_category_id]))/*Категория активна*/
						{

							$baloon_content='<div><strong>'.stripslashes($arItem['NAME']).'</strong></div>';
							$baloon_content.='<div><i>'.$address.'</i></div>';
							
							if ($arItem['PREVIEW_TEXT']!='') 
							{
								$comment = str_replace(array("\r\n", "\r", "\n"), '',  htmlspecialchars_decode($arItem['PREVIEW_TEXT']));
								$baloon_content=$comment;
							
							}
							
							if ($custom_image>0)
							{
								$custom_marker_img=CFile::GetPath($custom_image);
								$iconImageHref=$custom_marker_img;
								
								$size = getimagesize($_SERVER["DOCUMENT_ROOT"].$custom_marker_img);
								
								$iconImageSize=$size[0].', '.$size[1];
								
								if ($custom_image_offset!='')
								$iconImageOffset=$custom_image_offset;
								else
								$iconImageOffset='-'.(round($size[0]/2)).', -'.(round($size[1]/2));
								
							
							}
							else 
							{
								$iconImageSize='80, 104';
								$iconImageOffset='-40, -75';
								
								if ($infra_categs[$infra_category_id]['img_detail']=="")
								$iconImageHref=$templateFolder."/images/def.png";
								else	
								$iconImageHref=$infra_categs[$infra_category_id]['img_detail'];
							}
							
							?>

							myPlacemark = new ymaps.Placemark([<?=$coords?>], {
	    	    	        	balloonContent: '<?=$baloon_content ?>'
	    	    	        }, {
	    	    	        //draggable: true,
	    	    	        iconLayout: 'default#image',
	    	    	        iconImageHref: '<?=$iconImageHref ?>',
	    	                iconImageSize: [<?=$iconImageSize?>],
	    	                iconImageOffset: [<?=$iconImageOffset ?>],
	    	    	        });
	    	
	    	    	    	myCollection<?=$infra_category_id ?>.add(myPlacemark);
							<?
							
						}
					?>
					<?endforeach;?>
					
    	    		<?foreach ($infra_categs as $cat){?>myCollection.add(myCollection<?=$cat['ID'] ?>);<?} ?>
    	    		myCollection.add(myCollectionCustom);
    	    		
    	    		myMap_infra.geoObjects.add(myCollection);
    	    		myMap_infra.setBounds( myCollection.getBounds(), {zoomMargin: 10, useMapMargin: true} );


    
    	    		//alert(myMap_infra.geoObjects.get(0).getLength());
    	    		
    	  
    	    		function getGeoObjects(item, akk) {
					    if (item.each) {
					        item.each(function (elem, i) {
					            getGeoObjects(elem, akk); 
					        });
					    } else {
					        akk.push(item);
					    }
					
					    return akk;
					}


    	    		$(document).on('click','.infra_menu .item', function() {
    	    			if ($(this).parents('.infra_menu').hasClass('all_selected'))
    	    			{
    	    				$('.infra_menu').removeClass("all_selected");	
    	    				$('.infra_menu .item').addClass("no_active");

    	    			}

    	    			if ($(this).hasClass("no_active"))
    	    			$(this).removeClass("no_active");
    	    			else 
    	    			$(this).addClass("no_active");

    	    			myMap_infra.geoObjects.removeAll();
    	    		

	    				
    	    			$('.infra_menu .item:not(.no_active)').each(function()
    	    			{
    	    				
    	    				myMap_infra.geoObjects.add(eval('myCollection'+$(this).data('id')));
    	    				myMap_infra.geoObjects.add(eval('myCollectionCustom'));


    	    				const geoObjects = getGeoObjects(myMap_infra.geoObjects, []);
    	 					if (geoObjects.length==1)
    	 					{
	    	    				geoObjects.forEach(function(element) 
	    	    	    		{
	    	    					myMap_infra.setCenter([element.geometry._coordinates[0], element.geometry._coordinates[1]], 13, {checkZoomRange: true});	
	    	    				});
	    	    				
    	 					}
    	 					else
    	    				myMap_infra.setBounds( myMap_infra.geoObjects.getBounds(), {zoomMargin: 15, useMapMargin: true} );
    	    				
    	    			});

    	    			

    	    					    	    			
    	    		});


		
		    }
		</script>

		