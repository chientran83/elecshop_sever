import Vue from 'vue'
import App from './App.vue'
import VueRouter from 'vue-router'
import { routes } from './routes'
import getCookie from './components/component/getCookie'
import {getApi} from './components/component/getApi'

Vue.config.productionTip = false

Vue.prototype.$hostname = 'http://localhost:8000'
var hostname = 'http://localhost:8000'

Vue.prototype.$verifyLogin = ()=>{
  var getCookies = getCookie.getCookie('elecshop_login');
    return getApi(hostname +'/api/v1/users/user_login',"")
      .then(res => {
          if(getCookies == "" || res.code == 404 || res.message){
            return {
              success:false
            }
          }else{
              return {
                success:true,
                data: res.data,
                token: getCookies
              }
          }
      })
}

Vue.use(VueRouter)
const router = new VueRouter({
  routes
})

new Vue({
  router,
  render: h => h(App),
}).$mount('#app')
