console.log("VINI VIDI INTEGRATI");
console.log("ICI sera placé la réactivité de mon projet");
console.log("(note : plusieurs fichiers js peuvent cohexister)");

// Fonction de tri pour les colonnes du tableau
function sortTable(n) {
    var table = document.getElementById("gamesTable");
    var rows = table.rows;
    var switching = true;
    var dir = "asc"; // Direction du tri initiale
    var switchCount = 0;

    // Répéter jusqu'à ce que les lignes soient triées
    while (switching) {
        switching = false;
        var rowsArray = Array.from(rows).slice(1); // Ignorer la première ligne (en-tête)

        // Comparer chaque paire de lignes
        for (var i = 0; i < rowsArray.length - 1; i++) {
            var x = rowsArray[i].getElementsByTagName("TD")[n];
            var y = rowsArray[i + 1].getElementsByTagName("TD")[n];
            var shouldSwitch = false;

            // Comparer selon la direction (texte ou numérique)
            if (dir === "asc") {
                if (n === 1) { // Si on trie par note (numérique)
                    if (parseFloat(x.innerHTML) > parseFloat(y.innerHTML)) {
                        shouldSwitch = true;
                        break;
                    }
                } else { // Si on trie par titre (texte)
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
            } else if (dir === "desc") {
                if (n === 1) {
                    if (parseFloat(x.innerHTML) < parseFloat(y.innerHTML)) {
                        shouldSwitch = true;
                        break;
                    }
                } else {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
        }

        if (shouldSwitch) {
            // Si on doit échanger les lignes
            rowsArray[i].parentNode.insertBefore(rowsArray[i + 1], rowsArray[i]);
            switching = true;
            switchCount++;
        } else {
            // Si aucune ligne n'a été échangée et que la direction est "asc", on inverse la direction
            if (switchCount === 0 && dir === "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}




