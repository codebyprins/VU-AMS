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
            <p class="w-[630px]">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo, sed est necessitatibus voluptatum rem sequi 
                expedita quibusdam deleniti enim ratione quos autem adipisci, labore provident numquam. Ab illo quasi sapiente.
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo, sed est necessitatibus voluptatum rem sequi 
                expedita quibusdam deleniti enim ratione quos autem adipisci, labore provident numquam. Ab illo quasi sapiente.</p>
            <button class="border border-black rounded-lg bg-[#00B6CB] w-[150px] h-[35px] mt-3">
                <a href="<?php echo $youtube_url; ?>" target="blank">Link to video</a>
            </button>
        </div>
    </div>

</section>



