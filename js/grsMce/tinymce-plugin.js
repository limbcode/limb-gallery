(function() {
    tinymce.create('tinymce.plugins.GrsMce', {
        init : function(ed, url) {
			function replaceGrsGalleryShortcodes( content ) {
				return content.replace( /\[GRS([^\]]*)\]/g, function( match ) {
					return html( 'grsMce', match );
				});
			}
			
			function html( cls, data ) {
				data = window.encodeURIComponent( data );
				return '<img src="' + url + '/limb-32-32.png" style="cursor:pointer" class="mceItem ' + cls + '" ' +
					'data-grs="' + data + '" data-mce-resize="false" data-mce-placeholder="1" />';
			}
			
			function editGrsGallery( node ) {
				var data;

				if ( node.nodeName !== 'IMG' ) {
					return;
				}

				// Check if the `wp.media` API exists.
				if ( typeof wp === 'undefined' || ! wp.media ) {
					return;
				}
				data = ed.dom.getAttrib( node, 'data-grs' );

				// Make sure we've selected a grs gallery node.
				if ( ed.dom.hasClass( node, 'grsMce' )) {
					ed.windowManager.open({
						file: grsAdminAjax + '?action=grsGalleryAjax&grsAction=shortcode&task=update&data=' + data,
						width: 872,
						height: 465,
						inline: 1
					}, {
						plugin_url:url
					});
				}
			}
			
			function restoreGrsGalleryShortcodes( content ) {
				function getAttr( str, name ) {
					name = new RegExp( name + '=\"([^\"]+)\"' ).exec( str );
					return name ? window.decodeURIComponent( name[1] ) : '';
				}

				return content.replace( /(?:<p(?: [^>]+)?>)*(<img [^>]+>)(?:<\/p>)*/g, function( match, image ) {
					var data = getAttr( image, 'data-grs' );

					if ( data ) {
						// return '<p>' + data + '</p>';
						return data;
					}

					return match;
				});
			}
			
			ed.addButton('grsMce', {
                title : 'Limb Gallery',
                cmd : 'grsMce',
                image : url + '/limb-20-20.png'
            });
			 
            ed.addCommand('grsMce', function() {
				ed.windowManager.open({
					file: grsAdminAjax + '?action=grsGalleryAjax&grsAction=shortcode',
					width: 872,
					height: 465,
					inline: 1
				}, {
					plugin_url:url
				});
            });
			
			ed.on( 'BeforeSetContent', function( event ) {
				// 'wpview' handles the gallery shortcode when present
				if ( typeof ed.plugins.grs !== 'undefined' ) {
					event.content = replaceGrsGalleryShortcodes( event.content );
				}
			});
			
			ed.on( 'mouseup', function( event ) {
				var dom = ed.dom,
					node = event.target;

				function unselect() {
					dom.removeClass( dom.select( 'img.wp-media-selected' ), 'wp-media-selected' );
				}

				if ( node.nodeName === 'IMG' && dom.getAttrib( node, 'data-grs' ) ) {
					// Don't trigger on right-click
					if ( event.button !== 2 ) {
						/*if ( dom.hasClass( node, 'wp-media-selected' ) ) {
							editGrsGallery( node );
						} else {
							unselect();
							dom.addClass( node, 'wp-media-selected' );
						}*/
						editGrsGallery( node );
					}
				} else {
					unselect();
				}
			});

			
			ed.on( 'PostProcess', function( event ) {
				if ( event.get ) {
					event.content = restoreGrsGalleryShortcodes( event.content );
				}
			});
			
        },
        // ... Hidden code
    });
    // Register plugin
    tinymce.PluginManager.add( 'grs', tinymce.plugins.GrsMce );
})();