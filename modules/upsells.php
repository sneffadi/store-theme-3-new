<?php
add_action('page_after_entry_content', 'top_products_cb');

/*=============================================
this function builds the top x list on pages and
and the review overviews on recommended products
=============================================*/

function top_products_cb() {
    global $post, $sc_id;
    $options = get_option('theme_options');
    $num = !empty($options['ratings']) ? $options['ratings'] : "100";
    $niche = !empty($options['nichename']) ? $options['nichename'] : "";
    $niche_override = get_post_meta($post->ID, "override_niche_name_override-niche-name", true);
    if ( $niche_override !== '' && $niche_override !== false ){
            $niche = $niche_override;
    }
    $ids = explode(",", get_post_meta($post->ID, "top-products-list", true));
    $idsCount = count($ids);
    $year = date("Y");
    $is_single = is_single();
    $is_page = is_page();
    $is_product = is_singular('products');
    $readMore = 'Learn More';
    $seePricing = 'See Pricing';

    $i = 1;
    if($is_page&&$idsCount>1):
        ?>
<div class="row upsell collapse" id="top-rated-list">
    <div class="row collapse">
        <div class="small-24 columns">
            <h2 class="top-list"><?php echo $niche; ?>s <span class="pink"> of <?php echo $year; ?></span></h2>
        </div><!--/small-12 columns-->
    </div><!--/row collapse-->
    <div class="row collapse">
        <?php foreach($ids as $id):
            ?>
        <div class="small-24 columns top-product">
            <div class="row">
                <div class="small-24 medium-12 columns image-table">
                    <div class="row">
                        <div class="small-24 small-columns product-image">
                            <?php if (has_post_thumbnail($id)) {
                                echo "<figure>";
                                echo "<a href=\"" . get_the_permalink($id) . "\">";
                                echo get_the_post_thumbnail($id);
                                echo "</a>";
                                echo "</figure>";
                            } else echo '&nbsp;'; ?>
                        </div><!--/small-4 medium-2 columns-->
                        <div class="small-24 small-columns gray-wrap">
                            <div class="row collapse">
                                <div class="small-24 columns table">
                                    <div class="criterion-row row">
                                        <div class="small-8 columns criterion">
                                            <div class="rating-type">
                                                Overall Rating:
                                            </div>
                                            <?php $thisRating= get_post_meta($post->ID, $id.'-ratings-overall-value', TRUE);
                                            if($thisRating==='') {
                                                $thisRating= get_post_meta($id, 'ratings-overall-value', TRUE);
                                                if($thisRating==='') $thisRating= 0;
                                            }
                                            $thisRating= number_format(floatval($thisRating), 1); ?>
                                            <div class="star-col">
                                                <div class="star-positioner">
                                                    <div class="stars">
                                                        <div class="colorbar" style="width:<?php echo $thisRating*20;?>%"></div>
                                                        <div class="star_holder">
                                                            <div class="star star-1"></div> <!-- / .star -->
                                                            <div class="star star-2"></div> <!-- / .star -->
                                                            <div class="star star-3"></div> <!-- / .star -->
                                                            <div class="star star-4"></div> <!-- / .star -->
                                                            <div class="star star-5"></div> <!-- / .star -->
                                                        </div> <!-- / .star_holder -->
                                                    </div> <!-- / .stars -->
                                                </div> <!-- / .star-positioner -->
                                            </div>
                                        </div>
                                        <div class="small-8 columns criterion">
                                            <div class="rating-type">
                                                <?php $value= get_post_meta($id, "ratings-ingredient-quality", true);
                                                if(($value===FALSE)||($value==='')) $value= 0; ?>
                                                    Ingredient Quality:
                                            </div>
                                                <?php $thisRating= get_post_meta($post->ID, $id.'-ratings-ingredient-quality', TRUE);
                                                if($thisRating==='') {
                                                    $thisRating= get_post_meta($id, 'ratings-ingredient-quality', TRUE);
                                                    if($thisRating==='') $thisRating= 0;
                                                }
                                                $thisRating= number_format(floatval($thisRating), 1); ?>
                                            <div class="star-col">
                                                <div class="star-positioner">
                                                    <div class="stars">
                                                        <div class="colorbar" style="width:<?php echo $thisRating*20;?>%"></div>
                                                        <div class="star_holder">
                                                            <div class="star star-1"></div> <!-- / .star -->
                                                            <div class="star star-2"></div> <!-- / .star -->
                                                            <div class="star star-3"></div> <!-- / .star -->
                                                            <div class="star star-4"></div> <!-- / .star -->
                                                            <div class="star star-5"></div> <!-- / .star -->
                                                        </div> <!-- / .star_holder -->
                                                    </div> <!-- / .stars -->
                                                </div> <!-- / .star-positioner -->
                                            </div>
                                        </div>
                                        <div class="small-8 columns criterion">
                                            <div class="rating-type">
                                                <?php $value= get_post_meta($id, "ratings-effectiveness", true);
                                                if(($value===FALSE)||($value==='')) $value= 0; ?>
                                                    Enlargement Power:
                                            </div>
                                                <?php $thisRating= get_post_meta($post->ID, $id.'-ratings-effectiveness', TRUE);
                                                if($thisRating==='') {
                                                    $thisRating= get_post_meta($id, 'ratings-effectiveness', TRUE);
                                                    if($thisRating==='') $thisRating= 0;
                                                }
                                                $thisRating= number_format(floatval($thisRating), 1); ?>
                                            <div class="star-col">
                                                <div class="star-positioner">
                                                    <div class="stars">
                                                        <div class="colorbar" style="width:<?php echo $thisRating*20;?>%"></div>
                                                        <div class="star_holder">
                                                            <div class="star star-1"></div> <!-- / .star -->
                                                            <div class="star star-2"></div> <!-- / .star -->
                                                            <div class="star star-3"></div> <!-- / .star -->
                                                            <div class="star star-4"></div> <!-- / .star -->
                                                            <div class="star star-5"></div> <!-- / .star -->
                                                        </div> <!-- / .star_holder -->
                                                    </div> <!-- / .stars -->
                                                </div> <!-- / .star-positioner -->
                                            </div>
                                        </div> 
                                    </div><!--/ criterion-row row -->
                                    <div class="criterion-row row">
                                        <div class="small-8 columns criterion">
                                            <?php $value= get_post_meta($id, "ratings-long-term-results", true);
                                            if(($value===FALSE)||($value==='')) $value= 0; ?>
                                            <div class="rating-type">
                                                Long-Term Results:
                                            </div>
                                            <?php $thisRating= get_post_meta($post->ID, $id.'-ratings-long-term-results', TRUE);
                                            if($thisRating==='') {
                                                $thisRating= get_post_meta($id, 'ratings-long-term-results', TRUE);
                                                if($thisRating==='') $thisRating= 0;
                                            }
                                            $thisRating= number_format(floatval($thisRating), 1); ?>
                                            <div class="star-col">
                                                <div class="star-positioner">
                                                    <div class="stars">
                                                        <div class="colorbar" style="width:<?php echo $thisRating*20;?>%"></div>
                                                        <div class="star_holder">
                                                            <div class="star star-1"></div> <!-- / .star -->
                                                            <div class="star star-2"></div> <!-- / .star -->
                                                            <div class="star star-3"></div> <!-- / .star -->
                                                            <div class="star star-4"></div> <!-- / .star -->
                                                            <div class="star star-5"></div> <!-- / .star -->
                                                        </div> <!-- / .star_holder -->
                                                    </div> <!-- / .stars -->
                                                </div> <!-- / .star-positioner -->
                                            </div><!-- /.star-col -->
                                        </div>
                                        <div class="small-8 columns criterion">
                                            <div class="rating-type">
                                                <?php $value= get_post_meta($id, "ratings-customer-reviews", true);
                                                if(($value===FALSE)||($value==='')) $value= 0; ?>
                                                    Customer Reviews:
                                            </div>
                                                <?php $thisRating= get_post_meta($post->ID, $id.'-ratings-customer-reviews', TRUE);
                                                if($thisRating==='') {
                                                    $thisRating= get_post_meta($id, 'ratings-customer-reviews', TRUE);
                                                    if($thisRating==='') $thisRating= 0;
                                                }
                                                $thisRating= number_format(floatval($thisRating), 1); ?>
                                            <div class="star-col">
                                                <div class="star-positioner">
                                                    <div class="stars">
                                                        <div class="colorbar" style="width:<?php echo $thisRating*20;?>%"></div>
                                                        <div class="star_holder">
                                                            <div class="star star-1"></div> <!-- / .star -->
                                                            <div class="star star-2"></div> <!-- / .star -->
                                                            <div class="star star-3"></div> <!-- / .star -->
                                                            <div class="star star-4"></div> <!-- / .star -->
                                                            <div class="star star-5"></div> <!-- / .star -->
                                                        </div> <!-- / .star_holder -->
                                                    </div> <!-- / .stars -->
                                                </div> <!-- / .star-positioner -->
                                            </div><!--/ .star-col -->
                                        </div>
                                        <div class="small-8 columns criterion">
                                            <div class="rating-type">
                                                <?php $value= get_post_meta($id, "ratings-product-safety", true);
                                                if(($value===FALSE)||($value==='')) $value= 0; ?>
                                                    Product Safety:
                                            </div>
                                                <?php $thisRating= get_post_meta($post->ID, $id.'-ratings-product-safety', TRUE);
                                                if($thisRating==='') {
                                                    $thisRating= get_post_meta($id, 'ratings-product-safety', TRUE);
                                                    if($thisRating==='') $thisRating= 0;
                                                }
                                                $thisRating= number_format(floatval($thisRating), 1); ?>
                                            <div class="star-col">
                                                <div class="star-positioner">
                                                    <div class="stars">
                                                        <div class="colorbar" style="width:<?php echo $thisRating*20;?>%"></div>
                                                        <div class="star_holder">
                                                            <div class="star star-1"></div> <!-- / .star -->
                                                            <div class="star star-2"></div> <!-- / .star -->
                                                            <div class="star star-3"></div> <!-- / .star -->
                                                            <div class="star star-4"></div> <!-- / .star -->
                                                            <div class="star star-5"></div> <!-- / .star -->
                                                        </div> <!-- / .star_holder -->
                                                    </div> <!-- / .stars -->
                                                </div> <!-- / .star-positioner -->
                                            </div>
                                        </div>
                                    </div><!--/ criterion-row row -->
                                </div>
                                <div class="small-24 columns price-wrap">
                                    <div class="criterion-row row">
                                        <?php $cf_value= get_post_meta($id);
                                        $showCustom= (isset($cf_value['cf_custom_banner']))&&($cf_value['cf_custom_banner'][0]==='yes');
                                        if($showCustom) $value= get_post_meta($id, "cf_retail_price", true);
                                        else $value= get_post_meta($id, "retail_c1", true);
                                        if(($value===FALSE)||($value==='')) $value= 0; ?>
                                        <div class="small-10 medium-8 columns msrp">
                                            MSRP: <span><?php echo "$".number_format($value, 2); ?></span>
                                        </div>
                                        <div class="small-14 medium-16 columns our-price">

                                            Our Price: 
                                            <?php
                                                        if(get_post_meta($id, "cf_custom_banner", true)==='yes') {
                                                            $pricing= get_post_meta($id, "cf_store_price", true);
                                                            echo "<a href=\"" . get_the_permalink($id) . "\">" . "$" . number_format( $pricing, 2) . "</a>";
                                                        } else {
                                                            $pricing = array();
                                                            $p1 = get_post_meta($id, "price_c1", true) / 1;
                                                            $p2 = get_post_meta($id, "price_c2", true) / 2;
                                                            if (get_post_meta($id, "qty_c3", true) > 2) {
                                                            $p3 = get_post_meta($id, "price_c3", true) / 3;
                                                            array_push($pricing, $p1, $p2, $p3 );
                                                            }
                                                            else {
                                                               array_push($pricing, $p1, $p2);
                                                            }
                                                            $low = min($pricing);
                                                            $high = max($pricing);
                                                            $epsilon = 0.00001;
                                                            if(abs($low-$high) < $epsilon) {
                                                                echo "<a href=\"" . get_the_permalink($id) . "\">" . "$" . number_format( $low, 2) . "</a>";
                                                            } else {
                                                                echo "<a href=\"" . get_the_permalink($id) . "\">" . "$" . number_format( $low, 2) . "-" . number_format( $high, 2) .  "</a>";
                                                            }
                                                        }

                                                    ?>
                                        </div>
                                    </div><!-- /.criterion-row -->
                                </div><!-- /.price-wrap -->
                            </div>
                        </div><!-- /.small-columns -->
                        
                    </div><!--/row-->
                </div><!--/image-table-->

                <div class="small-24 medium-12 columns upsell-content">
                    <div class="row collapse">
                        <div class="small-12 columns">
                            <h3 class="upsell-title">
                                <a href="<?php echo get_the_permalink($id); ?>" >
                                    <?php
                                        $subhead = get_post_meta($id, 'review-subhead', true);
                                        echo "#{$i} " . get_the_title($id);
                                    ?>
                                </a>
                            </h3>
                        </div>
                        <div class="small-12 columns">
                            <div class="criterion-row row">
                                <?php $thisRating= get_post_meta($post->ID, $id.'-ratings-overall-value', TRUE);
                                if($thisRating==='') {
                                    $thisRating= get_post_meta($id, 'ratings-overall-value', TRUE);
                                    if($thisRating==='') $thisRating= 0;
                                }
                                $thisRating= number_format(floatval($thisRating), 1); ?>
                                <div class="small-18 columns star-col">
                                    <div class="star-positioner">
                                        <div class="stars">
                                            <div class="colorbar" style="width:<?php echo $thisRating*20;?>%"></div>
                                            <div class="star_holder">
                                                <div class="star star-1"></div> <!-- / .star -->
                                                <div class="star star-2"></div> <!-- / .star -->
                                                <div class="star star-3"></div> <!-- / .star -->
                                                <div class="star star-4"></div> <!-- / .star -->
                                                <div class="star star-5"></div> <!-- / .star -->
                                            </div> <!-- / .star_holder -->
                                        </div> <!-- / .stars -->
                                    </div> <!-- / .star-positioner -->
                                </div><!--/medium-5 columns show-for-medium-->
                                <div class="small-6 columns out-of">
                                    <?php echo $thisRating."/".$num; ?>
                                </div><!--/ small-3 medium-2 columns out-of -->
                            </div><!--/ criterion-row row -->
                        </div>
                    </div>
                    <h4><?php
                        if (isset($subhead) && $subhead !== '') {
                                echo "{$subhead}";
                            }
                     ?></h4>
                     <?php $guarantee = get_post_meta($id, 'ratings-guarantee', true);
                        if (isset($guarantee) && $guarantee !== '') { ?>
                            <div class="row guarantee-row collapse">
                                <div class="small-24 columns">
                                    <i class="fa fa-certificate" aria-hidden="true"></i> <?php echo get_post_meta($id, "ratings-guarantee", true); ?> <a href="">Details</a>
                                </div>
                             </div>
                        <?php    } ?>
                     
                     <div class="content-wrap">
                    <?php if (strlen(get_post_meta($id, $id . "_custom_content", true)) > 0) {
                    $sc_id= $id;
                    echo do_shortcode("<p>".get_post_meta($id, $id."_custom_content", true)." [a]Learn More &raquo;[/a]</p>");
                    } else {
                        $sc_id= $id;
                        echo do_shortcode("<p>".get_post_meta($id, 'review-blurb', true)." [a]Learn More &raquo;[/a]</p>");
                    } ?>
                    </div>
                    <div class="row collapse">
                        <div class="small-11 columns">
                            <a href="<?php echo get_permalink($id);?>" class="tiny button secondary radius"><?php echo $readMore;?></a>
                        </div><!--/.small-6 columns-->
                        <div class="small-13 columns">
                            <a href="<?php echo get_permalink($id) ?>/#buytable" class="tiny button success radius">
                            <?php echo $seePricing; ?>
                            </a>
                        </div><!--/.columns-->
                    </div><!--/.row collapse-->
                </div><!--/upsell-content-->
                
                
            </div><!--/.row collapse -->
        </div><!--/small-12 columns top-product-->
            <?php $i++;
        endforeach;
    endif; //end if is page and ids count ?>
    </div><!--/.row collapse-->
</div><!--/.row upsell collapse top-rated-list -->
<?php } // end top_products_cb
