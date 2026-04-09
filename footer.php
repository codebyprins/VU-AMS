<?php
  $logo = get_field('logo', 'option');
?>

</main>
<footer class="bg-primary-gradient px-section_sm sm:px-section_md xl:px-section_base">
  <div class="container py-container_sm grid grid-cols-12 gap-6">
    <div class="col-span-12 xl:col-span-4">
      <figure clas="max-w-[200px]">
        <img class="w-full h-auto" src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt']); ?>">
      </figure>
    </div>
    <div class="col-span-12 xl:col-span-4 bg-secondary p-4"></div>
    <div class="col-span-12 xl:col-span-4 bg-primary p-4"></div>
  </div>
  <div class="container py-2">
    <p class="text-center text-white">©<?php echo date("Y") ?> Your Company. All rights reserved.</p>
  </div>
</footer>

<?php wp_footer(); ?>
</body>

</html>