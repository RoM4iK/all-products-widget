jQuery(document).ready(function() {
    var elements = jQuery('.all-products-category');
    function show(el) {
    	elements.removeClass('active');
    	elements.find('.all-products-list').height(0);
        jQuery(el).addClass('active');
        var productsHeight = 0;
        var products = jQuery('.all-products-category.active .all-products-product');
        jQuery.each(products, function(key, product) {
            productsHeight += jQuery(product).outerHeight();
        });
        jQuery(el).find('.all-products-list').height(productsHeight);
    }
    elements.find('h4').on('click', function(e) {
    	var parent = jQuery(this).parent()
        if(parent.hasClass('active')) {
            console.log('active');
            return true;
        };
        e.preventDefault();
        show(parent);
    });
    var activeElement = jQuery('.all-products-category.active');
    if(activeElement.length == 0) {
    	show(elements[0]);
    }
    else {
    	show(activeElement);
    }
});