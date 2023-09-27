

document.addEventListener("DOMContentLoaded", function() {
    const deleteButtons = document.querySelectorAll(".modify-button");
    const section1 = document.querySelector(".section1");

    deleteButtons.forEach(button => {
        button.addEventListener("click", function() {
            section1.classList.toggle("active");
        });
    });
});

function confirmDelete() {
    return confirm("Are you sure you want to delete this group?");
}

function confirmDelete2() {
    return confirm("Are you sure you want to delete this student from this group?");
}  

function insererPersonnes() {
    const groupeIdContainer = document.getElementById("groupeIdContainer");
    const groupeId = groupeIdContainer.getAttribute("data-groupeid");

    const checkboxes = document.querySelectorAll('.personne-checkbox:checked');
    const etudiantIds = Array.from(checkboxes).map(checkbox => checkbox.value);

    if (etudiantIds.length === 0) {
        alert("Veuillez sélectionner au moins un étudiant.");
        return;
    }

    const data = new URLSearchParams();
    data.append("groupeId", groupeId);
    etudiantIds.forEach(etudiantId => data.append("etudiantIds[]", etudiantId));

    fetch("../php/Methodefile/insertEtudiantDansGroupe.php", {
        method: "POST",
        body: data
    })
    .then(response => response.text())
    .then(result => {
        if (result === "Success") {
            location.reload();
        } else {
            alert("Étudiants ajoutés avec succès.");
            location.reload();
        }
    })
    .catch(error => {
        alert("Une erreur est survenue : " + error.message);
    });
}
