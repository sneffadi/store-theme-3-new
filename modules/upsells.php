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
    $readMore = 'Read More';
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
                <h3 class="upsell-title">
                    <a href="<?php echo get_the_permalink($id); ?>" >
                        <?php
                            $subhead = get_post_meta($id, 'review-subhead', true);
                            echo "#{$i} " . get_the_title($id);
                            if (isset($subhead) && $subhead !== '') {
                                echo " – <span>{$subhead}</span>";
                            }
                        ?>
                    </a>
                </h3>
                <div class="small-8 medium-5 small-columns product-image">
            <?php if (has_post_thumbnail($id)) {
                echo "<figure>";
                echo "<a href=\"" . get_the_permalink($id) . "\">";
                echo get_the_post_thumbnail($id);
                echo "</a>";
                echo "</figure>";
            } else echo '&nbsp;'; ?>
                </div><!--/small-4 medium-2 columns-->
                <div class="small-16 medium-9 small-columns">
                    <div class="row collapse">
                        <div class="small-24 columns table">
                            <div class="criterion-row row">
                                <div class="small-14 medium-11 columns criterion">
                                    Overall Value:
                                </div>
                                <?php $thisRating= get_post_meta($post->ID, $id.'-ratings-overall-value', TRUE);
                                if($thisRating==='') {
                                    $thisRating= get_post_meta($id, 'ratings-overall-value', TRUE);
                                    if($thisRating==='') $thisRating= 0;
                                }
                                $thisRating= number_format(floatval($thisRating), 1); ?>
                                <div class="medium-9 small-10 columns star-col">
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
                                <div class="small-6 medium-4 columns out-of show-for-medium">
                                    <?php echo $thisRating."/".$num; ?>
                                </div><!--/ small-3 medium-2 columns out-of -->
                            </div><!--/ criterion-row row -->
                            <div class="criterion-row row">
            <?php $value= get_post_meta($id, "ratings-effectiveness", true);
            if(($value===FALSE)||($value==='')) $value= 0; ?>
                                <div class="small-14 medium-11 columns criterion">
                                    Effectiveness:
                                </div>
                                <?php $thisRating= get_post_meta($post->ID, $id.'-ratings-effectiveness', TRUE);
                                if($thisRating==='') {
                                    $thisRating= get_post_meta($id, 'ratings-effectiveness', TRUE);
                                    if($thisRating==='') $thisRating= 0;
                                }
                                $thisRating= number_format(floatval($thisRating), 1); ?>
                                <div class="medium-9 small-10 columns star-col">
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
                                    <div class="ratings" style="width:<?php echo $thisRating;?>%"></div>
                                </div>
                                <div class="small-6 medium-4 columns out-of show-for-medium">
                                    <?php echo $thisRating."/".$num; ?>
                                </div>
                            </div><!--/ criterion-row row -->
                            <div class="criterion-row row">
            <?php $value= get_post_meta($id, "ratings-speed-of-results", true);
            if(($value===FALSE)||($value==='')) $value= 0; ?>
                                <div class="small-14 medium-11 columns criterion">
                                    Speed of Results:
                                </div>
                                <?php $thisRating= get_post_meta($post->ID, $id.'-ratings-speed-of-results', TRUE);
                                if($thisRating==='') {
                                    $thisRating= get_post_meta($id, 'ratings-speed-of-results', TRUE);
                                    if($thisRating==='') $thisRating= 0;
                                }
                                $thisRating= number_format(floatval($thisRating), 1); ?>
                                <div class="medium-9 small-10 columns star-col">
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
                                <div class="small-6 medium-4 columns out-of show-for-medium">
                                    <?php echo $thisRating."/".$num; ?>
                                </div>
                            </div><!--/ criterion-row row -->
                            <div class="criterion-row row">
            <?php $value= get_post_meta($id, "ratings-product-safety", true);
            if(($value===FALSE)||($value==='')) $value= 0; ?>
                                <div class="small-14 medium-11 columns criterion">
                                    Product Safety:
                                </div>
                                <?php $thisRating= get_post_meta($post->ID, $id.'-ratings-product-safety', TRUE);
                                if($thisRating==='') {
                                    $thisRating= get_post_meta($id, 'ratings-product-safety', TRUE);
                                    if($thisRating==='') $thisRating= 0;
                                }
                                $thisRating= number_format(floatval($thisRating), 1); ?>
                                <div class="medium-9 small-10 columns star-col">
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
                                <div class="small-6 medium-4 columns out-of show-for-medium">
                                    <?php echo $thisRating."/".$num; ?>
                                </div>
                            </div><!--/ criterion-row row -->
                            <div class="criterion-row row">
            <?php $value= get_post_meta($id, "ratings-ingredient-quality", true);
            if(($value===FALSE)||($value==='')) $value= 0; ?>
                                <div class="small-14 medium-11 columns criterion">
                                    Ingredients:
                                </div>
                                <?php $thisRating= get_post_meta($post->ID, $id.'-ratings-ingredient-quality', TRUE);
                                if($thisRating==='') {
                                    $thisRating= get_post_meta($id, 'ratings-ingredient-quality', TRUE);
                                    if($thisRating==='') $thisRating= 0;
                                }
                                $thisRating= number_format(floatval($thisRating), 1); ?>
                                <div class="medium-9 small-10 columns star-col">
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
                                <div class="small-6 medium-4 columns out-of show-for-medium">
                                    <?php echo $thisRating."/".$num; ?>
                                </div>
                            </div><!--/ criterion-row row -->
                            <div class="criterion-row row">
            <?php $value= get_post_meta($id, "ratings-long-term-results", true);
            if(($value===FALSE)||($value==='')) $value= 0; ?>
                                <div class="small-14 medium-11 columns criterion">
                                    Long-Term Results:
                                </div>
                                <?php $thisRating= get_post_meta($post->ID, $id.'-ratings-long-term-results', TRUE);
                                if($thisRating==='') {
                                    $thisRating= get_post_meta($id, 'ratings-long-term-results', TRUE);
                                    if($thisRating==='') $thisRating= 0;
                                }
                                $thisRating= number_format(floatval($thisRating), 1); ?>
                                <div class="medium-9 small-10 columns star-col">
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
                                <div class="small-6 medium-4 columns out-of show-for-medium">
                                    <?php echo $thisRating."/".$num; ?>
                                </div>
                            </div><!--/ criterion-row row -->
                            <div class="criterion-row row">
            <?php $cf_value= get_post_meta($id);
            $showCustom= (isset($cf_value['cf_custom_banner']))&&($cf_value['cf_custom_banner'][0]==='yes');
            if($showCustom) $value= get_post_meta($id, "cf_retail_price", true);
            else $value= get_post_meta($id, "retail_c1", true);
            if(($value===FALSE)||($value==='')) $value= 0; ?>
                                <div class="small-14 medium-10 columns criterion">
                                    MSRP:
                                </div>
                                <div class="small-10 medium-14 columns">
                                    <?php echo "$".number_format($value, 2); ?>
                                </div>
                            </div>
                            <div class="criterion-row row">
                                <div class="small-14 medium-10 columns criterion">
                                    Our Price:
                                </div>
                                <div class="small-10 medium-14 columns">
            <?php if($showCustom) $price= get_post_meta($id, "cf_store_price_one", true);
            else {
                $pricing = array();
                $qty= get_post_meta($id, "qty_c1", true);
                if(($qty===FALSE)||($qty==='')) $qty= 1;
                $p1 = (get_post_meta($id, "price_c1", true)/$qty);
                $qty= get_post_meta($id, "qty_c2", true);
                if(($qty===FALSE)||($qty==='')) $qty= 1;
                $p2 = (get_post_meta($id, "price_c2", true)/$qty);
                $qty= get_post_meta($id, "qty_c3", true);
                if(($qty===FALSE)||($qty==='')) $qty= 1;
                $p3 = (get_post_meta($id, "price_c3", true)/$qty);
                if ($p3 == 0) {
                    array_push($pricing, $p1, $p2);
                } else {
                   array_push($pricing, $p1, $p2, $p3); 
                }
                $low = min($pricing);
                $high = max($pricing);
                $epsilon = 0.00001;
                if ($low == 0) {
                    $price = number_format($high, 2);
                }
                else {
                  $price= number_format($low, 2);
                if(abs($low-$high)>=$epsilon) $price.= '-'.number_format($high, 2);  
                }
                
            } ?>
                                    <a href="<?php echo get_the_permalink($id);?>">$<?php echo $price;?></a>
                                </div>
                            </div>
                            <div class="criterion-row row">
                                <div class="small-14 medium-10 columns criterion">
                                    Guarantee:
                                </div>
                                <div class="small-10 medium-14 columns">
                                    <?php echo get_post_meta($id, "ratings-guarantee", true); ?>
                                </div>
                            </div><!-- / .criterion-row -->
                            <?php
                                $officialSite = get_post_meta( $id, "ratings-official-site", true );
                                if ($officialSite !== "") { ?>
                            <div class="criterion-row row">
                                <div class="small-14 medium-10 columns criterion">
                                    Official Site:
                                </div>
                                <div class="small-10 medium-14 columns">
                                   <a href="http://www.<?php echo strtolower($officialSite); ?>/"><?php echo ucfirst($officialSite); ?></a>
                                </div>
                            </div><!-- / .criterion-row -->
                            <?php } ?>
                        </div> <!--/small-12 columns table -->
                    </div><!-- / .row -->
                </div><!--/small-8 medium-7 columns table-->
                <div class="small-24 medium-10 small-columns upsell-content">
            <?php if (strlen(get_post_meta($id, $id . "_custom_content", true)) > 0) {
                $sc_id= $id;
                echo do_shortcode("<p>".get_post_meta($id, $id."_custom_content", true)." [a]Read more...[/a]</p>");
            } else {
                $sc_id= $id;
                echo do_shortcode("<p>".get_post_meta($id, 'review-blurb', true)." [a]Read more...[/a]</p>");
            } ?>
                <p>*Individual results may vary</p>
                    <div class="row collapse">
                        <div class="small-12 columns">
                            <a href="<?php echo get_permalink($id);?>" class="tiny button secondary radius"><?php echo $readMore;?></a>
                        </div><!--/.small-6 columns-->
                        <div class="small-12 columns">
                            <a href="<?php echo get_permalink($id) ?>/#buytable" class="tiny button success radius">
            <?php echo $seePricing; ?>
                            </a>
                        </div><!--/.columns-->
                    </div><!--/.row collapse-->
                </div><!--/small-12 medium-5 columns-->
            </div><!--/.row collapse -->
        </div><!--/small-12 columns top-product-->
            <?php $i++;
        endforeach;
    endif; //end if is page and ids count ?>
    </div><!--/.row collapse-->
</div><!--/.row upsell collapse top-rated-list -->
<?php } // end top_products_cb
