<section class="section py-8 w-100 p-2">

<?php if (have_rows('product_items')): 

    $items = [];
    while (have_rows('product_items')): the_row();
        $items[] = [
            'title' => get_sub_field('title'),
            'content' => get_sub_field('content')
        ];
    endwhile;

    // Split in 2 kolommen
    $left_items = [];
    $right_items = [];

    foreach ($items as $index => $item) {
        if ($index % 2 === 0) {
            $left_items[] = $item;
        } else {
            $right_items[] = $item;
        }
    }
?>

<div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-8">

    <!-- LINKER KOLOM -->
    <div class="divide-y divide-yellow-400">
        <?php foreach ($left_items as $item): ?>
            <div class="accordion-item cursor-pointer">

                <div class="accordion-header px-[18px] py-4 flex justify-between items-center hover:bg-[#e1e1e1] bg-[#f3f3f3] rounded-md">
                    <h3 class="text-gray-700 text-[15px]">
                        <?php echo esc_html($item['title']); ?>
                    </h3>
                    <span class="icon font-bold text-lg text-yellow-400">+</span>
                </div>

                <?php if (!empty($item['content'])): ?>
                    <div class="panel max-h-0 overflow-hidden transition-[max-height] duration-300">
                        <p class="pt-2 px-[18px] pb-4 text-sm text-gray-600">
                            <?php echo $item['content']; ?>
                        </p>
                    </div>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
    </div>

    <!-- RECHTER KOLOM -->
    <div class="divide-y divide-yellow-400">
        <?php foreach ($right_items as $item): ?>
            <div class="accordion-item cursor-pointer">

                <div class="accordion-header px-[18px] py-4 flex justify-between items-center hover:bg-[#f3f3f3]">
                    <h3 class="text-gray-700 text-[15px]">
                        <?php echo esc_html($item['title']); ?>
                    </h3>
                    <span class="icon font-bold text-lg text-yellow-400">+</span>
                </div>

                <?php if (!empty($item['content'])): ?>
                    <div class="panel max-h-0 overflow-hidden transition-[max-height] duration-300">
                        <p class="pt-2 px-[18px] pb-4 text-sm text-gray-600">
                            <?php echo $item['content']; ?>
                        </p>
                    </div>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
    </div>

</div>

<?php endif; ?>

</section>