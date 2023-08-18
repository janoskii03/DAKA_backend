<template>
  <div>
    <Form >
      <template v-slot:form_query>
        <div class="col-md-2">
          <select class="form-select" aria-label="Default select example" v-model="selectedStatus" @change="filterDataList">
            <option value="" selected>請選擇</option>
            <option value="預約過期">預約過期</option>
            <option value="未取書">未取書</option>
            <option value="已取書">已取書</option>
            <option value="已歸還">已歸還</option>
            <option value="已取消">已取消</option>
            <option value="有罰金">有罰金</option>
          </select>
        </div>
        <Search @emit-txt= "getSearch" />
      </template>
      <template v-slot:form_table >
        <table class="main_list" v-show="filteredDataList.length > 0">
        <tr>
          <th v-for="column in columns">{{ column }}</th>
        </tr>
        <tr v-for="(item, index) in displayedDataList" :key="index" @click="openModal(index)">
          <td >{{ item.comics_order_no }}</td>
          <td>{{ item.mname }}</td>
          <td>{{ item.mobile }}</td>
          <td>{{ item.comics_order_date }}</td>
          <td>{{ item.comics_borrow_date }}</td>
          <td>{{ item.comics_return_duedate }}</td>
          <td>{{ item.comics_return_date }}</td>
          <td>{{ item.comics_order_status}}</td>
        </tr>
      </table>
      <div class="alert alert-warning" v-if="search && filteredDataList.length === 0">
        查無此手機號碼，請重新搜尋！
      </div>
      <div class="pagination-wrapper" v-if="totalPages > 1">
          <nav aria-label="Page navigation example">
            <ul class="pagination">
              <li
                class="page-item"
                @click="setCurrentPage(currentPage - 1)"
                :class="{ disabled: currentPage === 1 }"
              >
                <a class="page-link" href="#" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
              <li
                v-for="page in totalPages"
                :key="page"
                @click="setCurrentPage(page)"
                :class="{ active: page === currentPage }"
              >
                <a class="page-link" href="#"> {{ page }} </a>
              </li>
              <li
                class="page-item"
                @click="setCurrentPage(currentPage + 1)"
                :class="{ disabled: currentPage === totalPages }"
              >
                <a class="page-link" href="#" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            </ul>
          </nav>
      </div>
      <!-- 黑底 -->
      <div class="modal-backdrop" v-show="showModal"></div>
      <!-- 彈窗 -->
      <form v-show="showModal" class="com_reserve_modal">
        <div class="modal_title">
          <h5>{{ selectedItem.comics_order_status }}</h5>
          <img src="@/assets/images/member/close.svg" alt="close" class="close_window" @click="closeModal"> 
        </div>
        <div class="com_reserve_box">
          <div class="com_reserve_container">
            <table>
              <tr>
                <td>
                  <p>會員電話</p>
                  <span class="detail_content">{{ selectedItem.mobile }}</span>
                </td>
                <td>
                  <p>訂單編號</p>
                  <span class="detail_content">{{ selectedItem.comics_order_no }}</span>
                </td>
              </tr>
              <tr>
                <td>
                  <p>預約日期</p>
                  <span class="detail_content">{{ selectedItem.comics_order_date }}</span>
                </td>
                <td>
                  <p>取書日期</p>
                  <span class="detail_content">{{ selectedItem.comics_borrow_date }}</span>
                </td>
              </tr>
              <tr>
                <td>
                  <p>應還日期</p>
                  <span class="detail_content">{{ selectedItem.comics_return_duedate }}</span>
                </td>
                <td>
                  <p>歸還日期</p>
                  <span class="detail_content">{{ selectedItem.comics_return_date }}</span>
                </td>
              </tr>
            </table>
          </div>
          <div class="com_books_detail">
            <table>
                <tr>
                  <th>序號</th>
                  <th>建檔編碼</th>
                  <th>漫畫名稱</th>
                  <th>金額</th>
                </tr>
                <tr v-for="(item, itemIndex) in selectedItem.items" :key="'selected-item-' + itemIndex">
                  <td>{{ itemIndex + 1 }}</td>
                  <td>{{ item.comics_no }}</td>
                  <td>{{ item.title }} {{ item.comics_index }}</td>
                  <td>$10</td>
                </tr>
            </table>
          </div>
          <div class="check_line_show">
            <div class="total_amount_show">
              <tr>
                <p>總計金額</p>
                <span>{{ countTotal() }}</span>
              </tr>
            </div>
          </div>
        </div>
      </form>
      </template>
    </Form>
  </div>
</template>
<script>
import Form from '@/components/Form.vue';
import Search from '@/components/comics/Search.vue';

export default {
  components: {
    Form,Search
  },
  data() {
    return {
      currentPage: 1,
      itemsPerPage: 10,
      search: "",
      showModal:false,
      selectedStatus: "",
      columns: ["訂單編號", "姓名", "手機", "預約日期", "取書日期", "應還日期", "歸還日期", "租借狀態"],
      dataList:[],
      selectedItem:{},
      filteredDataList: []
    }
  },
  
  methods: {
    setCurrentPage(pageNumber) { 
      console.log(this.totalPages)
      if (pageNumber <= 0 || pageNumber > this.totalPages) {
        console.log('this.totalPages')
        return;
      }
      this.currentPage = pageNumber;
    },
    getSearch(searchMobile) {
      this.search = searchMobile;
      this.filterDataList();
    },
    filterDataList() {
      this.filteredDataList = this.dataList;

      if (this.selectedStatus) {
        this.filteredDataList = this.filteredDataList.filter(item => item.comics_order_status === this.selectedStatus);
      }

      if (this.search) {
        this.filteredDataList = this.filteredDataList.filter(item => item.mobile.includes(this.search));
      }
    },
    openModal(index) {
      const startIndex = (this.currentPage - 1) * this.itemsPerPage;
      const dataIndex = startIndex + index;
      this.showModal = true;
      this.selectedItem = this.filteredDataList[dataIndex];
    },
    closeModal(){
      this.showModal=false;
    },
    countTotal() {
      let totalAmount = 0;
      if (this.selectedItem && this.selectedItem.items) {
        totalAmount = this.selectedItem.items.length * 10; // 因為每本書都是$10
      }
      return `$${totalAmount}`;
    }
  },
  computed: {
    displayedDataList() {
      let start = (this.currentPage - 1) * this.itemsPerPage;
      let end = start + this.itemsPerPage;
      return this.filteredDataList.slice(start, end);
    },
    totalPages() {
      return Math.ceil(this.filteredDataList.length / this.itemsPerPage);
    }
  },
  mounted() {
    this.axios
      .get(`${this.$URL}/getOrderStatus.php`)
      .then((res) => {
        console.log(res);
        this.dataList = res.data;
      })
      .catch((err) => {
        console.log(err);
      });
  }
}
</script>

