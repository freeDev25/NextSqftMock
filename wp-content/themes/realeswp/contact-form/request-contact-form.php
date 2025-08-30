
<?php wp_nonce_field('handle_new_query_contact_form', 'new_query_contact_form'); ?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div id="response" class="hide alert alert-success">
            Thank you! for your interest. We will connect you soon.
        </div>
    </div>
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
            <label for="subject">My offer</label>
            <input type="text" id="subject" name="subject" placeholder="Enter greeting text" class="form-control">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="form-group"> 
            <label for="phone">Phone <span class="text-red">*</span></label>
            <input type="text" required="" id="subject" name="meta[<?php echo METABOX_PREFIX; ?>phone]" placeholder="Enter the phone" class="form-control">
        </div>
    </div>
</div>
<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="form-group"> 
            <?php
            $bedrooms = array(
                "0" => 'Studio',
                "1" => '1+',
                "2" => '2+',
                "3" => '3+',
                "4" => '4+',
                "5" => '5+');
            ?>

            <label for="subject">Bedroom </label>
            <!--<input type="text" id="bedroom" name="meta[<?php echo METABOX_PREFIX; ?>bedroom]" placeholder="Enter the beedroom" class="form-control">-->
            <select id="bedroom"  name="meta[<?php echo METABOX_PREFIX; ?>bedroom]" class="form-control">
                <option value="">Select</option>
                <?php foreach ($bedrooms as $key => $value) { ?>
                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="form-group"> 
            <?php
            $bathrooms = array(
                "1" => '1+',
                "2" => '2+',
                "3" => '3+',
                "4" => '4+',
                "5" => '5+');
            ?>
            <label for="phone">Bathroom</label>
            <!--<input type="text" id="bathroom" name="meta[<?php echo METABOX_PREFIX; ?>bathroom]" placeholder="Enter the bathroom" class="form-control">-->
            <select id="bathroom"  name="meta[<?php echo METABOX_PREFIX; ?>bathroom]" class="form-control">
                <option value="">Select</option>
                <?php foreach ($bathrooms as $key => $value) { ?>
                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
</div>
<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <div class="form-group"> 
            <?php
            $reales_fields_settings = get_option('reales_fields_settings');
            $floors = $reales_fields_settings['floor_no']['list'];
            $floors = explode(',', $floors);
            ?>
            <label for="phone">Floor</label>
            <!--<input type="text" id="floor" name="meta[<?php echo METABOX_PREFIX; ?>floor]" placeholder="Enter the floor" class="form-control">-->
            <select id="floor"  name="meta[<?php echo METABOX_PREFIX; ?>floor]" class="form-control">
                <option value="">Select</option>
                <?php foreach ($floors as $value) { ?>
                    <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <div class="form-group"> 
            <label for="subject">Size</label>
            <input type="text" id="size" name="meta[<?php echo METABOX_PREFIX; ?>size]" placeholder="Enter the size" class="form-control">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <div class="form-group"> 
            <label for="phone">Price</label>
            <input type="text" id="price" name="meta[<?php echo METABOX_PREFIX; ?>price]" placeholder="Enter the price" class="form-control">
        </div>
    </div>
</div>

<input type="hidden" name="action" value="lead_contact"> 
<input type="hidden" name="meta[<?php echo METABOX_PREFIX; ?>post_id]" id="post_id" value=""> 
