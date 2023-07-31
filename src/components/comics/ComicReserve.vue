<template>
  <div>
    <Form >
      <template v-slot:form_query>
        <button class="btn btn-dark member_add" type="submit">
        新增會員
        <img src="@/assets/images/member/plus.svg" alt="plus" class="member_plus"> 
      </button>
     
      <input type="search">
 </template>



     
        <template v-slot:form_table >
        <table>
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
</template>
<script>
import Form from '@/components/Form.vue';

export default {
  components: {
    Form
  },
  data() {
    return {
      columns: [
        '姓名',
        '會員編號',
        '會員等級',
        '手機號碼',
        '儲值餘額',
        '當年度累積消費金額'
      ],
     

    }
  },
  methods: {
 

  }
}
</script>

