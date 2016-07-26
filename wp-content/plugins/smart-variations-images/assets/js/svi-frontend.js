if (!WOOSVI) {
    var WOOSVI = {};
} else {
    if (WOOSVI && typeof WOOSVI !== "object") {
        throw new Error("WOOSVI is not an Object type");
    }
}
WOOSVI.isLoaded = false;
WOOSVI.STARTS = function ($) {
    var $form = $('.variations_form');
    var $product_variations = $form.data('product_variations');
    var $woosvi_strap = $("div#woosvi_strap");
    var $variations = [];
    var $woosvi_lightbox = $woosvi_strap.hasClass('woosvi_lightbox');
    var $woosvi_lens = $woosvi_strap.hasClass('woosvi_lens');
    var $svihide_thumbs = $woosvi_strap.hasClass('svihide_thumbs');
    var $svi_type = true;
    return{NAME: "Application initialize module", VERSION: 3.4, init: function () {
            this.loadInits();
        },
        loadInits: function () {
            WOOSVI.STARTS.initImages();
        },
        runInits: function () {
            if ($form.find('.variations select').length > 0) {
                WOOSVI.STARTS.getVariations(); //Carrega todas as variações
                WOOSVI.STARTS.variationLoad();
                WOOSVI.STARTS.variationChange();
                WOOSVI.STARTS.variationReset();
            } else {
                $('div.svithumbnails,a.woocommerce-main-image').fadeIn();
            }

            if ($woosvi_lightbox)
                WOOSVI.STARTS.prettyPhoto();

            if ($woosvi_lens)
                WOOSVI.STARTS.LoadLens();

        },
        preventDefault: function () {
            $('div#woosvi_strap a').click(function (e) {
                e.preventDefault();
            });
            $("div.product a").unbind('click.prettyphoto');
        },
        /*DEFAULT HANDLER*/
        initImages: function () {
            if ($form.find('.variations select').length <= 0) {
                $svi_type = false;
            }
            $('#woosvi_strap').fadeIn();
            if ($svihide_thumbs && $svi_type)
                $('a.woocommerce-main-image').hide().removeClass('hidden');
            else
                $('div.svithumbnails,a.woocommerce-main-image').hide().removeClass('hidden');

            $('div.svithumbnails a').click(function () {
                WOOSVI.STARTS.initSwap(this);
            });
            //setTimeout(function () {
            WOOSVI.STARTS.runInits();
            WOOSVI.STARTS.preventDefault();
            //}, 200);
        },
        initRebuild: function ($variation) {
            var $columns, $classes, $variations_choosen, $clonemain, $size;
            $columns = $('div.svithumbnails').data('columns');
            $size = $('div.svithumbnails').find('img[data-woosvi="' + $variation + '"]').size() - 1;
            $variations_choosen = $('div.svithumbnails').find('img[data-woosvi="' + $variation + '"]').closest('a')

            $('div.svithumbnails').find('img').closest('a').show();
            $('div.svithumbnails').find('img').closest('a').attr('class', '');
            $('div.svithumbnails').find('img:not([data-woosvi="' + $variation + '"])').closest('a').hide();

            $variations_choosen.each(function ($loop, v) {
                $classes = [''];
                if ($loop === 0 || $loop % $columns === 0) {
                    $classes.push('first');
                }
                if (($loop + 1) % $columns === 0) {
                    $classes.push('last');
                }
                if ($loop === $size)
                    $classes.push('last');


                $(v).attr('class', $classes.join(' '));
                if ($loop == 0) {
                    WOOSVI.STARTS.initSwap(v);
                }
            });
            WOOSVI.STARTS.preventDefault();

        },
        initSwap: function (v, action) {
            var $clonemain = $(v).clone();
            var image = new Image();
            image.src = $clonemain.find('img').attr("src");
            $(image).on("load", function () {
                $clonemain.attr('class', 'woocommerce-main-image sviZoom');
                $('div#woosvimain').empty();
                $('div#woosvimain').prepend($clonemain);
                WOOSVI.STARTS.preventDefault();
                if ($woosvi_lightbox)
                    WOOSVI.STARTS.prettyPhoto();
                if ($woosvi_lens)
                    WOOSVI.STARTS.imgGalreset();
                if ($svihide_thumbs && $svi_type) {
                    if (action !== 'initReset')
                        $('div.svithumbnails').hide().removeClass('hidden');
                    else
                        $('div.svithumbnails').hide().addClass('hidden');
                }
                $('div.svithumbnails,a.woocommerce-main-image').fadeIn();
            });
        },
        initReset: function () {
            var $columns, $classes, $variations_choosen;
            $columns = $('div.svithumbnails').data('columns');
            $variations_choosen = $('div.svithumbnails').find('img').closest('a')

            $('div.svithumbnails').find('img').closest('a').show();
            $('div.svithumbnails').find('img').closest('a').attr('class', '');
            $variations_choosen.each(function ($loop, v) {

                $classes = ['zoom'];
                if ($loop === 0 || $loop % $columns === 0) {
                    $classes.push('first');
                }
                if (($loop + 1) % $columns === 0) {
                    $classes.push('last');
                }

                $(v).attr('class', $classes.join(' '));
                if ($loop == 0) {
                    WOOSVI.STARTS.initSwap(v, 'initReset');
                }
            });

            WOOSVI.STARTS.preventDefault();

            if ($woosvi_lightbox)
                WOOSVI.STARTS.prettyPhoto();
            if ($woosvi_lens)
                WOOSVI.STARTS.imgGalreset();

        },
        /*END DEFAULT HANDLER*/
        /*PRETTY PHOTO*/
        prettyPhoto: function () {

            if (!$woosvi_lightbox) {
                WOOSVI.STARTS.preventDefault();
                $("div.product a").unbind('click.prettyphoto');
                return;
            }
            $("div.product a").unbind('click.prettyphoto');
            $('div#svi_mainslider a,div#woosvimain a').on('click', function (e) {
                e.preventDefault();
                var click_url = $(this).attr('href');
                var click_title = $(this).attr('title');
                var api_images = [];
                var api_titles = [];
                $('div#svi_mainslider a,div.svithumbnails a:visible').each(function () {
                    var href = $(this).attr('href');

                    if (href === "") {
                        href = $(this).data('o_href');
                    }

                    api_images.push(href);
                    api_titles.push($(this).attr('title'));
                });

                if ($.isEmptyObject(api_images)) {
                    api_images.push(click_url);
                    api_titles.push(click_title);
                }

                $.prettyPhoto.open(api_images, api_titles);
                $('div.pp_gallery').find('img[src="' + click_url + '"]').parent().trigger('click');
            });
        },
        /*END PRETTY PHOTO*/
        /*LOAD LENS*/
        LoadLens: function () {
            $("div.sviZoomContainer").remove();
            var ez, lensdata, lensoptions;
            ez = $("div#woosvi_strap div#svi_mainslider .swiper-slide.swiper-slide-active img,div#woosvimain img");
            lensdata = $("div#woosvi_strap").data();
            lensoptions = {
                sviZoomType: 'lens',
                lensShape: 'round',
                lensSize: 150
            };

            ez.ezPlus(lensoptions);
        },
        imgGalreset: function () {
            $("div.sviZoomContainer").remove();
            WOOSVI.STARTS.LoadLens();
        },
        /*END LOAD LENS*/
        /*VARIATIONS HANDLER*/
        getVariations: function () {
            $.each($product_variations, function (i, v) {
                $variations.push(v.attributes.attribute_pa_color);
            });
        },
        variationLoad: function () {
            var varexist = false;
            $.each($form.find('.variations select'), function (ic, vc) {

                var $variation = $(this).val().replace(/ /g, '').toLowerCase();

                if ($variation) {

                    varexist = $('div.svithumbnails').find('img[data-woosvi="' + $variation + '"]').length;

                    if (varexist === 0)
                        return;

                    WOOSVI.STARTS.initRebuild($variation);

                }
            });
            if (!varexist)
                $('div.svithumbnails,a.woocommerce-main-image').fadeIn();
        },
        variationChange: function () {
            var varexist, varexist_vis, varexist_total;

            $form.on('found_variation', function (event, variation) {

                $.each(variation.attributes, function (i, v) {

                    var $variation = v.replace(/ /g, '').toLowerCase();
                    if ($variation === '') {
                        WOOSVI.STARTS.variationLoad();
                        return false;
                    } else {
                        varexist = $('div.svithumbnails').find('img[data-woosvi="' + $variation + '"]').length;
                        varexist_vis = $('div.svithumbnails').find('img[data-woosvi="' + $variation + '"]').closest('a:visible').length;
                        varexist_total = $('div.svithumbnails').find('img').closest('a:visible').length;


                        if (varexist === 0)
                            return;

                        if (varexist_vis === varexist && varexist_vis === varexist_total)
                            return;

                        WOOSVI.STARTS.initRebuild($variation);
                    }
                });
            });
        },
        variationReset: function () {
            $form.on('click', '.reset_variations', function (event) {

                WOOSVI.STARTS.initReset();

            });
        },
        /*END VARIATIONS HANDLER*/
    }
}(jQuery.noConflict());
jQuery(document).ready(function () {
    WOOSVI.STARTS.init();
});

