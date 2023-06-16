const container_card=document.querySelector(".container_card");
const classe=container_card.dataset.classe;

let updates=[];

// Créez une instance de MutationObserver
const observer = new MutationObserver((mutationsList, observer) => {
  // Parcourez les mutations détectées
    handleValMax(document.querySelectorAll("input"), updates);
    const deletes=document.querySelectorAll(".delete");
    deletes.forEach(element => {
        element.addEventListener("click",(e)=>{
            const discipline=e.target.dataset.discipline;
            requestOptions.body=JSON.stringify([discipline]);
            fetch(`${hostname}/discipline/set`, requestOptions)
            .then(response=>response.json())
            .then(result=>{
                showModal(result.message);
                const url=`${hostname}/classe/discipline/${classe}`;
                lister(url, container_card, createCard);
            
            })
            .catch(err=>console.log(err))
        })
    });
});

// Configurez les options de l'Observateur de mutations
  
  // Commencez à observer les mutations sur l'élément parent avec les options spécifiées
  observer.observe(container_card, observerOptions);


update.addEventListener("click",()=>{
    if (updates.length) {
        requestOptions["body"]=JSON.stringify(updates);
        fetch(`${hostname}/classe/maxval`, requestOptions)
        .then(response=>response.json())
        .then(result=>{
            showModal(result.message);

            updates=[];
        })
    }
    
});

async function load(){
   lister(`${hostname}/discipline/load_valMax_eval/${classe}`, container_card, createCard);

}
window.onload=load;

function createCard(data, container) {
    container.innerHTML="";
    const header=data.header;
    console.log(data);
    data.data.forEach(value => {
        let inputs="";
        for (const key in value["notes_max"]) {
                const element = value["notes_max"][key];
                inputs+=
                `
                <div class="col-6">
                    <label>${key}</label>
                    <input type="number" class="form-control" name="${key}" value="${element}" />
                </div>
                
                `;
                
        }
        
        container.innerHTML+=`
        <div class="card position-relative" style="width: 18rem;">
            <button type="button" data-discipline="${value["id_info"]}" class="btn btn-circle delete text-danger position-absolute" style=" top:0px;right:10px">&times</button>
            <div class="card-header">
                <h5 class="card-title text-dark mt-4">${value['desc_discipline']} </h5>
            </div>
            <div class="card-body">
            <div class="row" data-discipline="${value["id_info"]}">
                ${inputs}
                <p class="col"></p>
            </div>
            </div>
        </div>
        `;
    });

}
function  handleValMax(tab , updates) {
    tab.forEach(element=>{
        element.addEventListener("input",(e)=>{
            const target=e.target;
            const value=target.value;
            const parentElement=target.parentElement;
            target.classList.remove("text-success");
            target.classList.remove("text-danger");
            const update={
                "discipline":parentElement.parentElement.dataset.discipline,
                "name":target.name
            };

            if(value>=10)
            {
                target.classList.add("text-success");
                update["value"]=target.value;
            }else
            {
                target.classList.add("text-danger");
                update["value"]=0;
            }
            let pos=updates.findIndex(se=>se?.discipline==update.discipline && se?.name==update.name);
            if (pos==-1) {
                updates.push(update);
                return;
            }
            updates[pos]["value"]=update["value"];
    
        })
    })
}
