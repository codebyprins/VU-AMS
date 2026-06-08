	(() => {
		if (window.__timelineReadMoreReady) return;
		window.__timelineReadMoreReady = true;

		document.addEventListener('click', (event) => {
			const button = event.target.closest('.timeline-read-more-js-toggle');
			if (!button) return;

			const card = button.closest('article');
			if (!card) return;

			const ellipsis = card.querySelector('.timeline-read-more-ellipsis');
			const rest = card.querySelector('.timeline-read-more-rest');
			const willExpand = button.getAttribute('aria-expanded') !== 'true';

			button.setAttribute('aria-expanded', willExpand ? 'true' : 'false');
			button.textContent = willExpand ? 'Read less' : 'Read more';

			if (ellipsis) ellipsis.classList.toggle('hidden', willExpand);
			if (rest) rest.classList.toggle('hidden', !willExpand);
		});
	})();