<?php
function theme_svg($name, $class = '')
{
  // build payh
  $path = get_template_directory() . "/resources/images/icons/{$name}.svg";

  // if the file doesnt exist return empty
  if (!file_exists($path)) {
    return '';
  }

  // the svg is the content of the path
  $svg = file_get_contents($path);

  // if attributes are given, add them as class
  if ($class) {
    $svg = preg_replace(
      '/<svg /',
      '<svg class="' . esc_attr($class) . '" ',
      $svg,
      1
    );
  }

  return $svg;
}

function theme_button($args = [])
{
  // fall backs
  $defaults = [
    'text'   => 'Button',
    'url'    => '#',
    'icon'   => '',
    'class'  => 'btn-primary',
    'target' => '',
    'style'  => 'primary',
    'color'  => 'white',
  ];

  // merge args with fall backs
  $args = wp_parse_args($args, $defaults);
?>

  <a
    href="<?= esc_url($args['url']); ?>"
    class="mb-4 flex gap-2 btn <?= esc_attr($args['class']); ?>"
    <?= $args['target'] ? 'target="' . esc_attr($args['target']) . '"' : ''; ?>>

    <?php if ($args['icon']) : ?>
      <span class="w-4 h-4 inline-flex <?php echo $args['style'] === 'outline' ? 'text-primary' : 'text-white'; ?>">
        <?= theme_svg($args['icon'], 'w-4 h-4'); ?>
      </span>
    <?php endif; ?>

    <?= esc_html($args['text']); ?>
  </a>

<?php
}
