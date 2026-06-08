<?php
$titel = get_sub_field('titel');
$beschrijving = get_sub_field('beschrijving');

$year_terms = get_terms([
    'taxonomy' => 'publication_year',
    'hide_empty' => true,
    'orderby' => 'name',
    'order' => 'ASC',
]);

$jaren = [];
$publicaties = [];

if (!is_wp_error($year_terms) && !empty($year_terms)) {
    foreach ($year_terms as $term) {
        $jaren[] = $term->name;
        $publicaties[] = $term->count;
    }
}
?>

<section class="container mx-auto px-4 py-8 md:py-12">

    <?php if ($titel) : ?>
        <h2 class="font-sans text-2xl md:text-4xl font-bold mb-2 fade-in-up delay-1"><?php echo esc_html($titel); ?></h2>
        <div class="w-full h-[2px] bg-primary mb-4 fade-in-up delay-1"></div>
    <?php endif; ?>

    <?php if ($beschrijving) : ?>
        <p class="font-sans text-[16px] text-gray-600 mb-8 fade-in-up delay-2"><?php echo esc_html($beschrijving); ?></p>
    <?php endif; ?>

    <?php if (!empty($jaren)) : ?>
        <div class="border border-gray-200 rounded-lg p-6 fade-in-up delay-3">
            <div class="flex items-center gap-4 mb-6">
                <span class="flex items-center gap-2 text-sm text-gray-500">
                    <span class="inline-block w-8 h-[2px] bg-primary"></span>
                    Publicaties
                </span>
            </div>

            <div style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
                <div style="position: relative; min-width: 800px; height: 350px;">
                    <canvas id="publicatie-grafiek"
                            role="img"
                            aria-label="Lijngrafiek van publicaties per jaar">
                        <?php foreach ($jaren as $index => $jaar) : ?>
                            <?php echo esc_html($jaar); ?>: <?php echo esc_html($publicaties[$index]); ?> publicaties.
                        <?php endforeach; ?>
                    </canvas>
                </div>
            </div>
        </div>
    <?php endif; ?>

</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
<script>
(function () {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });

    document.querySelectorAll('.fade-in-up').forEach((el) => {
        observer.observe(el);
    });

    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('publicatie-grafiek');
        if (!ctx) return;

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($jaren); ?>,
                datasets: [{
                    label: 'Publicaties',
                    data: <?php echo json_encode($publicaties); ?>,
                    borderColor: '#00B6CB',
                    backgroundColor: 'rgba(0, 182, 203, 0.1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#00B6CB',
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Jaar',
                            color: '#888'
                        },
                        ticks: {
                            autoSkip: false,
                            maxRotation: 45
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Publicaties',
                            color: '#888'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    });
})();
</script>