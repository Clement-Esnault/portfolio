const commandesBtns = document.querySelectorAll('.toggle-commandes');
const commandesRows = document.querySelectorAll('.commandes');
const modifierBtns = document.querySelectorAll('.modifier');
const supprimerBtns = document.querySelectorAll('.supprimer');
const formModal = document.getElementById('form-modifier');
const confirmModal = document.getElementById('confirm-suppression');
const closeModalBtns = document.querySelectorAll('.close-modal');
const form = document.querySelector('#form-modifier form');

let currentRow = null;

// Voir/Replier les commandes
commandesBtns.forEach((btn, index) => {
  btn.addEventListener('click', () => {
    currentRow = btn.closest('tr');
    const cells = currentRow.querySelectorAll('td');

    document.getElementById('id').value = cells[0].textContent; 
    const row = commandesRows[index];
    row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
    btn.textContent = row.style.display === 'none' ? 'Voir commandes' : 'Replier commandes';
  });
});

// Modifier client
modifierBtns.forEach((btn) => {
  btn.addEventListener('click', () => {
    currentRow = btn.closest('tr');
    const cells = currentRow.querySelectorAll('td');

    document.getElementById('e-id').value = cells[0].textContent; 

  
    document.getElementById('edit-nom').value = cells[1].textContent;
    document.getElementById('edit-prenom').value = cells[2].textContent;
    document.getElementById('edit-email').value = cells[3].textContent;
    document.getElementById('edit-tel').value = cells[4].textContent;

    formModal.classList.remove('hidden');
  });
});




// Supprimer client
supprimerBtns.forEach((btn) => {
  btn.addEventListener('click', () => {
    currentRow = btn.closest('tr');
    const cells = currentRow.querySelectorAll('td');
    document.getElementById('s-id').value = cells[0].textContent;
    confirmModal.classList.remove('hidden');
  });
});

// Confirmer suppression
document.querySelector('.confirmer').addEventListener('click', () => {
  const index = Array.from(document.querySelectorAll('tr')).indexOf(currentRow);
  const commandesRow = document.querySelectorAll('.commandes')[(index - 1) / 2];
  currentRow.remove();
  commandesRow.remove();
  confirmModal.classList.add('hidden');
});

// Fermer modales
closeModalBtns.forEach(btn => {
  btn.addEventListener('click', () => {
    formModal.classList.add('hidden');
    confirmModal.classList.add('hidden');
  });
});


