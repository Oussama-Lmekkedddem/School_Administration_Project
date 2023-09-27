const editButton = document.querySelector('.btn-edit');
const editDiv = document.querySelector('.edit-div');
        
        const deleteButton = document.querySelector('.btn-delete');
        const deleteDiv = document.querySelector('.delete-div');
        
        
        editButton.addEventListener('click', () => {
           editDiv.style.display = 'block';
            deleteDiv.style.display = 'none';
        });
        
        deleteButton.addEventListener('click', () => {
            deleteDiv.style.display = 'block';
            editDiv.style.display = 'none';
        });




        

        function confirmDelete() {
            return confirm("Are you sure you want to delete this student?");
          }





          const btnPaiement = document.getElementById("btnPaiement");
        const btnCours = document.getElementById("btnCours");
        const tableauPaiement = document.getElementById("tableauPaiement");
        const tableauCours = document.getElementById("tableauCours");
        btnPaiement.addEventListener("click", () => {
            tableauPaiement.style.display = "block";
            tableauCours.style.display = "none";
        });

        btnCours.addEventListener("click", () => {
            tableauCours.style.display = "block";
            tableauPaiement.style.display = "none";
        });



        const modifyButton = document.querySelector(".modify-button");
        const moreInfoDiv = document.getElementById("moreinfo_paiement");
    
        modifyButton.addEventListener("click", () => {
            if (moreInfoDiv.style.display === "none") {
                moreInfoDiv.style.display = "block";
            } else {
                moreInfoDiv.style.display = "none";
            }
        });
    
    function confirmDelete2() {
        return confirm("Are you sure you want to delete this payment?");
      }