<template>
  <div>
    <Form v-show="modals.index">
      <template v-slot:form_query>
        <button class="btn btn-dark member_add" type="submit" @click="showModal('addMember')">
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
          <tr v-for="(item, index) in dataList" :key="item.index" @click="memberInfo(index)">
            <td>{{ item.mname }}</td>
            <td>{{ item.mem_no }}</td>
            <td>{{ item.grade }}</td>
            <td>{{ item.mobile }}</td>
            <td>{{ item.remain }}</td>
            <td>{{ item.value }}</td>
          </tr>
        </table>


      </template>
    </Form>
  </div>
  <!---------------------會員資料------------------------------  -->

  <div class="member_data" v-show="modals.info">
    <div class="management_all" >
      <div class="title">{{ memInfo.grade }}{{ memInfo.mname }}</div>
      <div class="gold">
        <div class="buy"><span>儲值金:</span>{{ memInfo.remain }}<span>元</span></div>
        <div class="spend"><span>當年度累積消費金額:</span>{{ memInfo.value }}<span>元</span></div>
      </div>
      <div class="member_infor">

        <div class="infor">
          <img src="../assets/images/member/pen_icon.png" alt="編輯" class="pen" @click="showModal('edit')">
          <div class="first">
            <label for="name"> 姓名<input type="text" class="name" id="name" :value="memInfo.mname"></label>
            <label for="password">密碼<input type="text" class="password" id="password" ></label>
          </div>
          <div class="second">

            <label for="phone">電話<input type="text" class="phone" id="phone" :value="memInfo.mobile"></label>
            <label for="birthday">生日<input type="text" class="birthday" id="birthday"></label>
          </div>
          <div class="third">
            <label for="mail">信箱<input type="text" class="mail" id="mail"></label>
          </div>
          <div class="barcode">
            <img src="../assets/images/member/barcode.png" alt="條碼">{{ management_all.mem_no }}
          </div>
          <button class="confirm"  @click="showModal('info')">確認</button>

        </div>
      </div>
    </div>
  </div>
  <!-- ------------------------會員編輯---------------------------------------- -->
  <div class="member_edit" v-show="modals.edit">
    <div class="management_all">
     
      <div class="title">{{ memInfo.grade }}{{ memInfo.mname }}</div>
      <div class="gold">
        <div class="buy"><span> 我是編輯--儲值金:</span>{{ memInfo.remain }}<span>元</span></div>
        <div class="spend"><span> 當年度累積消費金額:</span>{{ memInfo.value }}<span>元</span></div>
      </div>
      <div class="member_infor">
        <div class="infor">
          <img src="../assets/images/member/pen_icon.png" alt="編輯" class="pen" >
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
          <button class="confirm" @click="handleEditConfirm">確認</button>

        </div>
      </div>
    </div>
  </div>



  <!-- ----------------------------修改成功-------------------------------- -->
  <div class="revise" v-show="modals.editSuccess">
    <div class="back">
      <div class="text">
        修改成功！
      </div>

      <button class="confirm" @click="showModal('editSuccess')">返回</button>
    </div>
  </div>

  <!-- -------------------------會員儲值----------------------------------------- -->
  <div class="member_deposit" v-show="modals.deposit">
    <div class="management_all">
      <div class="title">{{ management_all.grade }}{{ management_all.ename }}</div>
      <div class="gold">
        <div class="buy"><span>儲值金:</span>{{ management_all.remain }}<span>元</span></div>
        <div class="spend"><span>當年度累積消費金額:</span>{{ management_all.value }}<span>元</span></div>
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
          <button class="confirm" @click="handleDepositConfirm">確認儲值</button>

        </div>
      </div>
    </div>
  </div>
  <!-- -----------------------儲值成功-------------------------------- -->

  <div class="revise" v-show="modals.depositSuccess">
    <div class="back">
      <div class="text">
        儲值成功
      </div>

      <button class="confirm" @click="showModal('depositSuccess')">確認</button>
    </div>
  </div>
  <!-- -----------------------新增會員---------------------------- -->
  <div class="member_edit" v-show="modals.addMember">
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
          <button class="confirm"  @click="handleAddConfirm">確認</button>

        </div>
      </div>
      <button class="com_x_btn" @click="closeModal1" style="margin-left: 265px;">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
  </div>
  <!-- --------------------確認新增-------------------------- -->
  <div class="add_confirm" v-show="modals.addMemberSuccess">
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
        grade: '白金會員_',
        mname: '周杰倫',
        remain: '5600',
        value: '3670',
        mem_no: '1234567890ABCD',
        add: '新增會員',
      },
      memInfo: [],
      dataList: [
        {
          mname: 1,
          mem_no: 1,
          grade: 1,
          mobile: '',
          remain: 11,
          value: 1
        },
        {
          mname: 2,
          mem_no: 1,
          grade: 1,
          mobile: '',
          remain: 11,
          value: 1
        },
        {
          mname: 3,
          mem_no: 1,
          grade: 1,
          mobile: '',
          remain: 11,
          value: 1
        },
        {
          mname: 4,
          mem_no: 1,
          grade: 1,
          mobile: '',
          remain: 11,
          value: 1
        },
        {
          mname: 5,
          mem_no: 1,
          grade: 1,
          mobile: '',
          remain: 11,
          value: 1
        },
        {
          mname: 6,
          mem_no: 1,
          grade: 1,
          mobile: '',
          remain: 11,
          value: 1
        },
        {
          mname: 7,
          mem_no: 1,
          grade: 1,
          mobile: '',
          remain: 11,
          value: 1
        },
        {
          mname: 8,
          mem_no: 1,
          grade: 1,
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
      modals: {
        index:true,
        info:false,
        edit: false,
        editSuccess: false,
        deposit: false,
        depositSuccess: false,
        addMember: false,
        addMemberSuccess: false
      }
    }
  },
  methods: {
    memberInfo(index) {
      this.memInfo = this.dataList[index];
      this.showModal('info');
    },
    showModal(type) {
      this.modals[type] = !this.modals[type];
    },
    handleEditConfirm(){
      this.showModal('edit');
      this.showModal('editSuccess');
    },
    handleDepositConfirm(){
      this.showModal('deposit');
      this.showModal('depositSuccess');
    },
    handleAddConfirm(){
      this.showModal('addMember');
      this.showModal('addMemberSuccess');
    }
  }
}
</script>

