<template>
  <div>
    <Form >
    <template v-slot:form_query>
      <div>
        <input type="search" id="searchInput" placeholder="歸還書籍請輸入電話">
        <button id="searchButton">
          <i class="bi bi-search"></i>
        </button>
      </div>
    </template>     
    <template v-slot:form_table >
      <table class="main_list">
        <tr>
          <th v-for="order in comics_order" :key="order">{{ order }}</th>
        </tr>
        <tr v-for="(item, index) in dataList" :key="index" @click="openModal(index)">
          <td >{{ item.comics_order_no }}</td>
          <td>{{ item.menno }}</td>
          <td>{{ item.comics_order_date }}</td>
          <td>{{ item.comics_borrow_date }}</td>
          <td>{{ item.comics_return_date }}</td>
          <td>{{ item.comics_borrow}}</td>
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

