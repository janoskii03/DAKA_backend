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
      <slot name="form_query"></slot>
    </div>


    <div class="wrap">
     
            <slot name="form_table">
            </slot>

          

      <!-- <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-end">
          <li class="page-item">
            <a class="page-link" href="#" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
            </a>
          </li>
          <li class="page-item" v-for="page in totalPages"><a class="page-link" href="#">{{ page }}</a></li>
          
          <li class="page-item">
            <a class="page-link" href="#" aria-label="Next" >
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>
        </ul>
      </nav> -->

    </div>

    
  </div>
 

</template>

<script>
export default {
props:{
  columns: {
      type: Array,
      required: true,
    },
    dataList: {
      type: Array,
      required: true,
    },
},
components:{

},
  data() {
    return {
      perPages:8,
      currentPage: 1,
    }
  },
// computed:{
//   totalPages() {
//       return Math.ceil(this.data.length / this.perPage);
//     },
//     displayedData() {
//       const startIndex = (this.currentPage - 1) * this.perPage;
//       const endIndex = startIndex + this.perPage;
//       return this.data;
//     },
// },
  methods: {
   
},
watch:{

},


}
</script>