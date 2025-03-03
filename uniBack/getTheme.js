// Vérifie le thème dans le stockage local lors du chargement de la page
const theme = localStorage.getItem('theme');
if (theme === 'dark') {
    document.documentElement.style.setProperty('--background', '#344D59');
    document.documentElement.style.setProperty('--text-color', '#FFFFFF');
    toggleTheme++;
}