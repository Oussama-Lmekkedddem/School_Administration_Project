
    const button1 = document.getElementById('button1');
    const button2 = document.getElementById('button2');
    const div1 = document.getElementById('div1');
    const div2 = document.getElementById('div2');
    const div3 = document.getElementById('div3');
    const div4 = document.getElementById('div4');
    const div5 = document.getElementById('div5');
    const div6 = document.getElementById('div6');

    button1.addEventListener('click', () => {
        div1.classList.add('active');
        div2.classList.remove('active');
        div3.classList.add('active'); 
        div4.classList.remove('active');
        div5.classList.add('active'); 
        div6.classList.remove('active');
    });

    button2.addEventListener('click', () => {
        div1.classList.remove('active');
        div2.classList.add('active');
        div3.classList.remove('active');
        div4.classList.add('active');
        div5.classList.remove('active');
        div6.classList.add('active');
    });

    

function confirmDelete() {
  return confirm("Are you sure you want to delete?");
}