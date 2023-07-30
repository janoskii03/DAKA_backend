<template>
  <div>


    <Form >
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
import Modal from '@/components/Modal.vue';
import Form from './Form.vue';

export default {
  components: {
    Modal,
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

