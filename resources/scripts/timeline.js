	(() => {
		if (window.__timelineReadMoreReady) return;
		window.__timelineReadMoreReady = true;

		document.addEventListener('click', (event) => {
			const button = event.target.closest('.timeline-read-more-js-toggle');
			if (!button) return;

			const card = button.closest('article');
			if (!card) return;

			const fullText = card.querySelector('.timeline-read-more-full');
			const willExpand = button.getAttribute('aria-expanded') !== 'true';
			const openButtons = document.querySelectorAll('.timeline-read-more-js-toggle[aria-expanded="true"]');

			openButtons.forEach((openButton) => {
				if (openButton === button) return;

				const openCard = openButton.closest('article');
				const openText = openCard?.querySelector('.timeline-read-more-full');

				openButton.setAttribute('aria-expanded', 'false');
				openButton.textContent = 'Read more';

				if (openText) {
					openText.style.maxHeight = '0px';
					openText.style.opacity = '0';
					openText.classList.add('hidden');
				}
			});

			button.setAttribute('aria-expanded', willExpand ? 'true' : 'false');
			button.textContent = willExpand ? 'Read less' : 'Read more';

			if (fullText) {
				if (willExpand) {
					fullText.classList.remove('hidden');
					requestAnimationFrame(() => {
						fullText.style.maxHeight = fullText.scrollHeight + 'px';
						fullText.style.opacity = '1';
					});
				} else {
					fullText.style.maxHeight = '0px';
					fullText.style.opacity = '0';
					setTimeout(() => fullText.classList.add('hidden'), 300);
				}
			}
		});
	})();