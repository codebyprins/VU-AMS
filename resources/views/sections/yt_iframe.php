<?php 

$link = get_sub_field("youtube_url");
$youtube_url = $link['url'];

$button_link = get_sub_field("button_link");
$button_text = get_sub_field("button_text");
$text_field  = get_sub_field("text_field");

?>
<section class="section py-8 w-100 p-2">
    <div class="container mx-auto flex flex-col justify-center items-start gap-[53px]">
        <div class="w-[75%] h-full">
            <iframe class="aspect-video w-full" src="<?php echo $youtube_url; ?>"></iframe>
        </div>

        <?php if ($text_field || ($button_link && $button_text)) : ?>
        <div class="w-full h-[190px] flex flex-col justify-center items-start mt-5">

            <?php if ($text_field) : ?>
            <div class="w-full max-w-[630px]">
                <?php echo $text_field; ?>
            </div>
            <?php endif; ?>

            <?php if ($button_link && $button_text) : ?>
            <button class="border border-black rounded-lg bg-[#00B6CB] h-[35px] mt-3 pl-2 pr-2">
                <a href="<?php echo esc_url($button_link); ?>" target="_blank">
                    <?php echo $button_text; ?>
                </a>
            </button>
            <?php endif; ?>

        </div>
        <?php endif; ?>

    </div>
</section>