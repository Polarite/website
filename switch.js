const modeSwitcher = document.getElementById('mode-switcher');
const body = document.body;

modeSwitcher.addEventListener('click', () => {
  body.classList.toggle('light-mode');
  body.classList.toggle('dark-mode');
  const topnavLinks = document.querySelectorAll('.topnav a');
  topnavLinks.forEach(link => {
    link.classList.toggle('light-mode');
    link.classList.toggle('dark-mode');
  });
});