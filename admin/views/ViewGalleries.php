<?php
/**
 * LIMB gallery
 * Admin view
 */
class GRSViewGalleries {
	
	//Private variables
	private $model;
	
	//Costructor
	public function __construct($model) {
		$this->model = $model;
    }

	// method declaration
	public function check_action() {
	}
	
	public function display() {
		?>
			<div class="grsGallFCont" id="grsGallFCont" ng-app="grsApp" winclick> 
				<div class="grsGallHeader" id="grsGallHeader" ng-controller="grsGallHeader" ng-mouseenter="checkTooltip()">
					<div class="grsGallAdgMessC" >
						<div class="grsGallAdgMessSc" >
							<div class="grsGallAdgC" >
								<div class="grsGallAdgB" ng-click="addGallery()">
									<span class="grsGallAdgBi"></span>
									<span class="grsGallAdgBl">Add gallery</span>
								</div>
							</div>
							<div class="grsGallMessC" >
								<div class="grsGallMess grsAnDur" ng-class="{'grsFadeIn' : grsMassageC , 'grsFadeOut' : !grsMassageC, 'grsError' : grsMassageMood == 'error' }" >
									<span>{{grsMassage}}</span>
								</div>
							</div>
						</div>
					</div>	
					<div class="grsGallHNavC">
						<ul class="grsGallHNavCu">
							<li class="grsGallHNavCuli">
								<div class="grsGallHTc" ng-show="showGTs">
									<ul class="grsGallHTcU">
										<li class="grsGallHTcUli" ng-class="{'selected' : selGall.id == galData.id}" ng-repeat="galData in pageination.pagedItems[pageination.currentPage]" ng-click="selectGallery($index, $event)" >
											<span class="grsGallHTcheck" ng-class="{selected : selGall.id == galData.id}"></span>
											<span class="grsGallHTlab" title="{{galData.title.length > 20 ? galData.title : ''}}">{{galData.title.trunc(24)}}</span>
											<span class="grsGallHTdel" ng-click="deleteGalleryPr($index, $event)" title="Delete" ></span>
										</li>									 
									</ul>
									<grs-page-nav page-ination="pageination" ></grs-page-nav>
								</div>
								<div class="grsGallHNavGB" ng-class="{'grsGallHNavAcB' : activeTab == 'Gall'}" ng-click="showGTsCont($event)" >
									<span class="grsGallHNavGBi"></span>
									<span class="grsGallHNavGBl">Galleries</span>
								</div>
							</li>
							<li class="grsGallHNavCuli">
								<div class="grsGallHNavUB" ng-class="{'grsGallHNavAcB' : activeTab == 'Upl'}" ng-click="selectTab('Upl')" >
									<span class="grsGallHNavUBi"></span>
									<span class="grsGallHNavUBl">Media</span>
								</div>
							</li>
							<li class="grsGallHNavCuli">
								<div class="grsGallHNavSB" ng-class="{'grsGallHNavAcB' : activeTab == 'Sett'}" ng-click="selectTab('Sett')" >
									<span class="grsGallHNavSBi"></span>
									<span class="grsGallHNavSBl">Settings</span>
								</div>
							</li>
							<li class="grsGallHNavCuli">
								<div class="grsGallHNavTB" ng-class="{'grsGallHNavAcB' : activeTab == 'Theme', 'disable' : disTheme()}" ng-click="selectTab('Theme')" >
									<span class="grsGallHNavTBi"></span>
									<span class="grsGallHNavTBl">Themes</span>
								</div>
							</li>
							<li class="grsGallHNavCuli">
								<div class="grsGallHNavAB" ng-class="{'grsGallHNavAcB' : activeTab == 'Alb'}" ng-click="selectTab('Alb')" >
									<span class="grsGallHNavABi"></span>
									<span class="grsGallHNavABl">Albums</span>
								</div>
							</li>
							<li class="grsGallHNavCuli prf" ng-if="shProF()">
								<a href="http://limbcode.com/" target="_blank">
									<div class="grsGallHNavPf" >
										<span class="grsGallHNavPfi"></span>
										<span class="grsGallHNavPfl">Pro features !</span>
									</div>
								</a>
							</li>
							<li class="grsGallHNavCuli grsGallHNavCuliFr">
								<div class="grsGallCoLc">
									<div class="grsGallCoL" ng-if="grsLoading">
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>	
				<div class="grsGallUpl grsDisplayNone" id="grsGallUpl" ng-class="{'grsAnDur grsZoomIn' : options.show, 'grsDisplayNone' : !options.show}" ng-controller="grsUploader" ng-mouseenter="checkTooltip()">
					<grs-uploader></grs-uploader>
				</div>					
				<div class="grsGallContent grsDisplayNone" ng-controller="grsContent" ng-class="{'grsAnDur grsFadeIn' : show , 'grsDisplayNone' : !show }" ng-mouseenter="checkTooltip()">
					<div class="grsGallContentSc">
						<div class="grsGallCoSaLc">
							<div class="grsGallCoSaC">
								<button class="grsGallCoSave" ng-click="grsSave()" >Save</button>
							</div>
						</div>
						<grs-galleries></grs-galleries>
						<grs-themes></grs-themes>
						<grs-albums></grs-albums>
						<grs-settings></grs-settings>
					</div>
				</div>
				<div class="grsGallConfirmMC grsGallConfirmH" id="grsGallConfirmMC" ng-controller="grsConfirmM" ng-class="{'grsAnDur grsFadeIn' : options.show, 'grsGallConfirmH': !options.show}"  >
					<div class="grsGallConfirmM" ng-if="options.show" ng-style="{'left': options.left, 'top': options.top, 'width': options.width}">
						<p>{{options.grsConMess}}<i>{{options.grsConIt}}</i>{{options.grsConTp}}
							<br ng-if="options.br">
						   	<span class="grsConfirmMCont" ng-if="options.br" >{{options.grsConMessCont}}</span/>
						    <br ng-if="options.br">	
						   {{options.grsConMessFoot}}
						</p>
						<button ng-click="answer(true, $event)">Yes</button>
						<button ng-click="answer(false, $event)">No</button>
					</div>
				</div>
			</div>
		<?php		
	}
}  