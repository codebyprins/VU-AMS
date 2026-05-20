<?php

$title = get_sub_field('title');
$content = get_sub_field('content');
$button = get_sub_field('button');

?>

<section class="bg-[#F8F8F8] py-10">
    <div class="container mx-auto px-4 text-center flex flex-col gap-3 md:gap-5 items-center">
        <h2 class="text-2xl md:text-4xl font-bold"><?php echo $title; ?></h2>
        <div class="max-w-[600px]"><?php echo $content; ?></div>
        <a class="btn btn-primary w-fit" href="<?php echo $button['url']; ?>" target="<?php echo $button['target']; ?>"><?php echo $button['title']; ?></a>
    </div>
</section>