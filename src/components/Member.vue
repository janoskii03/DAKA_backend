<template>
  <div>
    <Form v-show="modals.index">
      <template v-slot:form_query>
        <button class="btn btn-dark member_add" type="submit" @click="showModal('addMember')">
          新增會員
          <img src="@/assets/images/member/plus.svg" alt="plus" class="member_plus">
        </button>
        <div class="col-md-2">
          <div class="input-group">
            <input type="search" class="form-control" v-model="searchInput" @input="performSearch" placeholder="請輸入電話號碼"
              aria-describedby="basic-addon1" />
            <button class="input-group-text" id="basic-addon1">
              <img src="@/assets/images/search.svg" alt="search" @input="performSearch" />
            </button>
          </div>
        </div>


      </template>
      <template v-slot:form_table>
        <table class="main_list">
          <tr>
            <th v-for="column in columns">{{ column }}</th>
          </tr>
          <tr v-for="(item, index) in filteredDataList" :key="index" @click="memberInfo(index)">
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

  <div class="member_data" v-show="modals.info" id="member_data">
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
            <label for="name"> 姓名<input type="text" class="name" id="name" :value="memInfo.mname" name="mname" readonly></label>
            <label for="password">密碼<input type="text" class="password" id="password" :value="memInfo.password"
                name="password" readonly></label>
          </div>
          <div class="second">

            <label for="phone">電話<input type="text" class="phone" id="phone" :value="memInfo.mobile"
                name="mobile" readonly></label>
            <label for="birthday">生日<input type="text" class="birthday" id="birthday" :value="memInfo.member_birth"
                name="member_birth" readonly></label>
          </div>
          <div class="third">
            <label for="mail">信箱<input type="text" class="mail" id="mail" :value="memInfo.email" name="email" readonly></label>
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
  <div class="member_edit" v-show="modals.edit" id="member_edit">
    <div class="management_all">
      <button class="com_x_btn" @click="closeEdit">
        <i class="fa-solid fa-xmark"></i>
      </button>

      <div class="title" >{{ memInfo.grade }}{{ memInfo.mname }}</div>
      <div class="gold">
        <div class="buy"><span>儲值金:</span>{{ memInfo.remain }}<span>元</span></div>
        <div class="spend"><span> 當年度累積消費金額:</span>{{ memInfo.value }}<span>元</span></div>
      </div>
      <div class="member_infor">
        <div class="infor">
          <img src="../assets/images/member/pen_icon.png" alt="編輯" class="pen">
          <div class="first">
            姓名<input type="text" class="name"  name="mname" v-model="memInfo.mname">
            性別<select name="sex" id="sex" v-model="memInfo.sex">
              <option selected disabled hidden></option>
              <option value="男">男</option>
              <option value="女">女</option>
            </select>
          </div>
          <div class="second">
            電話<input type="text" class="phone" v-model="memInfo.mobile" name="mobile">
            密碼<input type="text" class="password" v-model="memInfo.password" name="password">
          </div>
          <div class="third">
            生日<input type="text" class="birthday" v-model="memInfo.member_birth" name="member_birth">
            信箱<input type="text" class="mail" v-model="memInfo.email" name="email">
          </div>
          地址<input type="text" class="address" v-model="memInfo.address" name="address">
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
  <div class="mem_add" v-show="modals.addMember" id="mem_add">
    <div class="management_all" style="height: 360px;">
      <button class="com_x_btn" @click="handleAddMember">
        <i class="fa-solid fa-xmark"></i>
      </button>
      <div class="title">新增會員</div>
      <div class="member_infor">
        <div class="infor">
          <img src="../assets/images/member/pen_icon.png" alt="編輯" class="pen">
          <div class="first">
            姓名<input type="text" class="name" v-model="newMember.mname">
            性別<select name="sex" id="sex" v-model="newMember.sex">
              <option selected disabled hidden></option>
              <option value="男">男</option>
              <option value="女">女</option>
            </select>
          </div>
          <div class="second">
            電話<input type="text" class="phone" v-model="newMember.mobile">
            密碼<input type="text" class="password" v-model="newMember.password">
          </div>
          <div class="third">
            生日<input type="text" class="birthday" v-model="newMember.member_birth">
            信箱<input type="text" class="mail" v-model="newMember.email">
          </div>
          地址<input type="text" class="address" v-model="newMember.address">
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
      filteredDataList: [],
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

      SearchData: [],
      newMember: {
        mname: null,
        sex: null,
        mobile: null,
        password: null,
        member_birth: null,
        email: null,
        address: null,
      },
    }
  },
  computed: {

  },
  methods: {
    performSearch() {
      if (this.searchInput === '') {
        alert('請輸入關鍵字');
        return;
      } else {
        this.filteredDataList = this.memberData.filter(item => {
          return item.mobile.includes(this.searchInput);
        });
      }
    },
    


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
     
       const editData = {
        mem_id:this.memInfo.mem_id,
        mname: this.memInfo.mname,
        sex: this.memInfo.sex,
        mobile: this.memInfo.mobile,
        password: this.memInfo.password,
        member_birth: this.memInfo.member_birth,
        address: this.memInfo.address,
        email: this.memInfo.email,
      };
      console.log('發送會員資料');

      axios.post(`${this.$URL}/updateMemberData.php`, JSON.stringify(editData))
        .then(res => {
          console.log(res);
        })
        .catch(err => {
          console.log(err);
        })
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
    closeEdit(){
      this.showModal('edit');
      this.showModal('info');
    },
    fetchMemberData() {
      axios.get(`${this.$URL}/getMember.php`)
        .then((res) => {
          console.log(res);
          this.memberData = res.data;
          this.memberData.forEach(mem => {
            switch (mem.grade) {
              case '0':
                mem.grade = '普通會員';
                break;
              case '1':
                mem.grade = '白銀會員';
                break;
              case '2':
                mem.grade = '黃金會員';
                break;
              case '3':
                mem.grade = '白金會員';
                break;
              case '4':
                mem.grade = '鑽石會員';
                break;
            }
          })
        })
        .catch((err) => {
          console.log(err);
        })
    },
    addMemberData() {
      console.log('發送會員資料');
      this.showModal('addMemberSuccess');
      this.axios.post(`${this.$URL}/addMemberData.php`, JSON.stringify(this.newMember))
        .then(res => {
          console.log(res);
        })
        .catch(err => {
          console.log(err);
        })
    },
    // example() {
    // if (condition1) { return value1; }
    // else if (condition2) { return value2; }
    // else if (condition3) { return value3; }
    // else { return value4; }
    // },

  },
  mounted() {
    this.fetchMemberData();
  }
}
</script>

