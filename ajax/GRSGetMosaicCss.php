<?php
/**
 * LIMB gallery
 * Get Mosaic CSS
 */
 
class GRSGetMosaicCss {
	// Costructor
	public function __construct() {				
	}
	public function get_($id, $grsTheme) {
		$mosaic = ".grsTemplate".$id." .grsMosImFrCont {
			display: block;
			max-width: 100%;
			position: absolute;
			box-sizing: content-box;
			background-color: ". $grsTheme->mosaicBgColor .";
			box-shadow: ". $grsTheme->mosaicBoxshadowFstVal ."px ". $grsTheme->mosaicBoxshadowSecVal ."px ". $grsTheme->mosaicBoxshadowThdVal ."px ". $grsTheme->mosaicBoxshadowColor .";
			border: ". $grsTheme->mosaicBorderWidth ."px ". $grsTheme->mosaicBorderStyle ." ". $grsTheme->mosaicBorderColor .";
			border-radius: ". $grsTheme->mosaicBorderRadius ."px !important;
			padding: ". $grsTheme->mosaicPadding ."px;
			overflow: hidden;";
			switch($grsTheme->mosaicHoverEffect) {
				case 'scale':
				case 'rotate':
					$mosaic .= "-webkit-transition: 0.1s transform linear, 0.5s left linear, 0.5s top linear, 0.5s width linear, 0.5s height linear;
						-ms-transition: 0.1s transform linear, 0.5s left linear, 0.5s top linear, 0.5s width linear, 0.5s height linear;
							transition: 0.1s transform linear, 0.5s left linear, 0.5s top linear, 0.5s width linear, 0.5s height linear;";
				break;
				case 'grayscale':
					$mosaic .= "-webkit-transition: 0.5s ease-in-out;
							transition: 0.5s ease-in-out;
					-webkit-filter: grayscale(100%);
							filter: grayscale(100%);";
				break;
				case 'blur':
					$mosaic .= "-webkit-filter: grayscale(0) blur(0);
							filter: grayscale(0) blur(0);
					-webkit-transition: 0.5s ease-in-out;
							transition: 0.5s ease-in-out;";
				break;
				case 'sepia':
					$mosaic .= "-webkit-filter: sepia(100%);
							filter: sepia(100%);
					-webkit-transition: 0.5s ease-in-out;
							transition: 0.5s ease-in-out;";
				break;
				case 'flash':
				case 'shine':
				case 'circle':
				default:
					$mosaic .= "-webkit-transition: 0.5s left linear, 0.5s top linear,  0.5s width linear, 0.5s height linear;
						-ms-transition: 0.5s left linear, 0.5s top linear,  0.5s width linear, 0.5s height linear;
							transition: 0.5s left linear, 0.5s top linear,  0.5s width linear, 0.5s height linear;";
				break;
			}
		$mosaic .= "}";
		if($grsTheme->mosaicHoverEffect == 'shine') { 
			$mosaic .= ".grsTemplate".$id." .grsMosImFrCont::before {
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
			.grsTemplate".$id." .grsMosImFrCont:hover::before {
				-webkit-animation: shine .75s;
						animation: shine .75s;
			}";
		} elseif($grsTheme->mosaicHoverEffect == 'circle') { 
			$mosaic .= ".grsTemplate".$id." .grsMosImFrCont::before {
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
			.grsTemplate".$id." .grsMosImFrCont:hover::before {
				-webkit-animation: circle .75s;
						animation: circle .75s;
			}";
		} 
		$mosaic .= ".grsTemplate".$id." .grsMosImFrCont:hover {"; 
			switch($grsTheme->mosaicHoverEffect) {
				case 'scale':
					$mosaic .= "-webkit-transform: scale(1.1);
						-ms-transform: scale(1.1);
						transform: scale(1.1);
						z-index: 2;";
				break;
				case 'rotate':
					$mosaic .= "-webkit-transform: rotate(3.5deg);
						-ms-transform: rotate(3.5deg);
						transform: rotate(3.5deg);
						z-index: 2;";
				break;
				case 'grayscale':
					$mosaic .= "-webkit-filter: grayscale(0);
						filter: grayscale(0);";
				break;
				case 'blur':
					$mosaic .= "-webkit-filter: grayscale(100%) blur(1px);
						filter: grayscale(100%) blur(1px);";
				break;
				case 'sepia':
					$mosaic .= "-webkit-filter: sepia(0);
						filter: sepia(0);";
				break;
				case 'flash':
					$mosaic .= "	opacity: 1;
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
		$mosaic .= "}";
		$mosaic .= ".grsTemplate".$id." .grsMosImFrCont .grsIm {
			box-sizing: border-box;
			border-radius: 0px;
			box-shadow: none;
			width:100%;
			border-radius: ". $grsTheme->mosaicBorderRadius ."px !important;
			-webkit-transition: 0.3s transform ease-in-out;
			transition: 0.3s transform ease-in-out, 0.3s opacity ease-in-out;";
			switch($grsTheme->mosaicHoverEffect) {
				case 'scaleIm':
					$mosaic .= "-webkit-transform: scale3d(1,1,1);
						-ms-transform: scale3d(1,1,1);
							transform: scale3d(1,1,1);";
				break;
				case 'scaleRotIm':
					$mosaic .= "-webkit-transform: rotate(0deg) scale3d(1,1,1);
						-ms-transform: rotate(0deg) scale3d(1,1,1);
							transform: rotate(0deg) scale3d(1,1,1);";
				break;
				case 'scaleTransIm':
					$mosaic .= "-webkit-transform: scale3d(1,1,1) translate(0px);
						-ms-transform: scale3d(1,1,1) translate(0px);
							transform: scale3d(1,1,1) translate(0px);";
				break;
				default:
				break;
			}
		$mosaic .= "}";
		$mosaic .= ".grsTemplate".$id." .grsMosImFrCont:hover .grsIm {";
			switch($grsTheme->mosaicHoverEffect) {
				case 'scaleIm':
					$mosaic .= "-webkit-transform: scale3d(1.2, 1.2, 1.2);
						-ms-transform: scale3d(1.2, 1.2, 1.2);
						transform: scale3d(1.2, 1.2, 1.2);";
				break;
				case 'scaleRotIm':
					$mosaic .= "-webkit-transform: scale3d(1.2,1.2,1.2) rotate(5deg);
						-ms-transform: scale3d(1.2,1.2,1.2) rotate(5deg);
						transform: scale3d(1.2,1.2,1.2) rotate(5deg);";
				break;
				case 'scaleTransIm':
					$mosaic .= "-webkit-transform: scale3d(1.2,1.2,1.2) translate(15px);
						-ms-transform: scale3d(1.2,1.2,1.2) translate(15px);
						transform: scale3d(1.2,1.2,1.2) translate(15px);";
				break;
				default:
				break;
			}
		$mosaic .= "}";
		$mosaic .= ".grsTemplate".$id." .grsMosImFrCont .grsImSecCont {
			position: relative;
			border-radius: ". $grsTheme->mosaicBorderRadius ."px !important;
			height: 100%;
			width: 100%;
			overflow: hidden;
			".(strrpos($grsTheme->mosaicHoverEffect, 'scale') === false ? '' : 'z-index:0')."
		}
		.grsTemplate".$id." .grsMosImFrCont .grsImSecCont > .grsMask  {
			overflow: hidden;
			width: 100%;
			height: 100%;
			position: absolute;
			top: 0px;
			left: 0px;
			z-index: 2;
		}
		.grsTemplate".$id." .grsMosImFrCont .grsImSecCont > .grsMosTitleC {
			background-color: ". $grsTheme->mosaicTBgcolor .";
			padding: ". $grsTheme->mosaicTpadding ."px;
			border-radius: ". $grsTheme->mosaicBorderRadius ."px !important;
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
			-webkit-animation-delay: 0.1s;
					animation-delay: 0.1s;
		}
		.grsTemplate".$id." .grsMosImFrCont .grsImSecCont > .grsMosTitleC.grsTOnhover {
			transition: all 500ms linear;
			transition-timing-function: ease-in-out;
			-webkit-perspective: 100px;
					perspective: 100px;";
			switch($grsTheme->mosaicTEffect) {
				case 'grsFadeIn':
					$mosaic .= "opacity: 0;";
				break;
				case 'grsSlideInLeft':
					$mosaic .= "-webkit-transform: translateX(-50%);
							transform: translateX(-50%);
					opacity: 0;";
				break;
				case 'grsSlideInRight':
					$mosaic .= "-webkit-transform: translateX(50%);
							transform: translateX(50%);
					opacity: 0;";
				break;
				case 'grsSlideInUp':
					$mosaic .= "-webkit-transform: translateY(50%);
							transform: translateY(50%);
					opacity: 0;";
				break;
				case 'grsSlideInDown':
					$mosaic .= "-webkit-transform: translateY(-50%);
							transform: translateY(-50%);
					opacity: 0;";
				break;
				case 'grsZoomIn':
					$mosaic .= "-webkit-transform: scale3d(0.7, 0.7, 0.7);
    						transform: scale3d(0.7, 0.7, 0.7);
    				opacity: 0;";
				break;	
				case 'grsTransUp':
					$mosaic .= "-webkit-transform: rotateX(5deg) translate3d(0,10px,0);
	                    -ms-transform: rotateX(5deg) translateY(10px);
	    					transform: rotateX(5deg) translate3d(0,10px,0);
					-webkit-transform-origin: 0 100%;
	                    -ms-transform-origin: 0 100%;
	                        transform-origin: 0 100%;
	                opacity: 0;";
				break;
				case 'grsRotateX':
					$mosaic .= "-webkit-transform: rotateX(100deg);
	                    -ms-transform: rotateX(100deg);
	                        transform: rotateX(100deg);
	                -webkit-transform-origin: 100% 0%;
                        -ms-transform-origin: 100% 0%;
	           				transform-origin: 100% 0%;
	           		opacity: 0;";
				break;
				case 'grsRotateY':
					$mosaic .= "-webkit-transform: rotateY(100deg);
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
					$mosaic .= "opacity: 0;";
				break;
				default:
				break;
			}
		$mosaic .= "}";
		$mosaic .= ".grsTemplate".$id." .grsMosImFrCont:hover .grsMosTitleC.grsTOnhover {";
			switch($grsTheme->mosaicTEffect) {
				case 'grsFadeIn':
					$mosaic .= "opacity: 1;";
				break;
				case 'grsSlideInLeft':
				case 'grsSlideInRight':
				case 'grsSlideInUp':
				case 'grsSlideInDown':
					$mosaic .= "-webkit-transform: translateY(0%);
							transform: translateY(0%);
					-webkit-transform: translate(0%, 0%);
							transform: translate(0%, 0%);
					opacity: 1;";
				break;
				case 'grsZoomIn':
					$mosaic .= "-webkit-transform: scale3d(1, 1, 1);
    						transform: scale3d(1, 1, 1);
					opacity: 1;";
				break;
				case 'grsTransUp':
					$mosaic .= "-webkit-transform: rotateX(0deg) translate3d(0px,0px,0px);
			                transform: rotateX(0deg) translate3d(0px,0px,0px);
	                opacity: 1;";
				break;
				case 'grsRotateX':
					$mosaic .= "-webkit-transform: rotateX(0deg);
                        -ms-transform: rotateX(0deg);
    						transform: rotateX(0deg);
    				opacity: 1;";
				break;						
				case 'grsRotateY':
					$mosaic .= "-webkit-transform: rotateY(0deg);
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
					$mosaic .= "-webkit-animation-name: ". $grsTheme->mosaicTEffect .";
							animation-name: ". $grsTheme->mosaicTEffect .";
					opacity: 1;";
				break;
				default:
				break;
			}
		$mosaic .= "}";
		$mosaic .= ".grsTemplate".$id." .grsMosImFrCont .grsImSecCont .grsMosTitleCT > .grsMosTitleCC > .grsMosTitle {
			font-weight: ". $grsTheme->mosaicTFWeight .";
			font-family: ". $grsTheme->mosaicTFFamily .";
			font-size: ". $grsTheme->mosaicTFSize ."px;
			font-style: ". $grsTheme->mosaicTFstyle .";
			color: ". $grsTheme->mosaicTcolor .";
			word-break: break-word;
			text-align: center;
		}
		.grsTemplate".$id." .grsMosImFrCont .grsImSecCont .grsMosTitleCT > .grsMosTitleCC {
			display: table-cell;
			vertical-align: ". $grsTheme->mosaicTpos .";
			width: 100%;
			height: 100%;
		}
		.grsTemplate".$id." .grsMosImFrCont .grsImSecCont .grsMask > .grsImHovEf {
			width: 100%;
			height: 100%;
			position: absolute;
			overflow: hidden;
			top: 0;
			left: 0;
			text-align: center;
			opacity: 0;
			font-size: 12px;
			transform: rotate(-33.5deg) translate(-112px,166px);
			transform-origin: 0% 100%;
			transition: all 0.4s ease-in-out 0.3s;
			z-index: 2;
		}
		/*.grsTemplate".$id." .grsMosImFrCont .grsImSecCont .grsMask .grsImHovEf > h2 {
			text-transform: uppercase;
			font-weight: ". $grsTheme->mosaicTFWeight .";
			font-family: ". $grsTheme->mosaicTFFamily .";
			font-size: ". $grsTheme->mosaicTFSize ."px;
			font-style: ". $grsTheme->mosaicTFstyle .";
			color: ". $grsTheme->mosaicTcolor .";
			word-break: break-word;
			text-align: center;
			position: relative;
			padding: 5px;
			background:  ". $grsTheme->mosaicTBgcolor .";
			margin: 20px 0 0 0;
			margin-top: 5px;
			border-bottom: 1px solid rgba(255,255,255,0.2);
		}
		.grsTemplate".$id." .grsMosImFrCont .grsImSecCont .grsMask > .grsImHovEf > p {
			text-transform: uppercase;
			font-weight: ". $grsTheme->mosaicTFWeight .";
			font-family: ". $grsTheme->mosaicTFFamily .";
			font-size: ". $grsTheme->mosaicTFSize ."px;
			font-style: ". $grsTheme->mosaicTFstyle .";
			color: ". $grsTheme->mosaicTcolor .";
			word-break: break-word;
			text-align: center;
			position: relative;
			background:  ". $grsTheme->mosaicTBgcolor .";
			padding: 10px 20px 20px;
		}*/
		.grsTemplate".$id." .grsMosImFrCont .grsImSecCont .grsMask .mask-1,
		.grsTemplate".$id." .grsMosImFrCont .grsImSecCont .grsMask .mask-2{
			position: absolute;
			background-color: rgba(0,0,0,0.75); /*thumbnailMaskColor*/
			width: 100%;
			opacity: 1;
			transition: all 0.3s ease-in-out 0.6s;
			z-index: 3;
		}
		.grsTemplate".$id." .grsMosImFrCont .grsImSecCont .grsMask .mask-1 {
			top: 0px;
			height: 0%;
		}
		.grsTemplate".$id." .grsMosImFrCont .grsImSecCont .grsMask .mask-2 {
			bottom: 0px;
			height: 0%;
		}
		.grsTemplate".$id." .grsMosImFrCont .grsImSecCont .grsMask:hover .grsImHovEf {
			opacity: 1;
			transform: rotate(0deg) translate(0px,0px);
			z-index:3
		}
		.grsTemplate".$id." .grsMosImFrCont .grsImSecCont .grsMask:hover .mask-1,
		.grsTemplate".$id." .grsMosImFrCont .grsImSecCont .grsMask:hover .mask-2{
			transition-delay: 0s;
		}
		.grsTemplate".$id." .grsMosImFrCont .grsImSecCont .grsMask:hover .mask-1{
			height: 50%;
		}
		.grsTemplate".$id." .grsMosImFrCont .grsImSecCont .grsMask:hover .mask-2 {  
			height: 50%;
		}
		.grsTemplate".$id." .grsMosImFrCont .grsImSecCont .grsMosTitleCT {
			display: table;
			width: 100%;
			height: 100%;
		}";
		return $mosaic;
	}
}