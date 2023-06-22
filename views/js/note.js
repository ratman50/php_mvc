const id_classe=header.dataset.eleve;
console.log(id_classe);
const tab=[
    {"name":1,"libelle":"premier"},
    {"name":2,"libelle":"premier"},
    {"name":3, "libelle":"troisième"}
]
lister(`${hostname}/eleve/get/${id_classe}`,header, (result, header)=>{
    console.log(result);
    effectif.textContent=result.effectif;
    name_eleve.textContent=result.eleve.prenom+' '+result.eleve.nom;
    name_classe.textContent=result.eleve.nom_classe;
    name_classe.dataset.classe=result.eleve.classe;
    date_naiss.textContent=result.eleve.date_naiss;
    annee.textContent=result.eleve.name_scol;
    lister(`${hostname}/semestre/list/${result.eleve.classe}`, semestre, (result, semestre)=>{
        console.log(result);
        const libelle_semestre=result.periode_active.libelle_semestre;
        const pos=libelle_semestre.slice(libelle_semestre.length-2,libelle_semestre.length);
        const position=tab.find(el=>el.name==+pos);
        console.log(position);
        semestre.innerHTML=position.libelle+" "+libelle_semestre.slice(0, libelle_semestre.length-1);
    })
});

// console.log(name_classe.dataset.classe);
