document.addEventListener('DOMContentLoaded', () => {
    const counts = document.querySelectorAll('.count');
    const speed = 97;

    // Function to animate the counter numbers
    function animateCounters() {
        counts.forEach((counter) => {
            function update() {
                const target = Number(counter.getAttribute('data-target'));
                const count = Number(counter.innerText);
                const inc = target / speed;

                if (count < target) {
                    counter.innerText = Math.floor(inc + count);
                    setTimeout(update, 15);
                } else {
                    counter.innerText = target + "+"; // Append '+' after reaching the target
                }
            }
            counter.innerText = '0'; // Reset counter to 0 before starting the animation
            update(); // Start the counter animation
        });
    }

    // Using IntersectionObserver to trigger the counter animation on scroll
    const counterSection = document.querySelector('.counter-wrapper');
    let hasAnimated = false; // To ensure animation runs only once

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !hasAnimated) {
                hasAnimated = true; // Prevent further animations
                animateCounters();  // Trigger the counter animation
                observer.unobserve(entry.target); // Stop observing after animation starts
            }
        });
    }, {
        threshold: 0.5 // Trigger animation when 50% of the section is visible
    });

    // Start observing the counter section
    observer.observe(counterSection);
});
