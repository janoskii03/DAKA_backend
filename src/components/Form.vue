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
export default {
props:{
},
components:{

},
  data() {
    return {

    }
  },
computed:{

},
  methods: {
   
},
watch:{

},


}
</script>