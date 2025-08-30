<?php
$user = wp_get_current_user();
$is_logged_in = is_user_logged_in();
$is_saller = reales_check_user_agent($user->ID) === true;
$is_mobile_numbr_showable = $is_logged_in && $is_saller;
?>
<script type="text/javascript">
    var is_user_logged_in = <?php echo $is_logged_in ? '1' : '0'; ?>;
    var is_saller = <?php echo $is_saller ? '1' : '0'; ?>;
    var is_mobile_numbr_showable = <?php echo $is_mobile_numbr_showable ? '1' : '0'; ?>;
</script>

<!-- Modal -->
<div class="modal fade" id="myCRModal" tabindex="-1" role="dialog" aria-labelledby="myCRModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="request-query custom-form-checkbox" id="request-new-lead-contact"  method='post' action=''>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myCRModalLabel">My Offer</h4>
                </div>
                <div class="modal-body">
                    <div class="lead-backdrop">
                        <div class="rq-loader" id="rq-loader"></div> 
                    </div>
                    <?php get_template_part('contact-form/request-contact-form'); ?>
                </div>
                <div class="modal-footer">
                    <input type="reset" id="form-reset" class="hide" title="Reset" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myPLModal" tabindex="-1" role="dialog" aria-labelledby="myPLModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!--            <form class="request-query custom-form-checkbox" id="request-new-lead-contact"  method='post' action=''>-->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php if (!$is_mobile_numbr_showable): ?>
                    <h4 class="modal-title" id="myPLModalLabel">Please Login/Register</h4>
                <?php else: ?>
                    <h4 class="modal-title" id="myPLModalLabel">Mobile number</h4>
                <?php endif; ?>
            </div>
            <div class="modal-body <?php if ($is_mobile_numbr_showable): ?> not-logged-in<?php endif; ?>">
                <div class="lead-backdrop">
                    <div class="rq-loader" id="rq-loader"></div> 
                </div>
                <?php if ($is_mobile_numbr_showable): ?>

                    <h3 id="mobile-number-show"></h3>
                <?php endif; ?>
                <?php if (!$is_mobile_numbr_showable): ?>
                    You are not logged in please
                    <a href="#" class="link-primary" data-toggle="modal" data-target="#signin"  data-dismiss="modal" aria-label="Close">Login </a> 
                    or <a href="#" class="link-primary" data-toggle="modal" data-target="#signup"  data-dismiss="modal" aria-label="Close">Register</a> as a saller.
                    <?php echo do_shortcode('[nextend_social_login]'); ?>
                    No need to login or register you can just 
                    <a href="#" class="link-primary" data-toggle="modal" data-target="#myCRModal"  data-dismiss="modal" aria-label="Close">Send Offer</a> as a Guest.
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" <?php if ($is_mobile_numbr_showable): ?> hidden <?php endif; ?> class="btn btn-default myPLModalClose" data-dismiss="modal" aria-label="Close">Close</button>
            </div>
            <!--</form>-->
        </div>
    </div>
</div>