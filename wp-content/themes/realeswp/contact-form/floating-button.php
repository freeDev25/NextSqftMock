<?php
$buttonText = $args['buttonText'] ?? 'Add';
$buttons = $args['buttons'] ?? array();
?>

<div class="floating-area">
    <a class="floating-button btn btn-primary btn-sm" id="quick-links-button"><?php echo $buttonText; ?></a>
    <?php if (count($buttons) > 0): ?>
    <div class="quick-links" id="quick-links-panel">
            <?php foreach ($buttons as $button): ?>
                <a class="quick-link btn btn-primary btn-sm" href="<?php echo $button['url']; ?>"><?php echo $button['text']; ?></a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>