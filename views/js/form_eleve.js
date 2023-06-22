const fieldModif=document.querySelector('.fieldModif');
const formClass=document.getElementsByClassName('form-class');
const classe_niveau=document.getElementsByClassName('classe_niveau');
const notif_content=document.querySelector('.notif_content');
const modal_body_notification=document.querySelector('.modal-body.notification');
const container_form=document.querySelector('.container-form');
const classes=document.querySelector('.classes');
const niveauxSelect=document.querySelector('.form-label.niveaux select');
const form_eleve=document.forms["form-eleve"];
const modalNotif=document.getElementById('modalNotif')
let tabId=[];

let data={
    "prenom":"",
    "nom":"",
    "numero":"",
    "niveau":"",
    "classe":"",
    "sexe":"",
    "date_naiss":"",
    "lieu_naiss":""
};
const tabRequire=[
    "prenom",
    "nom",
    "numero",
    "niveau",
    "classe"
];
let isOk;
const urlListerGroupe=`${hostname}/discipline/group`;
// updateClasseOnChange(inputGroupClasse, inputGroupDiscipline, createOptionDisci, urlListerGroupe);
// console.log(add_discipline);

// inputGroupClasse.addEventListener("change",()=>{
//     lister(urlListerGroupe, inputGroupDiscipline, createOptionDisci);
// } )

// input.addEventListener("blur",()=>{
   

//     setTimeout(()=>{
//         text_group.classList.add("invisible");

//     },600)

// })
form_eleve["save"].disabled=true;
form_eleve["niveau"].addEventListener("change", ()=>{
    lister(`${hostname}/classe/list/${form_eleve['niveau'].value}`,classes.querySelector('select'), createOptions)
})
form_eleve["save"].addEventListener("click",()=>{
    let isOk="";
    tabRequire.forEach(elem=>{
        const inputElem=form_eleve[elem];
        const method=FieldName[inputElem.name];
        data[inputElem.name]=inputElem.value;
        const notifValue=inputElem.parentElement.querySelector('.notification');
        notifValue.textContent="";
        Util[method](inputElem, notifValue);
        isOk +=notifValue.textContent;

    });
    data["sexe"]=form_eleve["sexe"].value;
    data["date_naiss"]=form_eleve["date_naiss"].value;
    data["lieu_naiss"]=form_eleve["lieu_naiss"].value;
    console.log(data);
    // if(!isOk)
    // {
    //     fetch("http://localhost:8000/ajouterEleve",{
    //         method:"POST",
    //         headers:{
    //             'Content-Type':"application/json"
    //         },
    //         body: JSON.stringify(data)
    //     })
    //     .then(response=>response.json())
    //     .then(data=>{console.log(data);
    //     window.location.href="/eleve";
    //     })
    //     .catch(err=>console.log(err))
    // }
    // console.log(isOk);
})
let Util={
    "controlVide":function(field, notifValue){
        let notif="";
        const valField=field.value;
        if(!valField)
        {
            etat=false;
            notif="champs est vide";
        }
        notifValue.textContent=notif;
    },
    "controlNumero":function(field, notifValue)
    {
        const valField=field.value;
        if(valField.length>0 && !(+valField)) {
            notif="seuls les chiffres sont acceptés";
            notifValue.textContent=notif;
        }
        else if(valField){
            fetch(`${hostname}/eleve/find/${+valField}`)
            .then(response=> response.json())
            .then(resultat=>{
                console.log(resultat);
                notif=resultat.data ?"numero deja attribué":"";
                notifValue.textContent=notif;
            })
            .catch(er=>{console.log(er)})

        }
    },
    "controlSelect":function(field, notifValue){
        const valField=field.value;
        const nameElem=field.name;
        if(!valField)
        {
            notif="Vous devez choisir "+nameElem;
            notifValue.textContent=notif;
        }
    }
}
const FieldName={
    "prenom":"controlVide",
    "nom":"controlVide",
    "numero":"controlNumero",
    "niveau":"controlSelect",
    "classe":"controlSelect"
}

tabRequire.forEach(elem=>{
    const inputElem=form_eleve[elem];
    
    inputElem.addEventListener("blur",async(e)=>{
        const target=e.target;
        const method=FieldName[target.name];
        console.log(method);
        const notifValue=target.parentElement.querySelector('.notification');
        notifValue.textContent="";
        await Util[method](target, notifValue);
        isOk='';
        tabRequire.forEach(elem=>{
            const inputElem=form_eleve[elem];
            const method=FieldName[inputElem.name];
            const notifValue=inputElem.parentElement.querySelector('.notification');
            isOk +=notifValue.textContent;
    
        });
    })
});




function  controlVide(valField) {
    return valField=="" ? "champs est vide":"";
}

function createOptions(donnee, container) {
    container.innerHTML=`<option value="">Choisir une classe</option>`;
    const data=donnee?.data;
    if(data)
        data.forEach(da=>{
            container.innerHTML+=`<option value=${da["id_classe"]}>${da["nom_classe"]}</option>`
        })    
}



