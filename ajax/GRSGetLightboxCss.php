<?php
/**
 * LIMB gallery
 * Get Lightbox CSS
 */
 
class GRSGetLightboxCss {
	// Costructor
	public function __construct() {				
	}
	public function get_($id, $grsTheme) {
		/* Lightbox */
		$lightbox = ".grsTemplate".$id." {
			}
			.grsTemplate".$id.".grsPopup {
				width:100%;
				height:100%;
				position:fixed;
				top:0px;
				left:0px;
				z-index: 99999;
				cursor:pointer;
				background-color: ".$grsTheme->bgColor .";
			}
			.grsTemplate".$id." .grsPopupRc {
				position: absolute;
				margin: auto;
				top: 0;
				right: 0;
				bottom: 0;
				left: 0;
			}
			.grsTemplate".$id." .grsPopupRc > .grsPopupMc {
				display:inline-block;
				height:100%;
				max-width: 100%;
				overflow:hidden;
				position:relative;
				cursor:auto
			}
			.grsTemplate".$id." .grsPopupImC {
				display:block;
				max-height: 100%;
				height:100%;
				position:relative;
				overflow: hidden;
				float:left;
				background-color: ".$grsTheme->boxBgColor .";
			}
			
			/*Filmstrip*/
			.grsTemplate".$id." .grsPopupImC > .grsPopupFc {
				display:block;
				width:100%;
				background-color: ".$grsTheme->filmstripBgColor .";
				position:relative;
				height: ".($filmstripContHeight = $grsTheme->filmstripSize + $grsTheme->filmstripMarginTop + $grsTheme->filmstripMarginBottom +  2*($grsTheme->filmThumbPadding + (($grsTheme->filmThumbBorderStyle != 'none') ? $grsTheme->filmThumbBorderWidth : 0)))."px;
				overflow: hidden;
			}
			.grsTemplate".$id." .grsPopupImC > .grsPopupFc .grsPopupFmB {
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
			    position:absolute;
				box-sizing: border-box;
				width: ".$grsTheme->filmNavWidth."px;
				height: ".$grsTheme->filmNavHeight."px;
				top: calc(50% - (".($grsTheme->filmNavHeight/2)."px));
				background-color: ".$grsTheme->filmNavBgColor .";
				box-shadow: ".$grsTheme->filmNavBoxshadowFstVal."px ".$grsTheme->filmNavBoxshadowSecVal."px ".$grsTheme->filmNavBoxshadowThdVal."px ".$grsTheme->filmNavBoxshadowColor .";
				border-radius: ".$grsTheme->filmNavBorderRadius."px;
				border: ".$grsTheme->filmNavBorderWidth."px ".$grsTheme->filmNavBorderStyle." ".$grsTheme->filmNavBorderColor ."; 
				z-index: 2;";
				if($grsTheme->filmNavButtonsSh == 'onhover') {
					$lightbox .= "opacity: 0;";
				} elseif($grsTheme->filmNavButtonsSh == 'no') {
					$lightbox .= "display: none;";
				}
				$lightbox .= "cursor:pointer;
				transition: 0.3s all linear;
			}
			.grsTemplate".$id." .grsPopupImC > .grsPopupFc .grsPopupFmB:hover {
				background-color: ".$grsTheme->filmNavHoverBgColor .";
			}
			.grsTemplate".$id." .grsPopupImC > .grsPopupFc:hover > .grsPopupFmB {
				opacity: 1;
			}
			.grsTemplate".$id." .grsPopupImC > .grsPopupFc .grsPopupFmB > .fa {
				font-size: ".$grsTheme->filmNavButtSize."px;
			    color: ".$grsTheme->filmNavButtColor .";
			    transition: 0.3s all ease-in-out;
			    margin: 0;
			    padding: 0;
			    border: none;
			    outline: none;
			}
			.grsTemplate".$id." .grsPopupImC > .grsPopupFc .grsPopupFmB:hover > .fa {
				color: ".$grsTheme->filmNavButtHoverColor .";
			}
			.grsTemplate".$id." .grsPopupImC > .grsPopupFc .grsPopupFmR {
				left: ".$grsTheme->filmNavOffset."px;
			}
			.grsTemplate".$id." .grsPopupImC > .grsPopupFc .grsPopupFmL {
				right: ".$grsTheme->filmNavOffset."px;
			}
			.grsTemplate".$id." .grsPopupImC > .grsPopupFc .grsPopupFIsC {
				transition: 0.5s all ease-in-out;
				display:block;
				overflow: hidden; 
				position:relative;
				box-sizing: content-box;
				margin: 0px;
				background-color: ".$grsTheme->filmstripBgColor .";
				height: 100%;
			}
			.grsTemplate".$id." .grsPopupImC > .grsPopupFc .grsPopupFIsC > .grsPopupFiC:first-child {
				margin: ".$grsTheme->filmstripMarginTop."px  ".$grsTheme->filmThumbMargin."px ".$grsTheme->filmstripMarginBottom."px ".$grsTheme->filmThumbMargin."px;
			}
			.grsTemplate".$id." .grsPopupImC > .grsPopupFc .grsPopupFIsC > .grsPopupFiC {
				background-color: ".$grsTheme->filmThumbBgColor .";
				height: ".$grsTheme->filmstripSize."px; 
				width: ".$grsTheme->filmThumbWidth."px;
				margin: ".$grsTheme->filmstripMarginTop."px  ".$grsTheme->filmThumbMargin."px ".$grsTheme->filmstripMarginBottom."px 0px;
				padding: ".$grsTheme->filmThumbPadding."px;
				border: ".$grsTheme->filmThumbBorderWidth."px ".$grsTheme->filmThumbBorderStyle." ".$grsTheme->filmThumbBorderColor ."; 
				box-shadow: ".$grsTheme->filmThumbBoxshadowFstVal."px ".$grsTheme->filmThumbBoxshadowSecVal."px ".$grsTheme->filmThumbBoxshadowThdVal."px ".$grsTheme->filmThumbBoxshadowColor .";
				float:left;
				cursor: pointer;
				box-sizing: content-box;";
				if($grsTheme->filmThumbSelEffect == 'fadeIn') {
					$lightbox .= "opacity: 0.3;
					transition: 0.3s all linear;";
				} elseif($grsTheme->filmThumbSelEffect == 'fadeOut') {
					$lightbox .= "opacity: 1;
					transition: 0.3s all linear;";
				} elseif($grsTheme->filmThumbSelEffect == 'zoom') {
					$lightbox .= "transform: scale(1);
					transition: 0.2s all linear;";
				} elseif($grsTheme->filmThumbSelEffect == 'rotate') {
					$lightbox .= "transform: rotate(0deg);
					transition: 0.2s all linear;";
				}
			$lightbox .= "}";
			$lightbox .= ".grsTemplate".$id." .grsPopupImC > .grsPopupFc .grsPopupFIsC > .grsPopupFiC:hover {";
				if($grsTheme->filmThumbSelEffect == 'fadeIn') {
					$lightbox .= "opacity: 1;";
				} elseif($grsTheme->filmThumbSelEffect == 'fadeOut') {
					$lightbox .= "opacity: 0.5;";
				} elseif($grsTheme->filmThumbSelEffect == 'zoom') {
					$lightbox .= "transform: scale(0.9);";
				} elseif($grsTheme->filmThumbSelEffect == 'rotate') {
					$lightbox .= "transform: rotate(6deg);";
				}
			$lightbox .= "}";
			$lightbox .= ".grsTemplate".$id." .grsPopupImC > .grsPopupFc .grsPopupFIsC > .grsPopupFiCAc {";
				if($grsTheme->filmThumbSelEffect == 'fadeIn') {
					$lightbox .= "opacity: 1;";
				} elseif($grsTheme->filmThumbSelEffect == 'fadeOut') {
					$lightbox .= "opacity: 0.5;";
				} elseif($grsTheme->filmThumbSelEffect == 'zoom') {
					$lightbox .= "transform: scale(0.9);";
				} elseif($grsTheme->filmThumbSelEffect == 'rotate') {
					$lightbox .= "transform: rotate(6deg);";
				}
			$lightbox .= "}";
			$lightbox .= ".grsTemplate".$id." .grsPopupImC > .grsPopupFc .grsPopupFIsC > .grsPopupFiC > .grsPopupFi {
				height: 100%; 
				width: 100%;
				background-size: cover !important;
				background-repeat:no-repeat;
				background-position:center;
				box-sizing: border-box;";
				if($grsTheme->filmThumbSelEffect == 'border') {
					$lightbox .= "outline: ".$grsTheme->filmSelThumbBorderWidth."px ".$grsTheme->filmSelThumbBorderStyle." ".$grsTheme->filmThumbBorderColor .";
					transition: 0.1s outline-color linear";
				}
			$lightbox .= "}
			.grsTemplate".$id." .grsPopupImC > .grsPopupFc .grsPopupFIsC > .grsPopupFiC.grsPopupFiCAc > .grsPopupFi {";
				if($grsTheme->filmThumbSelEffect == 'border') {
					$lightbox .= "outline-color: ".$grsTheme->filmSelThumbBorderColor.";";
				}
                $lightbox .= "}
			/* Image layers and navigation */
			/* Image layers */
			.grsTemplate".$id." .grsPopupImMc  {
				max-height: 100%;
				display:block;
				width:inherit;
				background-color: ".$grsTheme->boxBgColor .";
				position:relative;
				overflow: hidden;
			}
			.grsTemplate".$id." .grsPopupImMc > .grsPopupImLc {
				height:inherit; 
				width:inherit;
				position:absolute;
				top:0px;
				left:0px;
				text-align: center;
			}
			.grsTemplate".$id." .grsPopupImMc > .grsPopupImFLc {
				z-index: 0;
			}
			.grsTemplate".$id." .grsPopupImMc > .grsPopupImSLc {
				z-index: 0;
			}
			.grsTemplate".$id." .grsPopupImMc > .grsPopupImFLc.active {
				z-index: 1;
			}
			.grsTemplate".$id." .grsPopupImMc > .grsPopupImSLc.active {
				z-index: 1;
			}
			.grsTemplate".$id." .grsPopupImMc video, .grsPopupImMc iframe {
				height:100%; 
				width:100%;
			}
			.grsTemplate".$id." .grsPopupImMc > .grsPopupImLc > .grsPopupImLV {
				height:inherit;
				width:inherit;
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
			}
			.grsTemplate".$id." .grsPopupImMc > .grsPopupImLc > .grsPopupImLV > .grsPopupImLfE {
				position:relative;
				overflow:hidden;
				display:block;
			}
			.grsTemplate".$id." .grsPopupImMc > .grsPopupImLc > .grsPopupImLV > .grsPopupImLfE > img {
				display:block;
			}
			/*Navigation*/";
			if($grsTheme->navButtShButts == 'onhover') {
				$lightbox .= ".grsTemplate".$id." .grsPopupImMc:hover > .grsPopupImNVl {";
					if($grsTheme->navButtHoverEffect == 'fade') {
						$lightbox .= "opacity: 1;";
					} elseif($grsTheme->navButtHoverEffect == 'slideIn') {
						$lightbox .= "opacity: 1;
						transform: translateX(0%);";
					} elseif($grsTheme->navButtHoverEffect == 'rotateIn') {
						$lightbox .= "opacity: 1;
						transform: translateX(0%) rotate(0deg);";
					} elseif($grsTheme->navButtHoverEffect == 'no') {
						$lightbox .= "display: block;";
					}
				$lightbox .= "}";
				$lightbox .= ".grsTemplate".$id." .grsPopupImMc:hover > .grsPopupImNVr {";
					if($grsTheme->navButtHoverEffect == 'fade') {
						$lightbox .= "opacity: 1;";
					} elseif($grsTheme->navButtHoverEffect == 'slideIn') {
						$lightbox .= "opacity: 1;
						transform: translateX(0%);";
					} elseif($grsTheme->navButtHoverEffect == 'rotateIn') {
						$lightbox .= "opacity: 1;
						transform: translateX(0%) rotate(0deg);";
					} elseif($grsTheme->navButtHoverEffect == 'no') {
						$lightbox .= "display: block;";
					}
				$lightbox .= "}";
			}
			$lightbox .= ".grsTemplate".$id." .grsPopupImMc > .grsPopupImNVb {
			    display: -webkit-box;
			    display: -webkit-flex;
			    display: -ms-flexbox;
			    display: flex;
			    -webkit-box-align: center;
			    -webkit-align-items: center;
			    -ms-flex-align: center;
			    align-items: center;
			    /*-webkit-box-pack: center;
			    -webkit-justify-content: center;
			    -ms-flex-pack: center;
			    justify-content: center;*/
				position: absolute;
				top: calc(50% - (".($grsTheme->navButtBoxSize/2)."px));
				height: ".$grsTheme->navButtBoxSize."px;
				width: ".$grsTheme->navButtBoxSize."px;
				box-shadow: ".$grsTheme->navButtBoxshadowFstVal."px ".$grsTheme->navButtBoxshadowSecVal."px ".$grsTheme->navButtBoxshadowThdVal."px ".$grsTheme->navButtBoxshadowColor .";
				background-color: ".$grsTheme->navButtBgColor .";
				border: ".$grsTheme->navButtBorderWidth."px ".$grsTheme->navButtBorderStyle." ".$grsTheme->navButtBorderColor ."; 
				border-radius: ".$grsTheme->navButtBorderRadius."px;
				z-index: 2;
				cursor:pointer;
				transition: 0.3s all ease-in-out;";
				if($grsTheme->navButtShButts == 'no') {
					$lightbox .= "display: none;";
				}
			$lightbox .= "}";
			$lightbox .= ".grsTemplate".$id." .grsPopupImMc  > .grsPopupImNVl {
                -webkit-box-pack: flex-start;
			    -webkit-justify-content: flex-start;
			    -ms-flex-pack: flex-start;
			    justify-content: flex-start;
    			left: 0;";
				if($grsTheme->navButtShButts == 'onhover') {
					if($grsTheme->navButtHoverEffect == 'fade') {
						$lightbox .= "opacity: 0;";
					}  elseif($grsTheme->navButtHoverEffect == 'slideIn') {
						$lightbox .= "opacity: 0;
						transform: translateX(-100%);";
					}  elseif($grsTheme->navButtHoverEffect == 'rotateIn') {
						$lightbox .= "opacity: 0;
						transform: translateX(-100%) rotate(-180deg);";
					} elseif($grsTheme->navButtHoverEffect == 'no') {
						$lightbox .= "display: none;";
					}
				}
			$lightbox .= "}";
			$lightbox .= ".grsTemplate".$id." .grsPopupImMc > .grsPopupImNVr {
                -webkit-box-pack: flex-end;
			    -webkit-justify-content: flex-end;
			    -ms-flex-pack: flex-end;
			    justify-content: flex-end;
				right: 0;";
				if($grsTheme->navButtShButts == 'onhover') {
					if($grsTheme->navButtHoverEffect == 'fade') {
						$lightbox .= "opacity: 0;";
					} elseif($grsTheme->navButtHoverEffect == 'slideIn') {
						$lightbox .= "opacity: 0;
						transform: translateX(100%);";
					} elseif($grsTheme->navButtHoverEffect == 'rotateIn') {
						$lightbox .= "opacity: 0;
						transform: translateX(100%) rotate(180deg);";
					} elseif($grsTheme->navButtHoverEffect == 'no') {
						$lightbox .= "display: none;";
					}
				}
			$lightbox .= "}
			.grsTemplate".$id." .grsPopupImMc > .grsPopupImNVl > .fa {
			    margin: 0 0 0 ".$grsTheme->navButtMargin."px;
			}
			.grsTemplate".$id." .grsPopupImMc > .grsPopupImNVr > .fa {
			    margin: 0 ".$grsTheme->navButtMargin."px 0 0;
			}
			.grsTemplate".$id." .grsPopupImMc > .grsPopupImNVb > .fa {
				font-size: ".$grsTheme->navButtSize."px;
				color: ".$grsTheme->navButtColor.";
				text-shadow: ".$grsTheme->navButtShadowFstVal."px ".$grsTheme->navButtShadowSecVal."px ".$grsTheme->navButtShadowThdVal."px ".$grsTheme->navButtShadowColor.";
				transition: 0.2s all ease-in-out;
			    padding: 0;
			    border: none;
			    outline: none;
			}
			.grsTemplate".$id." .grsPopupImMc > .grsPopupImNVb:hover > .fa {
				color: ".$grsTheme->navButtHoverColor.";
				text-shadow: ".$grsTheme->navButtHoverShadowFstVal."px ".$grsTheme->navButtHoverShadowSecVal."px ".$grsTheme->navButtHoverShadowThdVal."px ".$grsTheme->navButtHoverShadowColor.";
			}
			/* Loading */
			.grsTemplate".$id." .grsPopupImMc > .grsPopupLc {
				height: 56px;
				z-index:1;
				width:100%;
				max-height: 100%;
				position:absolute;
				top: 10px;
				left: 10px;
				background-image: url('".GRS_PLG_URL."/images/admin/ring-alt-p.svg');
				background-position: left top;
				background-repeat: no-repeat;
				background-size: auto;
			}
			.grsTemplate".$id." .grsPopupCoC .grsPopupCoCLoC {
			    height: 30px;
			    width: 30px;
			    float: left;
				background-image: url('".GRS_PLG_URL."/images/admin/ring-alt-c.svg');
			    background-position: center center;
				background-repeat: no-repeat;
				background-size: auto;
			}
			/* Control Buttons */
			.grsTemplate".$id." .grsPopupImMc > .grsPopupB {
			    z-index:3;
				width:100%;
				max-height: 100%;
				position: absolute;
				".($grsTheme->filmstripPos == 'top' ? 'bottom' : 'top').": 0px;
				left: 0px;
				height: ".($contButtContHeight = $grsTheme->contButtBoxSize + 2 * ($grsTheme->contButtcontMargin + ($grsTheme->contButtBorderStyle != 'none' ? $grsTheme->contButtBorderWidth : 0)))."px;
				box-sizing: content-box;
				border: ".$grsTheme->contButtContBorderWidth."px ".$grsTheme->contButtContBorderStyle." ".$grsTheme->contButtContBorderColor ."; 
				background: ".$grsTheme->contButtContBgGrFrColor."; /* For browsers that do not support gradients */
                background: -webkit-linear-gradient(".$grsTheme->contButtContBgGrDir.", ".$grsTheme->contButtContBgGrFrColor.", ".$grsTheme->contButtContBgGrToColor."); /* For Safari 5.1 to 6.0 */
                background: -o-linear-gradient(".$grsTheme->contButtContBgGrDir.", ".$grsTheme->contButtContBgGrFrColor.", ".$grsTheme->contButtContBgGrToColor."); /* For Opera 11.1 to 12.0 */
                background: -moz-linear-gradient(".$grsTheme->contButtContBgGrDir.", ".$grsTheme->contButtContBgGrFrColor.", ".$grsTheme->contButtContBgGrToColor."); /* For Firefox 3.6 to 15 */
                background: linear-gradient(".$grsTheme->contButtContBgGrDir.", ".$grsTheme->contButtContBgGrFrColor.", ".$grsTheme->contButtContBgGrToColor."); /* Standard syntax */
				box-shadow: ".$grsTheme->contButtContBoxshadowFstVal."px ".$grsTheme->contButtContBoxshadowSecVal."px ".$grsTheme->contButtContBoxshadowThdVal."px ".$grsTheme->contButtContBoxshadowColor .";
				border-".($grsTheme->filmstripPos == 'top' ? 'bottom' : 'top')."-style: none;
				border-right-style: none;
				border-left-style: none;
				opacity: 0;
				transition: 0.3s all ease-in-out;
			}
			.grsTemplate".$id." .grsPopupImMc:hover > .grsPopupB {
			    opacity: 1;
			}
			.grsTemplate".$id." .grsPopupImMc > .grsPopupB > .grsPopupSBmC {
				float: left;
				height: ".($grsTheme->contButtBoxSize + 2*($grsTheme->contButtBorderStyle != 'none' ? $grsTheme->contButtBorderWidth : 0))."px;
				margin: ".$grsTheme->contButtcontMargin."px 0px;
			}
			.grsTemplate".$id." .grsPopupImMc > .grsPopupB > .grsPopupOBmC {
				float:right;
				height: ".($grsTheme->contButtBoxSize + 2*($grsTheme->contButtBorderStyle != 'none' ? $grsTheme->contButtBorderWidth : 0))."px;
				margin: ".$grsTheme->contButtcontMargin."px 0px;
			}
			.grsTemplate".$id." .grsPopupImMc > .grsPopupB > .grsPopupSBmC .grsPopupSB {
			    margin: 0px 0px 0px ".$grsTheme->contButtMargin."px ; 
			} 
			.grsTemplate".$id." .grsPopupImMc > .grsPopupB > .grsPopupOBmC .grsPopupOB {
			    margin: 0px ".$grsTheme->contButtMargin."px 0px 0px; 
			}
			.grsTemplate".$id." .grsPopupImMc > .grsPopupB > .grsPopupSBmC .grsPopupSB, 
			.grsTemplate".$id." .grsPopupImMc > .grsPopupB > .grsPopupOBmC .grsPopupOB {
				width: ".$grsTheme->contButtBoxSize."px;
				height: ".$grsTheme->contButtBoxSize."px;
				border: ".$grsTheme->contButtBorderWidth."px ".$grsTheme->contButtBorderStyle." ".$grsTheme->contButtBorderColor ."; 
				box-sizing: content-box;
				border-radius: ".$grsTheme->contButtBorderRadius."px;
				box-shadow: ".$grsTheme->contButtBoxshadowFstVal."px ".$grsTheme->contButtBoxshadowSecVal."px ".$grsTheme->contButtBoxshadowThdVal."px ".$grsTheme->contButtBoxshadowColor .";
				background-color: ".$grsTheme->contButtBgColor .";
				cursor: pointer;
				float:left;
				background-repeat: no-repeat;
				background-size: ".($grsTheme->contButtSize < 35 ? 'contain' : 'auto' ).";
				background-position: center center;
				transition: 0.2s all ease-in-out;
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
			}
            .grsTemplate".$id." .grsPopupImMc > .grsPopupB > .grsPopupSBmC .grsPopupSB:hover, 
			.grsTemplate".$id." .grsPopupImMc > .grsPopupB > .grsPopupOBmC .grsPopupOB:hover {
			    background-color: ".$grsTheme->contButtHoverBgColor.";
			}
			.grsTemplate".$id." .grsPopupImMc > .grsPopupB > .grsPopupSBmC .grsPopupSB > .fa, 
			.grsTemplate".$id." .grsPopupImMc > .grsPopupB > .grsPopupOBmC .grsPopupOB > .fa {
				margin: 0;
				padding: 0;
				border: none;
				outline: none;
			    font-size: ".$grsTheme->contButtSize."px;
				color: ".$grsTheme->contButtColor.";
				text-shadow: ".$grsTheme->contButtShadowFstVal."px ".$grsTheme->contButtShadowSecVal."px ".$grsTheme->contButtShadowThdVal."px ".$grsTheme->contButtShadowColor .";
				transition: 0.3s all ease-in-out;
			}
            .grsTemplate".$id." .grsPopupImMc > .grsPopupB > .grsPopupSBmC .grsPopupSB:hover > .fa, 
			.grsTemplate".$id." .grsPopupImMc > .grsPopupB > .grsPopupOBmC .grsPopupOB:hover > .fa {
				color: ".$grsTheme->contButtHoverColor.";
				text-shadow: none;
				transition: 0.3s all ease-in-out;
			}
			/* Refactored styles for video content */
			.grsTemplate".$id." .grsPopupImMc > .grsPopupB.refactorContent {
				left: 0;
				width: ".($grsTheme->contButtBoxSize + 2 * ($grsTheme->contButtcontMargin + ($grsTheme->contButtBorderStyle != 'none' ? $grsTheme->contButtBorderWidth : 0)))."px;
				height: 100%;
				border: none;
				background: ".$grsTheme->contButtContBgGrFrColor."; /* For browsers that do not support gradients */
                background: -webkit-linear-gradient(90deg, ".$grsTheme->contButtContBgGrFrColor.", ".$grsTheme->contButtContBgGrToColor."); /* For Safari 5.1 to 6.0 */
                background: -o-linear-gradient(90deg, ".$grsTheme->contButtContBgGrFrColor.", ".$grsTheme->contButtContBgGrToColor."); /* For Opera 11.1 to 12.0 */
                background: -moz-linear-gradient(90deg, ".$grsTheme->contButtContBgGrFrColor.", ".$grsTheme->contButtContBgGrToColor."); /* For Firefox 3.6 to 15 */
                background: linear-gradient(90deg, ".$grsTheme->contButtContBgGrFrColor.", ".$grsTheme->contButtContBgGrToColor."); /* Standard syntax */
			}
			.grsTemplate".$id." .grsPopupImMc > .grsPopupB.refactorContent > .grsPopupSBmC {
				position: absolute;
				top: 40px;
				width: ".($grsTheme->contButtBoxSize + 2*($grsTheme->contButtBorderStyle != 'none' ? $grsTheme->contButtBorderWidth : 0))."px;
				height: auto;
				margin: 0px ".$grsTheme->contButtcontMargin."px;
			}
			.grsTemplate".$id." .grsPopupImMc > .grsPopupB.refactorContent > .grsPopupOBmC {
				position: absolute;
				bottom: 40px;
				width: ".($grsTheme->contButtBoxSize + 2*($grsTheme->contButtBorderStyle != 'none' ? $grsTheme->contButtBorderWidth : 0))."px;
				height: auto;
				margin: 0px ".$grsTheme->contButtcontMargin."px;
			}
			.grsTemplate".$id." .grsPopupImMc > .grsPopupB.refactorContent > .grsPopupSBmC .grsPopupSB {
			    margin: ".$grsTheme->contButtMargin."px 0px 0px 0px; 
			} 
			.grsTemplate".$id." .grsPopupImMc > .grsPopupB.refactorContent > .grsPopupOBmC .grsPopupOB {
			    margin: 0px 0px ".$grsTheme->contButtMargin."px 0px; 
			}
			
			/*Title & description*/
			.grsTemplate".$id." .grsPopupImMc > .grsPopupTc {
				position: absolute;";
				$lightbox .= $this->getRightPosition($grsTheme->titleDescpPosXoffset, $grsTheme->titleDescpPosYoffset, $grsTheme->titleDescpPos);
                $lightbox .= "width: ".($grsTheme->titleDescpFWith ? '100%' : $grsTheme->titleDescpWith . 'px' ).";
			    padding: ".$grsTheme->titleDescpPadding."px;
			    background: ".$grsTheme->titleDescpBgGrFrColor."; /* For browsers that do not support gradients */
                background: -webkit-linear-gradient(".$grsTheme->titleDescpBgGrDir.", ".$grsTheme->titleDescpBgGrFrColor.", ".$grsTheme->titleDescpBgGrToColor."); /* For Safari 5.1 to 6.0 */
                background: -o-linear-gradient(".$grsTheme->titleDescpBgGrDir.", ".$grsTheme->titleDescpBgGrFrColor.", ".$grsTheme->titleDescpBgGrToColor."); /* For Opera 11.1 to 12.0 */
                background: -moz-linear-gradient(".$grsTheme->titleDescpBgGrDir.", ".$grsTheme->titleDescpBgGrFrColor.", ".$grsTheme->titleDescpBgGrToColor."); /* For Firefox 3.6 to 15 */
                background: linear-gradient(".$grsTheme->titleDescpBgGrDir.", ".$grsTheme->titleDescpBgGrFrColor.", ".$grsTheme->titleDescpBgGrToColor."); /* Standard syntax */
			    box-shadow: ".$grsTheme->titleDescpshadowFstVal."px ".$grsTheme->titleDescpshadowSecVal."px ".$grsTheme->titleDescpshadowThdVal."px ".$grsTheme->titleDescpshadowColor .";
			    font-family: ".$grsTheme->titleDescpTffamily .";
			    z-index: 1;
			    border-radius: ".$grsTheme->titleDescpBrad."px;
			    box-sizing: border-box;
			    line-height: normal;
			    max-block-size: max-content;
			    max-width: 100%;
			    opacity: 0;
				transition: 0.3s all ease-in-out;
			}
			.grsTemplate".$id." .grsPopupImMc:hover > .grsPopupTc {
			    opacity: 1;
			}
			.grsTemplate".$id." .grsPopupImMc > .grsPopupTc > span {
				display: block;
				color: ".$grsTheme->titleDescpTColor .";
			    text-align: left;
			    word-wrap: break-word;
			    font-size: ".$grsTheme->titleDescpTfsize."px;
			    font-weight: ".$grsTheme->titleDescpTfweight .";
			    max-width: ".$grsTheme->titleDescpTmaxWidth."%;
			}
			.grsTemplate".$id." .grsPopupImMc > .grsPopupTc > p {
			    color: ".$grsTheme->titleDescpDColor .";
			    text-align: justify;
			    word-wrap: break-word;
			    line-height: 1.5;
			    margin: 0;
			    padding: 0;
			    font-size: ".$grsTheme->titleDescpDfsize."px;
			    font-weight: ".$grsTheme->titleDescpDfweight .";
			    max-width: ".$grsTheme->titleDescpDmaxWidth."%;
			}
			/* Image counting */
			.grsTemplate".$id." .grsPopupImMc > .grsPopupImCount { 
				position: absolute;";
				$lightbox .= $this->getRightPosition($grsTheme->imgcoPosXoffset, $grsTheme->imgcoPosYoffset, $grsTheme->imgcoPos);
				$lightbox .= "z-index: 1;
				border-radius: ".$grsTheme->imgcoBrad."px;
				background-color: ".$grsTheme->imgcoBgColor .";
				padding: ".$grsTheme->imgcoPadding."px;
				box-shadow: ".$grsTheme->imgcoshadowFstVal."px ".$grsTheme->imgcoshadowSecVal."px ".$grsTheme->imgcoshadowThdVal."px ".$grsTheme->imgcoshadowColor .";
				box-sizing: border-box;
			    line-height: normal;
			    opacity: 0;
				transition: 0.3s all ease-in-out;
			}
			.grsTemplate".$id." .grsPopupImMc:hover > .grsPopupImCount {
			    opacity: 1;
			}
			.grsTemplate".$id." .grsPopupImMc > .grsPopupImCount > span {
				display: block;
				color: ".$grsTheme->imgcoColor .";
		    	font-size: ".$grsTheme->imgcofsize."px;
		    	font-weight: ".$grsTheme->imgcofweight .";
		    	font-family: ".$grsTheme->imgcoffamily .";
			}
			/* Comments container */
			.grsTemplate".$id." .grsPopupCoC {
				max-height: 100%;
				display: block;
				height: 100%;
				position: absolute;
				overflow: hidden;
				background-color: ".$grsTheme->commContBgcolor .";
				padding: ".$grsTheme->commContMargin."px ".$grsTheme->commContMarginH."px;
				box-sizing:border-box;
				text-align:left;
				overflow: auto;
			}
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCb {
				position:absolute;
				left: ".$grsTheme->commClButtPosXoffset."px;
				top: ".$grsTheme->commClButtPosYoffset."px;
				width:".$grsTheme->commClButtBoxSize."px;
				height:".$grsTheme->commClButtBoxSize."px;
				background-color: ".$grsTheme->commClButtBgColor .";
				box-shadow: ".$grsTheme->commClButtBoxshadowFstVal."px ".$grsTheme->commClButtBoxshadowSecVal."px ".$grsTheme->commClButtBoxshadowThdVal."px ".$grsTheme->commClButtBoxshadowColor .";
				border: ".$grsTheme->commClButtBorderWidth."px ".$grsTheme->commClButtBorderStyle." ".$grsTheme->commClButtBorderColor ."; 
				border-radius: ".$grsTheme->commClButtBorderRadius."px;
				z-index: 2;
				cursor:pointer;
				background-repeat: no-repeat;
				background-size: ".($grsTheme->commClButtBoxSize < 35 ? 'contain' : 'auto' ).";
				background-position: center center;
				transition: 0.3s background-image linear;
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
			}
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCb > .fa {
			    font-size: ".$grsTheme->commClButtSize."px;
				color: ".$grsTheme->commClButtColor.";
				transition: 0.3s all ease-in-out;
			}
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCb:hover > .fa {
			    color: ".$grsTheme->commClButtHoverColor .";
			}
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCNc,
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCEc,
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCc,
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCPc {
				margin: 8px 0px 0px 0px;
				box-sizing: border-box;
				border-width: 1px;
				border-color: white;
			}
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCNc > .grsPopupCoCNLc,
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCEc > .grsPopupCoCELc,
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCc > .grsPopupCoCCLc,
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCPc > .grsPopupCoCCPic {
				margin: 0px 0px 3px 0px;
			}
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCNc label , 
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCEc label, 
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCc label,
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCPc label {
				font-weight: ".$grsTheme->commFontWeight .";
				font-family: ".$grsTheme->commFontFamily .";
				font-size: ".$grsTheme->commFontSize."px;
				font-style: ".$grsTheme->commFontStyle .";
				color: ".$grsTheme->commFontColor .";
				cursor: pointer;
			}
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCNc .grsPopupCoCNi, 
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCEc .grsPopupCoCEi, 
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCc .grsPopupCoCCi,
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCPc .grsPopupCoCCPinp {
				font-size: ".$grsTheme->commInpFSize."px;
				font-family: ".$grsTheme->commInpFFamily .";
				font-weight: ".$grsTheme->commInpFWeight .";
				font-style: ".$grsTheme->commInpFFstyle .";
				box-shadow: ".$grsTheme->commInpBoxshadowFstVal."px ".$grsTheme->commInpBoxshadowSecVal."px ".$grsTheme->commInpBoxshadowThdVal."px ".$grsTheme->commInpBoxshadowColor .";
				border: ".$grsTheme->commInpBorderWidth."px ".$grsTheme->commInpBorderStyle." ".$grsTheme->commInpBorderColor ."; 
				border-radius: ".$grsTheme->commInpBorderRadius."px;
				background-color: ".$grsTheme->commInpBgColor .";
				color: ".$grsTheme->commInpColor." !important;
				padding: 2px;
				box-sizing: border-box;
				max-width: 100%;
				width: 100%;
				-webkit-appearance: none;
				text-decoration: none;
				overflow: hidden;
				transition-duration: 200ms !important;
				-webkit-transition-duration: 200ms !important;
				transition-property: border, box-shadow !important;
				-webkit-transition-property: border, box-shadow !important;
				transition-timing-function: linear !important;
				-webkit-transition-timing-function: linear !important;
				outline: none;
				height: auto;
			}
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCNc  .grsPopupCoCNi:focus, 
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCEc  .grsPopupCoCEi:focus, 
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCc  .grsPopupCoCCi:focus,
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCPc .grsPopupCoCCPinp:focus {
				padding: 2px; 
				-webkit-appearance: none;
				overflow: hidden;
				background-color: ".$grsTheme->commInpBgColor .";
				box-shadow: ".$grsTheme->commInpAcBoxshadowFstVal."px ".$grsTheme->commInpAcBoxshadowSecVal."px ".$grsTheme->commInpAcBoxshadowThdVal."px ".$grsTheme->commInpAcBoxshadowColor ."; 
				border: ".$grsTheme->commInpBorderWidth."px ".$grsTheme->commInpBorderStyle." ".$grsTheme->commInpAcBorderColor ."; 
				outline: none;
			}
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCNc .grsPopupCoCNi.error, 
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCEc .grsPopupCoCEi.error, 
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCc .grsPopupCoCCi.error,
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCPc .grsPopupCoCCPinp.error {
				box-shadow: ".$grsTheme->commInpAcBoxshadowFstVal."px ".$grsTheme->commInpAcBoxshadowSecVal."px ".$grsTheme->commInpAcBoxshadowThdVal."px red; 
				border: ".$grsTheme->commInpBorderWidth."px ".$grsTheme->commInpBorderStyle." red; 
			}
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCc .grsPopupCoCCi, .grsPopupCoC > .grsPopupCoCCc .grsPopupCoCCi:focus {
				min-height: 120px;
			}
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCPc > .grsPopupCoCCPic {
				float:left;
				width: 70px;
			}
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCPc > .grsPopupCoCCPic > .grsPopupCoCCPi {
				width: 100%;
				max-height:32px;
				margin: 0px 0px 2px 0px;
			}
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCPc > .grsPopupCoCCPic > .grsPopupCoCCPi > .grsPopupCoCCPim {
				width: 100%;
				min-height:32px;
				max-height:32px
			}
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCPc > .grsPopupCoCCPcRc {
				float: left;
				height: ".(32 + 2 + 2*2 + $grsTheme->commInpFSize)."px;/*captcha nkar + input size + 2*input padding + 2*inputborder*/
				margin: 0px 0px 0px 6px;
			} 
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCPc > .grsPopupCoCCPcRc > .grsPopupCoCCPcRcV {
				display: table;
				height: 100%;
			} 
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCPc > .grsPopupCoCCPcRc > .grsPopupCoCCPcRcV > .grsPopupCoCCPcRcVc {
				display: table-cell;
				height: 100%;
				vertical-align: middle;
			} 
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCPc > .grsPopupCoCCPcRc > .grsPopupCoCCPcRcV > .grsPopupCoCCPcRcVc > .grsPopupCoCCPcR {
				width: ".$grsTheme->commCpButtBoxSize."px;
				height: ".$grsTheme->commCpButtBoxSize."px;
				background-color: ".$grsTheme->commCpButtBgColor .";
				box-shadow: ".$grsTheme->commCpButtBoxshadowFstVal."px ".$grsTheme->commCpButtBoxshadowSecVal."px ".$grsTheme->commCpButtBoxshadowThdVal."px ".$grsTheme->commCpButtBoxshadowColor ."; 
				border: ".$grsTheme->commCpButtBorderWidth."px ".$grsTheme->commCpButtBorderStyle." ".$grsTheme->commCpButtBorderColor ."; 
				border-radius: ".$grsTheme->commCpButtBorderRadius."px;
				cursor: pointer;
				transition: 0.3s background-image linear;
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
			} 
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCPc > .grsPopupCoCCPcRc > .grsPopupCoCCPcRcV > .grsPopupCoCCPcRcVc > .grsPopupCoCCPcR > .fa {
			    font-size: ".$grsTheme->commCpButtSize ."px;
				color: ".$grsTheme->commCpButtColor.";
				transition: 0.3s all ease-in-out;
			}
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCPc > .grsPopupCoCCPcRc > .grsPopupCoCCPcRcV > .grsPopupCoCCPcRcVc > .grsPopupCoCCPcR:hover > .fa {
			    color: ".$grsTheme->commCpButtHoverColor.";
			}
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCPc .grsPopupCoCCPinp {
			}
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCosC {
				margin: 8px 0px 0px 0px;
			}
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCosC .grsPopupCoCCoC {
				margin-top: 2px;
				padding: 3px 3px 3px 3px;
				box-sizing: border-box;
				border-width: 1px;
				border-color: white;
			}
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCosC > .grsPopupCoCCoC > .grsPopupCoCCoTc {
				font-weight: ".$grsTheme->commTFontWeight .";
				font-family: ".$grsTheme->commTFontFamily .";
				font-size: ".$grsTheme->commTFontSize."px;
				font-style: ".$grsTheme->commTFontStyle .";
				color: ".$grsTheme->commTFontColor .";
			    line-height: ".$grsTheme->commAFontSize."px;
				margin: 0px;
				word-wrap: break-word;
    			text-align: left;
			}
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCosC > .grsPopupCoCCoC > .grsPopupCoCCoTc > .grsPopupCoCCoTn {
			    font-weight: ".$grsTheme->commAFontWeight .";
				font-family: ".$grsTheme->commAFontFamily .";
				font-size: ".$grsTheme->commAFontSize."px;
				font-style: ".$grsTheme->commAFontStyle .";
				color: ".$grsTheme->commAFontColor .";
			    margin: 0px 10px 0px 0px;
			    word-wrap: break-word;
    			text-align: left;
			}
			.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCosC > .grsPopupCoCCoC > .grsPopupCoCCoTd {
			    display: block;
			    margin: 5px 0px 0px 0px;
			    font-weight: ".$grsTheme->commDFontWeight .";
				font-family: ".$grsTheme->commDFontFamily .";
				font-size: ".$grsTheme->commDFontSize."px;
				font-style: ".$grsTheme->commDFontStyle .";
				color: ".$grsTheme->commDFontColor .";
				word-wrap: break-word;
    			text-align: left;
			}
			.grsTemplate".$id." .grsPopupCoCClos {
				position:absolute;";
				$lightbox .= $this->getRightPosition($grsTheme->closeButtPosXoffset, $grsTheme->closeButtPosYoffset, $grsTheme->closeButtPos);
				$lightbox .= "width:".$grsTheme->closeButtBoxSize."px;
				height:".$grsTheme->closeButtBoxSize."px;
				border-radius:".$grsTheme->closeButtBRad."px;
				border: ".$grsTheme->closeButtBorderWidth."px ".$grsTheme->closeButtBorderStyle." ".$grsTheme->closeButtBorderColor ."; 
				background-color: ".$grsTheme->closeButtBgColor .";
				box-shadow: ".$grsTheme->closeButtBoxshadowFstVal."px ".$grsTheme->closeButtBoxshadowSecVal."px ".$grsTheme->closeButtBoxshadowThdVal."px ".$grsTheme->closeButtBoxshadowColor .";
				cursor:pointer;
				z-index: 3;
				transition: 0.3s all linear;
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
			}
			.grsTemplate".$id." .grsPopupCoCClos > .fa {
			    font-size: ".$grsTheme->closeButtSize ."px;
				color: ".$grsTheme->closeButtColor.";
				transition: 0.3s all ease-in-out;
				margin: 0;
				border: 0;
				outline: 0;
				padding: 0;
			}
			.grsTemplate".$id." .grsPopupCoCClos:hover > .fa {
			    color: ".$grsTheme->closeButtHoverColor.";
			}
			.grsTemplate".$id." .grsPopupCoCClos.grsPopupCoCClosRes {";
                $lightbox .= $this->getRightPosition(5, 5, $grsTheme->closeButtPos)."
            }
            .grsTemplate".$id." .grsPopupCoCClos.grsPopupCoCClosResWithFilm {";
                $lightbox .= $this->getRightPosition(5, $filmstripContHeight, $grsTheme->closeButtPos)."
            }
            .grsTemplate".$id." .grsPopupCoCClos.grsPopupCoCClosResWithContButts {";
                $lightbox .= $this->getRightPosition($grsTheme->contButtMargin, $contButtContHeight, $grsTheme->closeButtPos)."
            }
            .grsTemplate".$id." .grsPopupCoCClos.comm {";
                $lightbox .= $this->getRightPosition(5, 5, $grsTheme->closeButtPos)."
            }
			/* Media rules */
			@media screen and (max-width: 700px) , screen and (max-height: 500px) {
				/* Filmstrip */
                .grsTemplate".$id." .grsPopupImC > .grsPopupFc .grsPopupFIsC > .grsPopupFiC:first-child {
                    margin: ".($res700x500FilmMarTop = intval($grsTheme->filmstripMarginTop/2))."px  ".( $res700x500FilmThMar = intval($grsTheme->filmThumbMargin/2))."px ".( $res700x500FilmMarBottom = intval($grsTheme->filmstripMarginBottom/2))."px ".$res700x500FilmThMar."px;
                }
				.grsTemplate".$id." .grsPopupImC > .grsPopupFc .grsPopupFIsC > .grsPopupFiC {";
                    $res700x500FilmSize = $this->getWidthHeightForFmResize(80, $grsTheme->filmThumbWidth, $grsTheme->filmstripSize );
                    $lightbox .= "height: ".$res700x500FilmSize->height."px;
                    width: ". $res700x500FilmSize->width."px;
                    margin: ".$res700x500FilmMarTop."px  ".$res700x500FilmThMar."px ".$res700x500FilmMarBottom."px 0px;
                    padding: 0;
                    border: none;
                }
				.grsTemplate".$id." .grsPopupImC > .grsPopupFc .grsPopupFIsC > .grsPopupFiC > .grsPopupFi {";
                    if($grsTheme->filmThumbSelEffect == 'border') {
                        $lightbox .= "outline-width: ".(intval($grsTheme->filmSelThumbBorderWidth/2))."px";
                    }
                $lightbox .= "}
				.grsTemplate".$id." .grsPopupImC > .grsPopupFc {
					height: ".($res700X500FilmHeight = $res700x500FilmSize->height + $res700x500FilmMarTop + $res700x500FilmMarBottom)."px;
				}
				.grsTemplate".$id." .grsPopupImC > .grsPopupFc .grsPopupFmB {";
                    $res700x500FmNavSize = $this->getWidthHeightForFmResize(25, 40, 40); // just pass equal vars
                    $lightbox.="width: ".$res700x500FmNavSize->width."px;
                    height: ".$res700x500FmNavSize->height."px;
                    top: calc(50% - (".($res700x500FmNavSize->height/2)."px));
                    border-radius: 15px;
				}
				.grsTemplate".$id." .grsPopupImC > .grsPopupFc .grsPopupFmR {
                    left: 3px;
                }
                .grsTemplate".$id." .grsPopupImC > .grsPopupFc .grsPopupFmL {
                    right: 3px;
                }
                .grsTemplate".$id." .grsPopupImC > .grsPopupFc .grsPopupFmB > .fa {
                    font-size: 18px;
                }
				/* Control buttons */
				.grsTemplate".$id." .grsPopupImMc > .grsPopupB {
					height: ".($res700X500ContButtHeight = (23 + 2 * (7 + ($grsTheme->contButtBorderStyle != 'none' ? 1 : 0))))."px;
				}
				.grsTemplate".$id." .grsPopupImMc > .grsPopupB > .grsPopupSBmC {
					height: ".(23 + 2*($grsTheme->contButtBorderStyle != 'none' ? 1 : 0))."px;
					margin: 7px 0px;
				}
				.grsTemplate".$id." .grsPopupImMc > .grsPopupB > .grsPopupOBmC {
					height: ".(23 + 2*($grsTheme->contButtBorderStyle != 'none' ? 1 : 0))."px;
					margin: 7px 0px;
				}
				.grsTemplate".$id." .grsPopupImMc > .grsPopupB > .grsPopupSBmC .grsPopupSB, 
				.grsTemplate".$id." .grsPopupImMc > .grsPopupB > .grsPopupOBmC .grsPopupOB {
					width: 23px;
					height: 23px;
					border: 1px ".$grsTheme->contButtBorderStyle." ".$grsTheme->contButtBorderColor ."; 
				}
                .grsTemplate".$id." .grsPopupImMc > .grsPopupB > .grsPopupSBmC .grsPopupSB {
                    margin: 0px 0px 0px 10px ; 
                } 
                .grsTemplate".$id." .grsPopupImMc > .grsPopupB > .grsPopupOBmC .grsPopupOB {
                    margin: 0px 10px 0px 0px; 
                }
				.grsTemplate".$id." .grsPopupImMc > .grsPopupB > .grsPopupSBmC .grsPopupSB > .fa, 
                .grsTemplate".$id." .grsPopupImMc > .grsPopupB > .grsPopupOBmC .grsPopupOB > .fa {
                    font-size: 13px;
                }
				/* Navigation */
				.grsTemplate".$id." .grsPopupImMc > .grsPopupImNVb {
					height: 100px;
					width: 100px;
					top: calc(50% - (50px));
				}
				.grsTemplate".$id." .grsPopupImMc > .grsPopupImNVl > .fa {
					margin-left: 15px;
				}
				.grsTemplate".$id." .grsPopupImMc > .grsPopupImNVr > .fa {
					margin-right: 15px;
				}
				.grsTemplate".$id." .grsPopupImMc > .grsPopupImNVb > .fa {
                    font-size: 45px;
                }
				/*Title & description*/
				.grsTemplate".$id." .grsPopupImMc > .grsPopupTc {
				    width: ".($grsTheme->titleDescpFWith ? '100%' : '150px' ).";
				    padding: ".($res700X500ImgCountPos = intval($grsTheme->titleDescpPadding/2))."px;
				}
				.grsTemplate".$id." .grsPopupImMc > .grsPopupTc > span {
				    font-size: 12px;
				}
				.grsTemplate".$id." .grsPopupImMc > .grsPopupTc > p {
				    font-size: 10px;
				}
				/*Image counting*/
				.grsTemplate".$id." .grsPopupImMc > .grsPopupImCount {";
				    $lightbox .= $this->getRightPosition(12, $res700X500ImgCountPos, $grsTheme->imgcoPos)."
					padding: ".(intval($grsTheme->imgcoPadding/2))."px;
				}
				.grsTemplate".$id." .grsPopupImMc > .grsPopupImCount > span {
			    	font-size: 10px;
				}
				/* Comments container */
				.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCNc label , 
				.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCEc label, 
				.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCc label,
				.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCPc label {
					font-size: 12px;
				}
				.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCNc .grsPopupCoCNi, 
				.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCEc .grsPopupCoCEi, 
				.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCc .grsPopupCoCCi,
				.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCPc .grsPopupCoCCPinp {
					font-size: 11px;
				}
				.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCb {
					width: 25px;
					height: 25px;
				}
				.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCPc > .grsPopupCoCCPcRc > .grsPopupCoCCPcRcV > .grsPopupCoCCPcRcVc > .grsPopupCoCCPcR {
					width: 25px;
					height: 25px;
				}
                .grsTemplate".$id." .grsPopupCoC > .grsPopupCoCb > .fa,
				.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCPc > .grsPopupCoCCPcRc > .grsPopupCoCCPcRcV > .grsPopupCoCCPcRcVc > .grsPopupCoCCPcR > .fa {
				    font-size: 13px;
				}
				.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCc .grsPopupCoCCi,
				.grsPopupCoC > .grsPopupCoCCc .grsPopupCoCCi:focus {
					min-height: 90px;
				}
                /* Popup close button */
				.grsTemplate".$id." .grsPopupCoCClos {
					width: 30px;
					height: 30px;
					border: 1px ".$grsTheme->closeButtBorderStyle." ".$grsTheme->closeButtBorderColor ."; 
				}
				.grsTemplate".$id." .grsPopupCoCClos > .fa {
				    font-size: 18px;
				}
                .grsTemplate".$id." .grsPopupCoCClos.grsPopupCoCClosRes {";
                    $lightbox .= $this->getRightPosition(2, 30, $grsTheme->closeButtPos)."
                }
                .grsTemplate".$id." .grsPopupCoCClos.grsPopupCoCClosResWithFilm {";
                    $lightbox .= $this->getRightPosition(2, $res700X500FilmHeight + 25, $grsTheme->closeButtPos)."
                }
                .grsTemplate".$id." .grsPopupCoCClos.grsPopupCoCClosResWithContButts {";
                    $lightbox .= $this->getRightPosition(2, $res700X500ContButtHeight + 25, $grsTheme->closeButtPos)."
                }
                .grsTemplate".$id." .grsPopupCoCClos.comm {";
                    $lightbox .= $this->getRightPosition(5, 5, $grsTheme->closeButtPos)."
                }
			}
			/* Media rules */
			@media screen and (max-width: 400px) , screen and (max-height: 200px) {
				/* Filmstrip */
                .grsTemplate".$id." .grsPopupImC > .grsPopupFc .grsPopupFIsC > .grsPopupFiC:first-child {
                    margin: ".($res400x200FilmMarTop = intval($grsTheme->filmstripMarginTop/4))."px  ".( $res400x200FilmThMar = intval($grsTheme->filmThumbMargin/4))."px ".( $res400x200FilmMarBottom = intval($grsTheme->filmstripMarginBottom/4))."px ".$res400x200FilmThMar."px;
                }
				.grsTemplate".$id." .grsPopupImC > .grsPopupFc .grsPopupFIsC > .grsPopupFiC {";
                    $res400X200FilmSize = $this->getWidthHeightForFmResize(50, $grsTheme->filmThumbWidth, $grsTheme->filmstripSize );
                    $lightbox .= "height: ".$res400X200FilmSize->height."px;
                    width: ". $res400X200FilmSize->width."px;
                    margin: ".$res400x200FilmMarTop."px  ".$res400x200FilmThMar."px ".$res400x200FilmMarBottom."px 0px;
                    padding: 0;
                    border: none;
                }
				.grsTemplate".$id." .grsPopupImC > .grsPopupFc .grsPopupFIsC > .grsPopupFiC > .grsPopupFi {
					height: ".$res400X200FilmSize->height."px;
                    width: ". $res400X200FilmSize->width."px;
				}
				.grsTemplate".$id." .grsPopupImC > .grsPopupFc {
					height: ".($res400x200FilmHeight = $res400X200FilmSize->height + $res400x200FilmMarTop + $res400x200FilmMarBottom)."px;
				}
				.grsTemplate".$id." .grsPopupImC > .grsPopupFc .grsPopupFmB {";
                    $res400x200FmNavSize = $this->getWidthHeightForFmResize(18, 40, 40); // just pass equal vars
                    $lightbox.="width: ".$res400x200FmNavSize->width."px;
                    height: ".$res400x200FmNavSize->height."px;
                    top: calc(50% - (".($res400x200FmNavSize->height/2)."px));
                    border-radius: 15px;
				}
				.grsTemplate".$id." .grsPopupImC > .grsPopupFc .grsPopupFmR {
                    left: 3px;
                }
                .grsTemplate".$id." .grsPopupImC > .grsPopupFc .grsPopupFmL {
                    right: 3px;
                }
                .grsTemplate".$id." .grsPopupImC > .grsPopupFc .grsPopupFmB > .fa {
                    font-size: 14px;
                }          
				.grsTemplate".$id." .grsPopupImC > .grsPopupFc .grsPopupFIsC > .grsPopupFiC > .grsPopupFi {";
                    if($grsTheme->filmThumbSelEffect == 'border') {
                        $lightbox .= "outline-width: ".(intval($grsTheme->filmSelThumbBorderWidth/4))."px";
                    }
                $lightbox .= "}
				/* Control buttons */		
				.grsTemplate".$id." .grsPopupImMc > .grsPopupB {
					height: ".($res400x200ContButtHeight = (19 + 2 * (5 + ($grsTheme->contButtBorderStyle != 'none' ? 1 : 0))))."px;
				}
				.grsTemplate".$id." .grsPopupImMc > .grsPopupB > .grsPopupSBmC {
					height: ".(19 + 2*($grsTheme->contButtBorderStyle != 'none' ? 1 : 0))."px;
					margin: 5px 0px;
				}
				.grsTemplate".$id." .grsPopupImMc > .grsPopupB > .grsPopupOBmC {
					height: ".(19 + 2*($grsTheme->contButtBorderStyle != 'none' ? 1 : 0))."px;
					margin: 5px 0px;
				}
				.grsTemplate".$id." .grsPopupImMc > .grsPopupB > .grsPopupSBmC .grsPopupSB, 
				.grsTemplate".$id." .grsPopupImMc > .grsPopupB > .grsPopupOBmC .grsPopupOB {
					width: 19px;
					height: 19px;
					border: 1px ".$grsTheme->contButtBorderStyle." ".$grsTheme->contButtBorderColor ."; 
				}
                .grsTemplate".$id." .grsPopupImMc > .grsPopupB > .grsPopupSBmC .grsPopupSB {
                    margin: 0px 0px 0px 5px ; 
                } 
                .grsTemplate".$id." .grsPopupImMc > .grsPopupB > .grsPopupOBmC .grsPopupOB {
                    margin: 0px 5px 0px 0px; 
                }
				.grsTemplate".$id." .grsPopupImMc > .grsPopupB > .grsPopupSBmC .grsPopupSB > .fa, 
                .grsTemplate".$id." .grsPopupImMc > .grsPopupB > .grsPopupOBmC .grsPopupOB > .fa {
                    font-size: 11px;
                }
				/* Navigation */
				.grsTemplate".$id." .grsPopupImMc > .grsPopupImNVb {
					height: 60px;
					width: 60px;
					top: calc(50% - (30px));
				}
				.grsTemplate".$id." .grsPopupImMc > .grsPopupImNVl > .fa {
					margin-left: 10px;
				}
				.grsTemplate".$id." .grsPopupImMc > .grsPopupImNVr > .fa {
					margin-right: 10px;
				}
				.grsTemplate".$id." .grsPopupImMc > .grsPopupImNVb > .fa {
                    font-size: 35px;
                }
				
                /* Popup close button */
				.grsTemplate".$id." .grsPopupCoCClos {
					width: 23px;
					height: 23px;
					border: 1px ".$grsTheme->closeButtBorderStyle." ".$grsTheme->closeButtBorderColor ."; 
				}
                .grsTemplate".$id." .grsPopupCoCClos.grsPopupCoCClosRes {";
                    $lightbox .= $this->getRightPosition(0, 20, $grsTheme->closeButtPos)."
                }
                .grsTemplate".$id." .grsPopupCoCClos.grsPopupCoCClosResWithFilm {";
                    $lightbox .= $this->getRightPosition(0, $res400x200FilmHeight + 15, $grsTheme->closeButtPos)."
                }
                .grsTemplate".$id." .grsPopupCoCClos.grsPopupCoCClosResWithContButts {";
                    $lightbox .= $this->getRightPosition(0, $res400x200ContButtHeight + 15, $grsTheme->closeButtPos)."
                }
                .grsTemplate".$id." .grsPopupCoCClos.comm {";
                    $lightbox .= $this->getRightPosition(0, 5, $grsTheme->closeButtPos)."
                }

                /*Title & description*/
				.grsTemplate".$id." .grsPopupImMc > .grsPopupTc {
				    width: ".($grsTheme->titleDescpFWith ? '100%' : '100px' ).";
				    padding: ".($res400X200ImgCountPos = intval($grsTheme->titleDescpPadding/4))."px;
				}
				.grsTemplate".$id." .grsPopupImMc > .grsPopupTc > span {
				    font-size: 11px;
				}
				.grsTemplate".$id." .grsPopupImMc > .grsPopupTc > p {
				    font-size: 10px;
				}
				/*Image counting*/
				.grsTemplate".$id." .grsPopupImMc > .grsPopupImCount {";
				    $lightbox .= $this->getRightPosition(5, $res400X200ImgCountPos, $grsTheme->imgcoPos)."
					padding: ".(intval($grsTheme->imgcoPadding/4))."px;
				}
				.grsTemplate".$id." .grsPopupImMc > .grsPopupImCount > span {
			    	font-size: 9px;
				}
				
				/* Comments container */
				.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCNc label , 
				.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCEc label, 
				.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCc label,
				.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCPc label {
					font-size: 11px;
				}
				.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCNc .grsPopupCoCNi, 
				.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCEc .grsPopupCoCEi, 
				.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCc .grsPopupCoCCi,
				.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCPc .grsPopupCoCCPinp {
					font-size: 10px;
					padding: 1px;
				}
				.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCb {
					width: 20px;
					height: 20px;
				}
				.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCPc > .grsPopupCoCCPcRc > .grsPopupCoCCPcRcV > .grsPopupCoCCPcRcVc > .grsPopupCoCCPcR {
					width: 20px;
					height: 20px;
				}
                .grsTemplate".$id." .grsPopupCoC > .grsPopupCoCb > .fa,
				.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCPc > .grsPopupCoCCPcRc > .grsPopupCoCCPcRcV > .grsPopupCoCCPcRcVc > .grsPopupCoCCPcR > .fa {
				    font-size: 12px;
				}
				.grsTemplate".$id." .grsPopupCoC > .grsPopupCoCCc .grsPopupCoCCi,
				.grsPopupCoC > .grsPopupCoCCc .grsPopupCoCCi:focus {
					min-height: 60px;
				}
			}";
		return $lightbox;
	}

	/**
	 * Get right params for close button position
	 * @param $x
	 * @param $y
	 * @param $posType
	 *
	 * @return string
	 */
	public function getRightPosition($x, $y, $posType) {
		$pos = "";
		switch($posType) {
			case 'topLeft':
				$pos .= "top: ".$y."px;
						left: ".$x."px;";
				break;
            case 'topCenter':
                $pos .= "top: ".$y."px;
						left: 0;
						right: 0;
						margin: auto;";
                break;
			case 'topRight':
				$pos .= "top: ".$y."px;
						right: ".$x."px;";
				break;
			case 'bottomLeft':
				$pos .= "bottom: ".$y."px;
						left: ".$x."px;";
				break;
			case 'bottomCenter':
				$pos .= "bottom: ".$y."px;
						left: 0;
						right: 0;
						margin: auto;";
				break;
			case 'bottomRight':
				$pos .= "bottom: ".$y."px;
						right: ".$x."px;";
				break;
			case 'center':
				$pos .= "bottom: 0;
				        top: 0;
						right: 0;
						left: 0;
						margin: auto;";
				break;
			default:
				$pos .= "";
				break;
		}
		return $pos;
	}

    public function getWidthHeightForFmResize($relativeSize, $width, $height) {
        $newSize = new stdClass();
	    if($width > $height) {
            $newSize->height = round($relativeSize/round($width/$height, 0), 0);
            $newSize->width = $relativeSize;
        } else {
            $newSize->width = round($relativeSize/round($height/$width, 0), 0);
            $newSize->height = $relativeSize;
        }
        return $newSize;
	}

}