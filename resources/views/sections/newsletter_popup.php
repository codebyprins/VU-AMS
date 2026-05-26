<?php
$title = get_field('popup_title', 'option');
$content = get_field('popup_text', 'option');
?>

<div id="newsletter-popup" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">

    <div class="relative w-full max-w-md mx-4 bg-white rounded-2xl shadow-xl p-6">

        <button 
            id="close-popup"
            class="absolute top-4 right-4 text-gray-400 hover:text-black text-xl"
        >
            &times;
        </button>

        <?php if ($title): ?>
            <h2 class="text-2xl font-semibold mb-3">
                <?php echo esc_html($title); ?>
            </h2>
        <?php endif; ?>

        <?php if ($content): ?>
            <div class="text-gray-600 mb-5">
                <?php echo wp_kses_post($content); ?>
            </div>
        <?php endif; ?>

        <div class="space-y-4 mailpoet-form-wrapper">
            <style>
                .mailpoet-form-wrapper input[type="email"],
                .mailpoet-form-wrapper input[type="text"],
                .mailpoet-form-wrapper input[type="number"] {
                    width: 100%;
                    padding: 0.5rem 1rem;
                    border: 1px solid #F7C80C;
                    border-radius: 0.5rem;
                    outline: none;
                }
                
                .mailpoet-form-wrapper input[type="email"]:focus,
                .mailpoet-form-wrapper input[type="text"]:focus,
                .mailpoet-form-wrapper input[type="number"]:focus {
                    outline: none;
                    ring: 1px #ebcf60;
                    box-shadow: 0 0 0 1px #ebcf60;
                }
                
                .mailpoet-form-wrapper button,
                .mailpoet-form-wrapper input[type="submit"] {
                    display: block;
                    width: 100%;
                    text-align: center;
                    background-color: #00B6CB;
                    color: white;
                    padding: 0.5rem 1rem;
                    border-radius: 0.5rem;
                    border: none;
                    cursor: pointer;
                    transition: background-color 0.2s;
                }
                
                .mailpoet-form-wrapper button:hover,
                .mailpoet-form-wrapper input[type="submit"]:hover {
                    background-color: #ABE0E6;
                }
            </style>
            <?php echo do_shortcode('[mailpoet_form id="1"]'); ?>
        </div>

    </div>
</div>