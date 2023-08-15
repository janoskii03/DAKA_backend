import { createStore } from 'vuex'

export default createStore({
  state: {
    isLogin:false,
    isLoginOpen:true,
    member: {},
  },
  getters: {
  },
  mutations: {
    //給member物件
    setInfo(state, payload) {
      state.member = payload;
    },
     //確定登入
     loginOk(state, payload) {
      state.islogin = payload;
      state.isLoginOpen = false;
    },
    //關閉登入
    toggleLoginModal(state,payload){
      state.isLoginOpen = payload;
    },
    loginOut(state) {
      state.islogin = false;
      state.member = {};
    },
  },
  actions: {
  },
  modules: {
  }
})
