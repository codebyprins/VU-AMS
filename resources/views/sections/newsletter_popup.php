<?php
$title = get_field('popup_title', 'option');
$content = get_field('popup_text', 'option');
$email = get_field('popup_email', 'option');
$button = get_field('popup_button', 'option');
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

        <div class="space-y-4">

            <input 
                type="email"
                placeholder="<?php echo esc_attr($email ?: 'Enter your email'); ?>"
                class="w-full px-4 py-2 border border-[#F7C80C] rounded-lg focus:outline-none focus:ring-1 focus:ring-[#ebcf60]"
            >

            <?php if ($button): ?>
                <a 
                    href="<?php echo esc_url($button); ?>"
                    class="block w-full text-center bg-[#00B6CB] text-white py-2 rounded-lg hover:bg-[#ABE0E6]transition"
                >
                    Subscribe
                </a>
            <?php endif; ?>

        </div>

    </div>
</div>