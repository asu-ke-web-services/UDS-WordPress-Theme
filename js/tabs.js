/**
 * File tabs.js.
 *
 * JS for tabs carosel.
 *
 */

 (function( $ ) {
 jQuery(function() {
 $( '.scroll-control-next' ).on( 'click', function( e ) {
 slideNav( this, e, -1 );
});

 $( '.scroll-control-prev' ).on( 'click', function( e ) {
 slideNav( this, e, 1 );
});

 $( '.uds-tabbed-panels .scroll-control-prev' ).hide();
});

 function setControlVisibility( clicked ) {
 var parentContainer = $( clicked ).closest( '.uds-tabbed-panels' );

 var parentNav = $( clicked ).siblings( '.nav-tabs' );

 var scrollPosition = parentNav.data( 'scroll-position' ) * 1;

 var navItems = parentNav.find( '.nav-item' ).toArray();

 if (  0 === scrollPosition ) {
 parentContainer.find( '.scroll-control-prev' ).hide();
} else {
 parentContainer.find( '.scroll-control-prev' ).show();
}

 if ( scrollPosition === navItems.length - 1 ) {
 parentContainer.find( '.scroll-control-next' ).hide();
} else {
 parentContainer.find( '.scroll-control-next' ).show();
}
}

 function slideNav( clicked, e, direction ) {
 var parentNav = $( clicked ).siblings( '.nav-tabs' );

 var scrollPosition = parentNav.data( 'scroll-position' ) * 1;

 var navItems = parentNav.find( '.nav-item' ).toArray();

 var scrollOffset = parentNav.css( 'left' ).replace( 'px', '' ) * 1;

 var i = 0;

 e.preventDefault();

 if ( 1 === direction && scrollPosition > 0 ) {
 scrollPosition -= 1;
}

 if ( scrollPosition < navItems.length - 1 && direction === -1 ) {
 scrollPosition += 1;
}

 parentNav.data( 'scroll-position', scrollPosition );

 scrollOffset = 0;

 for ( i = 0; i < scrollPosition; i++ ) {
 scrollOffset += $( navItems[i] ).outerWidth();
}

 parentNav.css( 'left', '-' + scrollOffset + 'px' );

 setControlVisibility( clicked );
}

})( jQuery );
