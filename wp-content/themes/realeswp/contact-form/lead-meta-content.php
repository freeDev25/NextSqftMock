<?php
$metas = $args['metas'];
$p_content = get_the_content();
$pid = get_the_ID();
//_p($metas);
?>
<div class="lead-meta-content row">
    <div class="col-sm-12 col-lg-6 col-md-6">
        <p>
            <label>Request ID: </label> 
            <?php echo $pid; ?>
        </p>
        <?php if (current_user_can('administrator')) { ?>
            <p>
                <label>Name: </label> 
                <?php echo $metas[METABOX_PREFIX . 'name'][0]; ?>
            </p>
            <p>
                <label>Email: </label> 
                <?php echo $metas[METABOX_PREFIX . 'email'][0]; ?>
            </p>
            <p>
                <label>Phone: </label> 
                <?php echo $metas[METABOX_PREFIX . 'phone'][0]; ?>
            </p>
        <?php } ?>
        <?php if ($metas[METABOX_PREFIX . 'local_location'][0]): ?>
            <p>
                <label>Location: </label> 
                <?php echo implode(', ', unserialize($metas[METABOX_PREFIX . 'local_location'][0])); ?>
            </p>
        <?php endif; ?>
        <?php if ($metas[METABOX_PREFIX . 'category'][0]): ?>
            <p>
                <label>Category</label> 
                <?php echo implode(', ', unserialize($metas[METABOX_PREFIX . 'category'][0])); ?>
            </p>
        <?php endif; ?>
        <?php if ($metas[METABOX_PREFIX . 'type'][0]): ?>
            <p>
                <label>Type: </label> 
                <?php echo implode(', ', unserialize($metas[METABOX_PREFIX . 'type'][0])); ?>
            </p>
        <?php endif; ?>
        <?php if ($metas[METABOX_PREFIX . 'status'][0]): ?>
            <p>
                <label>Status: </label> 
                <?php echo implode(', ', unserialize($metas[METABOX_PREFIX . 'status'][0])); ?>
            </p>
        <?php endif; ?>
        <?php if ($p_content): ?>
            <p>
                <label>Message: </label> 
                <?php echo limit_text(strip_tags($p_content), 22); ?>
            </p>
        <?php endif; ?>
    </div>
    <div class="col-sm-12 col-lg-6 col-md-6">
        <?php if ($metas[METABOX_PREFIX . 'price_to'][0] && $metas[METABOX_PREFIX . 'price_form'][0]): ?>
            <p>
                <label>Budget </label> 
                <?php echo floor($metas[METABOX_PREFIX . 'price_form'][0]); ?> to <?php echo floor($metas[METABOX_PREFIX . 'price_to'][0]); ?> lakh
            </p>
        <?php endif; ?>
        <?php if ($metas[METABOX_PREFIX . 'area_from'][0] && $metas[METABOX_PREFIX . 'area_to'][0]): ?>
            <p>
                <label>Area: </label> 
                <?php echo $metas[METABOX_PREFIX . 'area_from'][0]; ?> to <?php echo $metas[METABOX_PREFIX . 'area_to'][0]; ?> sqft
            </p>
        <?php endif; ?>
        <?php if ($metas[METABOX_PREFIX . 'floor_no'][0]): ?>
            <p>
                <label>Floor: </label> 
                <?php echo implode(', ', unserialize($metas[METABOX_PREFIX . 'floor_no'][0])); ?>
            </p>
        <?php endif; ?>
        <?php if ($metas[METABOX_PREFIX . 'facing'][0]): ?>
            <p>
                <label>Facing: </label> 
                <?php echo implode(', ', unserialize($metas[METABOX_PREFIX . 'facing'][0])); ?>
            </p>
        <?php endif; ?>
        <?php if ($metas[METABOX_PREFIX . 'bedrooms'][0]): ?>
            <p>
                <label><span class="fa fa-bed"></span> </label> 
                <?php echo implode(', ', unserialize($metas[METABOX_PREFIX . 'bedrooms'][0])); ?>
            </p>
        <?php endif; ?>
        <?php if ($metas[METABOX_PREFIX . 'bathrooms'][0]): ?>
            <p>
                <label><span class="fa fa-bath"></span> </label> 
                <?php echo implode(', ', unserialize($metas[METABOX_PREFIX . 'bathrooms'][0])); ?>
            </p>
        <?php endif; ?>
        <?php if ($metas[METABOX_PREFIX . 'amenities'][0]): ?>
            <p>
                <label>Amenities: </label> 
                <?php echo implode(', ', unserialize($metas[METABOX_PREFIX . 'amenities'][0])); ?>
            </p>
        <?php endif; ?>

    </div>
</div>