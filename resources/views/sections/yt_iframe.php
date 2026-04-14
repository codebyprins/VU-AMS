<?php 

$link = get_sub_field("youtube_url");
$youtube_url = $link['url'];

?>
<section class="section py-8 w-100 p-2">
    <div class="flex flex-col justify-center items-start">
        <div class="w-[700px] h-[400px]">
            <iframe class="w-full h-full" src="<?php echo $youtube_url; ?>"></iframe>
        </div>
        <div class="w-full h-[190px] flex flex-col justify-center items-start mt-5">
            <div class="w-[630px]">
                <?php the_sub_field("text_field"); ?>
            </div>
            <button class="border border-black rounded-lg bg-[#00B6CB] h-[35px] mt-3 pl-2 pr-2">
                <a href="<?php echo $youtube_url; ?>" target="_blank">
                    <?php the_sub_field("button_text"); ?>
                </a>
            </button>
        </div>
    </div>

</section>



