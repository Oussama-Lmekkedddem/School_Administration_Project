function confirmDelete() {
    return confirm("Are you sure you want to delete this reservation?");
}




const modifyButton = document.getElementById("modify-button");
const moreActionDiv = document.getElementById("more-action");

modifyButton.addEventListener("click", function() {
  if (moreActionDiv.style.display === "none") {
    moreActionDiv.style.display = "block";
  } else {
    moreActionDiv.style.display = "none";
  }
});


