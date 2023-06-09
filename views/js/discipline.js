const urlListerClasse="http://localhost:8000/classe/list";
updateClasseOnChange(inputGroupNiveau, inputGroupClasse, createOptionsClasse, urlListerClasse);

inputGroupClasse.addEventListener("change",()=>{
    const url=`http://localhost:8000/discipline/classe/${inputGroupClasse.value}&${inputGroupDiscipline.value}`;
    lister(url, document.querySelector(".container-discipline"), createCheckbox);
});



add_discipline.addEventListener("click",()=>{
    let valGroupe=inputGroupDiscipline.options[inputGroupDiscipline.selectedIndex].value;
    if (valGroupe==-1) 
    {
        valGroupe=inputGroupDiscipline.options[inputGroupDiscipline.selectedIndex].textContent;
       
    }

    data={
        "discipline":discipline_value.value,
        "classe":inputGroupClasse.options[inputGroupClasse.selectedIndex].value,
        "niveau":inputGroupNiveau.options[inputGroupNiveau.selectedIndex].value,
        "groupe":valGroupe
    }
    // console.log(data);
    notification_discipline.classList.add("invisible");
    if (discipline_value.value.length>=4) {
        
        fetch("http://localhost:8000/discipline/ajout",{
            method:"POST",
            headers:{
                'Content-Type':"application/json"
            },
            body: JSON.stringify(data)
            
        })
        .then(response=>{handleDiscipline(response)})
        return;
    }
    notification_discipline.textContent="nombre de caractères trop petit";
    notification_discipline.className = 'text-danger';
    notification_discipline.parentElement.classList.remove("invisible");
});
function lister(url, container, callback) {
    fetch(url)
    .then(response=>response.json())
    .then(data=>{
        callback(data, container);
    })
    .catch(err=>console.log(err))
}
const input=text_group.querySelector("input");
inputGroupDiscipline.addEventListener("change",()=>{
    const textcontent=inputGroupDiscipline.options[inputGroupDiscipline.selectedIndex].textContent;
    const value=inputGroupDiscipline.options[inputGroupDiscipline.selectedIndex].value;
    if(value>=0 || value=="null")
    {
        discipline_value.removeAttribute("disabled");
        add_discipline.removeAttribute("disabled");
        discipline_value.focus();
        const url=`http://localhost:8000/discipline/classe/${inputGroupClasse.value}&${inputGroupDiscipline.value}`;
        lister(url, document.querySelector(".container-discipline"), createCheckbox);
    }
    
    if(textcontent.toLowerCase()=="nouveau")
    {
        text_group.classList.remove("invisible");
        input.focus();

    }
    if (!value) {
        discipline_value.setAttribute("disabled",'');
        add_discipline.setAttribute("disabled",'');
    }
})
add_group.addEventListener("click",()=>{
    if (input.value) {
        console.log(input.value);
        inputGroupDiscipline.options[inputGroupDiscipline.selectedIndex].textContent=input.value;
        inputGroupDiscipline.options[inputGroupDiscipline.selectedIndex].value="-1";
        discipline_value.removeAttribute("disabled");
        add_discipline.removeAttribute("disabled");
        discipline_value.focus();
        text_group.classList.add("invisible");
    }
});

input.addEventListener("blur",()=>{
    setTimeout(() => {
        text_group.classList.add("invisible");
        if(!input.value)
            inputGroupDiscipline.selectedIndex="0";

    }, 400);
})

update.addEventListener("click",()=>{
    const checkbox=document.querySelectorAll(".form-check-input");
    const tabchecked=[];
    notification_update.className="invisible";
    checkbox.forEach(check=>{
        if(!check.checked)
            tabchecked.push(check.value);
    });
    console.log(tabchecked.length);
    if (!inputGroupClasse.value || !inputGroupNiveau.value || !tabchecked.length) 
    {
        notification_update.textContent="Vous devez choisir ";
        notification_update.classList.add("text-danger");
        notification_update.classList.remove("invisible");
        notification_update.textContent+=" (classe)";
        if (!tabchecked.length) 
        {
            notification_update.textContent="Vous devez décocher au plus une discipline";
            return;
        }
        if (!inputGroupNiveau.value) 
        notification_update.textContent+=" (niveau)";
        return;
      
    }
  
   
   
    const send={

        "unchecked":tabchecked
    }
    var myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");

    var raw = JSON.stringify(send);

    var requestOptions = {
        method: 'POST',
        headers: myHeaders,
        body: raw,
    };

    fetch("http://localhost:8000/discipline/set", requestOptions)
    .then(response=>response.json())
    .then(result=>{
        const url=`http://localhost:8000/discipline/classe/${inputGroupClasse.value}&${inputGroupDiscipline.value}`;
        lister(url, document.querySelector(".container-discipline"), createCheckbox);
    
    })
    .catch(err=>console.log(err))
    // console.log(send);
});
function createOptionsClasse(donnee, container)
{
    container.innerHTML=`<option value="">Choisir une classe</option>`;
    const data=donnee?.data;
    if(data)
        data.forEach(da=>{
            container.innerHTML+=`<option value=${da["id_classe"]}>${da["nom_classe"]}</option>`
        })   
}

function updateClasseOnChange(declencheur, target, callback, url)
{
    if (declencheur) {
        declencheur.addEventListener('change',e=>{
            const selectedIndex=e.target.selectedIndex;
            const selectedOption=e.target.options[selectedIndex];
            const valueOption=selectedOption.value;
            let uri;
            uri=`${url}/${+valueOption}`;
            console.log(uri);
            if (valueOption) {
                fetch(uri)
                .then(response=>response.json())
                .then(data=>{
                    callback(data,target);
                    if (declencheur===inputGroupNiveau) {
                        fetch(`http://localhost:8000/discipline/group/${valueOption}`)
                        .then(response=>response.json())
                        .then(data=>{createOptionDisci(data,inputGroupDiscipline)})
                    }
                    
                })
                .catch(er=>{console.log(er)})
            }else
            callback([],target);
        
        })
    }
}
function  createCheckbox(donnee, container)
{
    container.innerHTML="";
    container.classList.remove("text-danger");    

    const data=donnee?.data;
    if(data){
        data.forEach((da, pos)=>{
            container.innerHTML+=` 
            <div class="form-check">
                <input class="form-check-input" type="checkbox"  id="flexCheckChecked${pos}" value=${da["id_info"]} checked>
                <label class="form-check-label" for="flexCheckChecked${pos}">
                ${da["desc_discipline"]}<span>${" "}</span>(${da["code_discipline"]})
                </label>
          </div>
        `;
        });
        const classe=document.querySelector('.title_discipline > a');
        classe.innerHTML=inputGroupClasse.options[inputGroupClasse.selectedIndex].textContent;
        classe.setAttribute("href",`http://localhost:8000/eleve/liste/${inputGroupClasse.value}`)
        document.querySelectorAll(".form-check-input").forEach(element => {
            
            element.addEventListener("change",(e)=>{
                const parent=e.target.parentElement;
                const label=parent.querySelector(".form-check-label");
                label.classList.remove("text-danger");
                if(!e.target.checked)
                {
                    label.classList.add("text-danger");
                }
            })
        });
    }
    if(!data.length)
    {
        container.innerHTML="Pas encore de disciplines pour cette classe";
        container.classList.add("text-danger");    

    }
}
function  createOptionDisci(donnee, container) {
    container.innerHTML=`
    <option value="">Choisir</option>
    <option value="0" class="border-1" >Nouveau</option>`;
    const data=donnee?.data;
    if(data)
        data.forEach(da=>{
            container.innerHTML+=`<option value=${da["id_groupe"]}>${da["nom_groupe"]}</option>`
        })  
    container.innerHTML+=`<option value="${null}">Autre</option>`; 
}

async function handleDiscipline(response)
{
    let status=response.ok;
    let data= await response.json();
    const parentNotif=notification_discipline.parentElement;
    notification_discipline.textContent=data.message;
    notification_discipline.className = '';
    parentNotif.classList.remove("invisible");
    // console.log(status, data);
    if (!status) {
        console.log(parentNotif);
        parentNotif.classList.add("text-danger");
        discipline_value.focus();
        return;
    }   
    parentNotif.classList.add("text-success");
    let url;
    url=`http://localhost:8000/discipline/group/${inputGroupNiveau.value}`;
    lister(url, inputGroupDiscipline, createOptionDisci);
    url= `http://localhost:8000/discipline/classe/${inputGroupClasse.value}&${inputGroupDiscipline.value}`;
    lister(url, document.querySelector(".container-discipline"), createCheckbox);
    discipline_value.value="";
    setTimeout(() => {
        notification_discipline.textContent="";
        parentNotif.classList.add("invisible");
    }, 500);
}