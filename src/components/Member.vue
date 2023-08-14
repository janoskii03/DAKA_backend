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
        <div class="col-md-2">
          <div class="input-group">
            <input type="search" class="form-control" v-model="searchInput" @input="performSearch" placeholder="請輸入"
              aria-describedby="basic-addon1" />
            <button class="input-group-text" id="basic-addon1">
              <img @click="performSearch" src="@/assets/images/search.svg" alt="search" />
            </button>
          </div>
        </div>


      </template>
      <template v-slot:form_table>
        <table class="main_list">
          <tr>
            <th v-for="column in columns">{{ column }}</th>
          </tr>
          <tr v-for="(item, index) in memberData" :key="item.index" @click="memberInfo(index)">
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
    <div class="management_all">
      <button class="com_x_btn" @click="showModal('info')">
        <i class="fa-solid fa-xmark"></i>
      </button>
      <div class="title">{{ memInfo.grade }}{{ memInfo.mname }}</div>
      <div class="gold">
        <div class="buy"><span>儲值金:</span>{{ memInfo.remain }}<span>元</span></div>
        <div class="spend"><span>當年度累積消費金額:</span>{{ memInfo.value }}<span>元</span></div>
      </div>
      <div class="member_infor">

        <div class="infor" style="position: relative;">
          <button class="pen_box" style="position: absolute; border: none;"><img
              src="../assets/images/member/pen_icon.png" alt="編輯" class="pen" @click="showModal('edit')"
              style="position: absolute; right: -465px; top: -23px;"></button>
          <div class="first">
            <label for="name"> 姓名<input type="text" class="name" id="name" :value="memInfo.mname"></label>
            <label for="password">密碼<input type="text" class="password" id="password" :value="memInfo.password"></label>
          </div>
          <div class="second">

            <label for="phone">電話<input type="text" class="phone" id="phone" :value="memInfo.mobile"></label>
            <label for="birthday">生日<input type="text" class="birthday" id="birthday"
                :value="memInfo.member_birth"></label>
          </div>
          <div class="third">
            <label for="mail">信箱<input type="text" class="mail" id="mail" :value="memInfo.email"></label>
          </div>
          <div class="barcode">
            <img src="../assets/images/member/barcode.png" alt="條碼">1234567890ABCD
          </div>
          <button class="confirm" @click="showModal('info')">確認</button>

        </div>
      </div>
    </div>
  </div>
  <!-- ------------------------會員編輯---------------------------------------- -->
  <div class="member_edit" v-show="modals.edit">
    <div class="management_all">
      <button class="com_x_btn" @click="showModal('edit')">
        <i class="fa-solid fa-xmark"></i>
      </button>

      <div class="title">{{ memInfo.grade }}{{ memInfo.mname }}</div>
      <div class="gold">
        <div class="buy"><span>儲值金:</span>{{ memInfo.remain }}<span>元</span></div>
        <div class="spend"><span> 當年度累積消費金額:</span>{{ memInfo.value }}<span>元</span></div>
      </div>
      <div class="member_infor">
        <div class="infor">
          <img src="../assets/images/member/pen_icon.png" alt="編輯" class="pen">
          <div class="first">
            姓名<input type="text" class="name" :value="memInfo.mname">
            性別<select name="" id="sex" :value="memInfo.sex">
              <option selected disabled hidden></option>
              <option>男</option>
              <option>女</option>
            </select>
          </div>
          <div class="second">
            電話<input type="text" class="phone" :value="memInfo.mobile">
            密碼<input type="text" class="password" :value="memInfo.password">
          </div>
          <div class="third">
            生日<input type="text" class="birthday" :value="memInfo.member_birth">
            信箱<input type="text" class="mail" :value="memInfo.email">
          </div>
          地址<input type="text" class="address" :value="memInfo.address">
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

  <!-- -------------------------會員儲值-----------------------------------------
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
  </div> -->
  <!-- -----------------------儲值成功-------------------------------- -->
  <!-- <div class="revise" v-show="modals.depositSuccess">
    <div class="back">
      <div class="text">
        儲值成功
      </div>

      <button class="confirm" @click="showModal('depositSuccess')">確認</button>
    </div>
  </div> -->
  <!-- -----------------------新增會員---------------------------- -->
  <div class="mem_add" v-show="modals.addMember">
    <div class="management_all" style="height: 360px;">
      <button class="com_x_btn" @click="handleAddMember">
        <i class="fa-solid fa-xmark"></i>
      </button>
      <div class="title">新增會員</div>
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
          <button class="confirm" @click="handleAddConfirm">確認</button>

        </div>
      </div>
    </div>
  </div>
  <!-- --------------------確認新增-------------------------- -->
  <div class="add_confirm" v-show="modals.addMemberSuccess">
    <div class="back">
      <div class="text">
        確認新增？
      </div>
      <button class="yes" @click="showModal('addMemberSuccess')">確定</button>
      <button class="no" @click="showModal('addMemberSuccess')">取消</button>
    </div>
  </div>
</template>
<script>

import Form from '@/components/Form.vue';
import axios from 'axios';
export default {
  components: {
    Form
  },
  data() {
    return {
      memInfo: [],
      columns: [
        '姓名',
        '會員編號',
        '會員等級',
        '手機號碼',
        '儲值餘額',
        '當年度累積消費金額'
      ],
      modals: {
        index: true,
        info: false,
        edit: false,
        editSuccess: false,
        deposit: false,
        depositSuccess: false,
        addMember: false,
        addMemberSuccess: false
      },
      memberData: [],
    }
  },
  methods: {
    memberInfo(index) {
      this.memInfo = this.memberData[index];
      this.showModal('info');
    },
    showModal(type) {
      this.modals[type] = !this.modals[type];
    },
    handleEditConfirm() {
      this.showModal('edit');
      this.showModal('editSuccess');
    },
    handleDepositConfirm() {
      this.showModal('deposit');
      this.showModal('depositSuccess');
    },
    handleAddConfirm() {
      this.showModal('addMember');
      this.showModal('addMemberSuccess');
    },
    handleAddMember() {
      this.showModal('addMember');

    },
    fetchMemberData() {
      axios.get(`${this.$URL}/getMember.php`)
        .then((res) => {
          console.log(res);
          this.memberData = res.data;
        })
        .catch((err) => {
          console.log(err);
        })
    }
  },
  mounted() {
    this.fetchMemberData();
  }
}
</script>

