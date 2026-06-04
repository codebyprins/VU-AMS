<?php
?>
<div id="cookie-consent-overlay" class="fixed bottom-4 right-4 z-[60] opacity-0 transition-opacity duration-200" role="dialog" aria-modal="true" aria-labelledby="cookie-consent-title" style="display:none!important;">
    <div class="bg-gradient-to-br from-[#01B4C9] to-[#0F1733] rounded-2xl shadow-2xl max-w-xs w-full p-5 text-white">

        <div class="flex items-center gap-3 mb-5">
            <div class="shrink-0 w-10 h-10 bg-[#F7C80C] rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#0F1733]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2a10 10 0 1 0 10 10A10.011 10.011 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8.009 8.009 0 0 1-8 8zm1-5h-2v-2h2zm0-4h-2V7h2z"/>
                </svg>
            </div>
            <h2 id="cookie-consent-title" class="text-xl font-bold"><?php esc_html_e('Cookie settings', 'vu-ams'); ?></h2>
        </div>

        <div class="text-sm text-white/80 mb-3 [&_p]:text-sm [&_p]:m-0">
            <?php
            $cookie_description = get_field('cookie_description', 'option');
            echo $cookie_description ? wp_kses_post($cookie_description) : esc_html__('We use cookies to improve your experience on our website, analyse traffic, and show relevant content.', 'vu-ams');
            ?>
        </div>
        <p class="text-sm text-white/60 mb-7">
            <?php
            $privacy_url = get_privacy_policy_url();
            if ($privacy_url) {
                printf(
                    wp_kses(
                        __('Read our <a href="%s" class="underline hover:text-[#F7C80C] transition-colors" target="_blank" rel="noopener noreferrer">privacy policy</a> for more information.', 'vu-ams'),
                        ['a' => ['href' => [], 'class' => [], 'target' => [], 'rel' => []]]
                    ),
                    esc_url($privacy_url)
                );
            }
            ?>
        </p>

        <div class="flex flex-col gap-3">
            <button id="cookie-accept-all" type="button" class="btn btn-primary w-full justify-center font-semibold">
                <?php esc_html_e('Accept all', 'vu-ams'); ?>
            </button>
            <button id="cookie-accept-necessary" type="button" class="btn btn-secondary-outline w-full justify-center font-semibold">
                <?php esc_html_e('Necessary only', 'vu-ams'); ?>
            </button>
            <button id="cookie-reject-all" type="button" class="text-white/60 hover:text-white text-sm underline transition-colors text-center py-1">
                <?php esc_html_e('Reject all', 'vu-ams'); ?>
            </button>
        </div>

    </div>
</div>

<button
    id="cookie-settings-btn"
    type="button"
    class="fixed bottom-6 right-6 z-[59] w-12 h-12 rounded-full bg-[#F7C80C] text-[#0F1733] shadow-lg flex items-center justify-center opacity-0 scale-95 transition-all duration-300 hover:scale-110 hover:shadow-xl"
    aria-label="<?php esc_attr_e('Adjust cookie settings', 'vu-ams'); ?>"
    style="display:none;">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M21.598 11.064a1.006 1.006 0 0 0-.854-.172A2.938 2.938 0 0 1 20 11c-1.654 0-3-1.346-3.003-2.937.005-.034.016-.136.017-.17a1 1 0 0 0-1.263-1.02 2.99 2.99 0 0 1-.471.066C13.839 6.938 13 6.08 13 5a3.01 3.01 0 0 1 .05-.567A1 1 0 0 0 12 3.116a9 9 0 1 0 10.087 8.816 1 1 0 0 0-.489-.868z"/>
        <circle cx="9.5" cy="13.5" r="1.5"/>
        <circle cx="13.5" cy="16" r="1"/>
        <circle cx="15" cy="11.5" r="1"/>
        <circle cx="10.5" cy="10" r="1"/>
    </svg>
</button>