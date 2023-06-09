const ressources=document.querySelectorAll(".ressource");
const compositions=document.querySelectorAll(".composition");
const container_card=document.querySelector(".container_card");
const classe=container_card.dataset.classe;
var myHeaders = new Headers();
lister(`http://localhost:8000/classe/discipline/${classe}`, container_card, createCard);

myHeaders.append("Content-Type", "application/json");

var requestOptions = {
    method: 'POST',
    headers: myHeaders,
};



function lister(url, container, callback) {
    fetch(url)
    .then(response=>response.json())
    .then(data=>{
        callback(data, container);
        const ress={
            "classe":classe,
            "updates":[]
        }
        const comp={
            "classe":classe,
            "updates":[]
        }
        handleValMax(document.querySelectorAll(".ressource"), "ressource",ress);
        handleValMax(document.querySelectorAll(".composition"), "composition",comp);
        update.addEventListener("click",()=>{
            console.log(ress);
            if (ress["updates"].length) {
                requestOptions["body"]=JSON.stringify(ress);
                fetch("http://localhost:8000/classe/maxval", requestOptions)
                .then(response=>response.json())
                .then(result=>{console.log(result);})
            }
            if (comp["updates"].length) {
                requestOptions["body"]=JSON.stringify(comp);
                fetch("http://localhost:8000/classe/maxval", requestOptions)
                .then(response=>response.json())
                .then(result=>{console.log(result);})
            }
           
        });
    
    })
    .catch(err=>console.log(err))
}
function createCard(data, container) {
    container.innerHTML="<button type='button' class='btn btn-primary position-absolute' id='update' style='top:-50px;right:10px'>Mettre à jour </button>";
    data.data.forEach(value => {
        container.innerHTML+=`
        <div class="card position-relative" style="width: 18rem;">
            <button type="button" class="btn btn-circle text-danger position-absolute" style=" top:0px;right:10px">&times</button>
            <div class="card-header">
                <h5 class="card-title text-dark mt-4">${value['desc_discipline']} </h5>
            </div>
            <div class="card-body">
            <div class="row" data-discipline="${value["id_info"]}">
                    <div class="col-6">
                        <label>Ressource</label>
                        <input type="number" value="${value["ressource"]}" class="form-control ressource"/>
                    </div>
                    <div class="col-6">
                        <label>Composition</label>
                        <input type="number" class="form-control composition" value="${value["composition"]}" />
                    </div>
                    <p class="col"></p>
            </div>
            </div>
        </div>
        `;
    });
    

}
function  handleValMax(tab, nameField, result) {
    tab.forEach(element=>{
        element.addEventListener("input",(e)=>{
            const target=e.target;
            const value=target.value;
            const parentElement=target.parentElement;
            target.classList.remove("text-success");
            target.classList.remove("text-danger");
            if(value>=10)
            {
                target.classList.add("text-success");
                const update={
                    "discipline":parentElement.parentElement.dataset.discipline,
                    // nameField:value
                };
                update[nameField]=value;
                let pos=result["updates"].findIndex(se=>se?.discipline==update.discipline);
                if (pos==-1) {
                    result["updates"].push(update);
                    return;
                }
                result['updates'][pos][nameField]=value;
                return;
            }
            target.classList.add("text-danger");
    
    
        })
    })
}
// ressources.forEach(ressource=>{
//     ressource.addEventListener("input",(e)=>{
//         const target=e.target;
//         const value=target.value;
//         const parentElement=target.parentElement;
//         target.classList.remove("text-success");
//         target.classList.remove("text-danger");
//         if(value>=10)
//         {
//             target.classList.add("text-success");
//             const update={
//                 "discipline":parentElement.parentElement.dataset.discipline,
//                 "ressource":value
//             };
//             let pos=send["updates"].findIndex(se=>se?.discipline==update.discipline);
//             console.log(pos);
//             if (pos==-1) {
//                 send["updates"].push(update);
//                 return;
//             }
//             send['updates'][pos].ressource=value;

//         }
//         else
//         {
//             target.classList.add("text-danger");
//         }
//         // console.log(send["updates"]);
//         // $send={
            
//         // }
//     })
// })