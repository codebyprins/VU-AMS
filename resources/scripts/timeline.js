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
			const allCards = document.querySelectorAll('article');

			if (willExpand) {
				allCards.forEach((otherCard) => {
					if (otherCard === card) return;

					const otherButton = otherCard.querySelector('.timeline-read-more-js-toggle');
					const otherText = otherCard.querySelector('.timeline-read-more-full');

					if (otherButton && otherButton.getAttribute('aria-expanded') === 'true') {
						otherButton.setAttribute('aria-expanded', 'false');
						otherButton.textContent = 'Read more';
					}

					if (otherText) {
						otherText.style.maxHeight = '0px';
						otherText.style.opacity = '0';
						otherText.classList.add('hidden');
					}
				});
			}

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