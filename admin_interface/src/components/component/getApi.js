export const getApi = async (url,param,token) => {
    try {
        if(token != ""){
            var headers = {headers:{"Authorization" : "Bearer " + token,'Content-Type': 'application/json','Accept': 'application/json'}}  
        }else{
            var headers = {headers:{'Content-Type': 'application/json','Accept': 'application/json'}}
        }
        const response = await fetch(url + param, headers);
        const json = await response.json();
        return json;
    } catch {
        return {
        success: false,
        message: "There is an issue to get data from server. Please try again later.",
        };
    }
};