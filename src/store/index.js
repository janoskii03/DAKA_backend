import { createStore } from 'vuex'

export default createStore({
  state: {
    isLogin:false,
    isLoginOpen:true,
    member: {},
    userTokenKey: "user_token",
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
      localStorage.clear(state.userTokenKey, state.member.addId);
    },
    setToStorage(state) {
      localStorage.setItem(state.userTokenKey, state.member.addId);
    },
  },
  actions: {
  },
  modules: {
  }
})
