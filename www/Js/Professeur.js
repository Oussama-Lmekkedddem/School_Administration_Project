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
            return confirm("Are you sure you want to delete this teacher? If you delete this teacher, all the groups taught by this teacher will also be deleted.");
          }



