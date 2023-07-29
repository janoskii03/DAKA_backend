
<template>
  <!-- <Login v-if="!$store.state.isLogging"></Login> -->

  <div class="main_container d-flex">
    <aside class="col-4 d-flex flex-column align-items-center">

      <img src="@/assets/images/logo.svg" alt="daka_logo" class="main_container_logo" @click="this.$router.push('/')">

      <div class="accordion accordion-flush w-100 mt-5 main_nav " id="accordionFlushExample">
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed main_nav_btn fs-4" @click="this.$router.push('/member')">
        <img src="@/assets/images/customer.svg" alt="daka_logo" class="main_sub_one_img" to="/member.vue">
        會員管理
      </button>
    </h2>
   
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed main_nav_btn fs-4" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
        <img src="@/assets/images/calendar.svg" alt="daka_logo" class="main_sub_two_img">
        座位管理
      </button>
    </h2>
    <div id="flush-collapseTwo" class="accordion-collapse collapse nav_btn_inside" data-bs-parent="#accordionFlushExample" style="
    background-color: #263238 ">
      <div class="accordion-body nav_btn_inside fs-5" style="
    color: #fff "><a >即時安排座位</a></div>
      <div class="accordion-body nav_btn_inside fs-5" style="
    color: #fff "><a >預約座位</a></div>
      <div class="accordion-body nav_btn_inside fs-5" style="
    color: #fff "><a >資料查詢</a></div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed main_nav_btn fs-4" >
        <img src="@/assets/images/news.svg" alt="daka_logo" class="main_sub_three_img">
        最新消息管理
      </button>
    </h2>
    
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed main_nav_btn fs-4" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
        <img src="@/assets/images/comics.svg" alt="daka_logo" class="main_sub_four_img">
        漫畫租借管理
      </button>
    </h2>
    <div id="flush-collapseFour" class="accordion-collapse collapse nav_btn_inside" data-bs-parent="#accordionFlushExample" style="
    background-color: #263238 ">
      <div class="accordion-body fs-5" style="
    color: #fff "><a >預約書籍</a></div>
      <div class="accordion-body fs-5"  style="
    color: #fff"><a>歸還書籍</a></div>
      <div class="accordion-body fs-5"  style="
    color: #fff "><a>訂單查詢</a>
    </div>
      <div class="accordion-body fs-5" style="
    color: #fff "><a >書籍資料</a></div>
      <div class="accordion-body fs-5" style="
    color: #fff "><a >新書上架</a></div>
    
     




    </div>
  </div>
</div>
    

      <div class="main_aside_bottom">
        <img src="@/assets/images/user.svg" alt="daka_user" class="bottom_img">
        <span>林育緯</span>
      </div>
    </aside>
    <main>
      <header>
        <h2>
          {{ title }}
        </h2>
        

          <Button  class="main_checkout" @click.prevent="signOut">Sign Out</Button>
       
      </header>
      <router-view></router-view>
      <footer>版權所有 © 2023 打咖 DAKA</footer>
    </main>
  </div>
</template>
<style scoped lang="scss">
.main_container {
  width: 100%;
  height: 100vh;
  

  .main_nav{
    color: #fff;

    .main_nav_btn{
  background-color: #263238;
  color: #fff;
  font-size: 1.2rem; 
}
  }
}

.main_sub_one_img,
.main_sub_two_img,
.main_sub_three_img,
.main_sub_four_img {
 margin-right: 10px;
}


.main_container aside {
  margin:0 auto;
  background-color: #263238;

}

.main_container aside .main_menu {
  color: #fff;
  font-size: 1.3rem;

}


.main_container aside .main_submenu {
  color: #fff;
  font-size: 1.1rem;
}





.main_container aside .main_container_logo {
  width: 100%;
  height: 46px;
 margin-top: 100px;
 cursor: pointer;
}



.main_container aside .main_aside_bottom {
  display: flex;
  align-items: center;
  margin-top: auto;
  margin-right: 100px;
  font-size: 1.3rem;
  color: #fff;
  margin-bottom: 20px;
  font-weight: 400;
}

.main_container aside .main_aside_bottom .bottom_img {
  width: 44px;
  height: 44px;
  margin-right: 5px;
}

.main_container main {
  width: 70%;

  display: flex;
  flex-direction: column;
  justify-content: space-between;
  background-color: rgba(248, 248, 248, 1);

}

.main_container main header {
  display: flex;
  background-color: #fff;
  justify-content: space-between;
  align-items: center;
}

.main_container main header h2 {
  font-size: 2.5rem;
  padding: 20px 40px;
}

.main_container main header .main_checkout {
  background-color: rgba(38, 50, 56, 1);
  color: rgba(255, 255, 255, 1);
  margin-right: 30px;

}

.main_container footer {
  width: 100%;
  background-color: #fff;
  text-align: center;
  font-weight: 400;
  padding: 20px 0;
}
</style>

<script>
import Member from '@/components/Member.vue'
import Login from '@/components/Login.vue'



export default {
  components: {
    Member, Login
  },
  data() {
    return {
      current: '首頁',
      nav: [
        {
          name: '首頁',
          path: '/',

        },
        {
          name: '會員管理',
          path: '/member',

        },
        {
          name: '座位管理',
          path: '/seat',

        },
        {
          name: '最新消息管理',
          path: '/news',

        },
        {
          name: '漫畫租借管理',
          path: '/comics',

        },
      ]


    }
  },
  computed: {
    title() {

      for (let i = 0; i < this.nav.length; i++) {
        if (this.nav[i].path == this.$route.path) {

          this.current = this.nav[i].name;
        } else {
          this.current;
        }
      }
      return this.current;
    },
    methods: {
      signOut() {
        this.$store.state.isLogging = false;
      }
    }
  }
}
</script>
