( function( blocks ) {
	var blockCategories = blocks.getCategories();
	blockCategories.unshift({ 'slug': 'merchandiser', 'title': 'Merchandiser Blocks'});
	blocks.setCategories(blockCategories);
})(
	window.wp.blocks
);
