const modif=document.querySelector(".modif");
const fieldModif=document.querySelector('.fieldModif');
const formClass=document.getElementsByClassName('form-class');
const classe_niveau=document.getElementsByClassName('classe_niveau');
const Niveaux={
    "enseignement primaire":["CI","CP","CE1","CE2","CM1","CM2"],
    "enseignement secondaire inférieur":["6ième","5ième","4ième","3ième"],
    "enseignement secondaire supérieur":["2nd","1er","Tle"],
};
const containerFluid=document.querySelector(".container-fluid .niveaux");
const elements=containerFluid.childElementCount;
console.log(elements);
if(elements<Object.keys(Niveaux).length)
{
    const valNiveau=Object.keys(Niveaux)[elements];
    const nameNiveau=document.querySelector(".name-niveau");
    nameNiveau.value=valNiveau;
    console.log(nameNiveau);
    console.log(valNiveau);
}
else
{
    //desactiver le bouton ajouter
}

[...formClass].forEach(form=>{
    console.log(form);
    const parent=form.parentElement;
    const fieldModif=parent.querySelector(".fieldModif");
    
    const valSearch=fieldModif.value;
    const pos=form.childElementCount-3;
    console.log(pos);
    if(pos<Niveaux[valSearch].length)
    {
        const valIns=Niveaux[valSearch][pos];
        const inputInser=parent.querySelector(".className");
        inputInser.value=valIns;
        console.log(inputInser);
    }
})

modif.addEventListener('click',()=>{
    fieldModif.disabled=false;
});
// [...addClass].forEach(element => {
    
//     element.addEventListener('click',(e)=>{
//         console.log("bal ala");
//         const target=e.target;
//         const parent=target.parentElement;
//         console.log(parent);
//         const form=document.createElement("form");
//         form.setAttribute("method","POST");
//         form.setAttribute("action","/ajouterClasse");
//         form.className='d-flex flex-column position-relative';
//         const child=document.createElement("input");
//         child.setAttribute("name","classe");
//         const niveau=document.createElement("input");
//         niveau.setAttribute("name","niveau");
//         niveau.setAttribute("type","hidden");
//         child.className="classe_niveau text-danger w-25 mt-2 border-0 form-control mb-2 ";
//         child.id="myInput";
//         const ul=document.createElement('ul');
//         ul.className="position-absolute w-25 dropdown-menu";
        
//         ul.style.top="100%";
//         ul.style.left="0";
//         // ul.style.display="block";
        
//         form.appendChild(child);
//         parent.appendChild(form);
//         form.appendChild(ul);
//         child.focus();
//         const pr=parent.parentElement.parentElement;
//         niveau.value=pr.dataset.id;
//         form.appendChild(niveau);
//         console.log(pr);
//         child.addEventListener('blur',()=>{
//             if(child.value=="")
//             {
//                 form.remove();
//             }
//             setTimeout(()=>{
//                 ul.style.display="none";
//             },200);
//         });
//         const valSearch=pr.querySelector('.name-value').value;
//         console.log(Niveaux[valSearch]);
//         child.addEventListener('input',()=>{
//             const val=child.value;
//             console.log(val.toUpperCase());
//             ul.innerHTML="";
//             const resultat=Niveaux[valSearch].filter(niveau=>niveau.startsWith(val.toUpperCase()));
//             if(val.length>0 && resultat.length>1)
//             {
//                 ul.style.display="block";
//                 console.table(resultat);
//                 resultat.forEach(res=>{
//                     const li=document.createElement("option");
//                     li.className="dropdown-item";
//                     li.textContent=res;
//                     ul.appendChild(li);
//                     li.addEventListener("click",()=>{
//                         child.value=li.textContent;
//                         child.focus();
//                         setTimeout(()=>{
//                             ul.style.display="none";
//                         },200);
//                     })
//                 })

//             }
//         })

//     })
// });
