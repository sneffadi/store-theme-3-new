jQuery(document).ready(function($) {
    $('section#product_meta').on('click', '.addRow', function(e) {
        e.preventDefault();
        var i, j, columnCount, rowCount, html;
        //columnCount = $(this).closest("section#product_meta").find("input[name^=columnCount]");
        rowCount = $(this).closest("div[data-column]").find("input[name^=rowCount]");
        //i = parseInt(columnCount.val());        
        j = parseInt(rowCount.val());
        j++;
        //columnCount.val(i);
        i = $(this).closest("div[data-column]").attr("data-column");
        i = parseInt(i);
        rowCount.val(j);
        $(this).closest('div').before(html);
    });
    $('section#product_meta').on('click', '.addColumn', function(e) {
        e.preventDefault();
        var i, j, columnCount, rowCount, html;
        columnCount = $(this).closest("section#product_meta").find("input[name^=columnCount]");
        i = parseInt(columnCount.val());
        i++;
        columnCount.val(i);
        j=1;
        html = '<div data-column="' + i + '"><h4>Column ' + i + '</h4>';

        html += '<label>Column Title:</label><input type="text" name="title_c'+i+'" value="">';
        html += '<label>Column Sub Title:</label><input type="text" name="sub_title_c'+i+'" value="">';
        html += '<label>Retail:</label><input type="text" name="retail_c'+i+'" value="">';
        html += '<label>Price:</label><input type="text" name="price_c'+i+'" value="">';
        html += '<label>Quantity (include bottles, kits, etc):</label><input type="text" name="qty_c'+i+'" value="">';
        html += '<label>Bonus:</label><input type="text" name="bonus_c'+i+'" value="">';
        html += '<label>Shipping:</label><input type="text" name="shipping_c'+i+'" value="">';
        html += '<label>Item ID:</label><input type="text" name="itemId_c' + i + '" value="">';
        html += '<label>Product Image:</label><input type="text" name="image_c' + i + '" value="">';

        $(this).closest("div").before(html);
    });


    /**
     *
     * This is for image upload funcitonality
     *
     **/

    var meta_image_frame;
    $("#product_meta").on("click", ".image-button", function(e) {
        e.preventDefault();
        var $this = $(e.target) || "";
        if (meta_image_frame) {
            meta_image_frame.open();
            return;
        }
        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
            title: meta_image.title,
            button: {
                text: meta_image.button
            },
            library: {
                type: "image"
            }
        });
        meta_image_frame.on("select", function() {
            var media_attachment = meta_image_frame.state().get("selection").first().toJSON();
            console.log(media_attachment);
            $this.prev().val(media_attachment.filename);
        });
        meta_image_frame.open();
    });
});

