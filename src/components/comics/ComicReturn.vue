<template>
  <div>
    <Form>
      <template v-slot:form_query>
        <Search @emit-txt="getSearch" />
      </template>
      <template v-slot:form_table>
        <table class="main_list" v-show="search">
          <thead v-if="filteredDataList.length > 0">
            <tr>
              <th v-for="column in columns">{{ column }}</th>
            </tr>
          </thead>
          <tr v-for="(item, index) in displayedDataList" :key="index" @click="openModal(index)">
            <td>{{ item.comics_order_no }}</td>
            <td>{{ item.mname }}</td>
            <td>{{ item.mobile }}</td>
            <td>{{ item.comics_return_duedate }}</td>
            <td>{{ item.comics_order_status }}</td>
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
        <div class="modal-backdrop" v-show="showBackdrop"></div>
        <!-- 彈窗 -->
        <div v-show="showModal" class="com_reserve_modal">
          <div class="modal_title">
            <h5>還書明細</h5>
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
            <div class="check_line">
              <div class="pickup_button">
                <button type="submit" @click="confirmPickup">還書</button>
              </div>
              <div class="total_amount">
                <tr>
                  <p>總計金額</p>
                  <span>{{ countTotal() }}</span>
                </tr>
              </div>
            </div>
          </div>
        </div>
        <!-- 確認彈窗 -->
        <div class="confirm_modal" v-show="showConfirmationModal">
          <h1>確定還書？</h1>
          <div class="confirm_buttons">
            <button @click="goBackToSearch">確定</button>
            <button @click="closeModal">取消</button>
          </div>
        </div>
      </template>
    </Form>
  </div>
</template>
<script>
import Form from '@/components/Form.vue';
import Search from '@/components/comics/Search.vue';

export default {
  components: {
    Form, Search
  },
  data() {
    return {
      currentPage: 1,
      itemsPerPage: 10,
      search: "",
      showModal: false,
      showBackdrop: false,
      showConfirmationModal: false,
      columns: ["訂單編號", "姓名", "手機", "應還日期", "租借狀態"],
      dataList: [],
      selectedItem: {},
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
      if (this.search === "") {
        this.filteredDataList = this.dataList;
      } else {
        this.filteredDataList = this.dataList.filter(item => item.mobile.includes(this.search));
      }
    },
    openModal(index) {
      // console.log(123);
      this.showModal = !this.showModal;
      this.selectedItem = this.filteredDataList[index];
      console.log(this.selectedItem);
      this.showBackdrop = true;
    },
    closeModal() {
      this.showConfirmationModal = false;
      this.showModal = this.showBackdrop = false;
    },
    confirmPickup() {
      this.showConfirmationModal = true;
      this.showModal = false;
    },
    updateOrderStatus() {
      const order_id = this.selectedItem.order_id;
      console.log('aaa', order_id)
      var params = new URLSearchParams();
      params.append('order_id', order_id);
      params.append('new_status', 4);
      // 取得當前日期
      const currentDate = new Date();
      const formattedDate = `${currentDate.getFullYear()}-${(currentDate.getMonth() + 1).toString().padStart(2, '0')}-${currentDate.getDate().toString().padStart(2, '0')}`;
      params.append('return_date', formattedDate);
      // 漫畫狀態修改  
      for (const item of this.selectedItem.items) {
      const comics_id = item.comics_id;      
      this.axios
        .post(`${this.$URL}/editComicReturn.php`, params) // 將新狀態傳遞給後端
        .then(response => {
          this.getData();
          this.getSearch(this.search); // 更新數據
          this.updateComicStatus(comics_id); // 在成功更新訂單資料後，更新漫畫書的狀態
          this.closeModal(); // 關閉彈窗
        })
        .catch(error => {
          console.error(error);
        });
      }
    },
    updateComicStatus(comics_id) {
      var params = new URLSearchParams();
      params.append('comics_id', comics_id);
      params.append('new_status', 1); // 將狀態更新為"在館"（代碼=1）

      this.axios
        .post(`${this.$URL}/editComicStatus.php`, params) // 更新每本漫畫書的狀態
        .then(response => {
          // 成功處理漫畫書狀態的更新
        })
        .catch(error => {
          console.error(error);
        });
    },
    goBackToSearch() {
      this.search = "";
      this.showConfirmationModal = this.showBackdrop = false;
      this.updateOrderStatus();
    },
    countTotal() {
      let totalAmount = 0;
      if (this.selectedItem && this.selectedItem.items) {
        totalAmount = this.selectedItem.items.length * 10; // 因為每本書都是$10
      }
      return `$${totalAmount}`;
    },
    getData(){
      this.axios
        .get(`${this.$URL}/getComicReturn.php`)
        .then((res) => {
          console.log(res);
          this.dataList = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
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
    this.getData();
  }
}
</script>

