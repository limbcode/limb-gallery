<?php
/**
 * LIMB gallery
 * Frontend
 * Album view
 */
 
class GRSViewAlbum {
	
	//Private variables
	private $model;
	//Costructor
	public function __construct($model) {
		$this->model = $model;
    }
    	
	public function display($counter) {
		?>
		<div id="grsGal<?php echo $counter; ?>" class="grsGal<?php echo $counter; ?> grsTemplate<?php echo $this->model->atts['theme']; ?>">
			<div class="grsGalCont" ng-controller="grsAlbum<?php echo $counter; ?>" ng-show="params.cssReady" >
				<grs-album params="params" resize scroll></grs-album>
			</div>
		</div>	
		<script>
			var grsAtts<?php echo $counter; ?> = jQuery.parseJSON('<?php echo json_encode($this->model->atts); ?>');
			grsApp.controller('grsAlbum<?php echo $counter; ?>', ['$scope', '$filter', '$log',
				function ($scope, $filter, $log) {
					$scope.params = {
						shatts: grsAtts<?php echo $counter; ?>,
						grs: '<?php echo $counter; ?>',
						data: {
							images : [],
							content : [],
							comments: [],
							theme: {}
						},
						cssReady: false
					};
					insertCss(grsAtts<?php echo $counter; ?>, '<?php echo $counter; ?>');
				}
			]);
		</script>
		<?php
    }
}