<template>
  <div>
    <Form>
      <template v-slot:form_query>
        <button class="btn btn-dark member_add" type="submit">
          新增會員
          <img src="@/assets/images/member/plus.svg" alt="plus" class="member_plus">
        </button>
        <select class="form-select w-25" aria-label="Default select example">
          <option selected>請選擇</option>
          <option value="1">One</option>
          <option value="2">Two</option>
          <option value="3">Three</option>
        </select>
        <input type="search">


      </template>
      <template v-slot:form_table>
        <table class="main_list">
          <tr>
            <th v-for="column in columns">{{ column }}</th>
          </tr>
          <tr v-for="(item, index) in dataList" :key="item.index" @click.prevent="memberInfo(index)">
            <td>{{ item.name }}</td>
            <td>{{ item.no }}</td>
            <td>{{ item.rank }}</td>
            <td>{{ item.mobile }}</td>
            <td>{{ item.remain }}</td>
            <td>{{ item.value }}</td>
          </tr>
        </table>


      </template>
    </Form>
  </div>
  <!---------------------會員資料------------------------------  -->
  <div class="member_data">
    <div class="management_all">
      <div class="title">{{ management_all.title }}</div>
      <div class="gold">
        <div class="buy">{{ management_all.buy }}</div>
        <div class="spend">{{ management_all.spend }}</div>
      </div>
      <div class="member_infor">

        <div class="infor">
          <img src="../assets/images/member/pen_icon.png" alt="編輯" class="pen">
          <div class="first">
            <label for="name"> 姓名<input type="text" class="name" id="name"></label>
            <label for="password">密碼<input type="text" class="password" id="password"></label>
          </div>
          <div class="second">

            <label for="phone">電話<input type="text" class="phone" id="phone"></label>
            <label for="birthday">生日<input type="text" class="birthday" id="birthday"></label>
          </div>
          <div class="third">
            <label for="mail">信箱<input type="text" class="mail" id="mail"></label>
          </div>
          <div class="barcode">
            <img src="../assets/images/member/barcode.png" alt="條碼">{{ management_all.mem_no }}
          </div>
          <button class="confirm">確認</button>

        </div>
      </div>
    </div>
  </div>
  <!-- ------------------------會員編輯---------------------------------------- -->
  <div class="member_edit">
    <div class="management_all">
      <div class="title">{{ management_all.title }}</div>
      <div class="gold">
        <div class="buy">{{ management_all.buy }}</div>
        <div class="spend">{{ management_all.spend }}</div>
      </div>
      <div class="member_infor">
        <div class="infor">
          <img src="../assets/images/member/pen_icon.png" alt="編輯" class="pen">
          <div class="first">
            姓名<input type="text" class="name">
            性別<select name="" id="sex">
              <option selected disabled hidden></option>
              <option>男</option>
              <option>女</option>
            </select>
          </div>
          <div class="second">
            電話<input type="text" class="phone">
            密碼<input type="text" class="password">
          </div>
          <div class="third">
            生日<input type="text" class="birthday">
            信箱<input type="text" class="mail">
          </div>
          地址<input type="text" class="address">
          <div class="barcode">
            <img src="../assets/images/member/barcode.png" alt="條碼">1234567890ABCD
          </div>
          <button class="confirm">確認</button>

        </div>
      </div>
    </div>
  </div>



  <!-- ----------------------------修改成功-------------------------------- -->
  <div class="revise">
    <div class="back">
      <div class="text">
        修改成功！
      </div>

      <button class="confirm">返回</button>
    </div>
  </div>

  <!-- -------------------------會員儲值----------------------------------------- -->
  <div class="member_deposit">
    <div class="management_all">
      <div class="title">{{ management_all.title }}</div>
      <div class="gold">
        <div class="buy">{{ management_all.buy }}</div>
        <div class="spend">{{ management_all.spend }}</div>
      </div>
      <div class="member_infor">

        <div class="infor">
          <p class="infor_text">充值儲值金</p>
          <select name="" id="gold">
            <option selected disabled hidden>請選擇</option>
            <option>100元</option>
            <option>200元</option>
            <option>500元</option>
            <option>1000元</option>
            <option>手動輸入</option>
          </select>
          <button class="confirm">確認儲值</button>

        </div>
      </div>
    </div>
  </div>
  <!-- -----------------------儲值成功-------------------------------- -->

  <div class="revise">
    <div class="back">
      <div class="text">
        儲值成功
      </div>

      <button class="confirm">確認</button>
    </div>
  </div>
  <!-- -----------------------新增會員---------------------------- -->
  <div class="member_edit">
    <div class="management_all" style="height: 360px;">
      <div class="title">{{ management_all.add }}</div>
      <div class="member_infor">
        <div class="infor">
          <img src="../assets/images/member/pen_icon.png" alt="編輯" class="pen">
          <div class="first">
            姓名<input type="text" class="name">
            性別<select name="" id="sex">
              <option selected disabled hidden></option>
              <option>男</option>
              <option>女</option>
            </select>
          </div>
          <div class="second">
            電話<input type="text" class="phone">
            密碼<input type="text" class="password">
          </div>
          <div class="third">
            生日<input type="text" class="birthday">
            信箱<input type="text" class="mail">
          </div>
          地址<input type="text" class="address">
          <div class="barcode">
            <img src="../assets/images/member/barcode.png" alt="條碼">1234567890ABCD
          </div>
          <button class="confirm">確認</button>

        </div>
      </div>
    </div>
  </div>
  <!-- --------------------確認新增-------------------------- -->
  <div class="add_confirm">
    <div class="back">
      <div class="text">
        確認新增？
      </div>
      <button class="yes">確定</button>
      <button class="no">取消</button>
    </div>
  </div>
</template>
<script>

import Form from '@/components/Form.vue';

export default {
  components: {
    Form
  },
  data() {
    return {
      management_all:
      {
        title: '白金會員_周杰倫',
        buy: '儲值金:5600元',
        spend: '當年度累積消費金額:3670元',
        mem_no: '1234567890ABCD',
        add: '新增會員',
      },
      memInfo: {
        name: '',
        no: '',
        rank: '',
        mobile: '',
        remain: '',
        value: ''
      },
      dataList: [
        {
          name: 1,
          no: 1,
          rank: 1,
          mobile: '',
          remain: 11,
          value: 1
        },
        {
          name: 2,
          no: 1,
          rank: 1,
          mobile: '',
          remain: 11,
          value: 1
        },
        {
          name: 3,
          no: 1,
          rank: 1,
          mobile: '',
          remain: 11,
          value: 1
        },
        {
          name: 4,
          no: 1,
          rank: 1,
          mobile: '',
          remain: 11,
          value: 1
        },
        {
          name: 5,
          no: 1,
          rank: 1,
          mobile: '',
          remain: 11,
          value: 1
        },
        {
          name: 6,
          no: 1,
          rank: 1,
          mobile: '',
          remain: 11,
          value: 1
        },
        {
          name: 7,
          no: 1,
          rank: 1,
          mobile: '',
          remain: 11,
          value: 1
        },
        {
          name: 8,
          no: 1,
          rank: 1,
          mobile: '',
          remain: 11,
          value: 1
        },
      ],
      columns: [
        '姓名',
        '會員編號',
        '會員等級',
        '手機號碼',
        '儲值餘額',
        '當年度累積消費金額'
      ],
      model: '',

    }
  },
  methods: {
    memberInfo(index) {
      let { name, no, rank, mobile, remain, value } = this.dataList[index];

      console.log(name, no, rank, mobile, remain, value);

    },


  }
}
</script>

