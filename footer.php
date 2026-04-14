<?php
$logo = get_field('logo', 'option');
$company = get_field('company_name', 'option');

$col2 = get_field('footer_column_2', 'option');
$col3 = get_field('footer_column_3', 'option');
$footer_col_4 = get_field('footer_column_4', 'option');

$footer_column = $footer_col_4
  ? 'col-span-12 sm:col-span-6 2xl:col-span-2'
  : 'col-span-12 sm:col-span-6 2xl:col-span-4';

// Contact details from general optionpage
$contact = [
  'address' => get_field('address_line', 'option'),
  'postcode_city' => get_field('postal_code_city', 'option'),
  'country' => get_field('country', 'option'),
  'phone' => get_field('phone_number', 'option'),
  'email' => get_field('email_address', 'option'),
  'kvk' => get_field('kvk', 'option'),
];

// function to render the content per column
function render_footer_column($col, $contact = [])
{
  if (!is_array($col)) return;

  $type = $col['footer_column_options'] ?? '';

  switch ($type) {

    case 'Contact':
      echo '<div class="text-white flex flex-col xl:flex-row gap-2">';

      echo '<div class="flex-1  ">';
      if (!empty($contact['address'])) echo '<p>' . esc_html($contact['address']) . '</p>';
      if (!empty($contact['postcode_city'])) echo '<p>' . esc_html($contact['postcode_city']) . '</p>';
      if (!empty($contact['country'])) echo '<p>' . esc_html($contact['country']) . '</p>';
      echo '</div>';

      echo '<div class="flex-1  ">';
      if (!empty($contact['phone'])) echo '<p>' . esc_html($contact['phone']) . '</p>';
      if (!empty($contact['email'])) echo '<p>' . esc_html($contact['email']) . '</p>';
      if (!empty($contact['kvk'])) echo '<p>' . esc_html($contact['kvk']) . '</p>';
      echo '</div>';

      echo '</div>';
      break;

    case 'Developed at':
      $data = $col['developed_at'] ?? [];

      echo '<div class="flex flex-col gap-2">';
      echo '<span class="text-white text-xl">Developed at</span>';
      echo '<div class="flex flex-wrap gap-4">';

      if (!empty($data['logo_1'])) {
        echo '<figure class="max-w-[150px]">';
        echo '<img class="w-full h-auto" src="' . esc_url($data['logo_1']['url']) . '" alt="">';
        echo '</figure>';
      }

      if (!empty($data['logo_2'])) {
        echo '<figure class="max-w-[150px]">';
        echo '<img class="w-full h-auto" src="' . esc_url($data['logo_2']['url']) . '" alt="">';
        echo '</figure>';
      }

      echo '</div>';
      echo '</div>';
      break;

    case 'Title text':
      $data = $col['footer_title_text'] ?? [];

      echo '<h3 class="text-white text-xl">' . esc_html($data['footer_title_text_title'] ?? '') . '</h3>';
      echo '<p class="text-white">' . esc_html($data['footer_title_text_text'] ?? '') . '</p>';
      break;

    case 'Title Image':
      $data = $col['footer_title_image'] ?? [];
      echo '<h3 class="text-white text-xl">' . esc_html($data['footer_title_image_title'] ?? '') . '</h3>';
      if (!empty($data['footer_title_image_image'])) {
        echo '<figure class="max-w-[150px]">';
        echo '<img class="w-full h-auto" src="' . esc_url($data['footer_title_image_image']['url']) . '" alt="">';
        echo '</figure>';
      }
      break;

    case 'Button':
      $btn = $col['footer_button'] ?? null;

      if ($btn) {
        echo '<a href="' . esc_url($btn['url']) . '" class="btn">';
        echo esc_html($btn['title']);
        echo '</a>';
      }
      break;

    case 'None':
    default:
      break;
  }
}
?>

</main>

<footer class="bg-primary-gradient px-section_sm sm:px-section_md xl:px-section_base">
  <div class="container py-container_sm grid grid-cols-12 gap-6">
    <!-- Column 1 is fixed -->
    <div class="<?php echo esc_attr($footer_column); ?>">
      <figure class="max-w-[200px]">
        <?php if (!empty($logo['url'])): ?>
          <img class="w-full h-auto"
               src="<?php echo esc_url($logo['url']); ?>"
               alt="<?php echo esc_attr($logo['alt'] ?? ''); ?>">
        <?php endif; ?>

        <?php if (!empty($company)): ?>
          <h2 class="text-white text-base mt-4">
            <?php echo esc_html($company); ?>
          </h2>
        <?php endif; ?>
      </figure>
    </div>

    <!-- Column 2 -->
    <div class="col-span-12 sm:col-span-6 2xl:col-span-4">
      <?php render_footer_column($col2, $contact); ?>
    </div>

    <!-- Column 3 -->
    <div class="col-span-12 sm:col-span-6 2xl:col-span-4">
      <?php render_footer_column($col3, $contact); ?>
    </div>

    <!-- Column 4 is optional -->
    <?php if ($footer_col_4): ?>
      <div class="col-span-12 sm:col-span-6 2xl:col-span-2">
        <button class="btn btn-secondary">Newsletter</button>
      </div>
    <?php endif; ?>
  </div>

  <!-- Sub footer -->
  <div class="container py-2">
    <p class="text-center text-xs text-white flex gap-2 flex-wrap justify-center">
      <?php if ($company): ?>
        <span><?php echo esc_html($company); ?></span>
      <?php endif; ?>
      <span>©<?php echo date("Y"); ?></span>
      <span>All rights reserved.</span>
    </p>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>