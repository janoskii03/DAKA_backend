<template>
  <div class="member">
    <div class="member_query">

      <ButtonGroup shape="circle">
        <Button type="black">新增會員
          <Icon type="md-add" />
        </Button>

      </ButtonGroup>
      <Select v-model="model" style="width:200px">
        <Option v-for="item in cityList" :value="item.value" :key="item.value">{{ item.label }}</Option>
      </Select>
      <Input placeholder="Enter text" style="width: auto">
      <template #suffix>
        <Icon type="ios-search" />
      </template>
      </Input>
    </div>



    <div class="wrap">
      <table >
        <tr>
          <th>姓名</th>
          <th>會員編號</th>
          <th>會員等級</th>
          <th>手機號碼</th>
          <th>儲值餘額</th>
          <th>當年度累積消費金額</th>
        </tr>
        <tr v-for="(item,index) in data" :key="item.index" @click.prevent="memberInfo(index)" >
          <td>{{item.name}}</td>
          <td>{{ item.no}}</td>
          <td>{{ item.rank}}</td>
          <td>{{ item.mobile}}</td>
          <td>{{ item.remain}}</td>
          <td>{{ item.value}}</td>
        </tr>
        
      </table>
      <Page :total="100" class="member_bottom" />
    </div>
  </div>
  <Modal></Modal>
</template>
<script>
import Modal from '@/components/Modal.vue'
export default {
  components:{
    Modal
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
      data: [
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


      ]

      ,
      cityList: [
        {
          value: 'New York',
          label: 'New York'
        },
        {
          value: 'London',
          label: 'London'
        },
        {
          value: 'Sydney',
          label: 'Sydney'
        },
        {
          value: 'Ottawa',
          label: 'Ottawa'
        },
        {
          value: 'Paris',
          label: 'Paris'
        },
        {
          value: 'Canberra',
          label: 'Canberra'
        }
      ],
      model: '',
    }
  },
  methods: {
    memberInfo(index) {
let {name,no,rank,mobile,remain,value} =this.data[index];

console.log(name,no,rank,mobile,remain,value);

    }
  }
}
</script>

<style scoped lang="scss">
.member {
  max-width: 883px;
  height: 609px;
  margin: 0 32px;
  background-color: #fff;
  display: flex;
  flex-direction: column;
  padding: 10px;
}

.member .member_query {
  display: flex;
  justify-content: end;
  align-items: center;
  gap: 10px;
  margin-bottom: 20px;
}

.member_form {
  width: 883px;
  flex-grow: 1;
  background-color: #fff;

}

.member_bottom {
  text-align: end;
  margin-top: 18px;
}

.wrap {
  overflow: hidden;


}

table {

  border-collapse: collapse;

}

th {


  width: 25vw;
  height: 75px;
}

td {
  background-color: #ffffff;
  width: 25vw;
  height: 50px;
  text-align: center;

}

tr {
  border-bottom: 1px solid #dddddd;

}

tr:hover td {
  background-color: rgba(38, 50, 56, 1);
  color: #fff;

}
</style>