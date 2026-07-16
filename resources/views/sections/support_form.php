<?php
$title     = get_sub_field('support_form_title');
$shortcode = get_sub_field('support_form_input');
?>

<?php if ($shortcode): ?>
<section class="support-form-section py-[80px] max-md:py-10 px-4 bg-white">
    <div class="mx-auto max-w-5xl">
        <h2 class="mb-8"><?php echo esc_html($title ?: 'Support form'); ?></h2>
        <?php echo do_shortcode($shortcode); ?>
    </div>
</section>
<?php endif; ?>
