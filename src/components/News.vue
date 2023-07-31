<template>
  <div>
 

    <Form >

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
      <template v-slot:form_table >
        <table>
        <tr>
          <!-- 資料表頭 -->
          <th v-for="column in columns">{{ column }}</th>
        </tr>
        <!-- 會員資料 -->
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
</template>
<script>

import Form from '@/components/Form.vue';

export default {
  components: {
    Form
  },
  data() {
    return {
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

