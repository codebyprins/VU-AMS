<?php 

$link = get_sub_field("youtube_url");
$youtube_url = $link['url'];

// NIEUW: button link ophalen
$button_link = get_sub_field("button_link");

?>
<section class="section py-8 w-100 p-2">
    <div class="container mx-auto flex flex-col justify-center items-start gap-[53px]">
        <div class="w-full h-[400px]">
            <iframe class="w-full h-full" src="<?php echo $youtube_url; ?>"></iframe>
        </div>
        <div class="w-full h-[190px] flex flex-col justify-center items-start mt-5">
            <div class="w-full max-w-[630px]">
                <?php the_sub_field("text_field"); ?>
            </div>

            <button class="border border-black rounded-lg bg-[#00B6CB] h-[35px] mt-3 pl-2 pr-2">
                <a href="<?php echo esc_url($button_link); ?>" target="_blank">
                    <?php the_sub_field("button_text"); ?>
                </a>
            </button>

        </div>
    </div>
</section>