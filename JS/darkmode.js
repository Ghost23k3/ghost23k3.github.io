document.addEventListener("DOMContentLoaded", function () {
    const toggleButton = document.getElementById("dark-mode-toggle");

    // Lade das Theme aus dem localStorage, falls vorhanden
    const savedTheme = localStorage.getItem("theme");
    if (savedTheme) {
        document.body.classList.add(savedTheme);
    } else {
        document.body.classList.add("light");
    }

    toggleButton.addEventListener("click", () => {
        const isDarkMode = document.body.classList.contains("dark");
        
        // Schaltet zwischen "dark" und "light" Klassen um
        document.body.classList.toggle("dark", !isDarkMode);
        document.body.classList.toggle("light", isDarkMode);

        // Speichert das neue Theme im localStorage
        localStorage.setItem("theme", isDarkMode ? "light" : "dark");
    });
});
