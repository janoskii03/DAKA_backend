<template>
  <div>
    <Form>
      <template v-slot:form_query>
        <div class="col-md-4 d-flex">
          <select
            class="form-select w-20"
            v-model="selectedOption"
            @change="computeResults"
            aria-label="Default select example"
          >
            <option value="0" selected>使用者</option>
            <option value="1">大廳區</option>
            <option value="2">包廂區</option>
          </select>

          <!-- <div class="input-group">
            <input
              type="search"
              class="form-control"
              placeholder="預約輸入請輸入電話"
              aria-describedby="basic-addon1"
              v-model="search"
            />
            <span
              class="input-group-text"
              id="basic-addon1"
              @click.prevent="searchReserve"
            >
              <img src="@/assets/images/search.svg" alt="search" />
            </span>
          </div> -->
        </div>
        <Search @emit-txt="getSearch" />
      </template>
      <template v-slot:form_table>
        <div class="scrollable-table">
          <table class="main_list" v-show="step === 1">
            <tr>
              <th v-for="order in seat_order" :key="order">{{ order }}</th>
            </tr>
            <tr v-for="(item, index) in displayedDataList" :key="index">
              <td>{{ stateMap[item.seat_order_state] }}</td>
              <td>{{ item.mname }}</td>
              <td>{{ item.mobile }}</td>
              <td>
                <div v-for="seat in item.items" :key="seat">
                  {{ areaMap[seat.seat_area] }}
                  {{ seat.seat_area + "-" + seat.seat_number }}
                </div>
              </td>
              <td>{{ item.seat_order_startdate }}</td>
              <td>{{ item.seat_order_enddate }}</td>
              <td>{{ item.seat_order_time }}</td>
              <td>{{ item.seat_order_sum }}</td>
              <div v-if="totalPages > 1"></div>
            </tr>
          </table>
        </div>
        <div class="pagination-wrapper" v-if="totalPages > 1">
          <!-- <button
            v-for="page in totalPages"
            :key="page"
            @click="setCurrentPage(page)"
          >
            {{ page }}
          </button> -->
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
        <div v-if="noResultsMessage" class="alert alert-warning">
          {{ noResultsMessage }}
        </div>
      </template>
    </Form>
  </div>
</template>
<script>
import Form from "@/components/Form.vue";
import Search from "@/components/comics/Search.vue";

export default {
  components: {
    Form,
    Search
  },
  data() {
    return {
      currentPage: 1,
      itemsPerPage: 10,
      searchTerm: "",
      title: "",
      src: "",
      areaMap: {
        A: "大廳電競區",
        B: "大廳一般區",
        C: "包廂單人房",
        D: "包廂雙人房"
      },
      stateMap: {
        0: "預約中",
        1: "已完成",
        2: "已取消"
      },
      showModal: false,
      seat_order: [
        "訂單狀態",
        "會員姓名",
        "電話",
        "使用電腦",
        "開始時間",
        "結束時間",
        "使用總時數",
        "總金額"
      ],
      dataList: [],
      selectedOption: "0",
      noResultsMessage: "",
      filterDataList: [],
      selectedItem: {},
      search: "",
      step: 0
    };
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

    getSearch(value) {
      this.searchTerm = value;
      this.computeResults();
    },
    computeResults() {
      this.filterDataList = [];

      // 根据选择的选项进行不同的查询
      switch (this.selectedOption) {
        case "0": // 使用者
          this.filterDataList = this.dataList.filter((item) =>
            item.mobile.includes(this.searchTerm)
          );
          break;

        case "1": // 大廳區
          this.filterDataList = this.dataList.filter((item) => {
            return item.items.some(
              (seat) =>
                seat.seat_number.includes(this.searchTerm) &&
                ["A", "B"].includes(seat.seat_area)
            );
          });
          break;

        case "2": // 包廂區
          this.filterDataList = this.dataList.filter((item) => {
            return item.items.some(
              (seat) =>
                seat.seat_number.includes(this.searchTerm) &&
                ["C", "D"].includes(seat.seat_area)
            );
          });
          break;

        default:
          break;
      }

      // 若查询结果为空
      if (this.filterDataList.length === 0) {
        this.noResultsMessage = "查無此資料，請重新搜尋。";
      } else {
        this.step = 1;
        this.noResultsMessage = "";
      }
    }
  },
  computed: {
    displayedDataList() {
      let start = (this.currentPage - 1) * this.itemsPerPage;
      let end = start + this.itemsPerPage;
      return this.filterDataList.slice(start, end);
    },
    totalPages() {
      return Math.ceil(this.filterDataList.length / this.itemsPerPage);
    }
  },
  mounted() {
    this.axios
      .get(`${this.$URL}/getSeatOrder.php`)
      .then((res) => {
        console.log(res);
        this.dataList = res.data;
      })
      .catch((err) => {
        console.log(err);
      });
  }
};
</script>
