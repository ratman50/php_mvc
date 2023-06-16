lister("http://localhost:8000/annee/list", dropdown_annee, createItem);


function createItem(data, container) {
    container.innerHTML="";
    data.annees.forEach(annee => {
        container.innerHTML+=`
            <li style="cursor:pointer"  data-id="${annee.id}" class="dropdown-item annee_item" >${annee.name_scol}</li>
        `
    });
    annee.innerHTML=data.cours ? data.cours.name_scol:"choisir une année";

    
}

const observerChange= new MutationObserver((mutationList, observer)=>{
    document.querySelectorAll(".annee_item").forEach(item=>{
        item.addEventListener("click",()=>{
            fetch(`http://localhost:8000/annee/set/${item.dataset.id}`)
            .then(response=>response.json())
            .then(result=>{
                showModal(result.message);
                lister("http://localhost:8000/annee/list", dropdown_annee, createItem);

            })
            
             
        })
    })
});

observerChange.observe(dropdown_annee, observerOptions);

