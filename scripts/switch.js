const modeSwitcher = document.getElementById('theme-toggle');
const body = document.body;

// Check if the element exists before adding event listener
if (modeSwitcher) {
  modeSwitcher.addEventListener('click', () => {
    body.classList.toggle('light-mode');
    body.classList.toggle('dark-mode');
    const topnavLinks = document.querySelectorAll('.topnav a');
    topnavLinks.forEach(link => {
      link.classList.toggle('light-mode');
      link.classList.toggle('dark-mode');
    });
  });
} else {
  console.warn('Theme toggle button not found');
}