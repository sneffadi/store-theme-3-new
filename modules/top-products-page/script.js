jQuery(document).ready(function($) {

    /**
     *
     * This is for image upload funcitonality
     *
     **/
    (function() {
        var checkbox = $('input[name=show_hero]');
        checkbox.on("change", function() {
            if (this.checked)
                $(this).closest('p').nextAll().fadeIn();
            else
                $(this).closest('p').nextAll().fadeOut();
        });
        if (checkbox.prop("checked")) {
            checkbox.closest('p').nextAll().show();
        } else {
            checkbox.closest('p').nextAll().hide();
        }
    })();

    (function() {
        var checkbox = $('input[name=use_image_other_than_featured]');
        checkbox.on("change", function() {
            if (this.checked)
                $(this).closest('p').next('p').fadeIn();
            else
                $(this).closest('p').next('p').fadeOut().find("input").val("");
        });
        if (checkbox.prop("checked")) {
            checkbox.closest('p').next('p').show();
        } else {
            checkbox.closest('p').next('p').hide();
        }
    })();

    (function() {
        var meta_image_frame;
        $("#hero_meta").on("click", ".upload-image", function(e) {
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
    })();


    // (function() {
    //     $("#sortable").sortable({
    //         revert: true
    //     });
    //     $("#draggable").draggable({
    //         connectToSortable: "#sortable",
    //         helper: "clone",
    //         revert: "invalid"
    //     });
    //     $("ul, li").disableSelection();
    // })();

    (function() {
        var count = $("#top-x-list li").size();
        $("#top-x-list").find("h3 > span").text(count);

        $("#all-products li").draggable({
            appendTo: "body",
            helper: "clone"
        });
        $("#top-x-list ol").droppable({
            activeClass: "ui-state-default",
            hoverClass: "ui-state-hover",
            accept: ":not(.ui-sortable-helper)",
            drop: function(event, ui) {
                $(this).find(".placeholder").remove();
                $("<li></li>").text(ui.draggable.text()).appendTo(this).attr("data-post-id", ui.draggable.attr("data-post-id"));
                var count = $("#top-x-list li").size();
                $(this).closest("#top-x-list").find("h3 > span").text(count);
                console.log($(this));
                var arr = [];
                $("#top-x-list li").each(function() {
                    var id = $(this).attr("data-post-id");
                    if (id) {
                        arr.push(id);
                    }
                });
                $("input[name=top-products-list]").val(arr);
            }
        }).sortable({
            items: "li:not(.placeholder)",
            refresh: true,
            sort: function(event, ui) {
                $(this).removeClass("ui-state-default");
            },
            stop: function() {
                var arr = [];
                $("#top-x-list li").each(function() {
                    var id = $(this).attr("data-post-id");
                    if (id) {
                        arr.push(id);
                    }
                });
                $("input[name=top-products-list]").val(arr);
                var count = $("#top-x-list li").size();
                $(this).closest("#top-x-list").find("h3 > span").text(count);
            },
            over: function() {
                removeIntent = false;
            },
            out: function() {
                removeIntent = true;
            },
            beforeStop: function (event, ui) {
                if(removeIntent == true){
                    ui.item.remove();   
                }
            }
        });
    })(); //end module

}); //end on ready
