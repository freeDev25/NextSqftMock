/* To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready(function ($) {
    document.addEventListener('wpcf7submit', function (event) {
        console.log('wpcf7submit event 1', event);
        let sallerData = event.detail.inputs.find(item => item.name === 'saler_id');
        console.log({ sallerData });
        if (71 == event.detail.contactFormId) {
            gtag_report_conversion();
            console.log("GTAG CODE CALLED");
            $('#contactAgent').modal('hide');
            if (sallerData) {
                $('#sallerDetails').data('saller-id', sallerData.value).modal('show');
            }
        }
    }, false);

    $('#sallerDetails').on('show.bs.modal', function (event) {
        //        console.log(event, $(this).data('saller-id'))
        //        var form = $(this);
        //        form.find('#saller-details').html('Thank you for connecting saller. Saller contact feature in progress.');
        //        let saller_id = $(this).data('saller-id');

    });
});

document.addEventListener('wpcf7mailsent', function (event) {
    console.log('wpcf7mailsent  event', event)
}, false);

document.addEventListener('wpcf7invalid', function (event) {
    console.log('wpcf7invalid   event', event)
}, false);

document.addEventListener('wpcf7mailfailed', function (event) {
    console.log('wpcf7mailfailed   event', event)
}, false);

function get_call_button(mobile, name, phone = '') {
    var template = '';
    if (mobile)
        template = template + `<a role="button" href="tel:${mobile}" class="btn btn-success call-button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                        <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"></path>
                        </svg>
                        ${name ?? mobile}
                    </a>`;
    if (phone)
        template = template + (mobile && phone) ? `<b class="or-tell">or</b>` : '' + `<a role="button" href="tel:${phone}" class="btn btn-success call-button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                        <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"></path>
                        </svg>
                        ${name ?? phone}
                    </a>`;
    return template;
}

jQuery(document).ready(function ($) {
    $('#contactAgent').on('hidden.bs.modal', function (event) {
        $(this).find('form').removeClass('sent');
        $(this).find('form').addClass('init');
        $(this).find('.wpcf7-response-output').html('');
    });

    $('#contactAgent').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var agentId = button.data('agent-id');
        var postId = button.data('post-id');
        var modal = $(this)
        //        modal.find('.modal-title').text('New message to ' + recipient)
        modal.find('.modal-body input#saler-id-replacer').val(agentId);
        modal.find('.modal-body input#post-id-replacer').val(postId);
        $('#saller-details').html('Thank you for connecting saller. Fetching saler contact info.');
        $.ajax({
            url: cpm_object.ajax_url,
            type: "GET",
            dataType: 'type',
            data: {
                action: 'get_saller_contact',
                saler_id: agentId
            },
            statusCode: {
                200: function (response) {
                    var responseData = JSON.parse(response.responseText);
                    var hasMobile = responseData.mobile || responseData.phone
                    var is_featured = responseData.is_featured
                    //                    console.log(responseData);
                    let agent = responseData.agent;
                    let name = agent.post_title;
                    var template = hasMobile ? "Please call/whatsapp to the below mobile number<br>" + get_call_button(responseData.mobile, name, responseData.phone) : "No mobile number found";
                    if (!is_featured) {
                        template = 'Your interest has been submitted, seller will call you back soon. <a role="button" href="https://nextsqft.com" class="btn btn-success call-button">Set property alert</a>';
                    }
                    $('#saller-details').html(template);
                }
            },
            success: function (response) {
                console.log("SUCCESS", response)
            },
            error: function (data) {
                //                form.find('.lead-backdrop').removeClass('show-loader');
                //                form.find('#mobile-number-show').addClass('error').html("Some internal error occured. Please contact with administrator.");
            }
        });
    });
    $('.contact-button').on('click', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $("#dialog").dialog();
    });
    $('#myPLModal').on('hide.bs.modal', function (event) {
        var form = $(this);
        form.find('#mobile-number-show').removeClass('error').html("");
        form.find('.myPLModalClose').attr('hidden');
    });
    $('#myPLModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var post_id = button.data('post_id') // Extract info from data-* attributes
        if (is_mobile_numbr_showable) {
            var form = $(this);
            form.find('#mobile-number-show').removeClass('error').html("");
            form.find('.lead-backdrop').addClass('show-loader')
            $.ajax({
                url: cpm_object.ajax_url,
                type: "GET",
                dataType: 'type',
                data: {
                    action: 'get_mobile_number',
                    post_id: post_id
                },
                statusCode: {
                    200: function (response) {

                        var responseData = JSON.parse(response.responseText);
                        //                        console.log(responseData)
                        form.find('.lead-backdrop').removeClass('show-loader');
                        form.find('#mobile-number-show').html(responseData.mobile ?
                            "Please call/whatsapp to the below mobile number<br>" + get_call_button(responseData.mobile) : "No mobile number found");
                        form.find('.myPLModalClose').removeAttr('hidden');
                    }
                },
                success: function (response) {
                    console.log("SUCCESS", response)
                },
                error: function (data) {
                    form.find('.lead-backdrop').removeClass('show-loader');
                    form.find('#mobile-number-show').addClass('error').html("Some internal error occured. Please contact with administrator.");
                }
            });
        }
    });
    $('#myCRModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var post_id = button.data('post_id') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        //        modal.find('.modal-title').text('New message to ' + recipient)
        modal.find('.modal-body input#post_id').val(post_id)
    })
    $('#myCRModal').on('hide.bs.modal', function (event) {
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        //        modal.find('.modal-title').text('New message to ' + recipient)
        modal.find('.modal-body input#post_id').val('')
    })

    $('form#request-new-query-form').on('submit', function (e) {
        e.preventDefault();
        var form = $(this);
        form.find('.lead-backdrop').addClass('show-loader');
        $(".success_msg").css("display", "none");
        $.ajax({
            url: cpm_object.ajax_url,
            type: "POST",
            dataType: 'type',
            data: form.serialize(),
            statusCode: {
                200: function (response) {
                    form.find('.lead-backdrop').removeClass('show-loader');
                    $(".success_msg").css("display", "block");
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    $('#form-reset').click();
                },
                400: function (data) {
                    $(".error_msg").css("display", "block");
                },
            },
            success: function (response) {
                $(".success_msg").css("display", "block");
                form.reset();
            },
            error: function (data) {
                $(".error_msg").css("display", "block");
            }
        });
    });
    $('form#request-new-lead-contact').on('submit', function (e) {
        e.preventDefault();
        var form = $(this);
        form.find('.lead-backdrop').addClass('show-loader');
        $("#response").addClass("hide");
        $.ajax({
            url: cpm_object.ajax_url,
            type: "POST",
            dataType: 'type',
            data: form.serialize(),
            statusCode: {
                200: function (response) {
                    console.log('response', JSON.parse(response.responseText));
                    form.find('.lead-backdrop').removeClass('show-loader');
                    $('#form-reset').click();
                    $("#response").removeClass('hide');
                    setTimeout(function () {
                        $('#myCRModal .close').first().trigger('click');
                        $("#response").addClass('hide');
                        $('#form-reset').click();
                    }, 3000);
                },
                400: function (data) {
                    $(".error_msg").css("display", "block");
                },
            },
            success: function (response) {
                alert('asd')
                $(".success_msg").css("display", "block");
                $('#myCRModal .close').first().trigger('click');
                form.reset();
            },
            error: function (data) {
                $(".error_msg").css("display", "block");
            }
        })

    });
    $(document).on('click', '.filter-menus', function (e) {
        e.stopPropagation();
    });
    $(document).on('click', '.limited-text .show-more', function (e) {
        e.stopPropagation();
        var limitedTextr = $(this).parent();
        limitedTextr.addClass('show-more-text');
    });
    $(document).on('click', '.limited-text .show-less', function (e) {
        e.stopPropagation();
        var limitedTextr = $(this).parent();
        limitedTextr.removeClass('show-more-text');
    });
    $("#leads-page-contents-wrapper").on('click', "#paginate a", function (e) {
        e.preventDefault();
        let backdrop = $('#leads-page-contents-wrapper').find('.lead-backdrop');
        backdrop.addClass('show-loader');
        $("#leads-page-contents").load($(this).attr('href') + " #leads-ajax-contents", function () {
            backdrop.removeClass('show-loader');
        });
    });
    $('form#leads-filters').on('submit', function (e) {
        e.preventDefault();
        var form = $(this);
        url = form.attr('action');
        type = form.attr('method');
        console.log("form.serialize", form.serialize());
        console.log("URL", url);
        console.log("type", type);
        var full_url = url + '?' + form.serialize();
        let backdrop = $('#leads-page-contents-wrapper').find('.lead-backdrop');
        backdrop.addClass('show-loader');
        const nextURL = full_url;
        const nextTitle = 'Current Leads';
        const nextState = { additionalInformation: 'Updated the URL with JS' };
        // This will create a new entry in the browser's history, without reloading
        window.history.pushState(nextState, nextTitle, nextURL);
        $("#leads-page-contents").load(full_url + " #leads-ajax-contents", function () {
            backdrop.removeClass('show-loader');
        });
    });
    $(document).on('click', '.copy-to-clip', function () {
        if ($(this).text() === 'Copied !')
            return false;
        let link = $(this).attr('data-share');
        var that = $(this);
        $('.copy-to-clip').text('Share');
        navigator.clipboard.writeText(link).then(function () {
            //            console.log('success')
            //            console.log('link', link)
            that.text('Copied !');
            /* clipboard successfully set */
        }, function () {
            //            console.log('fail');
            that.text('Error !');
            /* clipboard write failed */
        });
    });
    $(document).on('click', '#quick-links-button', function () {
        $("#quick-links-panel").toggleClass('show-filter');
    })
});