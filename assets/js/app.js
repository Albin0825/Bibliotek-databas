//==================================================
// Click
//==================================================
document.getElementsByClassName("img")[0].addEventListener("click", toggle); 

//==================================================
// Con
//==================================================
const con = document.getElementsByClassName("con");
const conLenght = document.querySelectorAll('.con').length

//==================================================
// ConForm
//==================================================
const conForm = document.getElementsByClassName("conForm");
const conFormLenght = document.querySelectorAll('.conForm').length



//==================================================
// Toggle classes
//==================================================
function toggle() {
    for (let i = 0; i < conLenght; i++) {
        con[i].classList.toggle("newCon");
    }
    for (let i = 0; i < conFormLenght; i++) {
        conForm[i].classList.toggle("newConForm");
    }
}