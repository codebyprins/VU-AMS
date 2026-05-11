<?php
// Don't render if user already made a choice (handled client-side via localStorage, but we still render the HTML)
?>
<div id="cookie-consent-overlay" class="fixed inset-0 z-[60] bg-black/60 flex items-center justify-center p-4 transition-opacity duration-300" role="dialog" aria-modal="true" aria-labelledby="cookie-consent-title" style="display:none!important;">
    <div class="bg-gradient-to-br from-[#01B4C9] to-[#0F1733] rounded-2xl shadow-2xl max-w-md w-full p-8 text-white">

        <div class="flex items-center gap-3 mb-5">
            <div class="shrink-0 w-10 h-10 bg-[#F7C80C] rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#0F1733]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2a10 10 0 1 0 10 10A10.011 10.011 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8.009 8.009 0 0 1-8 8zm1-5h-2v-2h2zm0-4h-2V7h2z"/>
                </svg>
            </div>
            <h2 id="cookie-consent-title" class="text-xl font-bold"><?php esc_html_e('Cookie-instellingen', 'vu-ams'); ?></h2>
        </div>

        <p class="text-sm text-white/80 mb-3">
            <?php esc_html_e('Wij gebruiken cookies om uw ervaring op onze website te verbeteren, verkeer te analyseren en relevante content te tonen.', 'vu-ams'); ?>
        </p>
        <p class="text-sm text-white/60 mb-7">
            <?php
            $privacy_url = get_privacy_policy_url();
            if ($privacy_url) {
                printf(
                    wp_kses(
                        /* translators: %s: privacy policy URL */
                        __('Lees onze <a href="%s" class="underline hover:text-[#F7C80C] transition-colors" target="_blank" rel="noopener noreferrer">privacyverklaring</a> voor meer informatie.', 'vu-ams'),
                        ['a' => ['href' => [], 'class' => [], 'target' => [], 'rel' => []]]
                    ),
                    esc_url($privacy_url)
                );
            }
            ?>
        </p>

        <div class="flex flex-col gap-3">
            <button id="cookie-accept-all" type="button" class="btn btn-primary w-full justify-center font-semibold">
                <?php esc_html_e('Alles accepteren', 'vu-ams'); ?>
            </button>
            <button id="cookie-accept-necessary" type="button" class="btn btn-secondary-outline w-full justify-center font-semibold">
                <?php esc_html_e('Alleen noodzakelijk', 'vu-ams'); ?>
            </button>
            <button id="cookie-reject-all" type="button" class="text-white/60 hover:text-white text-sm underline transition-colors text-center py-1">
                <?php esc_html_e('Alles weigeren', 'vu-ams'); ?>
            </button>
        </div>

    </div>
</div>
