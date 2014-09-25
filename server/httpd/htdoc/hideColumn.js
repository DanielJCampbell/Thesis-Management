function hidecolumn(){
	$('a.toggle-vis').on( 'click',hideThings(e));
}
function hideThings(e){
	e.preventDefault();
    /* Get the column API object*/
    var column = table.column( $(this).attr('data-column') );
    /* Toggle the visibility*/
    column.visible( ! column.visible() );
}