jQuery(document).ready(function () {
	/*Hide titles cont and types cont when clicking on document*/
	jQuery(document).click(function () { 		  
		var gT = jQuery('.grsGallTitlesCont'),
			aT = jQuery('.grsAlbTitlesCont'),
			tN = jQuery('.grsThemeNamesCont'),
			gVCon  = jQuery('.grsGallViewsCont ');
		if (gT.is(':hidden') == false)
			jQuery( ".grsGall" ).trigger( "click" );
		if (aT.is(':hidden') == false) 
			jQuery( ".grsAlb" ).trigger( "click" );
		if (tN.is(':hidden') == false) 
			jQuery( ".grsTheme" ).trigger( "click" );
		if (gVCon.is(':hidden') == false) 
			jQuery( ".grsType" ).trigger( "click" );
	});

	/*Select title*/
	jQuery('body').on('click', '.grsGallTitle, .grsAlbTitle', function (e) {
		e.stopPropagation(); 
		var type = (jQuery(this).hasClass("grsGallTitle")) ? 'Gall' : 'Alb',
			tBut = (type == "Gall") ? jQuery('.grsAlb') : jQuery('.grsGall'),
			tCont = (type == "Gall") ? jQuery('.grsAlbTitlesCont') : jQuery('.grsGallTitlesCont'),
			unCk = (type == "Gall") ? 'Alb' : 'Gall',
			grViC = (type == "Gall") ? '.grsGallThumbnailView' : '.grsGallAlbumView';
		jQuery('.grs'+type+'Title').removeClass('grs'+type+'Selected');
		jQuery(this).addClass('grs'+type+'Selected');
		/*Check icon, uncheck last one*/ 
		jQuery('.grs'+type+'Check').removeClass('grs'+type+'Checked');
		jQuery(this).find('.grs'+type+'Check').addClass('grs'+type+'Checked');
		/*Hide previus title cont*/
		if (tCont.is(':hidden') == false) {
			/*Uncheck previus title*/
			jQuery('.grs'+unCk+'Check').removeClass('grs'+unCk+'Checked');
			tBut.trigger( "click" );
		}
		/*Activate type fadeIn it and lightbox buttons*/ 
		jQuery('.grsTypeDeactive').removeClass('grsTypeDeactive').addClass('grsType');
		if (jQuery('.grsGallViewsCont').is(':hidden') == true && viewHelp) {
			viewHelp = false;
			jQuery( ".grsType" ).trigger( "click" );
		}
		/*Active some views if from album to gallery or vs*/
		if(type == "Gall") {
			jQuery('.grsView').removeClass('grsDeacView');
			jQuery('.grsGallAlbumView').addClass('grsDeacView');
		}
		else {
			jQuery('.grsView').addClass('grsDeacView');
			jQuery('.grsGallAlbumView').removeClass('grsDeacView');
		}
		if(/*ete galleric album kam hakarak@*/true)
			jQuery(grViC).trigger( "click" );
		/*Deactive some views by same problem*/
		
		jQuery('.grsLightboxDeactive').removeClass('grsLightboxDeactive').addClass('grsLightbox');
	});
	
	/*Select theme*/
	jQuery('body').on('click', '.grsThemeName', function (e) {
		e.stopPropagation();
		jQuery('.grsThemeName').removeClass('grsThemeSelected');
		jQuery(this).addClass('grsThemeSelected');
		jQuery('.grsThemeCheck').removeClass('grsThemeChecked');
		jQuery(this).find('.grsThemeCheck').addClass('grsThemeChecked');
	});
	
	/*Show view types container*/
	jQuery('body').on('click', '.grsType', function (e) { 	  
		e.stopPropagation(); 
		var display = jQuery('.grsGallViewsCont').css('display');
		var grsGallViewsCont = jQuery('.grsGallViewsCont');
	
		if(display == 'block') { 
			grsGallViewsCont.removeClass('animated fadeInRight').addClass('animated fadeOutRight');
			setTimeout(function(){ 
				jQuery('.grsGallViewsCont').css('display', 'none');
			}, 500);
		}
		else {
			jQuery('.grsGallViewsCont').css('display', 'block');
			grsGallViewsCont.removeClass('animated fadeOutRight').addClass('animated fadeInRight');
		}
	});
	
	/*Select view type*/
	jQuery('body').on('click', '.grsView.enabled', function (e) { 	  
		e.stopPropagation(); 
		/*Dont change for deactive views or for same view click*/
		if(jQuery(this).hasClass('grsDeacView')) return;
		jQuery('.grsView').removeClass('grsViewSelected');
		jQuery(this).addClass('grsViewSelected');
	    /*Store lastSeleceted for fadeing out it*/
		var viewType = jQuery(this).attr('grsview'),
			lastSelected = jQuery('.grsViewContSelected');
		
		/*Remove selected class from viewCont elements and select new one*/
		jQuery('.grsViewCont').removeClass('grsViewContSelected');
		jQuery('.grs'+viewType+'Cont').addClass('grsViewContSelected');
		
	
		/*Hide lightbox params when slideshow selected*/							
		if(viewType == 'Slideshow') { 
			jQuery('.grsLightboxParamsCont').removeClass('animated fadeInRight').addClass('animated fadeOutRight');
		}
		
		lastSelected.removeClass('animated fadeInLeft').addClass('animated fadeOutLeft');
		setTimeout(function(){ 
			lastSelected.css('display', 'none');
			
			jQuery('.grsViewContSelected').css('display', 'block');
			jQuery('.grsViewContSelected').removeClass('animated fadeOutLeft').addClass('animated fadeInLeft');
			
			if(viewType == 'Slideshow') {
				/*Hide lightbox params when*/
				jQuery('.grsLightboxParamsCont').css('display', 'none');
			}
			else {
				/*Show lightbox params when*/
				if(jQuery('.grsLightboxParamsCont').css('display') != 'block') {
				    jQuery('.grsLightboxParamsCont').css('display', 'block');
				    jQuery('.grsLightboxParamsCont').removeClass('animated fadeOutRight').addClass('animated fadeInRight');
				}
			}
		}, 500);
	});
	
	/*Change mosaic type*/
	jQuery('body').on('change', 'input[name="mosaicType"]', function (e) { 	  
		e.stopPropagation(); 
		if(jQuery(this).val() == 'ver') { 
			jQuery('.grsMosaicHorLab').removeClass('animated flipInX').addClass('animated flipOutX');
			jQuery('.grsMosaicHorInp').removeClass('animated flipInX').addClass('animated flipOutX');
			setTimeout(function(){ 
				jQuery('.grsMosaicVerInp').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
				jQuery('.grsMosaicVerLab').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
				
				jQuery('.grsMosaicHorLab').css('display', 'none');
				jQuery('.grsMosaicHorInp').css('display', 'none');
				
				/*jQuery('.grsMaxColumnsCountLab').css('display', 'table-cell');
				jQuery('.grsMaxColumnsCountInp').css('display', 'table-cell');
				jQuery('.grsMosaicContWidthLab').css('display', 'none');
				jQuery('.grsMosaicContWidthInp').css('display', 'none');*/
			}, 500);
			
		}
		else {
			jQuery('.grsMosaicVerInp').removeClass('animated flipInX').addClass('animated flipOutX');
			jQuery('.grsMosaicVerLab').removeClass('animated flipInX').addClass('animated flipOutX');
			setTimeout(function(){ 
				jQuery('.grsMosaicHorLab').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
				jQuery('.grsMosaicHorInp').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
				
				jQuery('.grsMosaicVerLab').css('display', 'none');
				jQuery('.grsMosaicVerInp').css('display', 'none');
				
				/*jQuery('.grsMaxColumnsCountLab').css('display', 'none');
				jQuery('.grsMaxColumnsCountInp').css('display', 'none');
				jQuery('.grsMosaicContWidthLab').css('display', 'table-cell');
				jQuery('.grsMosaicContWidthInp').css('display', 'table-cell');*/
			}, 500);
		}
	});

    /*Change click action type*/
    function grsAddClickActionOptionEvent(viewPrefix){
        jQuery('body').on('change', '#'+viewPrefix+'ClickAction', function (e) {
            e.stopPropagation();
            if(jQuery(this).val() == 'openLink') {
                jQuery('#'+viewPrefix+'OpenLinkTargetLabel').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
                jQuery('#'+viewPrefix+'OpenLinkTarget').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
            }
            else {
                jQuery('#'+viewPrefix+'OpenLinkTargetLabel').removeClass('animated flipInX').addClass('animated flipOutX');
                jQuery('#'+viewPrefix+'OpenLinkTarget').removeClass('animated flipInX').addClass('animated flipOutX');
                setTimeout(function(){
                    jQuery('#'+viewPrefix+'OpenLinkTargetLabel').css('display', 'none');
                    jQuery('#'+viewPrefix+'OpenLinkTarget').css('display', 'none');
                }, 500);
            }
        });
    }
    grsAddClickActionOptionEvent('thumbnail');
    grsAddClickActionOptionEvent('fm');
    grsAddClickActionOptionEvent('masonry');
    grsAddClickActionOptionEvent('mosaic');
    grsAddClickActionOptionEvent('gal');

	/*Change album main view type*/
	jQuery('body').on('change', '#albMainView', function (e, type) { 	  
		e.stopPropagation();								
		var masMosType = (typeof type != 'undefined') ? type : 'ver';
		switch(jQuery(this).val()) {
			case 'Thumbnail':
				jQuery('.grsAlbMasMosTypeLab').removeClass('animated flipInX').addClass('animated flipOutX');
				jQuery('.grsAlbMasMosTypeInp').removeClass('animated flipInX').addClass('animated flipOutX');
				jQuery('.grsAlbVerLab').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
				jQuery('.grsAlbVerInp').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
				jQuery('.grsAlbHorLab').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
				jQuery('.grsAlbHorInp').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
				setTimeout(function(){
					jQuery('.grsAlbMasMosTypeLab').css('display', 'none');
					jQuery('.grsAlbMasMosTypeInp').css('display', 'none');
				}, 500);
			break;
			case 'Masonry':
				jQuery('.grsAlbMasMosTypeLab').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
				jQuery('.grsAlbMasMosTypeInp').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
				jQuery('#albMasMosType_'+masMosType).attr('checked', 'checked');
				jQuery('#albMasMosType_'+masMosType).trigger("change");
			break;
			case 'Mosaic':
				jQuery('.grsAlbMasMosTypeLab').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
				jQuery('.grsAlbMasMosTypeInp').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
				jQuery('#albMasMosType_'+masMosType).attr('checked', 'checked');
				jQuery('#albMasMosType_'+masMosType).trigger("change");
			break;
		}
	});
	/*Change album masonry mosaic type*/
	jQuery('body').on('change', 'input[name="albMasMosType"]', function (e) { 	  
		e.stopPropagation(); 
		if(jQuery(this).val() == 'ver') {
			jQuery('.grsAlbHorLab').removeClass('animated flipInX').addClass('animated flipOutX');
			jQuery('.grsAlbHorInp').removeClass('animated flipInX').addClass('animated flipOutX');
			setTimeout(function(){ 
				jQuery('.grsAlbVerInp').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
				jQuery('.grsAlbVerLab').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
				jQuery('.grsAlbHorLab').css('display', 'none');
				jQuery('.grsAlbHorInp').css('display', 'none');
			}, 500);
		}
		else {
			jQuery('.grsAlbVerInp').removeClass('animated flipInX').addClass('animated flipOutX');
			jQuery('.grsAlbVerLab').removeClass('animated flipInX').addClass('animated flipOutX');
			setTimeout(function(){ 
				jQuery('.grsAlbHorInp').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
				jQuery('.grsAlbHorLab').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
				jQuery('.grsAlbVerInp').css('display', 'none');
				jQuery('.grsAlbVerLab').css('display', 'none');
			}, 500);
		}
	});
	
	/*Change album gallery view type*/
	jQuery('body').on('change', '#albGalView', function (e, type) { 	  
		e.stopPropagation(); 
		var masMosType = (typeof type != 'undefined') ? type : 'ver';
		switch(jQuery(this).val()) {
			case 'Thumbnail':
				jQuery('.grsAlbGalMasMosTypeLab').removeClass('animated flipInX').addClass('animated flipOutX');
				jQuery('.grsAlbGalMasMosTypeInp').removeClass('animated flipInX').addClass('animated flipOutX');
				jQuery('.grsAlbGalVerLab').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
				jQuery('.grsAlbGalVerInp').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
				jQuery('.grsAlbGalHorLab').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
				jQuery('.grsAlbGalHorInp').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
				setTimeout(function(){
					jQuery('.grsAlbGalMasMosTypeLab').css('display', 'none');
					jQuery('.grsAlbGalMasMosTypeInp').css('display', 'none');
				}, 500);
			break;
			case 'Masonry':
				jQuery('.grsAlbGalMasMosTypeLab').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
				jQuery('.grsAlbGalMasMosTypeInp').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
				jQuery('#albGalMasMosType_'+masMosType).attr('checked', 'checked');
				jQuery('#albGalMasMosType_'+masMosType).trigger("change");
			break;
			case 'Mosaic':
				jQuery('.grsAlbGalMasMosTypeLab').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
				jQuery('.grsAlbGalMasMosTypeInp').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
				jQuery('#albGalMasMosType_'+masMosType).attr('checked', 'checked');
				jQuery('#albGalMasMosType_'+masMosType).trigger("change");
			break;
		}
	});
	/*Change album gallery masonry mosaic type*/
	jQuery('body').on('change', 'input[name="albGalMasMosType"]', function (e) { 	  
		e.stopPropagation(); 
		if(jQuery(this).val() == 'ver') {
			jQuery('.grsAlbGalHorLab').removeClass('animated flipInX').addClass('animated flipOutX');
			jQuery('.grsAlbGalHorInp').removeClass('animated flipInX').addClass('animated flipOutX');
			setTimeout(function(){ 
				jQuery('.grsAlbGalVerInp').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
				jQuery('.grsAlbGalVerLab').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
				jQuery('.grsAlbGalHorLab').css('display', 'none');
				jQuery('.grsAlbGalHorInp').css('display', 'none');
			}, 500);
		}
		else {
			jQuery('.grsAlbGalVerInp').removeClass('animated flipInX').addClass('animated flipOutX');
			jQuery('.grsAlbGalVerLab').removeClass('animated flipInX').addClass('animated flipOutX');
			setTimeout(function(){ 
				jQuery('.grsAlbGalHorInp').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
				jQuery('.grsAlbGalHorLab').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
				jQuery('.grsAlbGalVerInp').css('display', 'none');
				jQuery('.grsAlbGalVerLab').css('display', 'none');
			}, 500);
		}
	});
	
	/*Change masonry type*/
	jQuery('body').on('change', 'input[name="masonryType"]', function (e) { 	  
		e.stopPropagation(); 
		if(jQuery(this).val() == 'ver') { 
			
			jQuery('.grsMasonryHorLab').removeClass('animated flipInX').addClass('animated flipOutX');
			jQuery('.grsMasonryHorInp').removeClass('animated flipInX').addClass('animated flipOutX');
			setTimeout(function(){ 
				jQuery('.grsMasonryVerInp').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
				jQuery('.grsMasonryVerLab').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
				
				jQuery('.grsMasonryHorLab').css('display', 'none');
				jQuery('.grsMasonryHorInp').css('display', 'none');
				
				/*jQuery('.grsMasMaxColumnsCountLab').css('display', 'table-cell');
				jQuery('.grsMasMaxColumnsCountInp').css('display', 'table-cell');
				jQuery('.grsMasonryContWidthLab').css('display', 'none');
				jQuery('.grsMasonryContWidthInp').css('display', 'none');*/
				
			}, 500);
			
		}
		else {
			jQuery('.grsMasonryVerInp').removeClass('animated flipInX').addClass('animated flipOutX');
			jQuery('.grsMasonryVerLab').removeClass('animated flipInX').addClass('animated flipOutX');
			setTimeout(function(){ 
				
				jQuery('.grsMasonryHorLab').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
				jQuery('.grsMasonryHorInp').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
				
				jQuery('.grsMasonryVerLab').css('display', 'none');
				jQuery('.grsMasonryVerInp').css('display', 'none');
				
				/*jQuery('.grsMasMaxColumnsCountLab').css('display', 'none');
				jQuery('.grsMasMaxColumnsCountInp').css('display', 'none');
				jQuery('.grsMasonryContWidthLab').css('display', 'table-cell');
				jQuery('.grsMasonryContWidthInp').css('display', 'table-cell');*/
				
			}, 500);
		}
	});

	jQuery('body').on('change', 'input[name="lightboxContButts"]', function (e) { 	  
		e.stopPropagation(); 
		if(jQuery(this).val() == 0) { 
			jQuery('.grsLightboxFButtLab').removeClass('animated flipInX').addClass('animated flipOutX');
			jQuery('.grsLightboxFButtInp').removeClass('animated flipInX').addClass('animated flipOutX');
			jQuery('.grsLightboxGButtLab').removeClass('animated flipInX').addClass('animated flipOutX');
			jQuery('.grsLightboxGButtInp').removeClass('animated flipInX').addClass('animated flipOutX');
			jQuery('.grsLightboxTButtLab').removeClass('animated flipInX').addClass('animated flipOutX');
			jQuery('.grsLightboxTButtInp').removeClass('animated flipInX').addClass('animated flipOutX');
			jQuery('.grsLightboxPButtLab').removeClass('animated flipInX').addClass('animated flipOutX');
			jQuery('.grsLightboxPButtInp').removeClass('animated flipInX').addClass('animated flipOutX');
            jQuery('.grsLightboxTbButtLab').removeClass('animated flipInX').addClass('animated flipOutX');
            jQuery('.grsLightboxTbButtInp').removeClass('animated flipInX').addClass('animated flipOutX');
            jQuery('.grsLightboxLiButtLab').removeClass('animated flipInX').addClass('animated flipOutX');
            jQuery('.grsLightboxLiButtInp').removeClass('animated flipInX').addClass('animated flipOutX');
            jQuery('.grsLightboxReddButtLab').removeClass('animated flipInX').addClass('animated flipOutX');
            jQuery('.grsLightboxReddButtInp').removeClass('animated flipInX').addClass('animated flipOutX');
			jQuery('.grsLightboxFsButtLab').removeClass('animated flipInX').addClass('animated flipOutX');
			jQuery('.grsLightboxFsButtInp').removeClass('animated flipInX').addClass('animated flipOutX');
			jQuery('.grsLightboxAPLab').removeClass('animated flipInX').addClass('animated flipOutX');
			jQuery('.grsLightboxAPInp').removeClass('animated flipInX').addClass('animated flipOutX');
			jQuery('.grsLightboxImInfLab').removeClass('animated flipInX').addClass('animated flipOutX');
			jQuery('.grsLightboxImInfInp').removeClass('animated flipInX').addClass('animated flipOutX');
			jQuery('.grsLightboxAPinLab').removeClass('animated flipInX').addClass('animated flipOutX');
			jQuery('.grsLightboxAPinInp').removeClass('animated flipInX').addClass('animated flipOutX');
			setTimeout(function(){ 
				jQuery('.grsLightboxFButtLab').css('display', 'none');
				jQuery('.grsLightboxFButtInp').css('display', 'none');
				jQuery('.grsLightboxGButtLab').css('display', 'none');
				jQuery('.grsLightboxGButtInp').css('display', 'none');
				jQuery('.grsLightboxTButtLab').css('display', 'none');
				jQuery('.grsLightboxTButtInp').css('display', 'none');
				jQuery('.grsLightboxPButtLab').css('display', 'none');
                jQuery('.grsLightboxPButtInp').css('display', 'none');
                jQuery('.grsLightboxTbButtLab').css('display', 'none');
                jQuery('.grsLightboxTbButtInp').css('display', 'none');
                jQuery('.grsLightboxLiButtLab').css('display', 'none');
                jQuery('.grsLightboxLiButtInp').css('display', 'none');
                jQuery('.grsLightboxReddButtLab').css('display', 'none');
                jQuery('.grsLightboxReddButtInp').css('display', 'none');
				jQuery('.grsLightboxFsButtLab').css('display', 'none');
				jQuery('.grsLightboxFsButtInp').css('display', 'none');	
				jQuery('.grsLightboxAPLab').css('display', 'none');
				jQuery('.grsLightboxAPInp').css('display', 'none');				
				jQuery('.grsLightboxImInfLab').css('display', 'none');
				jQuery('.grsLightboxImInfInp').css('display', 'none');
				jQuery('.grsLightboxAPinLab').css('display', 'none');
				jQuery('.grsLightboxAPinInp').css('display', 'none');
			}, 500);
		}
		else {
			jQuery('.grsLightboxFButtLab').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
			jQuery('.grsLightboxFButtInp').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
			jQuery('.grsLightboxGButtLab').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
			jQuery('.grsLightboxGButtInp').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
			jQuery('.grsLightboxTButtLab').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
			jQuery('.grsLightboxTButtInp').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
			jQuery('.grsLightboxPButtLab').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
			jQuery('.grsLightboxPButtInp').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
            jQuery('.grsLightboxTbButtLab').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
            jQuery('.grsLightboxTbButtInp').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
            jQuery('.grsLightboxLiButtLab').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
            jQuery('.grsLightboxLiButtInp').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
            jQuery('.grsLightboxReddButtLab').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
            jQuery('.grsLightboxReddButtInp').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
			jQuery('.grsLightboxFsButtLab').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
			jQuery('.grsLightboxFsButtInp').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
			jQuery('.grsLightboxAPLab').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
			jQuery('.grsLightboxAPInp').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
			jQuery('.grsLightboxImInfLab').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
			jQuery('.grsLightboxImInfInp').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
			jQuery('.grsLightboxAPinLab').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
			jQuery('.grsLightboxAPinInp').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
		}
	});
	jQuery('body').on('change', 'input[name="lightboxFullW"]', function (e) { 	  
		e.stopPropagation(); 
		if(jQuery(this).val() == 1) {
			jQuery('.grsLightboxWidthLab').removeClass('animated flipInX').addClass('animated flipOutX');
			jQuery('.grsLightboxWidthInp').removeClass('animated flipInX').addClass('animated flipOutX');
			jQuery('.grsLightboxHeightLab').removeClass('animated flipInX').addClass('animated flipOutX');
			jQuery('.grsLightboxHeightInp').removeClass('animated flipInX').addClass('animated flipOutX');
			setTimeout(function(){ 
				jQuery('.grsLightboxWidthLab').css('display', 'none');
				jQuery('.grsLightboxWidthInp').css('display', 'none');
				jQuery('.grsLightboxHeightLab').css('display', 'none');
				jQuery('.grsLightboxHeightInp').css('display', 'none');
			}, 500);
		} else {
			jQuery('.grsLightboxWidthLab').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
			jQuery('.grsLightboxWidthInp').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
			jQuery('.grsLightboxHeightLab').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
			jQuery('.grsLightboxHeightInp').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
		}
	});
	jQuery('body').on('change', 'input[name="lightboxAP"]', function (e) { 	  
		e.stopPropagation(); 
		if(jQuery(this).val() == 0) {
			jQuery('.grsLightboxAPinLab').removeClass('animated flipInX').addClass('animated flipOutX');
			jQuery('.grsLightboxAPinInp').removeClass('animated flipInX').addClass('animated flipOutX');
			setTimeout(function(){ 
				jQuery('.grsLightboxAPinLab').css('display', 'none');
				jQuery('.grsLightboxAPinInp').css('display', 'none');
			}, 500);
		} else {
			jQuery('.grsLightboxAPinLab').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
			jQuery('.grsLightboxAPinInp').css('display', 'table-cell').removeClass('animated flipOutX').addClass('animated flipInX');
		}
	});
	/*Show Gallery/Albums titles container*/
	jQuery('body').on('click', '.grsGall, .grsAlb', function (e) { 	  
		e.stopPropagation(); 
		var galCk = jQuery(this).hasClass("grsGall"),
			clN = (galCk) ? '.grsGallTitlesCont' : '.grsAlbTitlesCont',
			tCont = jQuery(clN),
			dis = tCont.css('display'),
			trIn = (galCk) ? 'fadeInLeft' : 'fadeInRight',
			trOut = (galCk) ? 'fadeOutLeft' : 'fadeOutRight';
		if(dis == 'block') { 
			tCont.removeClass('animated '+ trIn).addClass('animated '+ trOut);
			setTimeout(function(){ 
				tCont.css('display', 'none');
			}, 500);
		}
		else {
			tCont.css('display', 'block');
			tCont.removeClass('animated '+ trOut).addClass('animated '+ trIn);
		}
	});
	
	jQuery('body').on('click', '.grsTheme', function (e) { 	  
		e.stopPropagation(); 
		var tCont = jQuery('.grsThemeNamesCont'),
			dis = tCont.css('display');
		if(dis == 'block') { 
			tCont.removeClass('animated fadeInUp').addClass('animated fadeOutDown');
			setTimeout(function(){ 
				tCont.css('display', 'none');
			}, 500);
		}
		else {
			tCont.css('display', 'block');
			tCont.removeClass('animated fadeOutDown').addClass('animated fadeInUp');
		}
	});
	
	/*Show lightbox params*/
	jQuery('body').on('click', '.grsLightbox', function (e) { 	  
		e.stopPropagation(); 
		var display = jQuery('.grsLightboxParamsCont').css('display');
		var grsLightboxParamsCont = jQuery('.grsLightboxParamsCont');
	
		if(display == 'block') { 
			grsLightboxParamsCont.removeClass('animated fadeInRight').addClass('animated fadeOutRight');
			setTimeout(function(){ 
				jQuery('.grsLightboxParamsCont').css('display', 'none');
			}, 500);
		}
		else {
			jQuery('.grsLightboxParamsCont').css('display', 'block');
			grsLightboxParamsCont.removeClass('animated fadeOutRight').addClass('animated fadeInRight');
		}
	});
	
	/*Insert shortcode*/
	jQuery('body').on('click', '.grsOk', function (e) { 	
		var editor = window.parent.tinyMCE.activeEditor,
			data = '[GRS ', 
			/*Store id and view type*/
			grsView = jQuery('.grsViewSelected').attr('grsview'),
			grsTheme = jQuery('.grsThemeSelected').attr('grsthemeid'),
			grsSel = (grsView == "Album") ? jQuery('.grsAlbSelected') : jQuery('.grsGallSelected'),
			grsAt = (grsView == "Album") ? "grsalbid" : "grsgallid",
			grsId = grsSel.attr(grsAt),
			lightbox = true;
		data += 'id="' + grsId + '"';
		data += ' view="' + grsView + '"';
		data += ' theme="' + grsTheme + '"';
		/*Get selected view params*/
		switch(grsView) {
			case 'Thumbnail' : 
				data += ' width="' + jQuery('#thumbnailWidth').val() + '"';
				data += ' height="' + jQuery('#thumbnailHeight').val() + '"';
				data += ' contWidth="' + jQuery('#thumbnailContWidth').val() + '"';
				data += ' imagesPerpage="' + jQuery('#thumbnailImagesPerpage').val() + '"';
				/*data += ' maxColumnsCount="' + jQuery('#thumbnailMaxColumnsCount').val() + '"';*/
				data += ' pagination="' + jQuery('#thumbnailPagination').val() + '"';										
				data += ' title="' + jQuery('#thumbnailTitle').val() + '"';		
				data += ' orderBy="' + jQuery('#thumbnailOrderBy').val() + '"';										
				data += ' ordering="' + jQuery('#thumbnailOrdering').val() + '"';
                data += ' polaroid="' + jQuery('input[name=thumbnailPolaroid]:checked').val() + '"';
                data += ' clickAction="' + jQuery('#thumbnailClickAction').val() + '"';
                data += ' openLinkTarget="' + jQuery('#thumbnailOpenLinkTarget').val() + '"';
				break;
			case 'Masonry' :
				data += ' width="' + jQuery('#masonryWidth').val() + '"';
				data += ' height="' + jQuery('#masonryHeight').val() + '"';
				data += ' contWidth="' + jQuery('#masonryContWidth').val() + '"';
				data += ' imagesPerpage="' + jQuery('#masonryImagesPerpage').val() + '"';
				/*data += ' maxColumnsCount="' + jQuery('#masonryMaxColumnsCount').val() + '"';*/
				data += ' type="' + jQuery('input[name=masonryType]:checked').val() + '"';
				data += ' pagination="' + jQuery('#masonryPagination').val() + '"';
				data += ' title="' + jQuery('#masonryTitle').val() + '"';
				data += ' orderBy="' + jQuery('#masonryOrderBy').val() + '"';
				data += ' ordering="' + jQuery('#masonryOrdering').val() + '"';
                data += ' clickAction="' + jQuery('#masonryClickAction').val() + '"';
                data += ' openLinkTarget="' + jQuery('#masonryOpenLinkTarget').val() + '"';
				break;
			case 'Mosaic' :
				data += ' width="' + jQuery('#mosaicWidth').val() + '"';
				data += ' height="' + jQuery('#mosaicHeight').val() + '"';
				data += ' contWidth="' + jQuery('#mosaicContWidth').val() + '"';
				data += ' imagesPerpage="' + jQuery('#mosaicImagesPerpage').val() + '"';
				/*data += ' maxColumnsCount="' + jQuery('#mosaicMaxColumnsCount').val() + '"';*/
				data += ' type="' + jQuery('input[name=mosaicType]:checked').val() + '"';
				data += ' pagination="' + jQuery('#mosaicPagination').val() + '"';
				data += ' title="' + jQuery('#mosaicTitle').val() + '"';
				data += ' orderBy="' + jQuery('#mosaicOrderBy').val() + '"';
				data += ' ordering="' + jQuery('#mosaicOrdering').val() + '"';
                data += ' clickAction="' + jQuery('#mosaicClickAction').val() + '"';
                data += ' openLinkTarget="' + jQuery('#mosaicOpenLinkTarget').val() + '"';
				break;
			case 'Film' :
				data += ' width="' + jQuery('#fmWidth').val() + '"';
				data += ' height="' + jQuery('#fmHeight').val() + '"';
				data += ' contWidth="' + jQuery('#fmContWidth').val() + '"';
				data += ' imagesPerpage="' + jQuery('#fmImagesPerpage').val() + '"';
				data += ' nav="' + jQuery('#fmNav').val() + '"';
				data += ' title="' + jQuery('#fmTitle').val() + '"';
				data += ' orderBy="' + jQuery('#fmOrderBy').val() + '"';
				data += ' ordering="' + jQuery('#fmOrdering').val() + '"';
                data += ' clickAction="' + jQuery('#fmClickAction').val() + '"';
                data += ' openLinkTarget="' + jQuery('#fmOpenLinkTarget').val() + '"';
				break;
			case 'Slideshow' :
				data += ' width="' + jQuery('#slideshowWidth').val() + '"';
				data += ' height="' + jQuery('#slideshowHeight').val() + '"';
				data += ' filmstrip="' + jQuery('input[name=slideshowFilmstrip]:checked').val() + '"';
				data += ' comment="' + jQuery('input[name=slideshowComment]:checked').val() + '"';
				data += ' effect="' + jQuery('#slideshowEffect').val() + '"';
				data += ' filmstripPos="' + jQuery('#slideshowFilmstripPos').val() + '"';
				lightbox = false;
				break;
			case 'Album' :
				data += ' width="' + jQuery('#albWidth').val() + '"';
				data += ' height="' + jQuery('#albHeight').val() + '"';
				data += ' contWidth="' + jQuery('#albContWidth').val() + '"';
				data += ' mainView="' + jQuery('#albMainView').val() + '"';
				data += ' masMostype="' + jQuery('input[name=albMasMosType]:checked').val() + '"';
				data += ' title="' + jQuery('#albTitle').val() + '"';
				data += ' orderBy="' + jQuery('#albOrderBy').val() + '"';
				data += ' ordering="' + jQuery('#albOrdering').val() + '"';
				data += ' galView="' + jQuery('#albGalView').val() + '"';
				data += ' galMasMostype="' + jQuery('input[name=albGalMasMosType]:checked').val() + '"';
				data += ' galWidth="' + jQuery('#albGalWidth').val() + '"';
				data += ' galHeight="' + jQuery('#albGalHeight').val() + '"';
				data += ' galContWidth="' + jQuery('#galContWidth').val() + '"';
				data += ' galTitle="' + jQuery('#galTitle').val() + '"';
				data += ' galOrderBy="' + jQuery('#galOrderBy').val() + '"';
				data += ' galOrdering="' + jQuery('#galOrdering').val() + '"';
				data += ' imagesPerpage="' + jQuery('#albPerpage').val() + '"';
				data += ' pagination="' + jQuery('#albPagination').val() + '"';
                data += ' galClickAction="' + jQuery('#galClickAction').val() + '"';
                data += ' galOpenLinkTarget="' + jQuery('#galOpenLinkTarget').val() + '"';
				break;
			default :
				break;
		}

		/*Store lightbox params*/
		if(lightbox) {
			data += ' lightboxWidth="' + jQuery('#lightboxWidth').val() + '"';
			data += ' lightboxHeight="' + jQuery('#lightboxHeight').val() + '"';
			data += ' lightboxFilmstrip="' + jQuery('input[name=lightboxFilmstrip]:checked').val() + '"';
			data += ' lightboxComment="' + jQuery('input[name=lightboxComment]:checked').val() + '"';
			data += ' lightboxContButts="' + jQuery('input[name=lightboxContButts]:checked').val() + '"';
			data += ' lightboxFullW="' + jQuery('input[name=lightboxFullW]:checked').val() + '"';
			data += ' lightboxFButt="' + jQuery('input[name=lightboxFButt]:checked').val() + '"';
			data += ' lightboxGButt="' + jQuery('input[name=lightboxGButt]:checked').val() + '"';
			data += ' lightboxTButt="' + jQuery('input[name=lightboxTButt]:checked').val() + '"';
			data += ' lightboxPButt="' + jQuery('input[name=lightboxPButt]:checked').val() + '"';
			data += ' lightboxTbButt="' + jQuery('input[name=lightboxTbButt]:checked').val() + '"';
            data += ' lightboxLiButt="' + jQuery('input[name=lightboxLiButt]:checked').val() + '"';
            data += ' lightboxReddButt="' + jQuery('input[name=lightboxReddButt]:checked').val() + '"';
			data += ' lightboxFsButt="' + jQuery('input[name=lightboxFsButt]:checked').val() + '"';
			data += ' lightboxAP="' + jQuery('input[name=lightboxAP]:checked').val() + '"';
			data += ' lightboxAPin="' + jQuery('#lightboxAPin').val() + '"';
			data += ' lightboxImInf="' + jQuery('input[name=lightboxImInf]:checked').val() + '"';
			data += ' lightboxSwipe="' + jQuery('input[name=lightboxSwipe]:checked').val() + '"';
			data += ' lightboxImCn="' + jQuery('input[name=lightboxImCn]:checked').val() + '"';
			data += ' lightboxEffect="' + jQuery('#lightboxEffect').val() + '"';
		}
		data += ']';
        window.parent.send_to_editor(data);
        if(editor)
            editor.windowManager.close();
        	// editor.execCommand('mceInsertContent', false, data);
	});

	/*Update shortcode*/
	if(task === 'update') {
		var lightbox = true,
			grsView = data['view'],
			grsId = data['id'],
			grsTheme = data['theme'],
			grsTitle = (grsView === "Album") ? "grsalbid" : "grsgallid",
			grsType = (grsView === "Album") ? ".grsAlb" : ".grsGall";
		jQuery( "li["+grsTitle+"='"+ grsId +"']" ).trigger( "click" );
		jQuery( "li[grsthemeid='"+ grsTheme +"']" ).trigger( "click" );
		jQuery(grsType).trigger( "click" );
		jQuery( "div[grsview='"+ grsView +"']" ).trigger( "click" );
		switch(grsView) {
			case 'Thumbnail' :
				jQuery('#thumbnailWidth').val(data['width']);
				jQuery('#thumbnailHeight').val(data['height']);
				jQuery('#thumbnailContWidth').val(data['contWidth']);
				jQuery('#thumbnailImagesPerpage').val(data['imagesPerpage']);
				jQuery("#thumbnailPagination option[value='"+ data['pagination'] +"']" ).prop('selected', true);
				jQuery("#thumbnailTitle option[value='"+ data['title'] +"']" ).prop('selected', true);
				jQuery("#thumbnailOrderBy option[value='"+ data['orderBy'] +"']" ).prop('selected', true);
				jQuery("#thumbnailOrdering option[value='"+ data['ordering'] +"']" ).prop('selected', true);
                jQuery('#thumbnailPolaroid_' + data['polaroid']).attr('checked', 'checked');
                jQuery("#thumbnailClickAction option[value='"+ data['clickAction'] +"']" ).prop('selected', true);
                jQuery('#thumbnailClickAction').trigger("change");
                jQuery("#thumbnailOpenLinkTarget option[value='"+ data['openLinkTarget'] +"']" ).prop('selected', true);
                break;
			case 'Masonry' :
				jQuery('#masonryWidth').val(data['width']);
				jQuery('#masonryHeight').val(data['height']);
				jQuery('#masonryContWidth').val(data['contWidth']);
				jQuery('#masonryImagesPerpage').val(data['imagesPerpage']);
				/*jQuery('#masonryMaxColumnsCount').val(data['maxColumnsCount']);*/
				jQuery('#masonryType_' + data['type']).attr('checked', 'checked');
				jQuery('#masonryType_' + data['type']).trigger("change");
				jQuery("#masonryPagination option[value='"+ data['pagination'] +"']" ).prop('selected', true);
				jQuery("#masonryTitle option[value='"+ data['title'] +"']" ).prop('selected', true);
				jQuery("#masonryOrderBy option[value='"+ data['orderBy'] +"']" ).prop('selected', true);
				jQuery("#masonryOrdering option[value='"+ data['ordering'] +"']" ).prop('selected', true);
                jQuery("#masonryClickAction option[value='"+ data['clickAction'] +"']" ).prop('selected', true);
                jQuery('#masonryClickAction').trigger("change");
                jQuery("#masonryOpenLinkTarget option[value='"+ data['openLinkTarget'] +"']" ).prop('selected', true);
				break;
			case 'Mosaic' :
				jQuery('#mosaicWidth').val(data['width']);
				jQuery('#mosaicHeight').val(data['height']);
				jQuery('#mosaicContWidth').val(data['contWidth']);
				jQuery('#mosaicImagesPerpage').val(data['imagesPerpage']);
				/*jQuery('#mosaicMaxColumnsCount').val(data['maxColumnsCount']);*/
				jQuery('#mosaicType_' + data['type']).attr('checked', 'checked');
				jQuery('#mosaicType_' + data['type']).trigger("change");
				jQuery("#mosaicPagination option[value='"+ data['pagination'] +"']" ).prop('selected', true);
				jQuery("#mosaicTitle option[value='"+ data['title'] +"']" ).prop('selected', true);
				jQuery("#mosaicOrderBy option[value='"+ data['orderBy'] +"']" ).prop('selected', true);
				jQuery("#mosaicOrdering option[value='"+ data['ordering'] +"']" ).prop('selected', true);
                jQuery("#mosaicClickAction option[value='"+ data['clickAction'] +"']" ).prop('selected', true);
                jQuery('#mosaicClickAction').trigger("change");
                jQuery("#mosaicOpenLinkTarget option[value='"+ data['openLinkTarget'] +"']" ).prop('selected', true);
				break;
			case 'Film' :
				jQuery('#fmWidth').val(data['width']);
				jQuery('#fmHeight').val(data['height']);
				jQuery('#fmContWidth').val(data['contWidth']);
				jQuery('#fmImagesPerpage').val(data['imagesPerpage']);
				jQuery("#fmNav option[value='"+ data['nav'] +"']" ).prop('selected', true);
				jQuery("#fmTitle option[value='"+ data['title'] +"']" ).prop('selected', true);
				jQuery("#fmOrderBy option[value='"+ data['orderBy'] +"']" ).prop('selected', true);
				jQuery("#fmOrdering option[value='"+ data['ordering'] +"']" ).prop('selected', true);
                jQuery("#fmClickAction option[value='"+ data['clickAction'] +"']" ).prop('selected', true);
                jQuery('#fmClickAction').trigger("change");
                jQuery("#fmOpenLinkTarget option[value='"+ data['openLinkTarget'] +"']" ).prop('selected', true);
				break;
			case 'Slideshow' : 
				jQuery('#slideshowWidth').val(data['width']);
				jQuery('#slideshowHeight').val(data['height']);
				jQuery('#slideshowFilmstrip_' + data['filmstrip']).attr('checked', 'checked');
				jQuery('#slideshowComment_' + data['comment']).attr('checked', 'checked');
				jQuery("#slideshowEffect option[value='"+ data['effect'] +"']" ).prop('selected', true);
				jQuery("#slideshowFilmstripPos option[value='"+ data['filmstripPos'] +"']" ).prop('selected', true);
				lightbox = false;
				break;

			case 'Album' : 
				jQuery('#albWidth').val(data['width']);
				jQuery('#albHeight').val(data['height']);
				jQuery('#albContWidth').val(data['contWidth']);
				jQuery("#albMainView option[value='"+ data['mainView'] +"']" ).prop('selected', true);
				jQuery("#albMainView option[value='"+ data['mainView'] +"']" ).trigger("change", data['masMostype']);
				jQuery("#albTitle option[value='"+ data['title'] +"']" ).prop('selected', true);
				jQuery("#albOrderBy option[value='"+ data['orderBy'] +"']" ).prop('selected', true);	
				jQuery("#albOrdering option[value='"+ data['ordering'] +"']" ).prop('selected', true);
				jQuery("#albGalView option[value='"+ data['galView'] +"']" ).prop('selected', true);
				jQuery("#albGalView option[value='"+ data['galView'] +"']" ).trigger("change", data['galMasMostype']);
				jQuery('#albGalWidth').val(data['galWidth']);
				jQuery('#albGalHeight').val(data['galHeight']);
				jQuery('#galContWidth').val(data['galContWidth']);
				jQuery("#galTitle option[value='"+ data['galTitle'] +"']" ).prop('selected', true);
				jQuery("#galOrderBy option[value='"+ data['galOrderBy'] +"']" ).prop('selected', true);	
				jQuery("#galOrdering option[value='"+ data['galOrdering'] +"']" ).prop('selected', true);
				jQuery('#albPerpage').val(data['imagesPerpage']);
				jQuery("#albPagination option[value='"+ data['pagination'] +"']" ).prop('selected', true);
                jQuery("#galClickAction option[value='"+ data['galClickAction'] +"']" ).prop('selected', true);
                jQuery('#galClickAction').trigger("change");
                jQuery("#galOpenLinkTarget option[value='"+ data['galOpenLinkTarget'] +"']" ).prop('selected', true);
				break;
			default :
				break; 
		}
		
		if(lightbox) { 
			jQuery('#lightboxWidth').val(data['lightboxWidth']);
			jQuery('#lightboxHeight').val(data['lightboxHeight']);
			jQuery('#lightboxFilmstrip_' + data['lightboxFilmstrip']).attr('checked', 'checked');
			jQuery('#lightboxComment_' + data['lightboxComment']).attr('checked', 'checked');
			jQuery('#lightboxContButts_' + data['lightboxContButts']).attr('checked', 'checked');
			jQuery('#lightboxContButts_' + data['lightboxContButts']).trigger("change", data['lightboxContButts']);
			jQuery('#lightboxFullW_' + data['lightboxFullW']).attr('checked', 'checked');
			jQuery('#lightboxFullW_' + data['lightboxFullW']).trigger("change", data['lightboxFullW']);
			jQuery('#lightboxFButt_' + data['lightboxFButt']).attr('checked', 'checked');
			jQuery('#lightboxGButt_' + data['lightboxGButt']).attr('checked', 'checked');
			jQuery('#lightboxTButt_' + data['lightboxTButt']).attr('checked', 'checked');
			jQuery('#lightboxPButt_' + data['lightboxPButt']).attr('checked', 'checked');
            jQuery('#lightboxTbButt_' + data['lightboxTbButt']).attr('checked', 'checked');
            jQuery('#lightboxLiButt_' + data['lightboxLiButt']).attr('checked', 'checked');
            jQuery('#lightboxReddButt_' + data['lightboxReddButt']).attr('checked', 'checked');
			jQuery('#lightboxFsButt_' + data['lightboxFsButt']).attr('checked', 'checked');
			jQuery('#lightboxAP_' + data['lightboxAP']).attr('checked', 'checked');
			jQuery('#lightboxAP_' + data['lightboxAP']).trigger("change", data['lightboxAP']);
			jQuery('#lightboxAPin').val((typeof data['lightboxAPin'] == 'undefined' ? 3 : data['lightboxAPin']));
			jQuery('#lightboxImInf_' + data['lightboxImInf']).attr('checked', 'checked');
			jQuery('#lightboxSwipe_' + data['lightboxSwipe']).attr('checked', 'checked');
			jQuery('#lightboxImCn_' + data['lightboxImCn']).attr('checked', 'checked');
			jQuery("#lightboxEffect option[value='"+ data['lightboxEffect'] +"']" ).prop('selected', true);
		}
	}
})

function grsFirstToUpperCase( str ) {
	return str.substr(0, 1).toUpperCase() + str.substr(1);
}