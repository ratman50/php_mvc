lister(`${hostname}/discipline/classe/${semestre.dataset.id}`, inputGroupDiscipline, createOption);
lister(`${hostname}/classe/type_eval/${inputGroupNote.dataset.id}`, inputGroupNote,(result, container)=>{
    result. forEach(element => {
        container.innerHTML+=`
            <option value="${element.id_type}"> ${element.type}</option>
        `;
    });
});
lister(`${hostname}/semestre/list/${semestre.dataset.id}`, dropdown_semestre, (result, container)=>{
    semestre.innerHTML="choisir une période";
    if (result.periode_active) {
        semestre.innerHTML=result.periode_active.libelle_semestre;
        semestre.dataset.semestre=result.periode_active.id_semestre;
    }
    container.innerHTML="";
    result.periodes.forEach(element => {
        container.innerHTML+=`
            <li class="dropdown-item semestre_item" style="cursor:pointer" data-semestre='${element.id_semestre}'>${element.libelle_semestre.toUpperCase()}</li>
        `;
    });

    container.querySelectorAll(".semestre_item").forEach(semestre_item=>{
        semestre_item.addEventListener("click",()=>{
            const update={
                semestre:semestre_item.dataset.semestre,
                "classe":dropdown_semestre.dataset.classe
            }
            requestOptions.body=JSON.stringify(update);
            fetch(`${hostname}/semestre/set`,requestOptions)
            .then(response=>response.json())
            .then(result=>{
                showModal(result);
                semestre.innerHTML=semestre_item.textContent;
                semestre.dataset.semestre=semestre_item.dataset.semestre;
                load_note_max(inputGroupDiscipline, inputGroupNote);

            });
        })
    })
    
});

save.disabled=true;
const type_notes=[];
[...inputGroupNote.options].forEach((option, pos)=>{
    if(option.value)
    {
        type_notes.push(
            {
                id:pos++,
                name:option.textContent
            }
        );
    }
});
function createOption(result, container) {
    container.innerHTML="<option value='' >CHOISIR</option>";
    result.data.forEach(element => {
        container.innerHTML+=`
            <option value="${element.id_info}"> ${element.desc_discipline}</option>
        `;
    });
}

inputGroupDiscipline.addEventListener("change",()=>{
    load_note_max(inputGroupDiscipline, inputGroupNote);
});
inputGroupNote.addEventListener("change",()=>{
    load_note_max(inputGroupDiscipline, inputGroupNote);

});
let tab_val=[];
save.addEventListener("click",()=>{
    document.querySelectorAll(".changed").forEach(change=>{
        let number=change.querySelector("input[type='number']");
        let check=change.querySelector("input[type='checkbox']");
        // const field=change.parentElement;
        const ligne={
            "eleve":number.dataset.eleve,
            "max_note":notes.dataset.max_note,
            "semestre":semestre.dataset.semestre,
            "value":number.value,
            "etat":check.checked?1:0
        };
        // console.log(ligne);
        change.classList.remove("changed");
        tab_val.push(ligne);
    });
    save.disabled=true;
    requestOptions.body=JSON.stringify(tab_val);
    fetch(`${hostname}/note/setval`, requestOptions)
    .then(response=>response.json())
    .then(result=>{
        showModal(result);
        tab_val=[];
        save.innerHTML=`  <i class="fa-solid fa-spinner fa-spin-pulse fa-spin-reverse"></i>`
        setTimeout(()=>{
            save.innerHTML="Enregister"
        },100)
    })

})
document.querySelectorAll(".note_val").forEach(noteVal=>{
    noteVal.addEventListener("input",(e)=>{
        const value=+e.target.value;
        const target=e.target;
        const parent=target.parentElement
        const val_max=+target.parentElement.querySelector("p").textContent;
        parent.classList.remove("changed");
        target.classList.remove("text-danger","text-success");
        save.disabled=true;
        if(value>=0 && value<=val_max){

            target.classList.add("text-success");
            parent.classList.add("changed");
            save.disabled=false;

        }
        else
        {
            target.classList.add("text-danger");

        }

    })
});
document.querySelectorAll(".exampes").forEach(exampe=>{
    exampe.addEventListener("change",()=>{
        const input=exampe.parentElement.querySelector("input");
        save.disabled=false;
        exampe.parentElement.classList.add("changed");
        if(!exampe.checked)
        {
            input.disabled=true;
            return;
        }
        input.disabled=false;
    })
})
function load_note_max(discipline, note) {
    
    if(discipline.value && note.value)
    {
        fetch(`${hostname}/discipline/load_id_discipline/${discipline.value}&${inputGroupNote.value}`)
        .then(response=>response.json())
        .then(result=>{
            if(result)
            {
                save.disabled=true;
                document.querySelectorAll("changed").forEach(change=>{
                    change.classList.remove("changed");
                })
                lister(`${hostname}/note/val/discipline=${inputGroupDiscipline.value}&type_note=${inputGroupNote.value}&semestre=${semestre.dataset.semestre}`,
                    document.querySelector(".input"),(result, container)=>{
                    const numbers=container.querySelectorAll("input[type='number']");
                    numbers.forEach(number=>{
                        const eleve=number.dataset.eleve;
                        const id_eleve=result.find(ev=>ev.eleve==eleve);
                        const check=number.parentElement.querySelector("input[type='checkbox']");
                        if(id_eleve)
                        {
                            number.value=id_eleve.val_note;
                            if(!id_eleve.etat)
                            {
                                check.checked=false;
                                number.disabled=true;
                            }
                        }else
                        {
                            number.value=0;
                            check.checked=true;
                            number.disabled=false;  

                        }
                    })
                }
                )

                notes.classList.add("active");
                setTimeout(()=>{
                    notes.querySelector(".input").classList.remove("d-none");
                    notes.querySelector(".input").classList.add("d-flex");
                    notes.dataset.max_note=result.id_max_note;
                    document.querySelectorAll(".note_max").forEach(note=>{
                        note.textContent=result.max_note;
                    })
                }, 500)

            }
        })
    }
}

