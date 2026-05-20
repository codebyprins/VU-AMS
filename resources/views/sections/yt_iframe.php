<?php
$link = get_sub_field("youtube_url");
$youtube_url = $link['url'] ?? null;

$text = get_sub_field("text_field");
$button_text = get_sub_field("button_text");
?>

<?php if ($youtube_url || $text): ?>
<section class="section py-8 w-full p-2">

    <div class="flex flex-col justify-center items-start">

        <?php if ($youtube_url): ?>
            <div class="w-[700px] h-[400px]">
                <iframe
                    class="w-full h-full"
                    src="<?php echo esc_url($youtube_url); ?>"
                    frameborder="0"
                    allowfullscreen>
                </iframe>
            </div>
        <?php endif; ?>

        <?php if ($text || ($youtube_url && $button_text)): ?>
            <div class="w-full h-[190px] flex flex-col justify-center items-start mt-5">

                <?php if ($text): ?>
                    <div class="w-[630px]">
                        <?php echo $text; ?>
                    </div>
                <?php endif; ?>

                <?php if ($youtube_url && $button_text): ?>
                    <a
                        class="border rounded-lg bg-[#00B6CB] h-[35px] mt-3 px-2 flex items-center"
                        href="<?php echo esc_url($youtube_url); ?>"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        <?php echo esc_html($button_text); ?>
                    </a>
                <?php endif; ?>

            </div>
        <?php endif; ?>

    </div>

</section>
<?php endif; ?>