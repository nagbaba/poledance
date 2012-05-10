//Data table sorting/desorting
$(document).ready(function() {
	
	/* Date sorting in datatable*/
	jQuery.fn.dataTableExt.oSort['uk_date-asc']  = function(a,b) {
	var ukDatea = a.split('-');
	var ukDateb = b.split('-');
	
	var x = (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
	var y = (ukDateb[2] + ukDateb[1] + ukDateb[0]) * 1;
	
	return ((x < y) ? -1 : ((x > y) ?  1 : 0));
	};
	
	jQuery.fn.dataTableExt.oSort['uk_date-desc'] = function(a,b) {
	var ukDatea = a.split('-');
	var ukDateb = b.split('-');
	
	var x = (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
	var y = (ukDateb[2] + ukDateb[1] + ukDateb[0]) * 1;
	
	return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
	};
	/* End of date sorting in datatable*/
	
	/* Currency sorting in datatable*/
	jQuery.fn.dataTableExt.oSort['currency-asc'] = function(a,b) {
		/* Remove any commas (assumes that if present all strings will have a fixed number of d.p) */
		var x = a == "-" ? 0 : a.replace( /,/g, "" );
		var y = b == "-" ? 0 : b.replace( /,/g, "" );
		
		/* Remove the currency sign */
		x = x.substring( 1 );
		y = y.substring( 1 );
		
		/* Parse and return */
		x = parseFloat( x );
		y = parseFloat( y );
		return x - y;
	};

	jQuery.fn.dataTableExt.oSort['currency-desc'] = function(a,b) {
		/* Remove any commas (assumes that if present all strings will have a fixed number of d.p) */
		var x = a == "-" ? 0 : a.replace( /,/g, "" );
		var y = b == "-" ? 0 : b.replace( /,/g, "" );
		
		/* Remove the currency sign */
		x = x.substring( 1 );
		y = y.substring( 1 );
		
		/* Parse and return */
		x = parseFloat( x );
		y = parseFloat( y );
		return y - x;
	};
	/* End of currency sorting in datatable*/
	
} );
