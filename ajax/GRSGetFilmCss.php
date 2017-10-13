<?php
/**
 * LIMB gallery
 * Get Film CSS
 */
 
class GRSGetFilmCss {
	// Costructor
	public function __construct() {				
	}
	public function get_($id, $grsTheme) {
		$film = ".grsTemplate".$id." .grsFilm {
			display:block;
			width:100%;
			background-color:  ". $grsTheme->fmBgColor .";
			position:relative;
			height:100%;
		    overflow: hidden;
		}
		.grsTemplate".$id." .grsFilm > .grsFlImFrContmB {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
			width: ". $grsTheme->fmNavWidth ."px;
			height: ". $grsTheme->fmNavHeight ."px;
			position:absolute;
			top: calc(50% - (".($grsTheme->fmNavHeight/2)."px));
			background-color: ". $grsTheme->fmNavBgColor .";
			box-shadow: ". $grsTheme->fmNavBoxshadowFstVal ."px ". $grsTheme->fmNavBoxshadowSecVal ."px ". $grsTheme->fmNavBoxshadowThdVal ."px ". $grsTheme->fmNavBoxshadowColor .";
			box-sizing: border-box;
			border: ". $grsTheme->fmNavBorderWidth ."px ". $grsTheme->fmNavBorderStyle ." ". $grsTheme->fmNavBorderColor ."; 
			border-radius: ". $grsTheme->fmNavBorderRadius ."px;
			z-index: 3;
			cursor:pointer;
			transition: 0.3s all ease-in-out;
		}
        .grsTemplate".$id." .grsFilm > .grsFlImFrContmB:hover {
		    background-color: ". $grsTheme->fmNavHoverBgColor .";
		}
		.grsTemplate".$id." .grsFilm > .grsFlImFrContmB > .fa {
		    font-size: ". $grsTheme->fmNavSize ."px;
            color: ". $grsTheme->fmNavColor .";
            transition: 0.3s all ease-in-out;
            margin: 0;
		    padding: 0;
		    border: none;
		    outline: none;
		}
        .grsTemplate".$id." .grsFilm > .grsFlImFrContmB:hover > .fa {
		    color: ". $grsTheme->fmNavHoverColor .";
		}
		.grsTemplate".$id." .grsFilm > .grsFlImFrContmR {
			left: ". $grsTheme->fmNavOffset ."px;
		}
		.grsTemplate".$id." .grsFilm > .grsFlImFrContmL {
			right: ". $grsTheme->fmNavOffset ."px;
		}
		.grsTemplate".$id." .grsFilm > .grsFlImFIsC {
			margin: ". $grsTheme->fmMargin ."px 0px;
			height: 100%;
			position: absolute;
			transition: 0.5s all ease-in-out
		}
		.grsTemplate".$id." .grsFilm > .grsFlImFIsC > .grsFlImFrCont {
			background-color: ". $grsTheme->fmThumbBgColor .";
			margin: 0px ". $grsTheme->fmThumbMargin ."px 0px 0px;
			padding: ". $grsTheme->fmThumbPadding ."px;
			box-shadow: ". $grsTheme->fmThumbBoxshadowFstVal ."px ". $grsTheme->fmThumbBoxshadowSecVal ."px ". $grsTheme->fmThumbBoxshadowThdVal ."px ". $grsTheme->fmThumbBoxshadowColor .";
			border: ". $grsTheme->fmThumbBorderWidth ."px ". $grsTheme->fmThumbBorderStyle ." ". $grsTheme->fmThumbBorderColor ."; 
			box-sizing: content-box;
			float: left;
			position: relative;
			overflow: hidden;";
			switch($grsTheme->fmHoverEffect) {
				case 'scale':
				case 'rotate':	
					$film .= "-webkit-transition: 0.1s transform linear, 0.5s left linear, 0.5s top linear, 0.5s width linear, 0.5s height linear;
						-ms-transition: 0.1s transform linear, 0.5s left linear, 0.5s top linear, 0.5s width linear, 0.5s height linear;
							transition: 0.1s transform linear, 0.5s left linear, 0.5s top linear, 0.5s width linear, 0.5s height linear;";
				break;
				case 'grayscale':
					$film .= "-webkit-transition: 0.5s ease-in-out;
							transition: 0.5s ease-in-out;
					-webkit-filter: grayscale(100%);
							filter: grayscale(100%);";						
				break;
				case 'blur':
					$film .= "-webkit-filter: grayscale(0) blur(0);
							filter: grayscale(0) blur(0);
					-webkit-transition: 0.5s ease-in-out;
							transition: 0.5s ease-in-out;";
				break;
				case 'sepia':
					$film .= "-webkit-filter: sepia(100%);
							filter: sepia(100%);
					-webkit-transition: 0.5s ease-in-out;
							transition: 0.5s ease-in-out;";
				break;
				case 'flash':
				case 'shine':
				case 'circle':
				default:
					$film .= "-webkit-transition: 0.5s left linear, 0.5s top linear,  0.5s width linear, 0.5s height linear;
						-ms-transition: 0.5s left linear, 0.5s top linear,  0.5s width linear, 0.5s height linear;
							transition: 0.5s left linear, 0.5s top linear,  0.5s width linear, 0.5s height linear;";
				break;
			}
		$film .= "}";
		$film .= ".grsTemplate".$id." .grsFilm > .grsFlImFIsC > .grsFlImFrCont:first-child {
		    margin: 0px ". $grsTheme->fmThumbMargin ."px;
		}";
		if($grsTheme->fmHoverEffect == 'shine') {
			$film .= ".grsTemplate".$id." .grsFilm > .grsFlImFIsC > .grsFlImFrCont::before {
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
			.grsTemplate".$id." .grsFilm > .grsFlImFIsC > .grsFlImFrCont:hover::before {
				-webkit-animation: shine .75s;
						animation: shine .75s;
			}";
		} elseif($grsTheme->fmHoverEffect == 'circle') {
			$film .= ".grsTemplate".$id." .grsFilm > .grsFlImFIsC > .grsFlImFrCont::before {
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
			.grsTemplate".$id." .grsFilm > .grsFlImFIsC > .grsFlImFrCont:hover::before {
				-webkit-animation: circle .75s;
						animation: circle .75s;
			}";
		}
		$film .= ".grsTemplate".$id." .grsFilm > .grsFlImFIsC > .grsFlImFrCont:hover {"; 
			switch($grsTheme->fmHoverEffect) {
				case 'scale':
					$film .= "-webkit-transform: scale(1.1);
						-ms-transform: scale(1.1);
						transform: scale(1.1);
						z-index: 2;";
				break;
				case 'rotate':
					$film .= "-webkit-transform: rotate(3.5deg);
						-ms-transform: rotate(3.5deg);
						transform: rotate(3.5deg);
						z-index: 2;";
				break;
				case 'grayscale':
					$film .= "-webkit-filter: grayscale(0);
							filter: grayscale(0);";
				break;
				case 'blur':
					$film .= "-webkit-filter: grayscale(100%) blur(1px);
							filter: grayscale(100%) blur(1px);";
				break;
				case 'sepia':
					$film .= "-webkit-filter: sepia(0);
							filter: sepia(0);";
				break;
				case 'flash':
					$film .= "opacity: 1;
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
		$film .= "}";
		$film .= ".grsTemplate".$id." .grsFilm .grsFlImFIsC > .grsFlImFrCont:last-child {
			margin: 0px 0px 0px 0px;
		}
		.grsTemplate".$id." .grsFilm > .grsFlImFIsC > .grsFlImFrCont > .grsImsBox {
		    overflow: hidden;
		    text-decoration: none;
		    box-shadow: none;
		    border: none;
		    outline: none;
		    z-index: 1;
		}
		.grsTemplate".$id." .grsFilm > .grsFlImFIsC > .grsFlImFrCont > .grsImsBox > .grsImsMainC { 
			position: relative;
		    height: 100%;
		    width: 100%;
		    overflow: hidden;
		}
		.grsTemplate".$id." .grsFilm > .grsFlImFIsC > .grsFlImFrCont > .grsImsBox > .grsImsMainC > .grsFlImFrContbck {
			background-color: ". $grsTheme->fmThumbBgColor .";
			background-size: cover !important;
			background-repeat:no-repeat;
			background-position:center;
			position:relative;
			width: 100%;
			height: 100%;
			-webkit-transition: 0.3s transform ease-in-out;
			transition: 0.3s transform ease-in-out;";
			switch($grsTheme->fmHoverEffect) {
				case 'scaleIm':
					$film .= "-webkit-transform: scale3d(1,1,1);
						-ms-transform: scale3d(1,1,1);
							transform: scale3d(1,1,1);";
				break;
				case 'scaleRotIm':
					$film .= "-webkit-transform: rotate(0deg) scale3d(1,1,1);
						-ms-transform: rotate(0deg) scale3d(1,1,1);
							transform: rotate(0deg) scale3d(1,1,1);";
				break;
				case 'scaleTransIm':
					$film .= "-webkit-transform: scale3d(1,1,1) translate(0px);
						-ms-transform: scale3d(1,1,1) translate(0px);
							transform: scale3d(1,1,1) translate(0px);";
				break;
				default:
				break;
			}
		$film .= "}"; 
		$film .= ".grsTemplate".$id." .grsFilm > .grsFlImFIsC > .grsFlImFrCont:hover > .grsImsBox > .grsImsMainC > .grsFlImFrContbck {";
			switch($grsTheme->fmHoverEffect) {
				case 'scaleIm':
					$film .= "-webkit-transform: scale3d(1.2, 1.2, 1.2);
						-ms-transform: scale3d(1.2, 1.2, 1.2);
							transform: scale3d(1.2, 1.2, 1.2);";
				break;
				case 'scaleRotIm':
					$film .= "-webkit-transform: scale3d(1.2,1.2,1.2) rotate(5deg);
						-ms-transform: scale3d(1.2,1.2,1.2) rotate(5deg);
							transform: scale3d(1.2,1.2,1.2) rotate(5deg);";
				break;
				case 'scaleTransIm':
					$film .= "-webkit-transform: scale3d(1.2,1.2,1.2) translate(15px);
						-ms-transform: scale3d(1.2,1.2,1.2) translate(15px);
							transform: scale3d(1.2,1.2,1.2) translate(15px);";
				break;
				default:
				break;
			}
		$film .= "}";
		$film .= ".grsTemplate".$id." .grsFilm > .grsFlImFIsC > .grsFlImFrCont > .grsImsBox > .grsImsMainC > .grsMask  {
			overflow: hidden;
			width: 100%;
			height: 100%;
			position: absolute;
			top: 0px;
			left: 0px;
			z-index: 2;
		}
		.grsTemplate".$id." .grsFilm > .grsFlImFIsC > .grsFlImFrCont > .grsImsBox > .grsImsMainC > .grsFmTitleC {
			background-color: ". $grsTheme->fmTBgcolor .";
			padding: ". $grsTheme->fmTpadding ."px;
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
		.grsTemplate".$id." .grsFilm > .grsFlImFIsC > .grsFlImFrCont > .grsImsBox > .grsImsMainC > .grsFmTitleC.grsTOnhover {
			transition: all 500ms linear;
			transition-timing-function: ease-in-out;
			-webkit-perspective: 100px;
					perspective: 100px;"; 
			switch($grsTheme->fmThumbTeffect) {
				case 'grsFadeIn':
					$film .= "opacity: 0;";
				break;
				case 'grsSlideInLeft':
					$film .= "-webkit-transform: translateX(-50%);
					transform: translateX(-50%);
					opacity: 0;";
				break;
				case 'grsSlideInRight':
					$film .= "-webkit-transform: translateX(50%);
					transform: translateX(50%);
					opacity: 0;";
				break;
				case 'grsSlideInUp':
					$film .= "-webkit-transform: translateY(50%);
					transform: translateY(50%);
					opacity: 0;";
				break;
				case 'grsSlideInDown':
					$film .= "-webkit-transform: translateY(-50%);
					transform: translateY(-50%);
					opacity: 0;";
				break;
				case 'grsZoomIn':
					$film .= "-webkit-transform: scale3d(0.7, 0.7, 0.7);
					transform: scale3d(0.7, 0.7, 0.7);
    				opacity: 0;";
				break;	
				case 'grsTransUp':
					$film .= "-webkit-transform: rotateX(5deg) translate3d(0,10px,0);
	                    -ms-transform: rotateX(5deg) translateY(10px);
	    					transform: rotateX(5deg) translate3d(0,10px,0);
					-webkit-transform-origin: 0 100%;
	                    -ms-transform-origin: 0 100%;
	                        transform-origin: 0 100%;
	                opacity: 0;";
				break;
				case 'grsRotateX':
					$film .= "-webkit-transform: rotateX(100deg);
	                    -ms-transform: rotateX(100deg);
	                        transform: rotateX(100deg);
	                -webkit-transform-origin: 100% 0%;
                        -ms-transform-origin: 100% 0%;
	           				transform-origin: 100% 0%;
	           		opacity: 0;";
				break;
				case 'grsRotateY':
					$film .= "-webkit-transform: rotateY(100deg);
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
					$film .= "opacity: 0;";
				break;
				default:
				break;
			}
		$film .= "}";
		$film .= ".grsTemplate".$id." .grsFilm > .grsFlImFIsC > .grsFlImFrCont:hover > .grsImsBox > .grsImsMainC > .grsFmTitleC.grsTOnhover {";
			switch($grsTheme->fmThumbTeffect) {
				case 'grsFadeIn':
					$film .= "opacity: 1;";
				break;
				case 'grsSlideInLeft':
				case 'grsSlideInRight':
				case 'grsSlideInUp':
				case 'grsSlideInDown':
					$film .= "-webkit-transform: translateY(0%);
							transform: translateY(0%);
					-webkit-transform: translate(0%, 0%);
							transform: translate(0%, 0%);
					opacity: 1;";
				break;
				case 'grsZoomIn':
					$film .= "-webkit-transform: scale3d(1, 1, 1);
    						transform: scale3d(1, 1, 1);
					opacity: 1;";
				break;
				case 'grsTransUp':
					$film .= "-webkit-transform: rotateX(0deg) translate3d(0px,0px,0px);
			                transform: rotateX(0deg) translate3d(0px,0px,0px);
	                opacity: 1;";
				break;
				case 'grsRotateX':
				    $film .= "-webkit-transform: rotateX(0deg);
                        -ms-transform: rotateX(0deg);
    						transform: rotateX(0deg);
    				opacity: 1;";
				break;						
				case 'grsRotateY':
				    $film .= "-webkit-transform: rotateY(0deg);
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
					$film .= "-webkit-animation-name: ". $grsTheme->fmThumbTeffect .";
							animation-name: ". $grsTheme->fmThumbTeffect .";
					opacity: 1;";
				break;
				default:
				break;
			}
		$film .= "}";
		$film .= ".grsTemplate".$id." .grsFilm > .grsFlImFIsC > .grsFlImFrCont > .grsImsBox > .grsImsMainC .grsFmTitleCT > .grsFmTitleCC > .grsFmTitle {
			font-weight: ". $grsTheme->fmTFWeight .";
			font-family: ". $grsTheme->fmTFFamily .";
			font-size: ". $grsTheme->fmTFSize ."px;
			font-style: ". $grsTheme->fmTFstyle .";
			color: ". $grsTheme->fmTcolor .";
			word-break: break-word;
			text-align: center;
		}
		.grsTemplate".$id." .grsFilm > .grsFlImFIsC > .grsFlImFrCont > .grsImsBox > .grsImsMainC .grsFmTitleCT > .grsFmTitleCC {
			display: table-cell;
			vertical-align: ". $grsTheme->fmTpos .";
			width: 100%;
			height: 100%;
		}
		.grsTemplate".$id." .grsFilm > .grsFlImFIsC > .grsFlImFrCont > .grsImsBox > .grsImsMainC > .grsMask > .grsImHovEf {
			padding: ". $grsTheme->fmTpadding ."px;
			box-sizing: border-box;
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
		.grsTemplate".$id." .grsFilm > .grsFlImFIsC > .grsFlImFrCont > .grsImsBox > .grsImsMainC > .grsMask .mask-1,
		.grsTemplate".$id." .grsFilm > .grsFlImFIsC > .grsFlImFrCont > .grsImsBox > .grsImsMainC > .grsMask .mask-2 {
			position: absolute;
			background-color: rgba(0,0,0,0.75);/*thumbnailMaskColor*/
			width: 100%;
			opacity: 1;
			transition: all 0.3s ease-in-out 0.6s;
			z-index: 3;
		}
		.grsTemplate".$id." .grsFilm > .grsFlImFIsC > .grsFlImFrCont > .grsImsBox > .grsImsMainC > .grsMask .mask-1 {
			top: 0px;
			height: 0%;
		}
		.grsTemplate".$id." .grsFilm > .grsFlImFIsC > .grsFlImFrCont > .grsImsBox > .grsImsMainC > .grsMask .mask-2 {
			bottom: 0px;
			height: 0%;
		}
		.grsTemplate".$id." .grsFilm > .grsFlImFIsC > .grsFlImFrCont > .grsImsBox > .grsImsMainC > .grsMask:hover .grsImHovEf {
			opacity: 1;
			transform: rotate(0deg) translate(0px,0px);
			z-index:3
		}
		.grsTemplate".$id." .grsFilm > .grsFlImFIsC > .grsFlImFrCont > .grsImsBox > .grsImsMainC > .grsMask:hover .mask-1,
		.grsTemplate".$id." .grsFilm > .grsFlImFIsC > .grsFlImFrCont > .grsImsBox > .grsImsMainC > .grsMask:hover .mask-2{
			transition-delay: 0s;
		}
		.grsTemplate".$id." .grsFilm > .grsFlImFIsC > .grsFlImFrCont > .grsImsBox > .grsImsMainC > .grsMask:hover .mask-1{
			height: 50%;
		}
		.grsTemplate".$id." .grsFilm > .grsFlImFIsC > .grsFlImFrCont > .grsImsBox > .grsImsMainC > .grsMask:hover .mask-2 {  
			height: 50%;
		}
		.grsTemplate".$id." .grsFilm > .grsFlImFIsC > .grsFlImFrCont > .grsImsBox > .grsImsMainC .grsFmTitleCT {
			display: table;
			width: 100%;
			height: 100%;
		}";
		return $film;
	}
}