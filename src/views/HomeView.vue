<style scoped>
.layout {
  border: 1px solid #d7dde4;
  background: #f5f7f9;
  position: relative;
  border-radius: 4px;
  overflow: hidden;
}

.layout-header-bar {
  background: #fff;
  box-shadow: 0 1px 1px rgba(0, 0, 0, .1);
}

.menu-item span {
  display: inline-block;
  overflow: hidden;
  width: 69px;
  text-overflow: ellipsis;
  white-space: nowrap;
  vertical-align: bottom;
  transition: width .2s ease .2s;
}

.layout-footer-center {
  text-align: center;
}
</style>
<template>
  <div class="layout">
    <Layout>

      <Sider hide-trigger :style="{ background: '#fff' }">
        <Menu active-name="1-2" theme="light" width="auto" :open-names="['1']">
          <Submenu name="1">
            <template #title>
              <Icon type="ios-navigate"></Icon>
              Item 1
            </template>
            <MenuItem name="1-1">Option 1</MenuItem>
            <MenuItem name="1-2">Option 2</MenuItem>
            <MenuItem name="1-3">Option 3</MenuItem>
          </Submenu>
          <Submenu name="2">
            <template #title>
              <Icon type="ios-keypad"></Icon>
              Item 2
            </template>
            <MenuItem name="2-1">Option 1</MenuItem>
            <MenuItem name="2-2">Option 2</MenuItem>
          </Submenu>
          <Submenu name="3">
            <template #title>
              <Icon type="ios-analytics"></Icon>
              Item 3
            </template>
            <MenuItem name="3-1">Option 1</MenuItem>
            <MenuItem name="3-2">Option 2</MenuItem>
          </Submenu>
        </Menu>
      </Sider>
      <Layout>
        <Header class="layout-header-bar"></Header>

        <Content :style="{ margin: '20px', background: '#fff', minHeight: '100vh' }">
          Content
        </Content>
        <Footer class="layout-footer-center">版權所有 © 2023 打咖 DAKA</Footer>
      </Layout>
    </Layout>
  </div>
</template>

<script>
export default {
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
