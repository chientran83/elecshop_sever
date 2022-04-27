import getCookie from "./getCookie";

export const getApi = (url,param) => {
    var token = getCookie.getCookie('elecshop_login');
    var headers = {headers:{"Authorization" : "Bearer " + token,'Content-Type': 'application/json','Accept': 'application/json'}}
    var hostname = 'http://localhost:8000/';
    return fetch(hostname + url + param, headers)
        .then(res => res.json())
        .then(res => {
            return res})
        .catch(()=>{
            return {
                success: false,
                message: "There is an issue to get data from server. Please try again later.",
            };
        })
};