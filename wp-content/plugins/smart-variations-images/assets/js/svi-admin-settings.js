if (!WOOSVIADM) {
    var WOOSVIADM = {}
} else {
    if (WOOSVIADM && typeof WOOSVIADM !== "object") {
        throw new Error("WOOSVIADM is not an Object type")
    }
}
WOOSVIADM.isLoaded = false;
WOOSVIADM.STARTS = function ($) {
    return{NAME: "Application initialize module", VERSION: 1.0, init: function () {
            if (!$('body').hasClass('post-type-product')) {
                this.loadInits();
                this.ajaxOptions();
            }
            if ($('body').hasClass('post-type-product'))
                this.sviVideo();
        }, loadInits: function () {
            $("form#woosvi_options div.form-group.hidden,form#woosvi_options div.form-subgroup.hidden").hide().removeClass('hidden');

            if (!$('.input-default').is(':checked')) {
                $('input').not('.input-default').closest('div.form-group').slideDown();
            }

            $('.woosvi_input').checkboxpicker({
                html: true,
                offLabel: '<span class="glyphicon glyphicon-remove">',
                onLabel: '<span class="glyphicon glyphicon-ok">'
            });

            $('.input-default').change(function () {

                $('input').not('.input-default').closest('div.form-group').slideToggle();

            });

        },
        ajaxOptions: function () {
            $('form#woosvi_options').find('.fa-refresh').hide().removeClass('hidden');
            $("form#woosvi_options").submit(function (event) {
                event.preventDefault();
                $('form#woosvi_options').find('.fa-refresh').fadeIn();
                $('span.submittext').fadeIn().html('Saving...').fadeOut();

                if ($('.input-default').is(':checked')) {
                    $('.woosvi_input').not('.input-default').prop('checked', false);
                }

                jQuery.ajax({
                    url: ajaxurl,
                    type: 'post',
                    dataType: 'json',
                    data: {
                        action: 'woosvi_options',
                        data: $('form#woosvi_options').serialize()
                    },
                    success: function (response) {

                        $('form#woosvi_options').find('.fa-refresh').fadeOut();
                        $('span.submittext').fadeIn().html('Saved').fadeOut(function () {
                            $(this).fadeOut().html('Submit').fadeIn();
                        })
                    }
                });
            })
        },
        sviVideo: function () {
            WOOSVIADM.STARTS.removesviVideo();
            $('button#addvidsvi').click(function (e) {
                e.preventDefault();
                var size = $("table#svividtable tr").size();
                $("div.sviclone table tr").clone().clone().appendTo("table#svividtable");
                var last = $("table#svividtable tr:last");
                var current = $("table#svividtable tr").length - 1;
                last.find('input').attr("name", "svi_videos[" + current + "][url]");
                last.find('select').attr("name", "svi_videos[" + current + "][woosvi-slug]");
                WOOSVIADM.STARTS.removesviVideo();
            });

        },
        removesviVideo: function () {

            $('a.removevidsvi').click(function (e) {
                e.preventDefault();

                $(this).closest('tr').slideUp().remove();

                $("table#svividtable tr").each(function (i, v) {
                    $(this).find('input').attr("name", "svi_videos[" + i + "][url]");
                    $(this).find('select').attr("name", "svi_videos[" + i + "][woosvi-slug]");
                })

            });
        }
    }
}(jQuery);
jQuery(document).ready(function () {
    WOOSVIADM.STARTS.init();
});