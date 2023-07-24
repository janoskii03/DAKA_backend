
<template>
  <div class="main_container">
    <aside>
      <img src="@/assets/images/logo.svg" alt="daka_logo" class="main_container_logo">
      <Row>
        <Col span="8">
        <Menu theme="" width="250px" class="main_menu">
          <router-link to="/member">
          <Submenu name="1" class="main_sub_one" @click="">
            <template #title>
              <img src="@/assets/images/customer.svg" alt="daka_logo" class="main_sub_one_img" to="/member.vue">
              會員管理
            </template>

          </Submenu>
        </router-link>
          <Submenu name="2" class="main_sub_two">
            <template #title>

              <img src="@/assets/images/calendar.svg" alt="daka_logo" class="main_sub_two_img">
              座位管理
            </template>
            <MenuItem name="2-1" class="main_submenu">即時安排座位</MenuItem>
            <MenuItem name="2-2" class="main_submenu">預約座位</MenuItem>
            <MenuItem name="2-3" class="main_submenu">資料查詢</MenuItem>
          </Submenu>
          <Submenu name="3" class="main_sub_three">
            <template #title>
              <img src="@/assets/images/news.svg" alt="daka_logo" class="main_sub_three_img">
              最新消息管理
            </template>

          </Submenu>
          <Submenu name="4" class="main_sub_four">
            <template #title>
              <img src="@/assets/images/comics.svg" alt="daka_logo" class="main_sub_four_img">
              漫畫租借管理
            </template>

            <MenuItem name="3-1" class="main_submenu">預約書籍</MenuItem>
            <MenuItem name="3-2" class="main_submenu">歸還書籍</MenuItem>
            <MenuItem name="3-3" class="main_submenu">訂單查詢</MenuItem>
            <MenuItem name="3-4" class="main_submenu">書籍資料</MenuItem>
            <MenuItem name="3-5" class="main_submenu">新書上架</MenuItem>

          </Submenu>
        </Menu>
        </Col>


      </Row>
      
      <div class="main_aside_bottom">
        <img src="@/assets/images/user.svg" alt="daka_user" class="bottom_img" >
        <span>林育緯</span>
      </div>
    </aside>
    <main>
      <header>
        <h2>
          會員管理
        </h2>
        <Space wrap>
            
            <Button type="" shape="circle" class="main_checkout">Sign Out</Button>
        </Space>
      </header>
      <Member></Member>
      <router-view></router-view>
      <footer>版權所有 © 2023 打咖 DAKA</footer>
    </main>
  </div>
</template>
<style scoped >
.main_container {
  width: 100%;
  height: 100vh;
  display: flex;
}

.main_sub_one .main_sub_one_img,
.main_sub_two .main_sub_two_img,
.main_sub_three .main_sub_three_img,
.main_sub_four .main_sub_four_img {
  width: 20px;
  height: 20px;
  margin-right: 0;
  ;
}


.main_container aside {

  width: 30%;
  display: flex;
  flex-direction: column;
  align-items: end;
  gap: 100px;
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



.ivu-menu-submenu:not(:last-child) {
  border-bottom: 1px solid #fff;

}

.main_container aside .main_container_logo {
  width: 193px;
  height: 46px;
margin-top: 40px;
  margin-right: 28px;
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

.main_container aside .main_aside_bottom .bottom_img{
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

.main_container main header .main_checkout{
background-color: rgba(38, 50, 56, 1);
color: rgba(255, 255, 255, 1);
margin-right: 100px;

}
.main_container footer{
  width: 100%;
  background-color: #fff;
  text-align: center;
  font-weight: 400;
padding: 20px 0;
}

</style>

<script>
import Member from '@/components/Member.vue'
export default {
  components: {
    Member
  },
  data() {
    return {
      nav: [
        {
          name: '會員管理',
          path: ''
        },
        {
          name: '座位管理',
          path: ''
        },
        {
          name: '最新消息管理',
          path: ''
        },
        {
          name: '漫畫租借管理',
          path: ''
        },
      ]


    }
  }
}
</script>
