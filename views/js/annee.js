const url=  `${hostname}/annee/list`;

lister(url, container_annee, createCard_annee);

function createCard_annee(data, container) {
    container.innerHTML="";
    data.annees.forEach(element => {
        container.innerHTML+=`
        <!-- Content Column -->
        <div class="col-3 mb-4 ">
            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between ">
                    <form class="d-flex align-items-center" style="gap:10px" method="POST" action="/modifierAnnee">
                        <input type="hidden" name="id" value="${element["id"]}" />
                        <input type="text" name="name_scol" class="m-0 w-50 font-weight-bold text-primary border-0  val-annee"  value="${element["name_scol"]}"/>
                        ${
                            element["etat"] ? "<i  class='  text-success fa-regular fa-circle-check  ' style='top:26px;left:120px;'></i>":""

                        }
       
                    </form>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink" >
                            ${ element["etat"] ?
                                
                                `<button class="dropdown-item update" data-id="${element['id']}">desactiver</button>`
                                :
                                    `<button class="dropdown-item" data-id=${element['id']}">archiver</button>
                                    
                                <button class="dropdown-item update" data-id="${element['id']}">activer</button>
                                    <?php } ?>`
                            }
                                </div>
                            </div>
                        </div>
                   
                        <div class="card-body mb-3">
                            <h4 class="small font-weight-bold">Server Migration <span class="float-right">20%</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <h4 class="small font-weight-bold">Sales Tracking <span class="float-right">40%</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <h4 class="small font-weight-bold">Customer Database <span class="float-right">60%</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <h4 class="small font-weight-bold">Payout Details <span class="float-right">80%</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <h4 class="small font-weight-bold">Programmes <span class="float-right">Complete!</span></h4>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                   
                
                
            </div>
        </div>`;

        
    });
}

const obserserAnnee= new MutationObserver((mutationList, observer)=>{
    document.querySelectorAll(".update").forEach(item=>{
        item.addEventListener("click",()=>{
            fetch(`${hostname}/annee/set/${item.dataset.id}`)
            .then(response=>response.json())
            .then(result=>{
                showModal(result.message);
                lister(url, container_annee, createCard_annee);
                lister(`${hostname}/annee/list`, dropdown_annee, createItem);


            })
            
             
        })
    })
});

obserserAnnee.observe(container_annee, observerOptions);

