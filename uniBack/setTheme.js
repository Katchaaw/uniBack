const switchThemeBtn = document.querySelector('.changeTheme')
let toggleTheme = 0;

// Ajoute un écouteur d'événements pour basculer le thème lors du clic sur le bouton
switchThemeBtn.addEventListener('click', () => {
    if(toggleTheme === 0){
        document.documentElement.style.setProperty('--background', '#344D59'); // Met en place un thème sombre
        document.documentElement.style.setProperty('--text-color', '#FFFFFF'); // Change la couleur de la police en blanc
        localStorage.setItem('theme', 'dark'); // Stocke la valeur "dark" dans le stockage local du navigateur pour se souvenir du thème choisi
        toggleTheme++;
    } else{
        document.documentElement.style.setProperty('--background', '#B8CBD0'); // Met en place un thème clair
        document.documentElement.style.setProperty('--text-color', '#000000'); // Change la couleur de la police en noir
        localStorage.setItem('theme', 'light'); // Stocke la valeur "light" dans le stockage local du navigateur pour se souvenir du thème choisi
        toggleTheme--; 
    }
})

// Vérifie le thème dans le stockage local lors du chargement de la page
const theme = localStorage.getItem('theme');
if (theme === 'dark') {
    document.documentElement.style.setProperty('--background', '#344D59');
    document.documentElement.style.setProperty('--text-color', '#FFFFFF');
    toggleTheme++;
}
