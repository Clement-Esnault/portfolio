function updateTotalPoints() {
    var strength = parseInt(document.getElementById("strength").value) || 0;
    var initiative = parseInt(document.getElementById("initiative").value) || 0;
    var attack = parseInt(document.getElementById("attack").value) || 0;
    var pv = parseInt(document.getElementById("pv").value) || 0;
    var mana = parseInt(document.getElementById("mana").value) || 0;

    // Calculer la somme des points
    var totalPoints = strength + initiative + attack + pv + mana;

    // Mettre à jour le champ total_points
    document.getElementById("total_points").value = totalPoints;

    // Vérifier si le total dépasse 5 et afficher un message d'avertissement
    if (totalPoints > 5) {
        document.getElementById("total_points").style.backgroundColor = "#f8d7da"; // rouge clair
    } else {
        document.getElementById("total_points").style.backgroundColor = "#d4edda"; // vert clair
    }
}

// Attacher l'événement de mise à jour du total à chaque champ
document.getElementById("strength").addEventListener("input", updateTotalPoints);
document.getElementById("initiative").addEventListener("input", updateTotalPoints);
document.getElementById("attack").addEventListener("input", updateTotalPoints);
document.getElementById("pv").addEventListener("input", updateTotalPoints);
document.getElementById("mana").addEventListener("input", updateTotalPoints);

document.addEventListener('DOMContentLoaded', () => {
    function adjustTextareaHeight(textarea) {
        // Réinitialiser la hauteur pour recalculer la nouvelle hauteur
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    }

    const textarea = document.getElementById('description');
    
    // Ajuste la hauteur immédiatement si le champ contient déjà du texte
    adjustTextareaHeight(textarea);

    // Ajouter un événement pour ajuster la hauteur à chaque entrée de texte
    textarea.addEventListener('input', function () {
        adjustTextareaHeight(textarea);
    });

    const deleteBtn = document.getElementById('deleteBtn');
    const modal = document.getElementById('confirmModal');
    const cancelBtn = document.getElementById('cancelBtn');

    if (!deleteBtn) return;

    deleteBtn.addEventListener('click', (e) => {
        e.preventDefault();
        modal.style.display = 'flex';
    });

    cancelBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});