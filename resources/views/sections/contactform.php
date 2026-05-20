<?php
$form = get_sub_field('form');
$shortcode = '[contact-form-7 id="9e134a4" title="Contact form 1"]';

if (is_numeric($form)) {
	$shortcode = sprintf('[contact-form-7 id="%d"]', (int) $form);
} elseif (is_array($form) && isset($form['ID']) && is_numeric($form['ID'])) {
	$shortcode = sprintf('[contact-form-7 id="%d"]', (int) $form['ID']);
} elseif (is_object($form) && isset($form->ID) && is_numeric($form->ID)) {
	$shortcode = sprintf('[contact-form-7 id="%d"]', (int) $form->ID);
} elseif (is_string($form)) {
	$shortcode = trim($form);
}

if ($shortcode !== '') {
	$contact_title = get_sub_field('contact_title') ?: 'Neem contact op';
	?>
	<section class="section bg-gradient-to-b from-surface to-white py-20 lg:py-28">
		<div class="container px-4 sm:px-6 lg:px-8">

			<div class="mx-auto mb-12 max-w-2xl text-center lg:mb-16">
				<h2 class="font-bold leading-[1.15] tracking-tight text-accent"><?php echo esc_html($contact_title); ?></h2>
				<span class="mx-auto mt-6 block h-1 w-16 rounded-full bg-gradient-to-r from-primary to-primary_dark" aria-hidden="true"></span>
			</div>

			<div class="mx-auto max-w-2xl rounded-[1.75rem] bg-white p-8 shadow-2xl shadow-accent/10 sm:p-12 lg:p-16">
				<div
					id="contact-form-wrapper"
					class="
						[&_.wpcf7-form]:grid [&_.wpcf7-form]:items-start [&_.wpcf7-form]:gap-5
						[&_.wpcf7-form>p]:m-0
						[&_label]:block [&_label]:text-sm [&_label]:font-semibold [&_label]:leading-snug [&_label]:text-accent
						[&_label_br]:hidden
						[&_.cf7-required]:font-bold [&_.cf7-required]:text-primary
						[&_.cf7-optional]:text-xs [&_.cf7-optional]:font-normal [&_.cf7-optional]:text-accent/45
						[&_.wpcf7-form-control-wrap]:mt-2 [&_.wpcf7-form-control-wrap]:block
						[&_.wpcf7-form-control:not(.wpcf7-submit)]:block [&_.wpcf7-form-control:not(.wpcf7-submit)]:w-full [&_.wpcf7-form-control:not(.wpcf7-submit)]:appearance-none [&_.wpcf7-form-control:not(.wpcf7-submit)]:rounded-xl [&_.wpcf7-form-control:not(.wpcf7-submit)]:border [&_.wpcf7-form-control:not(.wpcf7-submit)]:border-accent/5 [&_.wpcf7-form-control:not(.wpcf7-submit)]:bg-[#f8f9fb] [&_.wpcf7-form-control:not(.wpcf7-submit)]:px-5 [&_.wpcf7-form-control:not(.wpcf7-submit)]:py-3.5 [&_.wpcf7-form-control:not(.wpcf7-submit)]:text-base [&_.wpcf7-form-control:not(.wpcf7-submit)]:text-accent [&_.wpcf7-form-control:not(.wpcf7-submit)]:shadow-sm [&_.wpcf7-form-control:not(.wpcf7-submit)]:outline-none [&_.wpcf7-form-control:not(.wpcf7-submit)]:transition
						[&_.wpcf7-form-control:not(.wpcf7-submit)::placeholder]:text-accent/40
						[&_.wpcf7-form-control:not(.wpcf7-submit):hover]:border-primary/40 [&_.wpcf7-form-control:not(.wpcf7-submit):hover]:shadow-md
						[&_.wpcf7-form-control:not(.wpcf7-submit):focus]:border-primary [&_.wpcf7-form-control:not(.wpcf7-submit):focus]:bg-white [&_.wpcf7-form-control:not(.wpcf7-submit):focus]:ring-[3px] [&_.wpcf7-form-control:not(.wpcf7-submit):focus]:ring-primary/20
						[&_textarea.wpcf7-form-control]:min-h-36 [&_textarea.wpcf7-form-control]:resize-y
						[&_.wpcf7-submit]:mt-1 [&_.wpcf7-submit]:flex [&_.wpcf7-submit]:w-full [&_.wpcf7-submit]:cursor-pointer [&_.wpcf7-submit]:items-center [&_.wpcf7-submit]:justify-center [&_.wpcf7-submit]:rounded-xl [&_.wpcf7-submit]:border-0 [&_.wpcf7-submit]:bg-gradient-to-br [&_.wpcf7-submit]:from-primary [&_.wpcf7-submit]:to-primary_dark [&_.wpcf7-submit]:px-8 [&_.wpcf7-submit]:py-4 [&_.wpcf7-submit]:text-base [&_.wpcf7-submit]:font-bold [&_.wpcf7-submit]:tracking-wide [&_.wpcf7-submit]:text-white [&_.wpcf7-submit]:shadow-lg [&_.wpcf7-submit]:shadow-primary/40 [&_.wpcf7-submit]:transition
						[&_.wpcf7-submit:hover]:-translate-y-0.5 [&_.wpcf7-submit:hover]:brightness-105 [&_.wpcf7-submit:hover]:shadow-xl [&_.wpcf7-submit:hover]:shadow-primary/50
						[&_.wpcf7-submit:active]:translate-y-0
						[&_.wpcf7-submit:focus-visible]:outline [&_.wpcf7-submit:focus-visible]:outline-[3px] [&_.wpcf7-submit:focus-visible]:outline-offset-2 [&_.wpcf7-submit:focus-visible]:outline-primary/40
						[&_.wpcf7-spinner]:mx-auto [&_.wpcf7-spinner]:mt-3
						[&_.wpcf7-not-valid-tip]:mt-1.5 [&_.wpcf7-not-valid-tip]:block [&_.wpcf7-not-valid-tip]:text-xs [&_.wpcf7-not-valid-tip]:font-medium [&_.wpcf7-not-valid-tip]:text-red-600
						[&_.wpcf7-form-control.wpcf7-not-valid]:!border-red-600 [&_.wpcf7-form-control.wpcf7-not-valid]:!bg-red-50
						[&_.wpcf7-response-output]:mt-1 [&_.wpcf7-response-output]:rounded-xl [&_.wpcf7-response-output]:border-[1.5px] [&_.wpcf7-response-output]:px-4 [&_.wpcf7-response-output]:py-3.5 [&_.wpcf7-response-output]:text-sm
						[&_form.sent_.wpcf7-response-output]:border-primary_dark [&_form.sent_.wpcf7-response-output]:bg-primary_light/30 [&_form.sent_.wpcf7-response-output]:text-primary_dark
						[&_form.invalid_.wpcf7-response-output]:border-red-600 [&_form.invalid_.wpcf7-response-output]:bg-red-50 [&_form.invalid_.wpcf7-response-output]:text-red-700
						[&_form.unaccepted_.wpcf7-response-output]:border-red-600 [&_form.unaccepted_.wpcf7-response-output]:bg-red-50 [&_form.unaccepted_.wpcf7-response-output]:text-red-700
						[&_form.failed_.wpcf7-response-output]:border-red-600 [&_form.failed_.wpcf7-response-output]:bg-red-50 [&_form.failed_.wpcf7-response-output]:text-red-700
						[&_form.spam_.wpcf7-response-output]:border-red-600 [&_form.spam_.wpcf7-response-output]:bg-red-50 [&_form.spam_.wpcf7-response-output]:text-red-700
						sm:[&_.wpcf7-form]:grid-cols-2
						sm:[&_.wpcf7-form>p]:col-span-2
						sm:[&_.wpcf7-form>p:has([data-name=your-name])]:col-span-1
						sm:[&_.wpcf7-form>p:has([data-name=your-email])]:col-span-1
						sm:[&_.wpcf7-response-output]:col-span-2
					"
				>
					<?php echo do_shortcode($shortcode); ?>
				</div>
			</div>
		</div>
	</section>
	<?php
}
?>
