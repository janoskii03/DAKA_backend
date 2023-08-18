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
            <td>{{ item.ename }}</td>
            <td>{{ item.admin_no }}</td>
            <td>{{ item.branch }}</td>
            <td>{{ item.ejob }}</td>
            <td>{{ item.password }}</td>
          </tr>
        </table>


      </template>
    </Form>
  </div>
  <!---------------------員工資料------------------------------  -->

  <div class="account_data" v-show="modals.info">
    <div class="management_all">
      <button class="com_x_btn" @click="showModal('info')">
        <i class="fa-solid fa-xmark"></i>
      </button>
      <div class="title">帳號管理_{{ memInfo.ename }}</div>
      <div class="member_infor">

        <div class="infor" style="position: relative;">
          <button class="pen_box" style="position: absolute; border: none;"><img
              src="../assets/images/member/pen_icon.png" alt="編輯" class="pen" @click="showModal('edit')"
              style="position: absolute; right: -465px; top: -18px;"></button>
          <div class="first">
            <label for="name"> 姓名<input type="text" class="name" id="name" :value="memInfo.ename"
                :disabled="isReadOnly"></label>
            <label for="password">分館<input type="text" class="password" id="password" :disabled="isReadOnly"
                :value="memInfo.branch"></label>
          </div>
          <div class="second">

            <label for="phone">編號<input type="text" class="phone" id="phone" :value="memInfo.admin_no"
                :disabled="isReadOnly"></label>
            <label for="birthday">職稱<input type="text" class="birthday" id="birthday" :value="memInfo.ejob"
                :disabled="isReadOnly"></label>
          </div>
          <div class="third">
            <label for="mail">密碼<input type="text" class="mail" id="mail" :value="memInfo.password"
                :disabled="isReadOnly"></label>
          </div>
          <div class="barcode">
            <img src="../assets/images/member/barcode.png" alt="條碼">1234567890ABCD
          </div>
          <button class="confirm" @click="showModal('info')">確認</button>

        </div>
      </div>
    </div>
  </div>
  <!-- ------------------------員工編輯---------------------------------------- -->
  <div class="account_edit" v-show="modals.edit">
    <div class="management_all">
      <button class="com_x_btn" @click="showModal('edit')">
        <i class="fa-solid fa-xmark"></i>
      </button>

      <div class="title">帳號編輯_{{ memInfo.ename }}</div>
      <div class="member_infor">
        <div class="infor">
          <img src="../assets/images/member/pen_icon.png" alt="編輯" class="pen">
          <div class="first">
            姓名<input type="text" class="name" v-model="memInfo.ename">
            分館<input type="text" class="password" v-model="memInfo.branch">

          </div>
          <div class="second">
            編號<input type="text" class="phone" v-model="memInfo.admin_no">
            職稱<input type="text" class="password" v-model="memInfo.ejob">
          </div>
          <div class="third">
            密碼<input type="text" class="address" v-model="memInfo.password">
          </div>
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

  <!-- -----------------------新增帳號---------------------------- -->
  <div class="account_edit" v-show="modals.addMember" id="acc_add">
    <div class="management_all" style="height: 360px;">
      <button class="com_x_btn" @click="handleAddMember">
        <i class="fa-solid fa-xmark"></i>
      </button>
      <div class="title">新增帳號</div>
      <div class="member_infor">
        <div class="infor">
          <img src="../assets/images/member/pen_icon.png" alt="編輯" class="pen">
          <div class="first">
            姓名<input type="text" class="name" v-model="newMember.ename">
            分館<input type="text" class="password" v-model="newMember.branch">

          </div>
          <div class="second">
            編號<input type="text" class="phone" v-model="newMember.admin_no">
            職稱<input type="text" class="password" v-model="newMember.ejob">
          </div>
          <div class="third">
            密碼<input type="text" class="address" v-model="newMember.password">
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
      <button class="yes" @click="addMemberData">確定</button>
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
      searchInput: '',
      columns: [
        '姓名',
        '員工編號',
        '分館',
        '職稱',
        '密碼',
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
      dataList: [],
      SearchData: [],
      newMember: {
        ename: null,
        branch: null,
        admin_no: null,
        ejob: null,
        password: null,
      },
    }
  },
  computed: {

  },
  methods: {
    memberInfo(index) {
      this.memInfo = this.memberData[index];
      this.showModal('info');
      console.log( this.memInfo);
    },
    showModal(type) {
      this.modals[type] = !this.modals[type];
    },
    handleEditConfirm() {
      this.showModal('info');
      this.showModal('edit');
      this.showModal('editSuccess');
      this.updateAccountData();
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
    toggleReadOnly() {
      this.isReadOnly = !this.isReadOnly;
    },
    fetchMemberData() {
      axios.get(`${this.$URL}/getAdministrator.php`)
        .then((res) => {
          console.log(res);
          this.memberData = res.data;
        })
        .catch((err) => {
          console.log(err);
        })
    },
    updateAccountData() {

      const editData = {
        admin_id: this.memInfo.admin_id,
        ename: this.memInfo.ename,
        branch: this.memInfo.branch,
        admin_no: this.memInfo.admin_no,
        ejob: this.memInfo.ejob,
        password: this.memInfo.password,
      };
      console.log('發送會員資料');

      axios.post(`${this.$URL}/updateAccountData.php`, JSON.stringify(editData))
        .then(res => {
          console.log(res);
          console.log('修改成功');
        })
        .catch(err => {
          console.log(err);
        })
    },
    addMemberData() {
      console.log('發送會員資料');
      this.showModal('addMemberSuccess');
      this.axios.post(`${this.$URL}/addAdminData.php`, JSON.stringify(this.newMember))
        .then(res => {
          console.log(res);
        })
        .catch(err => {
          console.log(err);
        })
    }
  },
  mounted() {
    this.fetchMemberData();
  }
}
</script>

