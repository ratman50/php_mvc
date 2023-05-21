const btnAddNiveau=document.querySelector('.form_niveau .addNiveau');
const inputText=document.querySelector('.form_niveau input');
btnAddNiveau=addEventListener("click",()=>{
    inputText.classList.add("active");
    
});
inputText=addEventListener("blur",()=>{
   this.classList.remove("active");
});