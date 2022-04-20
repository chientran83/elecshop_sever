export const getApi = (url,param,token) => {
    try {
        if(token != ""){
            var headers = {headers:{"Authorization" : "Bearer " + token,'Content-Type': 'application/json','Accept': 'application/json'}}  
        }else{
            var headers = {headers:{'Content-Type': 'application/json','Accept': 'application/json'}}
        }
        return fetch(url + param, headers)
            .then(res => res.json())
            .then(res => {  
                return res})
    } catch {
        return {
        success: false,
        message: "There is an issue to get data from server. Please try again later.",
        };
    }
};