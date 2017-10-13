<?php
/**
 * LIMB gallery
 * Get Navigation CSS
 */
 
class GRSGetNavigationCss {
	// Costructor
	public function __construct() {				
	}
	public function get_($id, $grsTheme) {
		/* Numbers */
		$navigation = ".grsTemplate".$id." .grsNavD {
			display: block;
			margin: ".$grsTheme->pnavCMarginT."px auto 0 auto;
		}
		.grsTemplate".$id." .grsNavD .grsNavC {
			text-align: ".$grsTheme->pnavAlign.";
			display: block;
		}
		/*.grsTemplate".$id." .grsNavD .grsHideNav {
			display: none;
		}*/
		.grsTemplate".$id." .grsNavD .grsNavC > .grsNav {
			display: inline-block;
			margin: 0px;
			padding: 0px;
		}
		.grsTemplate".$id." .grsNavD .grsNavC > .grsNav:after {
			content: '';
			clear: both;
			display: block;
		}
		.grsTemplate".$id." .grsNavD .grsNavC > .grsNav > .grsNavL {
			float: left;
			display: block;
			margin: 0px 0px 0px ".$grsTheme->pnavBMargin."px;
		}
		.grsTemplate".$id." .grsNavD .grsNavC > .grsNav > .grsNavLF {
			margin-left: 0px;
		}
		.grsTemplate".$id." .grsNavD .grsNavC > .grsNav > .grsNavLL {
			margin-right: 0px;
		}
		.grsTemplate".$id." .grsNavD .grsNavC > .grsNav > .grsNavL > .grsNavA {
			text-decoration: none;
			outline: none;
			background: ".$grsTheme->pnavBBgColor.";
			padding: 0px ".$grsTheme->pnavBPadding."px;
			display: block;
			border: ".$grsTheme->pnavBBorderWidth."px ".$grsTheme->pnavBBorderStyle." ".$grsTheme->pnavBBorderColor.";
			color: ".$grsTheme->pnavBcolor.";
			font-family: ".$grsTheme->pnavBFFamily.";
			font-style: ".$grsTheme->pnavBFstyle.";
			font-weight: ".$grsTheme->pnavBFWeight.";
			font-size: ".$grsTheme->pnavBFSize."px;
			box-shadow: ".$grsTheme->pnavBBoxshadowFstVal."px ".$grsTheme->pnavBBoxshadowSecVal."px ".$grsTheme->pnavBBoxshadowThdVal."px ".$grsTheme->pnavBBoxshadowColor.";
			border-radius: ".$grsTheme->pnavBBorderRadius."px;
			transition: 0.3s background linear;
		}
		.grsTemplate".$id." .grsNavD .grsNavC > .grsNav > .grsNavL > .grsNavA:focus {
			outline: none;
		}
		.grsTemplate".$id." .grsNavD .grsNavC > .grsNav > .grsNavL > .grsNavA:hover {
			background: ".$grsTheme->pnavBHBgColor.";
		}
		.grsTemplate".$id." .grsNavD .grsNavC > .grsNav > .grsNavL > .grsNavAct {
			background: ".$grsTheme->pnavBABgColor.";
		}
		/* Load more */
		.grsTemplate".$id." .grsNavD .grsNavC > .grsNavLoadMore {
			text-decoration: none;
			outline: none;
			background: ".$grsTheme->pnavBBgColor.";
			padding: ".$grsTheme->pnavBPadding."px;
			border: ".$grsTheme->pnavBBorderWidth."px ".$grsTheme->pnavBBorderStyle." ".$grsTheme->pnavBBorderColor.";
			color: ".$grsTheme->pnavBcolor.";
			font-family: ".$grsTheme->pnavBFFamily.";
			font-style: ".$grsTheme->pnavBFstyle.";
			font-weight: ".$grsTheme->pnavBFWeight.";
			font-size: ".$grsTheme->pnavBFSize."px;
			box-shadow: ".$grsTheme->pnavBBoxshadowFstVal."px ".$grsTheme->pnavBBoxshadowSecVal."px ".$grsTheme->pnavBBoxshadowThdVal."px ".$grsTheme->pnavBBoxshadowColor.";
			border-radius: ".$grsTheme->pnavBBorderRadius."px;
			display: inline-block;
			transition: 0.3s background linear;
		}
		.grsTemplate".$id." .grsNavD .grsNavC > .grsNavLoadMore:hover {
			background: ".$grsTheme->pnavBHBgColor.";
		}
		.grsTemplate".$id." .grsNavD .grsNavC > .grsNavLoadMore:focus {
			outline: none;
		}
		/*Back button*/
		.grsTemplate".$id." .grsBackC {
			margin: 0 auto 10px auto;
			text-align: center;
		}
		.grsTemplate".$id." .grsBackC > .grsBack {
			text-decoration: none;
			outline: none;
			background: ".$grsTheme->backBgColor.";
			padding: 0 10px;
			border: ".$grsTheme->backBorderWidth."px ".$grsTheme->backBorderStyle." ".$grsTheme->backBorderColor.";
			color: ".$grsTheme->backColor.";
			font-family: ".$grsTheme->pnavBFFamily.";
			font-style: ".$grsTheme->pnavBFstyle.";
			font-weight: ".$grsTheme->pnavBFWeight.";
			font-size: ".$grsTheme->backFSize."px;
			box-shadow: ".$grsTheme->backBoxshadowFstVal."px ".$grsTheme->backBoxshadowSecVal."px ".$grsTheme->backBoxshadowThdVal."px ".$grsTheme->backBoxshadowColor.";
			border-radius: ".$grsTheme->backBorderRadius."px;
			display: inline-block;
			transition: 0.3s background linear;
		}
		.grsTemplate".$id." .grsBackC > .grsBack:hover {
			background: ".$grsTheme->backHBgColor.";
		}";
		return $navigation;
	}
}