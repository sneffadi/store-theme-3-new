
$(window).load(function() {
    if ($("#buytable .buy-image")) {
        var heights = [];
        $('#buytable .buy-image').each(function() {
            $this = $(this);
            var $height = $this.height();
            heights.push($height);
        });
        var maxHeight = Math.max.apply(Math, heights);
        $('#buytable .buy-image').height(maxHeight);
    }

    var cartCount= $.trim($('#cart-count').text()).split(' ');
    cartCount= cartCount[0];
    if((cartCount!='No')&&(cartCount!=0)) {
        $('#cartCount').html(parseInt(cartCount));
        $('#cartCountWrap').show();
    }
});

$(document).ready(function() {
    /* Toggle the custom data visibility */
    $('.addProductForm').on('change', '.quantity', function() {
        var prodCount= $(this).val();
        /* Update retail pricing */
        var retail= $('.addProductForm').find('.retail');
        var amt= retail.attr('data-value')*prodCount;
        var savings= amt;
        amt= amt.toFixed(2);
        $('.addProductForm').find('.retail').children('span').html(amt);
        /* Update store pricing */
        var store= $('.addProductForm').find('.price');
        amt= store.attr('data-value')*prodCount;
        savings= savings - amt;
        amt= amt.toFixed(2);
        $('.addProductForm').find('.price').children('span').html(amt);
        /* Update savings */
        savings= savings.toFixed(2);
        $('.addProductForm').find('.savings').children('span').html(savings);
        /* Toggle free shipping banner */
        if(prodCount>1) $('.free-shipping').hide();
        else $('.free-shipping').show();
    });
    
});

$(document).ready(function() {
    var dd = $(".dropdown");
    var defaultText = dd.find(":selected").text();
    dd.find("span").text(defaultText);
    dd.find("select").on("change", function() {
        var selected = $(".dropdown").find(":selected");
        var selectionText = selected.text();
        var selectionVal = selected.val();
        var selectionSavings = selected.attr("data-savings");
        var selectedIndex = jQuery(this).prop("selectedIndex");
        $(this).closest(".dropdown").find("span").text(selectionText);
        $(this).closest("form").find("input[type='hidden']").val(selectionVal);
        $(this).closest("form").find(".option-savings").text(selectionSavings);
        $(".dd-buy").hide();
        $(".dd-buy").eq(selectedIndex).fadeIn();
    });
    dd.next().on('click', function() {
      var pname = $(this).closest("form").find("option:selected").text();
          pname = $.trim(pname);
      ga('send', {
        hitType: 'event',
        eventCategory: 'Click',
        eventAction: 'Add to Cart',
        eventLabel: pname
      });
    });
});

/* Out of stock for buytable */
! function(e) {
    e(function() {
        "use strict";
        if (e("body").hasClass('out-of-stock')) {
            e("#buytable").find(".button").addClass('gray').text("Out of Stock");
            jQuery('#content').on('click', 'a.add-to-cart', function() {
              event.preventDefault();
              alert('Out of Stock');
            });
        }
    });
}(jQuery, this);
/* Out of stock for Custom Banner */
! function(e) {
    e(function() {
        "use strict";
        if (e("body").hasClass('out-of-stock')) {
            e(".custom-product-banner").find(".button").addClass('gray').text("Out of Stock");
            jQuery('button').click(function(event) { 
              event.preventDefault(); 
              alert('Out of Stock');
            });
        }
    })
}(jQuery, this);
/*<![CDATA[*/
window.olark||(function(c){var f=window,d=document,l=f.location.protocol=="https:"?"https:":"http:",z=c.name,r="load";var nt=function(){
f[z]=function(){
(a.s=a.s||[]).push(arguments)};var a=f[z]._={
},q=c.methods.length;while(q--){(function(n){f[z][n]=function(){
f[z]("call",n,arguments)}})(c.methods[q])}a.l=c.loader;a.i=nt;a.p={
0:+new Date};a.P=function(u){
a.p[u]=new Date-a.p[0]};function s(){
a.P(r);f[z](r)}f.addEventListener?f.addEventListener(r,s,false):f.attachEvent("on"+r,s);var ld=function(){function p(hd){
hd="head";return["<",hd,"></",hd,"><",i,' onl' + 'oad="var d=',g,";d.getElementsByTagName('head')[0].",j,"(d.",h,"('script')).",k,"='",l,"//",a.l,"'",'"',"></",i,">"].join("")}var i="body",m=d[i];if(!m){
return setTimeout(ld,100)}a.P(1);var j="appendChild",h="createElement",k="src",n=d[h]("div"),v=n[j](d[h](z)),b=d[h]("iframe"),g="document",e="domain",o;n.style.display="none";m.insertBefore(n,m.firstChild).id=z;b.frameBorder="0";b.id=z+"-loader";if(/MSIE[ ]+6/.test(navigator.userAgent)){
b.src="javascript:false"}b.allowTransparency="true";v[j](b);try{
b.contentWindow[g].open()}catch(w){
c[e]=d[e];o="javascript:var d="+g+".open();d.domain='"+d.domain+"';";b[k]=o+"void(0);"}try{
var t=b.contentWindow[g];t.write(p());t.close()}catch(x){
b[k]=o+'d.write("'+p().replace(/"/g,String.fromCharCode(92)+'"')+'");d.close();'}a.P(2)};ld()};nt()})({
loader: "static.olark.com/jsclient/loader0.js",name:"olark",methods:["configure","extend","declare","identify"]});
olark.configure('box.corner_position', 'BL');
olark.identify('8146-171-10-5400');
/*]]>*/

