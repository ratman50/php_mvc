function lister(url, container, callback) {
    fetch(url)
    .then(response=>response.json())
    .then(data=>{
        callback(data, container);
    })
    .catch(err=>console.log(err))
}
const observerOptions = {
    childList: true, // Surveiller les modifications de la liste des enfants
    subtree: true, // Surveiller tous les descendants de l'élément parent
  };
var myHeaders = new Headers();

myHeaders.append("Content-Type", "application/json");
  
var requestOptions = {
    method: 'POST',
    headers: myHeaders,
  };
  
const hostname="http://localhost:8000";