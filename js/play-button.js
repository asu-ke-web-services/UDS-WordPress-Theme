( function( $ ) {

	$( '.side-tabs .tab-content .tab-pane button.btn.btn-circle' ).click(function() {
		var mainContant = $( this ).parent();
		var iframeVideo = mainContant.find( 'iframe' );
		mainContant.addClass( 'no-gradient-bg' );

		      mainContant.find( 'img' ).fadeOut( 'slow' );
		      $( this ).hide();
		      iframeVideo.attr(
		        'src',
		        iframeVideo.attr( 'src' ).replace( 'autoplay=0', 'autoplay=1' )
		      );
		      iframeVideo.attr( 'allow', 'autoplay' );

	});

	} )( jQuery );
