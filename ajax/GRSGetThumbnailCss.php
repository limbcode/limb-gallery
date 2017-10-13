<?php
/**
 * LIMB gallery
 * Get Thumbnail CSS
 */

class GRSGetThumbnailCss {
	// Costructor
	public function __construct() {				
	}
	public function get_($id, $grsTheme) {
		$thumbnail = ".grsTemplate".$id." .grsThImFrCont {
			display: block;
			max-width: 100%;
			position: absolute;
			box-sizing: content-box;
			background-color: ".$grsTheme->thumbnailBgColor.";
			box-shadow: ".$grsTheme->thumbnailBoxshadowFstVal."px ".$grsTheme->thumbnailBoxshadowSecVal."px ".$grsTheme->thumbnailBoxshadowThdVal."px ".$grsTheme->thumbnailBoxshadowColor.";
			border: ".$grsTheme->thumbnailBorderWidth."px ".$grsTheme->thumbnailBorderStyle." ".$grsTheme->thumbnailBorderColor.";
			border-radius: ".$grsTheme->thumbnailBorderRadius."px !important;
			padding: ".$grsTheme->thumbnailpadding."px;
			overflow: hidden;
		}
		.grsTemplate".$id." .grsThImFrCont {
			display: block;
			max-width: 100%;
			position: absolute;
			box-sizing: content-box;
			background-color: ".$grsTheme->thumbnailBgColor.";
			box-shadow: ".$grsTheme->thumbnailBoxshadowFstVal."px ".$grsTheme->thumbnailBoxshadowSecVal."px ".$grsTheme->thumbnailBoxshadowThdVal."px ".$grsTheme->thumbnailBoxshadowColor.";
			border: ".$grsTheme->thumbnailBorderWidth."px ".$grsTheme->thumbnailBorderStyle." ".$grsTheme->thumbnailBorderColor.";
			border-radius: ".$grsTheme->thumbnailBorderRadius."px !important;
			padding: ".$grsTheme->thumbnailpadding."px;
			overflow: hidden;";
		switch($grsTheme->thumbnailHoverEffect) {
			case 'scale':
			case 'rotate':
				$thumbnail .= "-webkit-transition: 0.1s transform linear, 0.5s left linear, 0.5s top linear, 0.5s width linear, 0.5s height linear;
					-ms-transition: 0.1s transform linear, 0.5s left linear, 0.5s top linear, 0.5s width linear, 0.5s height linear;
						transition: 0.1s transform linear, 0.5s left linear, 0.5s top linear, 0.5s width linear, 0.5s height linear;";
			break;
			case 'grayscale':
				$thumbnail .= "-webkit-transition: 0.5s ease-in-out;
						transition: 0.5s ease-in-out;
				-webkit-filter: grayscale(100%);
						filter: grayscale(100%);";
			break;
			case 'blur':
				$thumbnail .= "-webkit-filter: grayscale(0) blur(0);
						filter: grayscale(0) blur(0);
				-webkit-transition: 0.5s ease-in-out;
						transition: 0.5s ease-in-out";
			break;
			case 'sepia':
				$thumbnail .= "-webkit-filter: sepia(100%);
						filter: sepia(100%);
				-webkit-transition: 0.5s ease-in-out;
						transition: 0.5s ease-in-out;";
			break;
			case 'flash':
			case 'shine':
			case 'circle':
			default:
				$thumbnail .= "-webkit-transition: 0.5s left linear, 0.5s top linear,  0.5s width linear, 0.5s height linear;
					-ms-transition: 0.5s left linear, 0.5s top linear,  0.5s width linear, 0.5s height linear;
						transition: 0.5s left linear, 0.5s top linear,  0.5s width linear, 0.5s height linear;";
			break;
		}
		$thumbnail .= "}";

		if($grsTheme->thumbnailHoverEffect == 'shine') {
			$thumbnail .= ".grsTemplate".$id." .grsThImFrCont::before {
				position: absolute;
				top: 0;
				left: -75%;
				z-index: 2;
				display: block;
				content: '';
				width: 50%;
				height: 100%;
				background: -webkit-linear-gradient(left, rgba(255,255,255,0) 0%, rgba(255,255,255,.3) 100%);
				background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,.3) 100%);
				-webkit-transform: skewX(-25deg);
				transform: skewX(-25deg);
			}
			.grsTemplate".$id." .grsThImFrCont:hover::before {
				-webkit-animation: shine .75s;
						animation: shine .75s;
			}";
		} elseif($grsTheme->thumbnailHoverEffect == 'circle') {
			$thumbnail .= ".grsTemplate".$id." .grsThImFrCont::before {
				position: absolute;
				top: 50%;
				left: 50%;
				z-index: 2;
				display: block;
				content: '';
				width: 0;
				height: 0;
				background: rgba(255,255,255,.2);
				border-radius: 100%;
				-webkit-transform: translate(-50%, -50%);
				transform: translate(-50%, -50%);
				opacity: 0;
			}
			.grsTemplate".$id." .grsThImFrCont:hover::before {
				-webkit-animation: circle .75s;
						animation: circle .75s;
			}";
		}
		$thumbnail .= ".grsTemplate".$id." .grsThImFrCont:hover {"; 
				switch($grsTheme->thumbnailHoverEffect) {
					case 'scale':
						$thumbnail .= "-webkit-transform: scale(1.1);
							               -ms-transform: scale(1.1);
								               transform: scale(1.1);
						                z-index: 2;";
					break;
					case 'rotate':
						$thumbnail .= "-webkit-transform: rotate(3.5deg);
							               -ms-transform: rotate(3.5deg);
								               transform: rotate(3.5deg);
							            z-index: 2;";
					break;
					case 'grayscale':
						$thumbnail .= "-webkit-filter: grayscale(0);
							                   filter: grayscale(0);";
					break;
					case 'blur':
						$thumbnail .= "-webkit-filter: grayscale(100%) blur(1px);
							                   filter: grayscale(100%) blur(1px);";
					break;
					case 'sepia':
						$thumbnail .= "-webkit-filter: sepia(0);
							                   filter: sepia(0);";
					break;
					case 'flash':
						$thumbnail .= "opacity: 1;
						               -webkit-animation: flash 1.5s;
								               animation: flash 1.5s;";
					break;
					case 'shine':
					break;
					case 'circle':
					break;
					default:
					break;
				}
			
		$thumbnail .= "}";
		$thumbnail .= ".grsTemplate".$id." .grsThImFrCont.pol {
            -webkit-transition: 0.2s transform linear;
				-ms-transition: 0.2s transform linear;
					transition: 0.2s transform linear;
		}
		.grsTemplate".$id." .grsThImFrCont.pol.pol_0 {
		    -webkit-transform: rotate(3deg) scale(1.0);
		        -ms-transform: rotate(3deg) scale(1.0); 
		            transform: rotate(3deg) scale(1.0);
		}
		.grsTemplate".$id." .grsThImFrCont.pol.pol_1 {
		    -webkit-transform: rotate(-3deg) scale(1.0);
		        -ms-transform: rotate(-3deg) scale(1.0); 
		            transform: rotate(-3deg) scale(1.0);
		}
		.grsTemplate".$id." .grsThImFrCont.pol.pol_2 {
		    -webkit-transform: rotate(0deg) scale(1.0);
		        -ms-transform: rotate(0deg) scale(1.0); 
		            transform: rotate(0deg) scale(1.0);
		}
		.grsTemplate".$id." .grsThImFrCont.pol:hover  {
		    -webkit-transform: rotate(0deg) scale(1.12);
		        -ms-transform: rotate(0deg) scale(1.12); 
		            transform: rotate(0deg) scale(1.12);
		}
		.grsTemplate".$id." .grsThImFrCont > .grsImsBox {
		    overflow: hidden;
		    text-decoration: none;
		    box-shadow: none;
		    border: none;
		    outline: none;
		    z-index: 1;
		}
		.grsTemplate".$id." .grsThImFrCont > .grsImsBox > .grsImsMainC {
			position: relative;
		    height: 100%;
		    width: 100%;
		    overflow: hidden;
		}
		.grsTemplate".$id." .grsThImFrCont > .grsImsBox > .grsImsMainC > .grsImSecCont {
			background-size: cover;
			border-radius: ".$grsTheme->thumbnailBorderRadius."px !important;
			background-position: center;
			overflow: hidden;
			width: inherit;
			height: inherit;
			-webkit-transition: 0.3s transform ease-in-out;
			transition: 0.3s transform ease-in-out;";
			switch($grsTheme->thumbnailHoverEffect) {
				case 'scaleIm':
					$thumbnail .= "-webkit-transform: scale3d(1,1,1);
						-ms-transform: scale3d(1,1,1);
							transform: scale3d(1,1,1);";
				break;
				case 'scaleRotIm':
					$thumbnail .= "-webkit-transform: scale3d(1,1,1) rotate(0deg);
						-ms-transform: scale3d(1,1,1) rotate(0deg);
							transform: scale3d(1,1,1) rotate(0deg);";
				break;
				case 'scaleTransIm':
					$thumbnail .= "-webkit-transform: scale3d(1,1,1) translate(0px);
						-ms-transform: scale3d(1,1,1) translate(0px);
							transform: scale3d(1,1,1) translate(0px);";
				break;
				default:
				break;
			}
		$thumbnail .= "}";
		$thumbnail .= ".grsTemplate".$id." .grsThImFrCont:hover > .grsImsBox > .grsImsMainC > .grsImSecCont {";
		switch($grsTheme->thumbnailHoverEffect) {
			case 'scaleIm':
				$thumbnail .= "-webkit-transform: scale3d(1.2, 1.2, 1.2);
					-ms-transform: scale3d(1.2, 1.2, 1.2);
						transform: scale3d(1.2, 1.2, 1.2);";
			break;
			case 'scaleRotIm':
				$thumbnail .= "-webkit-transform: scale3d(1.2, 1.2, 1.2) rotate(5deg);
					-ms-transform: scale3d(1.2, 1.2, 1.2) rotate(5deg);
						transform: scale3d(1.2, 1.2, 1.2) rotate(5deg);";
			break;
			case 'scaleTransIm':
				$thumbnail .= "-webkit-transform: scale3d(1.2, 1.2, 1.2) translate(15px);
					-ms-transform: scale3d(1.2, 1.2, 1.2) translate(15px);
						transform: scale3d(1.2, 1.2, 1.2) translate(15px);";
			break;
			default:
			break;
		}
		$thumbnail .= "}";
		$thumbnail .= ".grsTemplate".$id." .grsThImFrCont > .grsImsBox > .grsImsMainC > .grsMask  {
			overflow: hidden;
			width: 100%;
			height: 100%;
			position: absolute;
			top: 0px;
			left: 0px;
			z-index: 2;
		}
		.grsTemplate".$id." .grsThImFrCont > .grsImsBox > .grsImsMainC > .grsThTitleC {
			background-color: ".$grsTheme->thumbnailTBgcolor.";
			padding: ".$grsTheme->thumbnailTpadding."px;
			border-radius: ".$grsTheme->thumbnailBorderRadius."px !important;
			box-sizing: border-box;
			position: absolute;
			overflow: hidden;
			height: 100%;
			width: 100%;
			left: 0px;
			top: 0px;
			z-index: 2;
			-webkit-animation-duration: 1s;
					animation-duration: 1s;	  
			-webkit-animation-fill-mode: both;
					animation-fill-mode: both;
			/*-webkit-animation-delay: 0.1s;
					animation-delay: 0.1s;*/
		}
		.grsTemplate".$id." .grsThImFrCont > .grsImsBox > .grsImsMainC > .grsThTitleC.grsTOnhover {
			transition: all 500ms;
			transition-timing-function: ease-in-out;
			-webkit-perspective: 100px;
					perspective: 100px;";
		switch($grsTheme->thumbnailTEffect) {
			case 'grsFadeIn':
				$thumbnail .= "opacity: 0;";
			break;
			case 'grsSlideInLeft':
				$thumbnail .= "-webkit-transform: translateX(-50%);
						transform: translateX(-50%);
				opacity: 0;";
			break;
			case 'grsSlideInRight':
				$thumbnail .= "-webkit-transform: translateX(50%);
						transform: translateX(50%);
				opacity: 0;";
			break;
			case 'grsSlideInUp':
				$thumbnail .= "-webkit-transform: translateY(50%);
						transform: translateY(50%);
				opacity: 0;";
			break;
			case 'grsSlideInDown':
				$thumbnail .= "-webkit-transform: translateY(-50%);
						transform: translateY(-50%);
				opacity: 0;";
			break;
			case 'grsZoomIn':
				$thumbnail .= "-webkit-transform: scale3d(0.7, 0.7, 0.7);
						transform: scale3d(0.7, 0.7, 0.7);
				opacity: 0;";
			break;	
			case 'grsTransUp':
				$thumbnail .= "-webkit-transform: rotateX(5deg) translate3d(0,10px,0);
                    -ms-transform: rotateX(5deg) translateY(10px);
    					transform: rotateX(5deg) translate3d(0,10px,0);
				-webkit-transform-origin: 0 100%;
                    -ms-transform-origin: 0 100%;
                        transform-origin: 0 100%;
                opacity: 0;";
			break;
			case 'grsRotateX':
				$thumbnail .= "-webkit-transform: rotateX(100deg);
                    -ms-transform: rotateX(100deg);
                        transform: rotateX(100deg);
                -webkit-transform-origin: 100% 0%;
                    -ms-transform-origin: 100% 0%;
           				transform-origin: 100% 0%;
           		opacity: 0;";
			break;
			case 'grsRotateY':
				$thumbnail .= "-webkit-transform: rotateY(100deg);
                    -ms-transform: rotateY(100deg);
    					transform: rotateY(100deg);
                -webkit-transform-origin: 0% 100%;
                    -ms-transform-origin: 0% 100%;
    					transform-origin: 0% 100%;
    			opacity: 0;";
			break;	
			case 'grsBounceIn':
			case 'grsBounceInDown':
			case 'grsBounceInLeft':
			case 'grsFlipInX':
			case 'grsFlipInY':
			case 'grsRollIn':
				$thumbnail .= "opacity: 0;";
			break;
			default:
			break;
		}
		$thumbnail .= "}";
		$thumbnail .= ".grsTemplate".$id." .grsThImFrCont:hover > .grsImsBox > .grsImsMainC .grsThTitleC.grsTOnhover {";
		switch($grsTheme->thumbnailTEffect) {
			case 'grsFadeIn':
				
				$thumbnail .= "opacity: 1;";
				
			break;
			case 'grsSlideInLeft':
			case 'grsSlideInRight':
			case 'grsSlideInUp':
			case 'grsSlideInDown':
				
				$thumbnail .= "-webkit-transform: translateY(0%);
						transform: translateY(0%);
				-webkit-transform: translate(0%, 0%);
						transform: translate(0%, 0%);
				opacity: 1;";
				
			break;
			case 'grsZoomIn':
				
				$thumbnail .= "-webkit-transform: scale3d(1, 1, 1);
						transform: scale3d(1, 1, 1);
				opacity: 1;";
				
			break;
			case 'grsTransUp':
				
				$thumbnail .= "-webkit-transform: rotateX(0deg) translate3d(0px,0px,0px);
		                transform: rotateX(0deg) translate3d(0px,0px,0px);
                opacity: 1;";
				
			break;
			case 'grsRotateX':
				
			    $thumbnail .= "-webkit-transform: rotateX(0deg);
                    -ms-transform: rotateX(0deg);
						transform: rotateX(0deg);
				opacity: 1;";
				
			break;						
			case 'grsRotateY':
				
			    $thumbnail .= "-webkit-transform: rotateY(0deg);
                    -ms-transform: rotateY(0deg);
   						transform: rotateY(0deg);
   				opacity: 1;";
				
			break;
			case 'grsBounceIn':
			case 'grsBounceInDown':
			case 'grsBounceInLeft':
			case 'grsFlipInY':
			case 'grsFlipInX':
			case 'grsRollIn':
				
				$thumbnail .= "-webkit-animation-name: ".$grsTheme->thumbnailTEffect.";
						animation-name: ".$grsTheme->thumbnailTEffect.";
				opacity: 1;";
				
			break;
			default:
			break;
		}
		$thumbnail .= "}";
		$thumbnail .= ".grsTemplate".$id." .grsThImFrCont > .grsImsBox > .grsImsMainC .grsThTitleCT > .grsThTitleCC > .grsThTitle {
			font-weight: ".$grsTheme->thumbnailTFWeight.";
			font-family: ".$grsTheme->thumbnailTFFamily.";
			font-size: ".$grsTheme->thumbnailTFSize."px;
			font-style: ".$grsTheme->thumbnailTFstyle.";
			color: ".$grsTheme->thumbnailTcolor.";
			word-break: break-word;
			text-align: center;
		}
		.grsTemplate".$id." .grsThImFrCont > .grsImsBox > .grsImsMainC .grsThTitleCT > .grsThTitleCC {
			display: table-cell;
			vertical-align: ".$grsTheme->thumbnailTpos.";
			width: 100%;
			height: 100%;
		}
		.grsTemplate".$id." .grsThImFrCont > .grsImsBox > .grsImsMainC .grsMask > .grsImHovEf {
			padding: ".$grsTheme->thumbnailTpadding."px;
			box-sizing: border-box;
			position: absolute;
			text-align: center;
			overflow: hidden;
			height: 100%;
			width: 100%;
			opacity: 0;
			z-index: 2;
			left: 0;
			top: 0;
			transform: rotate(-33.5deg) translate(-112px,166px);
			transform-origin: 0% 100%;
			transition: all 0.4s ease-in-out 0.3s;
		}
		/*.grsTemplate".$id." .grsThImFrCont > .grsImsBox > .grsImsMainC .grsMask .grsImHovEf > h2 {
			text-transform: uppercase;
			font-weight: ".$grsTheme->thumbnailTFWeight.";
			font-family: ".$grsTheme->thumbnailTFFamily.";
			font-size: ".$grsTheme->thumbnailTFSize."px;
			font-style: ".$grsTheme->thumbnailTFstyle.";
			color: ".$grsTheme->thumbnailTcolor.";
			word-break: break-word;
			text-align: center;
			position: relative;
			padding: 5px;
			background:  ".$grsTheme->thumbnailTBgcolor.";
			margin: 20px 0 0 0;
			margin-top: 5px;
			border-bottom: 1px solid rgba(255,255,255,0.2);
		}
		.grsTemplate".$id." .grsThImFrCont > .grsImsBox > .grsImsMainC .grsMask > .grsImHovEf > p {
			text-transform: uppercase;
			font-weight: ".$grsTheme->thumbnailTFWeight.";
			font-family: ".$grsTheme->thumbnailTFFamily.";
			font-size: ".$grsTheme->thumbnailTFSize."px;
			font-style: ".$grsTheme->thumbnailTFstyle.";
			color: ".$grsTheme->thumbnailTcolor.";
			word-break: break-word;
			text-align: center;
			position: relative;
			background:  ".$grsTheme->thumbnailTBgcolor.";
			padding: 10px 20px 20px;
		}*/
		.grsTemplate".$id." .grsThImFrCont > .grsImsBox > .grsImsMainC .grsMask .mask-1,
		.grsTemplate".$id." .grsThImFrCont > .grsImsBox > .grsImsMainC .grsMask .mask-2{
			position: absolute;
			background-color: ".$grsTheme->thumbnailMaskColor.";
			width: 100%;
			opacity: 1;
			transition: all 0.3s ease-in-out 0.6s;
			z-index: 3;
		}
		.grsTemplate".$id." .grsThImFrCont > .grsImsBox > .grsImsMainC .grsMask .mask-1 {
			top: 0px;
			height: 0%;
		}
		.grsTemplate".$id." .grsThImFrCont > .grsImsBox > .grsImsMainC .grsMask .mask-2 {
			bottom: 0px;
			height: 0%;
		}
		.grsTemplate".$id." .grsThImFrCont > .grsImsBox > .grsImsMainC .grsMask:hover .grsImHovEf {
			opacity: 1;
			transform: rotate(0deg) translate(0px,0px);
			z-index:3
		}
		.grsTemplate".$id." .grsThImFrCont > .grsImsBox > .grsImsMainC .grsMask:hover .mask-1,
		.grsTemplate".$id." .grsThImFrCont > .grsImsBox > .grsImsMainC .grsMask:hover .mask-2{
			transition-delay: 0s;
		}
		.grsTemplate".$id." .grsThImFrCont > .grsImsBox > .grsImsMainC .grsMask:hover .mask-1{
			height: 50%;
		}
		.grsTemplate".$id." .grsThImFrCont > .grsImsBox > .grsImsMainC .grsMask:hover .mask-2 {  
			height: 50%;
		}
		.grsTemplate".$id." .grsThImFrCont > .grsImsBox > .grsImsMainC .grsThTitleCT {
			display: table;
			width: 100%;
			height: 100%;
		}";
		return $thumbnail;
	}
}
?>