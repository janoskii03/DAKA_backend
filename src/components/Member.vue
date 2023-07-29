<template>
  <div class="member">
    <div class="member_query w-100 ">
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
    </div>



    <div class="wrap">
      <table>
        <tr>
          <th>姓名</th>
          <th>會員編號</th>
          <th>會員等級</th>
          <th>手機號碼</th>
          <th>儲值餘額</th>
          <th>當年度累積消費金額</th>
        </tr>
        <tr v-for="(item, index) in data" :key="item.index" @click.prevent="memberInfo(index)">
          <td>{{ item.name }}</td>
          <td>{{ item.no }}</td>
          <td>{{ item.rank }}</td>
          <td>{{ item.mobile }}</td>
          <td>{{ item.remain }}</td>
          <td>{{ item.value }}</td>
        </tr>

      </table>

      <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-end">
          <li class="page-item">
            <a class="page-link" href="#" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
            </a>
          </li>
          <li class="page-item"><a class="page-link" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item">
            <a class="page-link" href="#" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>
        </ul>
      </nav>

    </div>

    
  </div>
 

</template>
<script>
import Modal from '@/components/Modal.vue'
export default {
  components: {
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


      ],
      model: '',
  
    }
  },
  methods: {
    memberInfo(index) {
      let { name, no, rank, mobile, remain, value } = this.data[index];

      console.log(name, no, rank, mobile, remain, value);

    },

   
  }
}
</script>

<style scoped lang="scss">
.member {
  width: 100%;
  box-sizing: border-box;

  background-color: #fff;
  display: flex;
  flex-direction: column;

  padding: 40px 10px 20px 10px;
}

.member .member_query {
 
  display: flex;
  justify-content: end;
  align-items: center;
  gap: 10px;
  margin-bottom: 20px;

  .member_add{
    display: flex;
    align-items: center;
    gap: 5px;
  }
}

.member_form {
  width: 90%;

  flex-grow: 1;
  background-color: #fff;

}

.member_bottom {
  text-align: end;
  margin-top: 18px;
}

.wrap {
  overflow: hidden;
  width: 100%;

}

table {

  border-collapse: collapse;

}

th {


  width: 25vw;
  height: 75px;
  text-align: center;
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