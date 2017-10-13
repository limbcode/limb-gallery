<?php
/**
 * LIMB gallery
 * Shortcode view
 */
 
class GRSViewShortcode {
	
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
		$grsGalleries = $this->model->getGrsGalleries();
		$grsAlbums = $this->model->getGrsAlbums();
		$grsThemes = $this->model->getGrsThemes();
		$version = $this->model->version;
		$task = isset($_GET['task']) ? $_GET['task'] : '';
		$data = isset($_GET['data']) ? stripslashes($_GET['data']) : '';
		//trying to make json string from shortcode data
		$data = str_replace(
			array(' ', '[', ']', '=', 'GRS,'),
			array(',"', '{', '}', '":', ''),
			$data
		);
		$conf = $this->model->getConfig();
		$viewConf = $this->model->getViewConf($conf);
		$orderbies = $this->model->getOrderbies();
		$orderbiesForAlb = $this->model->getOrderbiesForAlb();
        $clickActions =  $this->model->getClickActions();
        $openlinkTargets =  $this->model->getOpenLinkTargets();
		?>
		<!DOCTYPE html>
			<html>
				<head>
					<title>Gallery RS</title>
					<link rel="stylesheet" type="text/css" href="<?php echo GRS_PLG_URL . '/css/grsShortcode.css?ver=' . $version; ?>">
					<?php wp_print_scripts('jquery'); ?>
					<script>
						var task = '<?php echo $task; ?>',
							data = (task == 'update') ? jQuery.parseJSON('<?php echo $data; ?>') : '',
							viewHelp = true;
					</script>
					<script src="<?php echo GRS_PLG_URL . '/js/grsShortcode.js?ver=' . $version; ?>"></script>
				</head>
				<body>
					<div class="grsMainCont">
						<div class="grsGallsLightCont">
							<div class="grsGallsCont">
								<div class="grsGallsButtons">
									<div>
										<div class="grsGallButton">
											<a class="grsGall" href="#">
												<i class="fa fa-camera-retro fa-lg"></i>
												<span>Select Gallery</span>
											</a>
											<!-- GRS titles -->
											<div class="grsGallTitlesCont" style="display:none">
												<ul class="grsGallTitles">
													<?php foreach($grsGalleries as $galKey => $grsGallerie) { ?>
														<li class="grsGallTitle" grsGallId="<?php echo $grsGallerie->id; ?>">
															<span class="grsCheck" ></span>
															<a href="#" class="grs_galleries_title_ln">
																<div class="grsTitleLabel"> <?php echo $this->model->addDotes($grsGallerie->title); ?> </div>
															</a>
														</li>	
													<?php } ?>
												</ul>
											</div>
										</div>
										<div class="grsAlbButton">
											<a class="grsAlb" href="#">
												<i class="fa fa-camera-retro fa-lg"></i>
												<span>Select Album</span>
											</a>
											<!-- GRS titles -->
											<div class="grsAlbTitlesCont" style="display:none">
												<ul class="grsAlbTitles">
													<?php foreach($grsAlbums as $albKey => $grsAlbum) { ?>
														<li class="grsAlbTitle" grsAlbId="<?php echo $grsAlbum->id; ?>">
															<span class="grsCheck" ></span>
															<a href="#" class="grsAlbumsTitleLn">
																<div class="grsTitleLabel"> <?php echo $this->model->addDotes($grsAlbum->title); ?> </div>
															</a>
														</li>	
													<?php } ?>
												</ul>
											</div>
										</div>
										<div class="grsTypeButton">
											<a class="grsTypeDeactive" href="#">
												<i class="fa fa-camera-retro fa-lg"></i>
												<span>Select view</span>
											</a>
											<!-- GRS view types -->
											<div class="grsGallViewsCont" style="display:none">
												<div class="grsGallViews" >
													<div class="grsGallThumbnailView grsView enabled" grsView="Thumbnail" title="Thumbnail"></div>
													<div class="grsGallMasonryView grsView enabled" grsView="Masonry" title="Masonry"></div>
													<div class="grsGallFilmView grsView enabled" grsView="Film" title="Carousel"></div>
													<div class="grsGallMosaicView grsView <?php echo $viewConf['views']['class']; ?>" grsView="Mosaic" title="Mosaic"></div>
													<div class="grsGallAlbumView grsView enabled" grsView="Album" title="Album"></div>
													<div class="grsClear"></div>
												</div>	
											</div>
										</div>
										<div class="grsClear"></div>
									</div>
									<div class="grsThemeButton">
										<a class="grsTheme" href="#">
											<i class="fa fa-camera-retro fa-lg"></i>
											<span>Select theme</span>
										</a>
										<div class="grsThemeNamesCont" style="display:none">
											<ul class="grsThemeNames">
												<?php foreach($grsThemes as $themeKey => $grsTheme) {
													$default = ($grsTheme->default) ? 'grsThemeSelected' : '';
													?>
													<li class="grsThemeName <?php echo $default; ?>" grsthemeid="<?php echo $grsTheme->id; ?>">
														<span class="grsCheck" ></span>
														<a href="#" class="grsThemesNameLn">
															<div class="grsNameLabel"> <?php echo $this->model->addDotes($grsTheme->name); ?> </div>
														</a>
													</li>	
												<?php } ?>
											</ul>
										</div>
									</div>
								</div>
								<!-- Thumbnail View -->
								<div class="grsThumbnailCont grsViewCont" style="display:none">
									<div class="grsThumbnail">
										<div class="grsThumbnailTitleCont">
											<div class="grsThumbnailTitle">
												Thumbnail view
											</div>
											<div class="grsClear"></div>
										</div>
										<div class="grsThumbnailParamsCont">
											<div class="grsThumbnailParams">
												<div class="grsRow">
													<div class="grsCell" >
														<label for="thumbnailWidth" >Width:</label>
													</div>
													<div class="grsCell" >
														<input type="number" value="200" name="thumbnailWidth" id="thumbnailWidth"><span>px</span>
													</div>
													<div class="grsCell" >
														<label for="thumbnailHeight" >Height:</label>
													</div>
													<div class="grsCell" >
														<input type="number" value="160" name="thumbnailHeight" id="thumbnailHeight"><span>px</span>
													</div>
												</div>
												<div class="grsRow">
													<div class="grsCell grsMasonryContWidthLab" style="width:25%">
														<label for="thumbnailContWidth" >Container Width:</label>
													</div>
													<div class="grsCell grsMasonryContWidthInp" style="width:25%">
														<input type="number" value="100" name="thumbnailContWidth" max="100" min="0" id="thumbnailContWidth"><span>%</span>
													</div>
													<div class="grsCell" >
														<label for="thumbnailTitle" >Show title:</label>
													</div>
													<div class="grsCell">
														<select name="thumbnailTitle" id="thumbnailTitle">
															<option value="no" >No</option>
															<option selected value="onhover">On hover</option>
															<option value="always">Always</option>
														</select>
													</div>
												</div>
												<div class="grsRow">
													<div class="grsCell"  >
														<label for="thumbnailPolaroid_1" >Polaroid:</label>
													</div>
													<div class="grsCell">
														<label for="thumbnailPolaroid_1" >Yes:</label>
														<input type="radio" value="1" name="thumbnailPolaroid" id="thumbnailPolaroid_1">
														<label for="thumbnailPolaroid_0" >No:</label>
														<input type="radio" checked value="0" name="thumbnailPolaroid" id="thumbnailPolaroid_0">
													</div>
													<div class="grsCell">
													</div>
													<div class="grsCell">
													</div>
												</div>
												<div class="grsRow">
													<div class="grsCell"  >
														<label for="thumbnailImagesPerpage" >Items Perpage:</label>
													</div>
													<div class="grsCell"  >
														<input type="number" value="20" name="thumbnailImagesPerpage" id="thumbnailImagesPerpage" style="width:38px">
													</div>
													<div class="grsCell" >
														<label for="thumbnailPagination" >Pagination:</label>
													</div>
													<div class="grsCell">
														<select name="thumbnailPagination" id="thumbnailPagination">
															<option value="numbers" >Numbers</option>
															<option selected value="loadMore">Load more</option>
															<option value="scrolling">Scrolling</option>
														</select>
													</div>
												</div>
												<div class="grsRow">
													<div class="grsCell"  >
														<label for="thumbnailOrderBy" >Order by:</label>
													</div>
													<div class="grsCell"  >
														<select name="thumbnailOrderBy" id="thumbnailOrderBy">
															<?php foreach($orderbies as $key => $orderBy) {	?>
																<option value="<?php echo $key; ?>"><?php echo $orderBy; ?></option>
															<?php } ?>
														</select>
													</div>
													<div class="grsCell" >
														<label for="thumbnailOrdering" >Ordering:</label>
													</div>
													<div class="grsCell">
														<select name="thumbnailOrdering" id="thumbnailOrdering">
															<option selected value="ASC" >ASC</option>
															<option value="DESC">DESC</option>
														</select>
													</div>
												</div>
                                                <div class="grsRow">
                                                    <div class="grsCell"  >
                                                        <label for="thumbnailClickAction" >Click action:</label>
                                                    </div>
                                                    <div class="grsCell"  >
                                                        <select name="thumbnailClickAction" id="thumbnailClickAction" >
                                                            <?php foreach($clickActions as $key => $action) {	?>
                                                                <option value="<?php echo $key; ?>"><?php echo $action; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="grsCell" >
                                                        <label for="thumbnailOpenLinkTarget" id="thumbnailOpenLinkTargetLabel" style="display:none" >Link target:</label>
                                                    </div>
                                                    <div class="grsCell">
                                                        <select name="thumbnailOpenLinkTarget" id="thumbnailOpenLinkTarget" style="display:none">
                                                            <?php foreach($openlinkTargets as $key => $target) {	?>
                                                                <option value="<?php echo $key; ?>"><?php echo $target; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
											</div>
										</div>
									</div>
								</div>
								<!-- Carousel View -->
								<div class="grsFilmCont grsViewCont" style="display:none">
									<div class="grsFilm">
										<div class="grsFilmTitleCont">
											<div class="grsFilmTitle">
												Carousel view
											</div>
											<div class="grsClear">
							
											</div>
										</div>
										<div class="grsFilmParamsCont">
											<div class="grsFilmParams">
												<div class="grsRow">
													<div class="grsCell" >
														<label for="fmWidth" >Width:</label>
													</div>
													<div class="grsCell" >
														<input type="number" value="200" name="fmWidth" id="fmWidth"><span>px</span>
													</div>
													<div class="grsCell" >
														<label for="fmHeight" >Height:</label>
													</div>
													<div class="grsCell" >
														<input type="number" value="160" name="fmHeight" id="fmHeight"><span>px</span>
													</div>
												</div>
												<div class="grsRow">
													<div class="grsCell grsMasonryContWidthLab" style="width:25%">
														<label for="fmContWidth" >Container Width:</label>
													</div>
													<div class="grsCell grsMasonryContWidthInp" style="width:25%">
														<input type="number" value="100" name="fmContWidth" max="100" min="0" id="fmContWidth"><span>%</span>
													</div>
													<div class="grsCell" >
														<label for="fmTitle" >Show title:</label>
													</div>
													<div class="grsCell">
														<select name="fmTitle" id="fmTitle">
															<option value="no" >No</option>
															<option selected value="onhover">On hover</option>
															<option value="always">Always</option>
														</select>
													</div>
												</div>
												<div class="grsRow">
													<div class="grsCell"  >
														<label for="fmImagesPerpage" >Items Perpage:</label>
													</div>
													<div class="grsCell"  >
														<input type="number" value="20" name="fmImagesPerpage" id="fmImagesPerpage" style="width:38px">
													</div>
													<div class="grsCell" >
														<label for="fmNav" >Navigation:</label>
													</div>
													<div class="grsCell">
														<select name="fmNav" id="fmNav">
															<option selected value="buttons" >Buttons</option>
															<option value="scroll">Scrolling</option>
															<option value="both">Buttons and scrolling</option>
														</select>
													</div>
												</div>
												<div class="grsRow">
													<div class="grsCell"  >
														<label for="fmOrderBy" >Order by:</label>
													</div>
													<div class="grsCell"  >
														<select name="fmOrderBy" id="fmOrderBy">
															<?php foreach($orderbies as $key => $orderBy) {	?>
																<option value="<?php echo $key; ?>"><?php echo $orderBy; ?></option>
															<?php } ?>
														</select>
													</div>
													<div class="grsCell" >
														<label for="fmOrdering" >Ordering:</label>
													</div>
													<div class="grsCell">
														<select name="fmOrdering" id="fmOrdering">
															<option selected value="ASC" >ASC</option>
															<option value="DESC">DESC</option>
														</select>
													</div>
												</div>
                                                <div class="grsRow">
                                                    <div class="grsCell"  >
                                                        <label for="fmClickAction" >Click action:</label>
                                                    </div>
                                                    <div class="grsCell"  >
                                                        <select name="fmClickAction" id="fmClickAction" >
                                                            <?php foreach($clickActions as $key => $action) {	?>
                                                                <option value="<?php echo $key; ?>"><?php echo $action; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="grsCell" >
                                                        <label for="fmOpenLinkTarget" id="fmOpenLinkTargetLabel" style="display:none">Link target:</label>
                                                    </div>
                                                    <div class="grsCell">
                                                        <select name="fmOpenLinkTarget" id="fmOpenLinkTarget" style="display:none">
                                                            <?php foreach($openlinkTargets as $key => $target) {	?>
                                                                <option value="<?php echo $key; ?>"><?php echo $target; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
											</div>
										</div>
									</div>
								</div>
								<!-- Masonry View -->
								<div class="grsMasonryCont grsViewCont" style="display:none">
									<div class="grsMasonry">
										<div class="grsMasonryTitleCont">
											<div class="grsMasonryTitle">
												Masonry view
											</div>
											<div class="grsClear">
							
											</div>
										</div>
										<div class="grsMasonryParamsCont">
											<div class="grsMasonryParams">
												<div class="grsRow">
													<div class="grsCell" >
														<label for="masonryType" >Type:</label>
													</div>
													<div class="grsCell" >
														<label for="masonryType_ver" >Vertical:</label>
														<input type="radio" checked value="ver" name="masonryType" id="masonryType_ver">
														<label for="masonryType_hor" >Horizontal:</label>
														<input type="radio" value="hor" name="masonryType" id="masonryType_hor">
													</div>
													<div class="grsCell">
													</div>
													<div class="grsCell">
													</div>
												</div>
												<div class="grsRow">
													<div class="grsCell grsMasonryVerLab" >
														<label for="masonryWidth" >Width:</label>
													</div>
													<div class="grsCell grsMasonryVerInp" >
														<input type="number" value="200" name="masonryWidth" id="masonryWidth"><span>px</span>
													</div>
													<div class="grsCell grsMasonryHorLab" style="display:none;width:25%">
														<label for="masonryHeight" >Height:</label>
													</div>
													<div class="grsCell grsMasonryHorInp" style="display:none;width:25%">
														<input type="number" value="160" name="masonryHeight" id="masonryHeight"><span>px</span>
													</div>
													<div class="grsCell grsMasonryContWidthLab" style="width:25%">
														<label for="masonryContWidth" >Container Width:</label>
													</div>
													<div class="grsCell grsMasonryContWidthInp" style="width:25%">
														<input type="number" value="100" name="masonryContWidth" max="100" min="0" id="masonryContWidth"><span>%</span>
													</div>
												</div>
												<div class="grsRow">
													<div class="grsCell" >
														<label for="masonryTitle" >Show title:</label>
													</div>
													<div class="grsCell">
														<select name="masonryTitle" id="masonryTitle">
															<option value="no" >No</option>
															<option selected value="onhover">On hover</option>
															<option value="always">Always</option>
														</select>
													</div>
												</div>
												<div class="grsRow">
													<div class="grsCell"  >
														<label for="masonryImagesPerpage" >Items Perpage:</label>
													</div>
													<div class="grsCell"  >
														<input type="number" value="20" name="masonryImagesPerpage" id="masonryImagesPerpage" style="width:38px">
													</div>
													<div class="grsCell" >
														<label for="masonryPagination" >Pagination:</label>
													</div>
													<div class="grsCell">
														<select name="masonryPagination" id="masonryPagination">
															<option value="numbers" >Numbers</option>
															<option selected value="loadMore">Load more</option>
															<option value="scrolling">Scrolling</option>
														</select>
													</div>
												</div>
												<div class="grsRow">
													<div class="grsCell"  >
														<label for="masonryOrderBy" >Order by:</label>
													</div>
													<div class="grsCell"  >
														<select name="masonryOrderBy" id="masonryOrderBy">
															<?php foreach($orderbies as $key => $orderBy) {	?>
																<option value="<?php echo $key; ?>"><?php echo $orderBy; ?></option>
															<?php } ?>
														</select>
													</div>
													<div class="grsCell" >
														<label for="masonryOrdering" >Ordering:</label>
													</div>
													<div class="grsCell">
														<select name="masonryOrdering" id="masonryOrdering">
															<option selected value="ASC" >ASC</option>
															<option value="DESC">DESC</option>
														</select>
													</div>
												</div>
                                                <div class="grsRow">
                                                    <div class="grsCell"  >
                                                        <label for="masonryClickAction" >Click action:</label>
                                                    </div>
                                                    <div class="grsCell"  >
                                                        <select name="masonryClickAction" id="masonryClickAction" >
                                                            <?php foreach($clickActions as $key => $action) {	?>
                                                                <option value="<?php echo $key; ?>"><?php echo $action; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="grsCell" >
                                                        <label for="masonryOpenLinkTarget" id="masonryOpenLinkTargetLabel" style="display:none" >Link target:</label>
                                                    </div>
                                                    <div class="grsCell">
                                                        <select name="masonryOpenLinkTarget" id="masonryOpenLinkTarget" style="display:none">
                                                            <?php foreach($openlinkTargets as $key => $target) {	?>
                                                                <option value="<?php echo $key; ?>"><?php echo $target; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
											</div>
										</div>
									</div>
								</div>
								<!-- Mosaic View -->
								<div class="grsMosaicCont grsViewCont" style="display:none">
									<div class="grsMosaic">
										<div class="grsMosaicTitleCont">
											<div class="grsMosaicTitle">
												Mosaic view
											</div>
											<div class="grsClear">
							
											</div>
										</div>
										<div class="grsMosaicParamsCont">
											<div class="grsMosaicParams">
												<div class="grsRow">
													<div class="grsCell" >
														<label for="mosaicType" >Type:</label>
													</div>
													<div class="grsCell" >
														<label for="mosaicType_ver" >Vertical:</label>
														<input type="radio" checked value="ver" name="mosaicType" id="mosaicType_ver">
														<label for="mosaicType_hor" >Horizontal:</label>
														<input type="radio" value="hor" name="mosaicType" id="mosaicType_hor">
													</div>
													<div class="grsCell">
													</div>
													<div class="grsCell">
													</div>
												</div>
												<div class="grsRow">
													<div class="grsCell grsMosaicVerLab" >
														<label for="mosaicWidth" >Width:</label>
													</div>
													<div class="grsCell grsMosaicVerInp" >
														<input type="number" value="200" name="mosaicWidth" id="mosaicWidth"><span>px</span>
													</div>
													<div class="grsCell grsMosaicHorLab" style="display:none;width:25%">
														<label for="mosaicHeight" >Height:</label>
													</div>
													<div class="grsCell grsMosaicHorInp" style="display:none;width:25%">
														<input type="number" value="160" name="mosaicHeight" max="1000" min="0" id="mosaicHeight"><span>px</span>
													</div>
													
													<div class="grsCell grsMosaicContWidthLab" style="width:25%">
														<label for="mosaicHeight" >Container Width:</label>
													</div>
													<div class="grsCell grsMosaicContWidthInp" style="width:25%">
														<input type="number" value="100" name="mosaicContWidth" max="100" min="0" id="mosaicContWidth"><span>%</span>
													</div>
												</div>
												<div class="grsRow">
													<div class="grsCell" >
														<label for="mosaicTitle" >Show title:</label>
													</div>
													<div class="grsCell">
														<select name="mosaicTitle" id="mosaicTitle">
															<option value="no" >No</option>
															<option selected value="onhover">On hover</option>
															<option value="always">Always</option>
														</select>
													</div>
												</div>
												<div class="grsRow">
													<div class="grsCell"  >
														<label for="mosaicImagesPerpage" >Items Perpage:</label>
													</div>
													<div class="grsCell"  >
														<input type="number" value="20" name="mosaicImagesPerpage" id="mosaicImagesPerpage" style="width:38px">
													</div>
													<div class="grsCell" >
														<label for="mosaicPagination" >Pagination:</label>
													</div>
													<div class="grsCell" >
														<select name="mosaicPagination" id="mosaicPagination">
															<option value="numbers" >Numbers</option>
															<option selected value="loadMore">Load more</option>
															<option value="scrolling">Scrolling</option>
														</select>
													</div>
												</div>
												<div class="grsRow">
													<div class="grsCell"  >
														<label for="mosaicOrderBy" >Order by:</label>
													</div>
													<div class="grsCell"  >
														<select name="mosaicOrderBy" id="mosaicOrderBy">
															<?php foreach($orderbies as $key => $orderBy) {	?>
																<option value="<?php echo $key; ?>"><?php echo $orderBy; ?></option>
															<?php } ?>
														</select>
													</div>
													<div class="grsCell" >
														<label for="mosaicOrdering" >Ordering:</label>
													</div>
													<div class="grsCell">
														<select name="mosaicOrdering" id="mosaicOrdering">
															<option selected value="ASC" >ASC</option>
															<option value="DESC">DESC</option>
														</select>
													</div>
												</div>
                                                <div class="grsRow">
                                                    <div class="grsCell"  >
                                                        <label for="mosaicClickAction" >Click action:</label>
                                                    </div>
                                                    <div class="grsCell"  >
                                                        <select name="mosaicClickAction" id="mosaicClickAction" >
                                                            <?php foreach($clickActions as $key => $action) {	?>
                                                                <option value="<?php echo $key; ?>"><?php echo $action; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="grsCell" >
                                                        <label for="mosaicOpenLinkTarget" id="mosaicOpenLinkTargetLabel" style="display:none" >Link target:</label>
                                                    </div>
                                                    <div class="grsCell">
                                                        <select name="mosaicOpenLinkTarget" id="mosaicOpenLinkTarget" style="display:none">
                                                            <?php foreach($openlinkTargets as $key => $target) {	?>
                                                                <option value="<?php echo $key; ?>"><?php echo $target; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
											</div>
										</div>
									</div>
								</div>
								<!-- Album View -->
								<div class="grsAlbumCont grsViewCont" style="display:none">
									<div class="grsAlbum">
										<div class="grsAlbumTitleCont">
											<div class="grsAlbumTitle">
												Album view
											</div>
											<div class="grsClear"></div>
										</div>
										<div class="grsAlbumParamsCont">
											<div class="grsAlbumParams">
												<div class="grsRow">
													<div class="grsCell" >
														<label for="albMainView" >Main view type:</label>
													</div>
													<div class="grsCell">
														<select name="albMainView" id="albMainView">
															<option value="Thumbnail" >Thumbnail</option>
															<option value="Masonry">Masonry</option>
															<option <?php echo $viewConf['views']['mode']; ?> value="Mosaic">Mosaic</option>
														</select>
													</div>
													<div class="grsCell grsAlbMasMosTypeLab" >
														<label for="albMasMosType_ver" >Type:</label>
													</div>
													<div class="grsCell grsAlbMasMosTypeInp" >
														<label for="albMasMosType_ver" >Vertical:</label>
														<input type="radio" checked value="ver" name="albMasMosType" id="albMasMosType_ver">
														<label for="albMasMosType_hor" >Horizontal:</label>
														<input type="radio" value="hor" name="albMasMosType" id="albMasMosType_hor">
													</div>
												</div>
												<div class="grsRow">
													<div class="grsCell grsAlbVerLab" >
														<label for="albWidth" >Width:</label>
													</div>
													<div class="grsCell grsAlbVerInp" >
														<input type="number" value="200" name="albWidth" id="albWidth"><span>px</span>
													</div>
													<div class="grsCell grsAlbHorLab" >
														<label for="albHeight" >Height:</label>
													</div>
													<div class="grsCell grsAlbHorInp" >
														<input type="number" value="160" name="albHeight" id="albHeight"><span>px</span>
													</div>
												</div>
												<div class="grsRow">
													<div class="grsCell grsMosaicContWidthLab" >
														<label for="albContWidthLab" >Main container Width:</label>
													</div>
													<div class="grsCell albContWidthInp" >
														<input type="number" value="60" name="albContWidth" max="100" min="0" id="albContWidth"><span>%</span>
													</div>
													<div class="grsCell" >
														<label for="albTitle" >Show title:</label>
													</div>
													<div class="grsCell">
														<select name="albTitle" id="albTitle">
															<option value="no" >No</option>
															<option value="onhover">On hover</option>
															<option selected value="always">Always</option>
														</select>
													</div>
												</div>
												<div class="grsRow">
													<div class="grsCell"  >
														<label for="albOrderBy" >Order by:</label>
													</div>
													<div class="grsCell"  >
														<select name="albOrderBy" id="albOrderBy">
															<?php foreach($orderbiesForAlb as $key => $orderBy) {	?>
																<option value="<?php echo $key; ?>"><?php echo $orderBy; ?></option>
															<?php } ?>
														</select>
													</div>
													<div class="grsCell" >
														<label for="albOrdering" >Ordering:</label>
													</div>
													<div class="grsCell">
														<select name="albOrdering" id="albOrdering">
															<option selected value="ASC" >ASC</option>
															<option value="DESC">DESC</option>
														</select>
													</div>
												</div>
												<div class="grsRow">
													<div class="grsCell">
														<label for="albGalView" >Gallery view type:</label>
													</div>
													<div class="grsCell">
														<select name="albGalView" id="albGalView">
															<option value="Thumbnail" >Thumbnail</option>
															<option value="Masonry">Masonry</option>
															<option <?php echo $viewConf['views']['mode']; ?> value="Mosaic">Mosaic</option>
														</select>
													</div>
													<div class="grsCell grsAlbGalMasMosTypeLab">
														<label for="albGalMasMosType_ver" >Type:</label>
													</div>
													<div class="grsCell grsAlbGalMasMosTypeInp">
														<label for="albGalMasMosType_ver" >Vertical:</label>
														<input type="radio" checked value="ver" name="albGalMasMosType" id="albGalMasMosType_ver">
														<label for="albGalMasMosType_hor" >Horizontal:</label>
														<input type="radio" value="hor" name="albGalMasMosType" id="albGalMasMosType_hor">
													</div>
												</div>
												<div class="grsRow">
													<div class="grsCell grsAlbGalVerLab" >
														<label for="albGalWidth" >Width:</label>
													</div>
													<div class="grsCell grsAlbGalVerLab" >
														<input type="number" value="200" name="albGalWidth" id="albGalWidth"><span>px</span>
													</div>
													<div class="grsCell grsAlbGalHorLab">
														<label for="albGalHeight" >Height:</label>
													</div>
													<div class="grsCell grsAlbGalHorInp">
														<input type="number" value="160" name="albGalHeight" id="albGalHeight"><span>px</span>
													</div>
												</div>
												<div class="grsRow">
													<div class="grsCell grsMosaicContWidthLab" >
														<label for="galContWidthLab" >Gall container Width:</label>
													</div>
													<div class="grsCell albContWidthInp" >
														<input type="number" value="100" name="galContWidth" max="100" min="0" id="galContWidth"><span>%</span>
													</div>
													<div class="grsCell" >
														<label for="galTitle" >Show title:</label>
													</div>
													<div class="grsCell">
														<select name="galTitle" id="galTitle">
															<option value="no" >No</option>
															<option selected value="onhover">On hover</option>
															<option value="always">Always</option>
														</select>
													</div>
												</div>
												<div class="grsRow">
													<div class="grsCell"  >
														<label for="galOrderBy" >Order by:</label>
													</div>
													<div class="grsCell"  >
														<select name="galOrderBy" id="galOrderBy">
															<?php foreach($orderbies as $key => $orderBy) {	?>
																<option value="<?php echo $key; ?>"><?php echo $orderBy; ?></option>
															<?php } ?>
														</select>
													</div>
													<div class="grsCell" >
														<label for="galOrdering" >Ordering:</label>
													</div>
													<div class="grsCell">
														<select name="galOrdering" id="galOrdering">
															<option selected value="ASC" >ASC</option>
															<option value="DESC">DESC</option>
														</select>
													</div>
												</div>
												<div class="grsRow">
													<div class="grsCell" >
														<label for="albPagination" >Pagination:</label>
													</div>
													<div class="grsCell">
														<select name="albPagination" id="albPagination">
															<option value="numbers" >Numbers</option>
															<option value="loadMore">Load more</option>
															<option value="scrolling">Scrolling</option>
														</select>
													</div>
													<div class="grsCell"  >
														<label for="albPerpage" >Items Perpage:</label>
													</div>
													<div class="grsCell"  >
														<input type="number" value="20" name="albPerpage" id="albPerpage" style="width:38px">
													</div>
												</div>
                                                <div class="grsRow">
                                                    <div class="grsCell"  >
                                                        <label for="galClickAction" >Click action:</label>
                                                    </div>
                                                    <div class="grsCell"  >
                                                        <select name="galClickAction" id="galClickAction" >
                                                            <?php foreach($clickActions as $key => $action) {	?>
                                                                <option value="<?php echo $key; ?>"><?php echo $action; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="grsCell" >
                                                        <label for="galOpenLinkTarget" id="galOpenLinkTargetLabel" style="display:none" >Link target:</label>
                                                    </div>
                                                    <div class="grsCell">
                                                        <select name="galOpenLinkTarget" id="galOpenLinkTarget" style="display:none">
                                                            <?php foreach($openlinkTargets as $key => $target) {	?>
                                                                <option value="<?php echo $key; ?>"><?php echo $target; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- Lightbox View -->
							<div class="grsLightCont">
								<div class="grsLightButtons">
									<div class="grsLightboxButton">
										<a class="grsLightboxDeactive" href="#">
											<i class="fa fa-camera-retro fa-lg"></i>
											<span>Lightbox</span>
										</a>
									</div>
									<div class="grsClear"></div>
								</div>
								<div class="grsLightboxParamsCont" style="display:none">
									<div class="grsLightboxParams">
										<div class="grsRow">
											<div class="grsCell" >
												<label for="lightboxFullW" >Full width:</label>
											</div>
											<div class="grsCell" >
												<div class="grsForSizeing">
													<label for="lightboxFullW_1" >Yes:</label>
													<input type="radio" value="1" name="lightboxFullW" id="lightboxFullW_1">
													<label for="lightboxFullW_0" >No:</label>
													<input type="radio" checked value="0" name="lightboxFullW" id="lightboxFullW_0">
												</div>
											</div>
											<div class="grsCell" >
											</div>
											<div class="grsCell">
											</div>
										</div>
										<div class="grsRow">
											<div class="grsCell grsLightboxWidthLab" >
												<label for="lightboxWidth" >Width:</label>
											</div>
											<div class="grsCell grsLightboxWidthInp" >
												<input type="number" value="800" name="lightboxWidth" id="lightboxWidth"><span>px</span>
											</div>
											<div class="grsCell grsLightboxHeightLab" >
												<label for="lightboxHeight" >Height:</label>
											</div>
											<div class="grsCell grsLightboxHeightInp" >
												<input type="number" value="600" name="lightboxHeight" id="lightboxHeight"><span>px</span>
											</div>
										</div> 
										<div class="grsRow">
											<div class="grsCell <?php echo $viewConf['filmstrip']['class']; ?>" >
												<label for="lightboxFilmstrip" >Filmstrip:</label>
											</div>
											<div class="grsCell <?php echo $viewConf['filmstrip']['class']; ?>" >
												<label for="lightboxFilmstrip_1" >Yes:</label>
												<input type="radio" <?php echo $viewConf['filmstrip']['checked_yes'] . ' '  . $viewConf['filmstrip']['mode']; ?> value="1" name="lightboxFilmstrip" id="lightboxFilmstrip_1">
												<label for="lightboxFilmstrip_0" >No:</label>
												<input type="radio" <?php echo $viewConf['filmstrip']['checked_no'] . ' '  . $viewConf['filmstrip']['mode']; ?> value="0" name="lightboxFilmstrip" id="lightboxFilmstrip_0">
											</div>
											<div class="grsCell <?php echo $viewConf['comments']['class']; ?>" >
												<label for="lightboxComment" >Comments:</label>
											</div>
											<div class="grsCell <?php echo $viewConf['comments']['class']; ?>" >
												<label for="lightboxComment_1" >Yes:</label>
												<input type="radio" <?php echo $viewConf['comments']['checked_yes'] . ' '  . $viewConf['comments']['mode']; ?> value="1" name="lightboxComment" id="lightboxComment_1">
												<label for="lightboxComment_0" >No:</label>
												<input type="radio" <?php echo $viewConf['comments']['checked_no'] . ' '  . $viewConf['comments']['mode']; ?> value="0" name="lightboxComment" id="lightboxComment_0">
											</div>
										</div>
										<div class="grsRow">
											<div class="grsCell" >
												<label for="lightboxContButts_1" >Control buttons:</label>
											</div>
											<div class="grsCell" >
												<label for="lightboxContButts_1" >Yes:</label>
												<input type="radio" checked value="1" name="lightboxContButts" id="lightboxContButts_1">
												<label for="lightboxContButts_0" >No:</label>
												<input type="radio" value="0" name="lightboxContButts" id="lightboxContButts_0">
											</div>
											<div class="grsCell" >
												<label for="lightboxEffect" >Effect:</label>
											</div>
											<div class="grsCell" >
												<select name="lightboxEffect" id="lightboxEffect">
													<optgroup label="No effect">
														<option value="no" >No</option>
													</optgroup>
													<optgroup label="No cutting">
														<option selected value="fade" >Fade</option>
														<option <?php echo $viewConf['effects']['mode']; ?> value="slideInLeft">Slide In left</option>
														<option <?php echo $viewConf['effects']['mode']; ?> value="slideInDown">Slide In Down</option>
														<option <?php echo $viewConf['effects']['mode']; ?> value="flip">Flip & Zoom</option>
														<option <?php echo $viewConf['effects']['mode']; ?> value="zoomIn">Zoom In</option>
														<option <?php echo $viewConf['effects']['mode']; ?> value="zoomInLeft">Zoom In Left</option>
														<option <?php echo $viewConf['effects']['mode']; ?> value="zoomInDown">Zoom In Down</option>
													</optgroup>
													<optgroup label="Cutting vertical">
														<option <?php echo $viewConf['effects']['mode']; ?> value="zoomX">Zoom</option>
														<option <?php echo $viewConf['effects']['mode']; ?> value="flipX">Flip</option>
														<option <?php echo $viewConf['effects']['mode']; ?> value="rotateX">Rotate</option>
														<option <?php echo $viewConf['effects']['mode']; ?> value="fadeX">Fade out up</option>
													</optgroup>
													<optgroup label="Cutting horizontal">
														<option <?php echo $viewConf['effects']['mode']; ?> value="zoomY">Zoom</option>
														<option <?php echo $viewConf['effects']['mode']; ?> value="flipY">Flip</option>
														<option <?php echo $viewConf['effects']['mode']; ?> value="rotateY">Rotate</option>
														<option <?php echo $viewConf['effects']['mode']; ?> value="fadeY">Fade out right</option>
													</optgroup>
													<optgroup label="Mix cutting out">
														<option <?php echo $viewConf['effects']['mode']; ?> value="fadeXYFun">Fade (Fun)</option>
														<option <?php echo $viewConf['effects']['mode']; ?> value="rollXY">Roll</option>
														<option <?php echo $viewConf['effects']['mode']; ?> value="zoomXY">Zoom</option>
														<option <?php echo $viewConf['effects']['mode']; ?> value="rotateXY">Rotate</option>
														<option <?php echo $viewConf['effects']['mode']; ?> value="zoomLeftXY">Zoom out Left</option>
														<option <?php echo $viewConf['effects']['mode']; ?> value="zoomXYFun">Zoom (Fun)</option>
														<option <?php echo $viewConf['effects']['mode']; ?> value="zoomXYDownFun">Zoom Down (Fun)</option>
													</optgroup>
													<optgroup label="Mix cutting in">
														<option <?php echo $viewConf['effects']['mode']; ?> value="zoomXYInFun">Zoom</option>
														<option <?php echo $viewConf['effects']['mode']; ?> value="zoomXYInUpFun">Zoom Up</option>
														<option <?php echo $viewConf['effects']['mode']; ?> value="fadeXYInFun">Fade (Fun)</option>
													</optgroup>
													<optgroup label="Random">
														<option <?php echo $viewConf['effects']['mode']; ?> value="random">Random</option>
													</optgroup>
												</select>
											</div>
										</div>	
										<div class="grsRow">
											<div class="grsCell grsLightboxFButtLab">
												<label for="lightboxFButt_1" >Facebook:</label>
											</div>
											<div class="grsCell grsLightboxFButtInp">
												<label for="lightboxFButt_1" >Yes:</label>
												<input type="radio" checked value="1" name="lightboxFButt" id="lightboxFButt_1">
												<label for="lightboxFButt_0" >No:</label>
												<input type="radio" value="0" name="lightboxFButt" id="lightboxFButt_0">
											</div>
											<div class="grsCell grsLightboxGButtLab" >
												<label for="lightboxGButt_1" >Google+:</label>
											</div>
											<div class="grsCell grsLightboxGButtInp" >
												<label for="lightboxGButt_1" >Yes:</label>
												<input type="radio" checked value="1" name="lightboxGButt" id="lightboxGButt_1">
												<label for="lightboxGButt_0" >No:</label>
												<input type="radio" value="0" name="lightboxGButt" id="lightboxGButt_0">
											</div>
										</div>
										<div class="grsRow">
											<div class="grsCell grsLightboxTButtLab">
												<label for="lightboxTButt_1" >Twitter:</label>
											</div>
											<div class="grsCell grsLightboxTButtInp">
												<label for="lightboxTButt_1" >Yes:</label>
												<input type="radio" checked value="1" name="lightboxTButt" id="lightboxTButt_1">
												<label for="lightboxTButt_0" >No:</label>
												<input type="radio" value="0" name="lightboxTButt" id="lightboxTButt_0">
											</div>
                                            <div class="grsCell grsLightboxPButtLab">
                                                <label for="lightboxPButt_1" >Pinterest:</label>
                                            </div>
                                            <div class="grsCell grsLightboxPButtInp">
                                                <label for="lightboxPButt_1" >Yes:</label>
                                                <input type="radio" checked value="1" name="lightboxPButt" id="lightboxPButt_1">
                                                <label for="lightboxPButt_0" >No:</label>
                                                <input type="radio" value="0" name="lightboxPButt" id="lightboxPButt_0">
                                            </div>
                                        </div>
                                        <div class="grsRow">
                                            <div class="grsCell grsLightboxTbButtLab">
                                                <label for="lightboxTbButt_1" >Tumblr:</label>
                                            </div>
                                            <div class="grsCell grsLightboxTbButtInp">
                                                <label for="lightboxTbButt_1" >Yes:</label>
                                                <input type="radio" checked value="1" name="lightboxTbButt" id="lightboxTbButt_1">
                                                <label for="lightboxTbButt_0" >No:</label>
                                                <input type="radio" value="0" name="lightboxTbButt" id="lightboxTbButt_0">
                                            </div>
                                            <div class="grsCell grsLightboxLiButtLab">
                                                <label for="lightboxLiButt_1" >LinkedIn:</label>
                                            </div>
                                            <div class="grsCell grsLightboxLiButtInp">
                                                <label for="lightboxLiButt_1" >Yes:</label>
                                                <input type="radio" checked value="1" name="lightboxLiButt" id="lightboxLiButt_1">
                                                <label for="lightboxLiButt_0" >No:</label>
                                                <input type="radio" value="0" name="lightboxLiButt" id="lightboxLiButt_0">
                                            </div>
                                        </div>
                                        <div class="grsRow">
                                            <div class="grsCell grsLightboxReddButtLab">
                                                <label for="lightboxReddButt_1" >Reddit:</label>
                                            </div>
                                            <div class="grsCell grsLightboxReddButtInp">
                                                <label for="lightboxReddButt_1" >Yes:</label>
                                                <input type="radio" checked value="1" name="lightboxReddButt" id="lightboxReddButt_1">
                                                <label for="lightboxReddButt_0" >No:</label>
                                                <input type="radio" value="0" name="lightboxReddButt" id="lightboxReddButt_0">
                                            </div>
											<div class="grsCell grsLightboxFsButtLab" >
												<label for="lightboxFsButt_1" >Fullscreen:</label>
											</div>
											<div class="grsCell grsLightboxFsButtInp" >
												<label for="lightboxFsButt_1" >Yes:</label>
												<input type="radio" checked value="1" name="lightboxFsButt" id="lightboxFsButt_1">
												<label for="lightboxFsButt_0" >No:</label>
												<input type="radio" value="0" name="lightboxFsButt" id="lightboxFsButt_0">
											</div>
										</div>
										<div class="grsRow">
											<div class="grsCell grsLightboxAPLab">
												<label for="lightboxAP_1" >Autoplay:</label>
											</div>
											<div class="grsCell grsLightboxAPInp">
												<label for="lightboxAP_1" >Yes:</label>
												<input type="radio" checked value="1" name="lightboxAP" id="lightboxAP_1">
												<label for="lightboxAP_0" >No:</label>
												<input type="radio" value="0" name="lightboxAP" id="lightboxAP_0">
											</div>
											<div class="grsCell grsLightboxImInfLab" >
												<label for="lightboxImInf_1" >Image Info:</label>
											</div>
											<div class="grsCell grsLightboxImInfInp" >
												<label for="lightboxImInf_1" >Yes:</label>
												<input type="radio" checked value="1" name="lightboxImInf" id="lightboxFsButt_1">
												<label for="lightboxImInf_0" >No:</label>
												<input type="radio" value="0" name="lightboxImInf" id="lightboxImInf_0">
											</div>
										</div>
										<div class="grsRow">
											<div class="grsCell grsLightboxAPinLab" >
												<label for="lightboxAPin" >Autoplay interval:</label>
											</div>
											<div class="grsCell grsLightboxAPinInp" >
												<input type="number" min="1" value="3" name="lightboxAPin" id="lightboxAPin"><span>sec</span>
											</div>
											<div class="grsCell grsLightboxAPinLab" >
											</div>
											<div class="grsCell grsLightboxAPinInp" >
											</div>
										</div>	
										<div class="grsRow">
											<div class="grsCell" >
												<label for="lightboxImCn_1" >Image counting:</label>
											</div>
											<div class="grsCell" >
												<label for="lightboxImCn_1" >Yes:</label>
												<input type="radio" checked value="1" name="lightboxImCn" id="lightboxImCn_1">
												<label for="lightboxImCn_0" >No:</label>
												<input type="radio" value="0" name="lightboxImCn" id="lightboxImCn_0">
											</div>
											<div class="grsCell" >
												<label for="lightboxSwipe" >Swipe:</label>
											</div>
											<div class="grsCell" >
												<label for="lightboxSwipe_1" >Yes:</label>
												<input type="radio" checked value="1" name="lightboxSwipe" id="lightboxSwipe_1">
												<label for="lightboxSwipe_0" >No:</label>
												<input type="radio" value="0" name="lightboxSwipe" id="lightboxSwipe_0">
											</div>
										</div>								
									</div>
								</div>
							</div>
							<div class="grsClear"></div>
							
							<div class="grsOkCont">
								<div class="grsOk">
									<?php echo $task == 'update' ? 'Update' : 'Insert'; ?>
								</div>
								<div class="grsClear"></div>
							</div>
						</div>
					</div>
				</body>
			</html>
		<?php
	}
}	