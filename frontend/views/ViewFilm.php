<?php
/**
 * LIMB gallery
 * Frontend
 * Thumbnail view
 */
 
class GRSViewFilm {
	
	//Private variables
	private $model;
	//Costructor
	public function __construct($model) {
		$this->model = $model;
    }
    	
	public function display($counter) {
		?>
		<div id="grsGal<?php echo $counter; ?>" class="grsGal<?php echo $counter; ?> grsTemplate<?php echo $this->model->atts['theme']; ?>">
			<div class="grsGalCont" ng-controller="grsFilm<?php echo $counter; ?>" ng-show="params.cssReady" >
				<grs-film params="params" resize scroll></grs-film>
			</div>
		</div>			
		<script>
			var grsAtts<?php echo $counter; ?> = jQuery.parseJSON('<?php echo json_encode($this->model->atts); ?>');
			grsApp.controller('grsFilm<?php echo $counter; ?>', ['$scope', 'GrsService',
				function ($scope, GrsService) {
					$scope.params = {
						shatts: grsAtts<?php echo $counter; ?>,
						grs: '<?php echo $counter; ?>',
						data: {
							images : [],
							comments: [],
							theme: {}
						},
						cssReady: false,
					};
					insertCss(grsAtts<?php echo $counter; ?>, '<?php echo $counter; ?>');
				}
			]);
		</script>
		<?php
    }
}