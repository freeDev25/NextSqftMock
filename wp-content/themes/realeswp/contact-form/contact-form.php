<form class="request-query custom-form-checkbox" id="request-new-query-form" method='post' action=''>
    <div class="lead-backdrop">
        <div class="rq-loader" id="rq-loader"></div>
    </div>
    <div class="alert alert-success success_msg" role="alert">The request created successfully. We will connect you soon.</div>
    <?php wp_nonce_field('handle_new_query_form', 'new_query_form'); ?>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="response"></div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
                <label for="name">Name <span class="text-red">*</span></label>
                <input type="text" required="" id="name" name="meta[<?php echo METABOX_PREFIX; ?>name]" placeholder="Enter your name" class="form-control">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
                <label for="email">Email <span class="text-red">*</span></label>
                <input type="text" required="" id="email" name="meta[<?php echo METABOX_PREFIX; ?>email]" placeholder="Enter your email" class="form-control">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
                <label for="subject">My Requirements <span class="text-red">*</span></label>
                <input type="text" required="" id="subject" name="subject" placeholder="My Requirements" class="form-control">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
                <label for="phone">Mobile <span class="text-red">*</span></label>
                <input type="text" required="" id="subject" name="meta[<?php echo METABOX_PREFIX; ?>phone]" placeholder="Enter the phone" class="form-control">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
                <label for="message">Any specific demand? <span class="text-red">*</span></label>
                <textarea id="message" name="message" placeholder="Any specific demand?" rows="3" class="form-control"></textarea>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?php get_template_part('contact-form/properties_form_template'); ?>
    </div>

    <input type="hidden" name="action" value="set_form">

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="alert alert-success success_msg" role="alert">The request created successfully. We will connect you soon.</div>
            <div class="form-group">
                <!-- <button type="reset" id="form-reset" class="btn btn-green btn-sm">Reset</button> -->
                <button type="submit" class="btn btn-green btn-sm">Send Request</button>
            </div>
        </div>
    </div>
</form>