jQuery(document).ready(function ($) {
    var upload_area = $('.upload_area');
    if (upload_area.length) {
        // Copy URL from media uploader
        var custom_uploader;
        upload_area.on('click', '.file_url_link, .no_image', (function (e) {

            var button_click = $(this);

            if ($(button_click).attr('readonly')) {
                return false;
            }

            e.preventDefault();

            custom_uploader = wp.media.frames.file_frame = wp.media({
                title: 'Choose Banner',
                button: {
                    text: 'Choose Banner'
                },
                multiple: true
            });

            //When a file is selected, grab the URL and set it as the text field's value
            custom_uploader.on('select', function () {
                attachment = custom_uploader.state().get('selection').first().toJSON();
                button_click.closest('.upload_area .single_upload').find('.file_url_link').val(attachment.url);
                button_click.closest('.upload_area .single_upload').find('.file_description').val(attachment.title);
                button_click.closest('.upload_area .single_upload').find('.width').val(attachment.width);
                button_click.closest('.upload_area .single_upload').find('.height').val(attachment.height);
                button_click.closest('.upload_area .single_upload').find('.no_image').html("<img width=130 height=130 src=" + attachment.url + ">");

            });
            //Open the uploader dialog
            custom_uploader.open();

        }));

        $('.add_new_upload, .add_new_script').on('click', function (e) {
            var content_;

            if ($(this).data('item') == 'add_new_upload') {
                content_ = content_fn_upload(vardata.category);
            }
            else if ($(this).data('item') == 'add_new_script') {
                content_ = content_fn_script(vardata.category);
            }
            else {
                content_ = content_fn_upload(vardata.category);
            }

            var flag = 'no';

            $('.upload_area .file_url_link').each(function () {
                if ($(this).val().length == 0) {
                    flag = 'yes';
                }
            });

            // Restrict to add multiple with out filling the previously added form
            if (flag == 'yes') {
                bc_rb_alert('There is already an empty field, Please fill that', 'warning');
                flag = 'no';
                return false;
            }

            // Restrict to add new form with out saving the previously added form
            if ($('.upload_area .bc_rb_button_save').length != 0) {
                bc_rb_alert('Please save previously added banner', 'warning');
                return false;
            }
            //console.log(moment().format('YYYYMMDD'));
            var single_upload = $('.single_upload');
            var display_name;
            if ((single_upload.length >= 10)) {
                display_name = $(this).closest('.bc_random_banner').data('display_name');
                paypal_donation_popup_no_skip(display_name.toUpperCase());
                $('.bc_rb_amount input[checked]').trigger('click');
                return false;
            }
            if ((single_upload.length >= 10) && ((upload_area.data('payment_info') == 'no') || (upload_area.data('payment_info') < moment().format('YYYYMMDD')))) {
                // Check for more than five to show donation popup
                display_name = $(this).closest('.bc_random_banner').data('display_name');
                paypal_donation_popup(display_name.toUpperCase());
                //$('.sweet-alert select').trigger('change');
                $('.bc_rb_amount input[checked]').trigger('click');
                return false;
            }
            // console.log(single_upload.length);

            if (upload_area.find('.single_upload')) {
                upload_area.prepend(content_);
            } else {
                upload_area.append().html(content_);
            }
            e.preventDefault();

        });

        // Edit to change text
        upload_area.on('click', '.bc_rb_button_edit', function (e) {
            var btn = $(this);
            var closest = btn.closest('form');
            if ($('.upload_area .bc_rb_button_save').length != 0) {
                bc_rb_alert('Please save previously added banner', 'warning');
                return false;
            }
            if ($(closest).has('textarea').length) {
                swal({
                    title: "Are you sure?",
                    text: "This action will clear the previous code in Textarea",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, I have a new code",
                    closeOnConfirm: true
                }, function () {
                    closest.find('.file_url_link_textarea').text('').removeAttr('readonly');
                    closest.find('.file_description').removeAttr('readonly');
                    closest.find('.bc_rb_button_edit').text('Save');
                    closest.find('.category').removeAttr('disabled');
                    closest.find('.bc_rb_button_edit').addClass('bc_rb_button_save').removeClass('bc_rb_button_edit');
                });
            } else {
                closest.find('.bc_rb_button_edit').text('Save');
                closest.find('input[type=text]').removeAttr('readonly');
                closest.find('.no_image').removeAttr('readonly');
                closest.find('.bc_rb_button_edit').addClass('bc_rb_button_save').removeClass('bc_rb_button_edit');
                closest.find('.category').removeAttr('disabled');
            }

            e.preventDefault();
        });

        // Send AJAX request to save
        upload_area.on('click', '.bc_rb_button_save', function (e) {
            var btn = $(this);
            var closest = btn.closest('.single_upload form');
            var url = upload_area.data('url');

            if (closest.find('textarea[name=file_url_link]').val() == '') {
                swal('Script Field Missing', 'Please add Script to save the banner', 'warning');
                return false;
            }
            if (closest.find('input[name=file_url_link]').val() == '') {
                swal('Upload Image Missing', 'Please add image to save the banner', 'warning');
                return false;
            }
            $('.spinner_circle').removeClass('hide');
            $('#preview-area').css('z-index', '9999');
            $.ajax({
                type: 'POST',
                url: url,
                data: closest.serialize(),
                success: function (result) {
                    $('.spinner_circle').addClass('hide');
                    $('#preview-area').css('z-index', '0');
                    var results = JSON.parse(result);
                    if (results.error) {
                        bc_rb_alert(results.error, results.type);
                    } else {
                        upload_area.html(results.content);
                        bc_rb_alert(results.message, results.type);
                        $('select.category_filter').trigger('change');
                    }
                },
                error: function (results) {
                    console.log('no' + results);
                }

            });

            e.preventDefault();
        });

        // Delete Locally
        upload_area.on('click', '.bc_rb_button_delete', function (e) {
            var btn = $(this);
            btn.closest('.single_upload').remove();
            e.preventDefault();
        });

        // Delete in DB
        upload_area.on('click', '.bc_rb_button_delete_by_id', function (e) {
            var btn = $(this);
            var closest = btn.closest('.single_upload form');
            var url = upload_area.data('delete');
            swal({
                title: "Are you sure?",
                text: "You want to delete this Banner?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes Delete it",
                closeOnConfirm: false
            }, function () {
                $('.spinner_circle').removeClass('hide');
                $('#preview-area').css('z-index', '9999');
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: closest.serialize(),
                    success: function (result) {
                        $('.spinner_circle').addClass('hide');
                        $('#preview-area').css('z-index', '0');
                        var results = JSON.parse(result);
                        if (results.error) {
                            bc_rb_alert(results.error, results.type);
                        } else {
                            bc_rb_alert(results.message, results.type);
                            btn.closest('.single_upload').remove();
                        }
                    },
                    error: function (results) {
                        console.log('no' + results);
                    }
                });
            });


            e.preventDefault();
        });

    }

    // PayPal Donation Button Click
    $('body').on('click', '.sweet-alert .donate_now', function () {
        $('body .spinner_circle').removeClass('hide');
        $('#preview-area').css('z-index', '9999');
    });


    //Remind Me Later Button Click
    $('body').on('click', '.donate_later', function (e) {
        location.reload(true);
    });

    // Popup on PayPal Button Click
    //   if ($('.bc_random_banner').length) {
    $('body').on('click', '.paypal_donation_button', function (e) {
        //var display_name = $(this).closest('.bc_random_banner').data('display_name');
        paypal_donation_popup(vardata.display_name);
        e.preventDefault();
    });
    // }

    // Setting Options save
    if ($('.bc_rb_option_save, .bc_rb_popup_save').length) {
        $('.bc_random_banner').on('click', '.bc_rb_option_save, .bc_rb_popup_save', function (e) {
            var option = $(this).closest('form');
            var data = option.serialize();
            var url = option.data('save');
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                success: function (results) {
                    if (results == 'ok') {
                        bc_rb_alert('Options saved Successfully', 'success');
                    } else {
                        bc_rb_alert('Something went wrong, kindly reload the page and try', 'error');
                    }
                }

            });
            e.preventDefault();
        });
    }

    // Edit Campaign
    $('.bc_random_banner_campaign').on('click', '.bc_rb_campaign_edit', function (e) {
        var click = $(this);
        var closest = click.closest('.campaign_data');

        if ($('.bc_random_banner_campaign .bc_rb_campaign_save').length != 0) {
            bc_rb_alert('Please save previously added Campaign', 'warning');
            return false;
        }

        closest.find('input').removeAttr('readonly');
        closest.find('select').removeAttr('disabled');

        click.addClass('paypal_donation_button').removeClass('bc_rb_campaign_edit').text('Save');

        e.preventDefault();
    });

    // On Change Ads Type
    $('.bc_random_banner_campaign').on('change', '.ads_type', function () {
        var change = $(this);
        var closest = change.closest('.campaign_data');

        if (change.val() == 'Cost Per Click') {
            closest.find('.ads_click').removeClass('hide');
            closest.find('.ads_impression').addClass('hide');
        }
        if (change.val() == 'Cost Per Impression') {
            closest.find('.ads_click').addClass('hide');
            closest.find('.ads_impression').removeClass('hide');
        }

    });

    if ($('.bc_filters').hasClass('hide')) {
        $('.bc_filters').removeClass('hide')
    }
    $('select.category_filter').on('change', function () {
        var select = $(this);
        var parent = select.closest('.bc_random_banner').find('.upload_area');
        if (select.val() == 'bc__all') {
            $(parent).find('.single_upload').removeClass('hide');
        } else {
            $(parent).find('.single_upload.' + select.val()).removeClass('hide');
            $(parent).find('.single_upload').not('.' + select.val()).addClass('hide');
        }
    });

    $('.bc_plugin_demo').on('click', function (e) {
        // console.log($(this).data('email'));
        $.ajax({
            type: 'post',
            url: 'https://buffercode.com/api/plugin/demo/random-banner-pro/',
            data: { 'email': vardata.contact_email, 'domain': window.location.host, 'plugin_name': 'random-banner-pro', 'type': 'demo' },
            success: function (result) {
                // console.log(result);
            }
        });
    });
    //slug generator
    var b = $('.bc_rb');
    b.on('keyup', '.slug_generator', function (e) {
        var value, original_value;
        value = original_value = $(this).val();
        if (e.keyCode !== 9 && e.keyCode !== 37 && e.keyCode !== 38 && e.keyCode !== 39 && e.keyCode !== 40) {
            value = value.replace(/ /g, "_");
            value = value.toLowerCase();
            value = replaceDiacritics(value);
            value = transliterate(value);
            value = replaceSpecialCharacters(value);
            if (value !== original_value) {
                $(this).attr('value', value);
            }
        }
    });
});

// Category
jQuery(document).ready(function ($) {
    var upload_area = $('.upload_area');
    // Adding New Category
    $('.category').on('click', '.new_category', function (e) {
        var content = content_category();
        var flag = 'no';
        $('.category_items .category_input').each(function () {
            if ($(this).val().length == 0) {
                flag = 'yes';
            }
        });

        // Restrict to add multiple with out filling the previously added form
        if (flag == 'yes') {
            bc_rb_alert('There is already an empty category field, Please fill that', 'warning');
            flag = 'no';
            return false;
        }

        // Restrict to add new form with out saving the previously added form
        if ($('.category_items .bc_rb_button_save').length != 0) {
            bc_rb_alert('Please save previously added banner', 'warning');
            return false;
        }

        if ($('.category_items').data('payment_info').toString().length < 13) {
            if ($('.single_category').length >= 3) {
                var display_name = $(this).closest('.category').data('display_name');
                paypal_donation_popup_no_skip(display_name.toUpperCase());
                $('.bc_rb_amount input[checked]').trigger('click');
                return false;
            }
        }

        if ($('.single_category').length >= 2 && ($('.category_items').data('payment_info') == 'no') || ($('.category_items').data('payment_info') < moment().format('YYYYMMDD'))) {
            // Check for more than five to show donation popup
            var display_name = $(this).closest('.category').data('display_name');
            paypal_donation_popup(display_name.toUpperCase());
            $('.bc_rb_amount input[checked]').trigger('click');
            return false;
        }

        if ($('.category_items').find('.single_category')) {
            $('.category_items').prepend(content);
        } else {
            $('.category_items').append().html(content);
        }
        e.preventDefault();
    });

    $('.category').on('click', '.bc_rb_button_save', function (e) {
        var option = $(this).closest('form');
        var data = option.serialize();
        var url = $('.category_items').data('save');
        $('body .spinner_circle').removeClass('hide');
        $('#preview-area').css('z-index', '9999');

        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function (results) {
                var result = JSON.parse(results);
                $('body .spinner_circle').addClass('hide');
                $('#preview-area').css('z-index', '0');
                bc_rb_alert(result.message, result.type);
                if (result.type == 'success') {
                    $('.category_items').append().html(result.content);
                }
            }

        });
        e.preventDefault();
    });

    $('.category').on('click', '.bc_rb_button_edit', function (e) {
        var btn = $(this).closest('form');
        if ($('.category_items .bc_rb_button_save').length != 0) {
            bc_rb_alert('Please save previously edited category', 'warning');
            return false;
        }

        btn.find('.category_input').removeAttr('readonly');
        btn.find('.bc_rb_button_edit').addClass('bc_rb_button_save');
        btn.find('.bc_rb_button_edit').text('save');
        btn.find('.bc_rb_button_edit').removeClass('bc_rb_button_edit');
        e.preventDefault();
    });

    $('.category').on('click', '.bc_rb_button_delete', function (e) {
        var btn = $(this);
        btn.closest('.single_category').remove();
        e.preventDefault();
    });

    $('.category').on('click', '.bc_rb_button_delete_by_id', function (e) {
        var btn = $(this);
        var closest = btn.closest('.single_category form');
        var url = $('.category_items').data('delete');

        swal({
            title: "Are you sure?",
            text: "You want to delete this Category? If so the category name associated with banner will be changed to default category",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes Delete it",
            closeOnConfirm: false
        }, function () {
            $('body .spinner_circle').removeClass('hide');
            $('#preview-area').css('z-index', '9999');
            $.ajax({
                type: 'POST',
                url: url,
                data: closest.serialize(),
                success: function (result) {
                    $('body .spinner_circle').addClass('hide');
                    $('#preview-area').css('z-index', '0');
                    var results = JSON.parse(result);
                    if (results.error) {
                        bc_rb_alert(results.error, results.type);
                    } else {
                        bc_rb_alert(results.message, results.type);
                        btn.closest('.single_category').remove();
                    }
                },
                error: function (results) {
                    console.log('no' + results);
                }
            });
        });


        e.preventDefault();
    });

    $('form#bc_delete_dbs').on('submit', function (e) {
        var btn = $(this);
        var url = btn.attr('action');

        swal({
            title: "Are you sure?",
            text: "You want to delete the Random Banner Tables and its option? You can recover it back!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes Delete it",
            closeOnConfirm: false
        }, function () {
            $('body .spinner_circle').removeClass('hide');
            $('#preview-area').css('z-index', '9999');
            $.ajax({
                type: 'POST',
                url: url,
                data: btn.serialize(),
                success: function (result) {
                    $('body .spinner_circle').addClass('hide');
                    $('#preview-area').css('z-index', '0');
                    var results = JSON.parse(result);
                    if (results.error) {
                        bc_rb_alert(results.error, results.type);
                    } else {
                        bc_rb_alert(results.message, results.type);
                    }
                },
                error: function (results) {
                    console.log('no' + results);
                }
            });
        });


        e.preventDefault();
    });

    // Validate PayPal Transaction
    $('.transaction_btn').on('click', function (e) {
        var btn = $(this);
        var data = btn.closest('form').serialize();
        var url = btn.closest('form').data('url');
        $('body .spinner_circle').removeClass('hide');
        $('#preview-area').css('z-index', '9999');
        $.ajax({
            type: 'get',
            data: data,
            url: url,
            success: function (result) {
                $('body .spinner_circle').addClass('hide');
                $('#preview-area').css('z-index', '0');
                var results = JSON.parse(result);
                if (results.status == 'ok') {
                    bc_rb_alert(results.message, results.type);
                    location.reload();
                } else {
                    bc_rb_alert(results.message, results.type);
                }
            }

        });

        e.preventDefault();
    })

    // Category and Setting pages
    if ($('.bc_rb_category_values_save').length) {
        $('.bc_rb_category_values_save').on('click', function (e) {
            $('.spinner_circle').removeClass('hide');
            var click = $(this);
            var closest = click.closest('form');
            var data = closest.serialize();
            var url = closest.data('save');
            $.ajax({
                type: 'post',
                data: data,
                url: url,
                success: function (results) {
                    var result = JSON.parse(results);
                    bc_rb_alert(result.message, result.type);
                    $('.spinner_circle').addClass('hide');
                }
            })
            e.preventDefault();
        });

        $('.bc_rb_enable_insert').on('change', function (e) {
            if ($(this).val() == 'false') {
                console.log($(this).val());
                $('.bc_rb_enable_insert_post_shortcode').addClass('hide');
            } else {
                console.log($(this).val());
                $('.bc_rb_enable_insert_post_shortcode').removeClass('hide');
            }
            e.preventDefault();
        });
    }
    $('.bc_rb_enable_insert').trigger('change');


});

function content_fn_upload(category) {
    var content = '<div class="row single_upload">' +
        '<form>' +
        '<div class="col-md-2">' +
        '<div class="col-md-12 padding_bottom_20">' +
        '<div class="no_image"><span class="glyphicon glyphicon-upload  btn-lg"></span> </div> </div> </div> <div class="col-md-8"> <div class="col-md-6"> <input type="hidden" name="banner_type" value="upload" /> <input type="text" name="file_url_link" class="form-control file_url_link" placeholder="Upload Image"/> </div> <div class="col-md-6"> <input type="text" name="file_description" class="form-control file_description" placeholder="File Description"/> </div> <div class="col-md-12 padding_top_10"> <input type="text" name="external_link" class="bc_rb_external_link form-control" placeholder="External Link" /> </div> <div class="col-md-3 padding_top_10"><div class="input-group"> <input type="number" name="width" class="form-control width" placeholder="Width in px"> <span class="input-group-addon" >px</span></div></div><div class="col-md-3 padding_top_10"><div class="input-group"> <input type="number" name="height" class="form-control height" placeholder="Height in px"> <span class="input-group-addon" >px</span></div></div><div class="col-md-3 padding_top_10"><div class="checkbox"> <label> <input checked type="checkbox" name="automatic" value="checked"  class="automatic"> Theme Based </label> </div></div> <div class="col-md-3 padding_top_10"> <div class="input-group"> <div class="dropdown"><select id="category" class="form-control category" name="category">' + category + '</select> </div> </div> </div></div> <div class="col-md-2"> <div class="col-md-12"> <button class="btn btn-primary bc_rb_button_save">Save</button> </div> <div class="col-md-12 padding_top_20"> <button class="btn btn-danger bc_rb_button_delete">Delete</button></div> </div></form></div>';

    return content;
}


function content_fn_script(category) {
    $content = '<div class="row single_upload">' +
        '<form>' +
        '<div class="col-md-6"> <input type="text" name="file_description" class="form-control file_description" placeholder="Title"/> </div>' +
        '<div class="col-md-6"> <div class="input-group"> <div class="dropdown"><select id="category" class="form-control category" name="category">' + category + '</select> </div> </div></div>' +
        '<div class="col-md-9 padding_top_10"><input type="hidden" name="banner_type" value="script" /><textarea name="file_url_link" class="file_url_link_textarea form-control" rows="5" placeholder="Please paste the code here"></textarea> </div>' +
        '<div class="col-md-3 padding_top_10"> <div class="col-md-12"> <button class="btn btn-primary bc_rb_button_save">Save</button> </div> <div class="col-md-12 padding_top_20"> <button class="btn btn-danger bc_rb_button_delete">Delete</button></div> </div></form></div>';

    return $content;
}


function content_category() {
    $content = '<div class="row single_category">' +
        '<form>' +
        '<div class="col-md-8">' +
        '<input type="text" name="category" class="category_input slug_generator form-control" />' +
        '</div>' +
        '<div class="col-md-4 category_button">' +
        '<button class="btn btn-primary bc_rb_button_save">Save</button>' +
        '<button class="btn btn-danger bc_rb_button_delete">Delete</button>' +
        '</div>' +
        '</form>' +
        '</div>';

    return $content;
}

function bc_rb_alert(message, type) {
    swal({
        title: message,
        type: type,
        closeOnConfirm: false
    });
}

function paypal_donation_popup(display_name) {
    swal({
        title: "",
        text: "<h2>Hi! " + (display_name) + " <br>Please Buy Pro Version</h2> <div class='bc_rb_donation_content'><b>to unlock all new features</b><br><br></div>" +
            "\t<div class=\"row bc_donation_container\">\n" +
            "    \t\t\t<div class=\"col-md-6\">\n" +
            "\t\t\t\t\n" +
            "\t\t\t\t\t<div class=\"panel price panel-red\">\n" +
            "\t\t\t\t\t\t<div class=\"panel-heading  text-center\">\n" +
            "\t\t\t\t\t\t<h3>Annual Plan</h3>\n" +
            "\t\t\t\t\t\t</div>\n" +
            "\t\t\t\t\t\t<div class=\"panel-body text-center\">\n" +
            "\t\t\t\t\t\t\t<p class=\"lead\" style=\"font-size:40px\"><strong>$39</strong></p>\n" +
            "\t\t\t\t\t\t</div>\n" +
            "\t\t\t\t\t\t<ul class=\"list-group list-group-flush text-center\">\n" +
            "\t\t\t\t\t\t\t<li class=\"list-group-item\"><i class=\"icon-ok text-danger\"></i>1 Year Update</li>\n" +
            "\t\t\t\t\t\t\t<li class=\"list-group-item\"><i class=\"icon-ok text-danger\"></i>1 Year Support</li>\n" +
            "\t\t\t\t\t\t</ul>\n" +
            "\t\t\t\t\t\t<div class=\"panel-footer\">\n" +
            "<form class='process_paypal_form' method='post' action='https://buffercode.com/payment/bc/payment_start'>" +
            "<input type='hidden' name='redirect_url' value=" + vardata.bc_redirect_url + " /> " +
            "<input type='hidden' name='domain' value=" + window.location.host + " /> " +
            "<input type='hidden' name='payment_info' value=" + vardata.payment_info + " /> " +
            "<input type='hidden' name='contact_email' value=" + vardata.contact_email + " /> " +
            "<input type='hidden' name='amount' value='39' /> " +
            "<input type='hidden' name='plugin_name' value='random-banner-pro' /> " +
            "<input type='hidden' name='plan_type' value='annual' /> " +
            "<button type='submit' name='donate_now' class='donate_now btn btn-lg btn-block btn-danger'>" +
            "<span class='glyphicon glyphicon-shopping-cart'></span> " +
            "BUY NOW" +
            "</button>" +
            "</form>" +
            "\t\t\t\t\t\t</div>\n" +
            "\t\t\t\t\t</div>\n" +
            "\t\t\t\t\t<!-- /PRICE ITEM -->\n" +
            "\t\t\t\t\t\n" +
            "\t\t\t\t\t\n" +
            "\t\t\t\t</div>\n" +
            "\t\t\t\t\n" +
            "\t\t\t\t<div class=\"col-md-6\">\n" +
            "\t\t\t\t\n" +
            "\t\t\t\t\t<!-- PRICE ITEM -->\n" +
            "\t\t\t\t\t<div class=\"panel price panel-blue\">\n" +
            "\t\t\t\t\t\t<div class=\"panel-heading arrow_box text-center\">\n" +
            "\t\t\t\t\t\t<h3>Lifetime Plan</h3>\n" +
            "\t\t\t\t\t\t</div>\n" +
            "\t\t\t\t\t\t<div class=\"panel-body text-center\">\n" +
            "\t\t\t\t\t\t\t<p class=\"lead\" style=\"font-size:40px\"><strong>$99</strong></p>\n" +
            "\t\t\t\t\t\t</div>\n" +
            "\t\t\t\t\t\t<ul class=\"list-group list-group-flush text-center\">\n" +
            "\t\t\t\t\t\t\t<li class=\"list-group-item\"><i class=\"icon-ok text-info\"></i>Lifetime Update</li>\n" +
            "\t\t\t\t\t\t\t<li class=\"list-group-item\"><i class=\"icon-ok text-info\"></i>1 Year Support</li>\n" +
            "\t\t\t\t\t\t</ul>\n" +
            "\t\t\t\t\t\t<div class=\"panel-footer\">\n" +
            "<form class='process_paypal_form' method='post' action='https://buffercode.com/payment/bc/payment_start'>" +
            "<input type='hidden' name='redirect_url' value=" + vardata.bc_redirect_url + " /> " +
            "<input type='hidden' name='domain' value=" + window.location.host + " /> " +
            "<input type='hidden' name='payment_info' value=" + vardata.payment_info + " /> " +
            "<input type='hidden' name='contact_email' value=" + vardata.contact_email + " /> " +
            "<input type='hidden' name='plugin_name' value='random-banner-pro' /> " +
            "<input type='hidden' name='amount' value='99' /> " +
            "<input type='hidden' name='plan_type' value='lifetime' /> " +
            "<button type='submit' name='donate_now' class='donate_now btn btn-lg btn-block btn-info'>" +
            "<span class='glyphicon glyphicon-shopping-cart'></span> " +
            "BUY NOW" +
            "</button>" +
            "</form>" +
            "\t\t\t\t\t\t</div>\n" +
            "\t\t\t\t\t</div>\n" +
            "\t\t\t\t\t<!-- /PRICE ITEM -->\n" +
            "\t\t\t\t\t\n" +
            "\t\t\t\t\t\n" +
            "\t\t\t\t</div></div>",
        html: true,
        showConfirmButton: false,
        showLoaderOnConfirm: true
    });
}

function paypal_donation_popup_no_skip(display_name) {
    swal({
        title: "",
        text: "<h2>Hi! " + (display_name) + " <br>Please Buy Pro Version</h2> <div class='bc_rb_donation_content'><b>to unlock all new features</b><br><br></div>" +
            "\t<div class=\"row bc_donation_container\">\n" +
            "    \t\t\t<div class=\"col-md-6\">\n" +
            "\t\t\t\t\n" +
            "\t\t\t\t\t<div class=\"panel price panel-red\">\n" +
            "\t\t\t\t\t\t<div class=\"panel-heading  text-center\">\n" +
            "\t\t\t\t\t\t<h3>Annual Plan</h3>\n" +
            "\t\t\t\t\t\t</div>\n" +
            "\t\t\t\t\t\t<div class=\"panel-body text-center\">\n" +
            "\t\t\t\t\t\t\t<p class=\"lead\" style=\"font-size:40px\"><strong>$39</strong></p>\n" +
            "\t\t\t\t\t\t</div>\n" +
            "\t\t\t\t\t\t<ul class=\"list-group list-group-flush text-center\">\n" +
            "\t\t\t\t\t\t\t<li class=\"list-group-item\"><i class=\"icon-ok text-danger\"></i>1 Year Update</li>\n" +
            "\t\t\t\t\t\t\t<li class=\"list-group-item\"><i class=\"icon-ok text-danger\"></i>1 Year Support</li>\n" +
            "\t\t\t\t\t\t\t<li class=\"list-group-item\"><i class=\"icon-ok text-danger\"></i>After 1 Year $19/Year</li>\n" +
            "\t\t\t\t\t\t</ul>\n" +
            "\t\t\t\t\t\t<div class=\"panel-footer\">\n" +
            "<form class='process_paypal_form' method='post' action='https://buffercode.com/payment/bc/payment_start'>" +
            "<input type='hidden' name='redirect_url' value=" + vardata.bc_redirect_url + " /> " +
            "<input type='hidden' name='domain' value=" + window.location.host + " /> " +
            "<input type='hidden' name='payment_info' value=" + vardata.payment_info + " /> " +
            "<input type='hidden' name='contact_email' value=" + vardata.contact_email + " /> " +
            "<input type='hidden' name='amount' value='39' /> " +
            "<input type='hidden' name='plugin_name' value='random-banner-pro' /> " +
            "<input type='hidden' name='plan_type' value='annual' /> " +
            "<button type='submit' name='donate_now' class='donate_now btn btn-lg btn-block btn-danger'>" +
            "<span class='glyphicon glyphicon-shopping-cart'></span> " +
            "BUY NOW" +
            "</button>" +
            "</form>" +
            "\t\t\t\t\t\t</div>\n" +
            "\t\t\t\t\t</div>\n" +
            "\t\t\t\t\t<!-- /PRICE ITEM -->\n" +
            "\t\t\t\t\t\n" +
            "\t\t\t\t\t\n" +
            "\t\t\t\t</div>\n" +
            "\t\t\t\t\n" +
            "\t\t\t\t<div class=\"col-md-6\">\n" +
            "\t\t\t\t\n" +
            "\t\t\t\t\t<!-- PRICE ITEM -->\n" +
            "\t\t\t\t\t<div class=\"panel price panel-blue\">\n" +
            "\t\t\t\t\t\t<div class=\"panel-heading arrow_box text-center\">\n" +
            "\t\t\t\t\t\t<h3>Lifetime Plan</h3>\n" +
            "\t\t\t\t\t\t</div>\n" +
            "\t\t\t\t\t\t<div class=\"panel-body text-center\">\n" +
            "\t\t\t\t\t\t\t<p class=\"lead\" style=\"font-size:40px\"><strong>$99</strong></p>\n" +
            "\t\t\t\t\t\t</div>\n" +
            "\t\t\t\t\t\t<ul class=\"list-group list-group-flush text-center\">\n" +
            "\t\t\t\t\t\t\t<li class=\"list-group-item\"><i class=\"icon-ok text-info\"></i>Lifetime Update</li>\n" +
            "\t\t\t\t\t\t\t<li class=\"list-group-item\"><i class=\"icon-ok text-info\"></i>1 Year Support</li>\n" +
            "\t\t\t\t\t\t\t<li class=\"list-group-item\"><i class=\"icon-ok text-info\"></i>-</li>\n" +
            "\t\t\t\t\t\t</ul>\n" +
            "\t\t\t\t\t\t<div class=\"panel-footer\">\n" +
            "<form class='process_paypal_form' method='post' action='https://buffercode.com/payment/bc/payment_start'>" +
            "<input type='hidden' name='redirect_url' value=" + vardata.bc_redirect_url + " /> " +
            "<input type='hidden' name='domain' value=" + window.location.host + " /> " +
            "<input type='hidden' name='payment_info' value=" + vardata.payment_info + " /> " +
            "<input type='hidden' name='contact_email' value=" + vardata.contact_email + " /> " +
            "<input type='hidden' name='plugin_name' value='random-banner-pro' /> " +
            "<input type='hidden' name='amount' value='99' /> " +
            "<input type='hidden' name='plan_type' value='lifetime' /> " +
            "<button type='submit' name='donate_now' class='donate_now btn btn-lg btn-block btn-info'>" +
            "<span class='glyphicon glyphicon-shopping-cart'></span> " +
            "BUY NOW" +
            "</button>" +
            "</form>" +
            "\t\t\t\t\t\t</div>\n" +
            "\t\t\t\t\t</div>\n" +
            "\t\t\t\t\t<!-- /PRICE ITEM -->\n" +
            "\t\t\t\t\t\n" +
            "\t\t\t\t\t\n" +
            "\t\t\t\t</div></div>",
        html: true,
        showConfirmButton: false,
        showLoaderOnConfirm: true
    });
}

//slug generator
function replaceDiacritics(s) {
    var diacritics = [
        /[\300-\306]/g, /[\340-\346]/g,  // A, a
        /[\310-\313]/g, /[\350-\353]/g,  // E, e
        /[\314-\317]/g, /[\354-\357]/g,  // I, i
        /[\322-\330]/g, /[\362-\370]/g,  // O, o
        /[\331-\334]/g, /[\371-\374]/g,  // U, u
        /[\321]/g, /[\361]/g, // N, n
        /[\307]/g, /[\347]/g  // C, c
    ];

    var chars = ['A', 'a', 'E', 'e', 'I', 'i', 'O', 'o', 'U', 'u', 'N', 'n', 'C', 'c'];

    for (var i = 0; i < diacritics.length; i++) {
        s = s.replace(diacritics[i], chars[i]);
    }

    return s;
}

function transliterate(word) {
    var cyrillic = {
        "Ё": "YO",
        "Й": "I",
        "Ц": "TS",
        "У": "U",
        "К": "K",
        "Е": "E",
        "Н": "N",
        "Г": "G",
        "Ш": "SH",
        "Щ": "SCH",
        "З": "Z",
        "Х": "H",
        "Ъ": "'",
        "ё": "yo",
        "й": "i",
        "ц": "ts",
        "у": "u",
        "к": "k",
        "е": "e",
        "н": "n",
        "г": "g",
        "ш": "sh",
        "щ": "sch",
        "з": "z",
        "х": "h",
        "ъ": "'",
        "Ф": "F",
        "Ы": "I",
        "В": "V",
        "А": "a",
        "П": "P",
        "Р": "R",
        "О": "O",
        "Л": "L",
        "Д": "D",
        "Ж": "ZH",
        "Э": "E",
        "ф": "f",
        "ы": "i",
        "в": "v",
        "а": "a",
        "п": "p",
        "р": "r",
        "о": "o",
        "л": "l",
        "д": "d",
        "ж": "zh",
        "э": "e",
        "Я": "Ya",
        "Ч": "CH",
        "С": "S",
        "М": "M",
        "И": "I",
        "Т": "T",
        "Ь": "'",
        "Б": "B",
        "Ю": "YU",
        "я": "ya",
        "ч": "ch",
        "с": "s",
        "м": "m",
        "и": "i",
        "т": "t",
        "ь": "'",
        "б": "b",
        "ю": "yu"
    };
    return word.split('').map(function (char) {
        return cyrillic[char] || char;
    }).join("");
}

function replaceSpecialCharacters(s) {

    s = s.replace(/[^a-z0-9\s]/gi, '_');

    return s;
}
