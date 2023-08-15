<template>
  <Form>
    <template v-slot:form_query>
      <div class="col-md-2">
        <select class="form-select" v-model="searchOption">
          <option value="0" disabled selected>請選擇</option>
          <option value="1">建檔編號</option>
          <option value="2">書籍名稱</option>
          <option value="3">ISBN碼</option>
        </select>
      </div>
      <div class="col-md-2">
        <div class="input-group">
          <input
            type="search"
            class="form-control"
            v-model="searchInput"
            @input="performSearch"
            placeholder="請輸入"
            aria-describedby="basic-addon1"
          />
          <button class="input-group-text" id="basic-addon1">
            <img
              @click="performSearch"
              src="@/assets/images/search.svg"
              alt="search"
            />
          </button>
        </div>
      </div>
    </template>

    <template v-slot:form_table>
      <div class="scrollable-table">
        <table class="main_list">
          <tr>
            <th v-for="header in comics_id">{{ header }}</th>
          </tr>
          <tr
            v-for="(item, index) in paginatedResults"
            :key="index"
            @click="openModal1(item, index)"
          >
            <td>{{ item.isbn }}</td>
            <td>{{ item.comics_no }}</td>
            <td class="col-md-3">{{ item.title + item.comics_index }}</td>
            <td>{{ item.comics_price }} 元</td>
            <td>{{ item.comics_status }}</td>
          </tr>

          <div class="comic_info">
            <!-- 第一層彈窗 -->
            <div v-if="selectedItemIndex !== null">
              <div class="modal_container" v-show="showModal1">
                <div v-if="selectedItem">
                  <div class="modal_overlay" @click="closeModal1"></div>
                  <div class="showModal1">
                    <div class="titleare">
                      <p>預覽書籍資料</p>
                      <button class="com_x_btn" @click="closeModal1">
                        <i class="fa-solid fa-xmark"></i>
                      </button>
                    </div>
                    <div class="com_whiteinfo_content">
                      <div class="row">
                        <!-- 資料題 -->

                        <div class="col-md-1">
                          <div class="mb-3">
                            <label class="col-form-label">建檔編號</label>
                          </div>
                          <div class="mb-3">
                            <label class="col-form-label">I S B N號</label>
                          </div>
                          <div class="mb-3">
                            <label class="col-form-label">書籍名稱</label>
                          </div>
                          <div class="mb-3">
                            <label class="col-form-label">書籍集數</label>
                          </div>
                          <div class="mb-3">
                            <label class="col-form-label">書籍作者</label>
                          </div>
                          <div class="mb-3">
                            <label class="col-form-label">書籍譯者</label>
                          </div>
                          <div class="mb-3">
                            <label class="col-form-label">漫畫分類</label>
                          </div>
                          <div class="mb-3">
                            <label class="col-form-label">熱門書籍</label>
                          </div>
                          <div class="mb-3">
                            <label class="col-form-label">新書推薦</label>
                          </div>
                        </div>
                        <!-- 填寫區 -->
                        <div class="col-md-3">
                          <div class="mt-1">
                            <input
                              type="text"
                              class="form-control"
                              disabled
                              :readonly="isPreviewMode(selectedItemIndex)"
                              v-model="selectedItem.comics_no"
                            />
                          </div>
                          <div class="mt-3">
                            <input
                              type="text"
                              class="form-control"
                              disabled
                              :readonly="isPreviewMode(selectedItemIndex)"
                              v-model="selectedItem.isbn"
                            />
                          </div>
                          <div class="mt-4">
                            <input
                              type="text"
                              class="form-control"
                              disabled
                              :readonly="isPreviewMode(selectedItemIndex)"
                              v-model="selectedItem.title"
                            />
                          </div>
                          <div class="mt-3">
                            <input
                              type="text"
                              class="form-control"
                              disabled
                              :readonly="isPreviewMode(selectedItemIndex)"
                              v-model="selectedItem.comics_index"
                            />
                          </div>
                          <div class="mt-3">
                            <input
                              type="text"
                              class="form-control"
                              disabled
                              :readonly="isPreviewMode(selectedItemIndex)"
                              v-model="selectedItem.author"
                            />
                          </div>
                          <div class="mt-3">
                            <input
                              type="text"
                              class="form-control"
                              disabled
                              :readonly="isPreviewMode(selectedItemIndex)"
                              v-model="selectedItem.translator"
                            />
                          </div>
                          <div class="mt-3">
                            <select
                              class="form-select"
                              v-model="selectedItem.type"
                              disabled
                              :readonly="isPreviewMode(selectedItemIndex)"
                            >
                              <option value="0" disabled selected>
                                請選擇
                              </option>
                              <option value="冒險系列">冒險系列</option>
                              <option value="少男系列">少男系列</option>
                              <option value="魔法系列">魔法系列</option>
                              <option value="格鬥系列">格鬥系列</option>
                            </select>
                          </div>
                          <div class="mt-3">
                            <input
                              class="form-check-input checkbox"
                              disabled
                              type="checkbox"
                              value=""
                              :disabled="isPreviewMode(selectedItemIndex)"
                              :checked="selectedItem.comics_hot === '1'"
                            />
                          </div>
                          <div class="mt-3">
                            <input
                              class="form-check-input checkbox"
                              disabled
                              type="checkbox"
                              value=""
                              :disabled="isPreviewMode(selectedItemIndex)"
                              :checked="selectedItem.comics_new === '1'"
                            />
                          </div>
                        </div>
                        <!-- 資料題 -->
                        <div class="col-md-1">
                          <div class="mb-3">
                            <label class="col-form-label">進貨價格</label>
                          </div>
                          <div class="mb-3">
                            <label class="col-form-label">書籍語言</label>
                          </div>
                          <div class="mb-3">
                            <label class="col-form-label">出版社</label>
                          </div>
                          <div class="mb-3">
                            <label class="col-form-label">出版日期</label>
                          </div>
                          <div class="mb-3">
                            <label class="col-form-label">封面更新</label>
                          </div>
                          <div class="mb-3">
                            <label class="col-form-label">內頁更新</label>
                          </div>
                        </div>
                        <!-- 填寫區 -->
                        <div class="col-md-3">
                          <div class="mt-1">
                            <input
                              type="text"
                              class="form-control"
                              disabled
                              :readonly="isPreviewMode(selectedItemIndex)"
                              v-model="selectedItem.comics_price"
                            />
                          </div>
                          <div class="mt-3">
                            <select
                              class="form-select"
                              v-model="selectedItem.language"
                              disabled
                              :readonly="isPreviewMode(selectedItemIndex)"
                            >
                              <option value="0" disabled selected>
                                請選擇
                              </option>
                              <option value="繁體中文">繁體中文</option>
                              <option value="日語">日語</option>
                            </select>
                          </div>
                          <div class="mt-3">
                            <input
                              type="text"
                              class="form-control"
                              v-model="selectedItem.publisher"
                              disabled
                              :readonly="isPreviewMode(selectedItemIndex)"
                            />
                          </div>
                          <div class="mt-3">
                            <input
                              type="date"
                              class="form-control"
                              v-model="selectedItem.publication_date"
                              disabled
                              :readonly="isPreviewMode(selectedItemIndex)"
                            />
                          </div>
                          <div class="mt-3">
                            <input
                              class="form-control"
                              type="file"
                              disabled
                              :readonly="isPreviewMode(selectedItemIndex)"
                            />
                          </div>
                          <div class="mt-3">
                            <input
                              class="form-control"
                              type="file"
                              disabled
                              :readonly="isPreviewMode(selectedItemIndex)"
                            />
                          </div>
                        </div>
                        <!-- 資料題 -->
                        <div class="col-md-1">
                          <div class="mb-3">
                            <label class="col-form-label">報銷書籍</label>
                          </div>
                          <div class="mb-3">
                            <label class="col-form-label">書籍簡介</label>
                          </div>
                        </div>
                        <!-- 填寫區 -->
                        <div class="col-md-3">
                          <div class="">
                            <input
                              class="form-check-input checkbox"
                              disabled
                              type="checkbox"
                              value=""
                              :disabled="isPreviewMode(selectedItemIndex)"
                              :checked="selectedItem.comics_status === '0'"
                            />
                          </div>
                          <div class="mb-3">
                            <textarea
                              class="form-control mb-4"
                              id="exampleFormControlTextarea1"
                              rows="10"
                              v-model="selectedItem.intro"
                              @input="countWords"
                              maxlength="150"
                              disabled
                              :readonly="isPreviewMode(selectedItemIndex)"
                            ></textarea>
                          </div>
                          <div class="mb-3">
                            <button class="com_write_btn" @click="openModal2">
                              <i class="fa-solid fa-pen"></i>
                            </button>
                          </div>
                          <div class="mb-3">
                            <button class="com_info_btn" @click="closeModal1">
                              確定
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </table>

      <!-- 搜尋 -->
      <div
        class="alert alert-warning"
        v-if="search && searchResults.length === 0"
      >
        查無此消息標題，請重新搜尋！
      </div>
      <nav class="container pagination_btn_position" v-if="searchResults.length > 0">
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
    </template>
    
  </Form>
</template>
<script>
import Form from "@/components/Form.vue";

export default {
  components: {
    Form,
  },
  data() {
    return {
      comics_id: ["ISBN編碼", "建檔編號", "書籍名稱", "進貨價格", "租借狀況"],
      searchOption: "0",
      searchInput: "",
      searchResults: [],
      search: false, // 控制是否执行搜索
      showModal1: false,
      showModal2: false,
      showModal3: false,
      showModal4: false,
      showModal5: false,
      selectedItem: null, // 选中的数据项
      editModes: [],
      selectedItemIndex: null,
      isFirstClick: true,
      currentPage: 1, // 当前页数
      itemsPerPage: 10, // 每页显示的项数
    };
  },
  computed: {
    isDisabled() {
      return this.mode === "preview" && this.dataList === 0;
    },
    // 根据当前页数和每页显示项数计算分页结果
    paginatedResults() {
      const startIndex = (this.currentPage - 1) * this.itemsPerPage;
      const endIndex = startIndex + this.itemsPerPage;
      return this.searchResults.slice(startIndex, endIndex);
    },
    // 计算总页数
    totalPages() {
      return Math.max(
        Math.ceil(this.searchResults.length / this.itemsPerPage),
        1
      );
    },
    // 判断是否为最后一页
    isLastPage() {
      return this.currentPage === this.totalPages;
    },
  },
  methods: {
    setCurrentPage(page) {
      if (page >= 1 && page <= this.totalPages) {
        this.currentPage = page;
      }
    },
    performSearch() {
      this.search = true;

      if (this.searchOption === "1") {
        this.searchResults = this.dataList.filter((item) =>
          item.comics_no.includes(this.searchInput)
        );
      } else if (this.searchOption === "2") {
        this.searchResults = this.dataList.filter((item) =>
          item.title.includes(this.searchInput)
        );
      } else if (this.searchOption === "3") {
        this.searchResults = this.dataList.filter((item) =>
          item.isbn.includes(this.searchInput)
        );
      } else {
        this.searchResults = this.dataList;
      }

      // 重置当前页数为第一页
      this.currentPage = 1;
    },
    memberInfo(index) {
      // 处理点击事件的逻辑
    },
    // 打开第一层弹窗
    openModal1() {
      this.showModal1 = true;
    },
    closeModal1() {
      this.showModal1 = false;
    },
    // 打开第二层弹窗
    openModal2() {
      this.showModal2 = true;
    },
    closeModal2() {
      this.showModal2 = false;
    },
    // 打开第三层弹窗
    openModal3() {
      this.showModal3 = true;
    },
    closeModal3() {
      this.showModal3 = false;
    },
    // 打开第四层弹窗
    openModal4() {
      this.showModal4 = true;
    },
    closeModal4() {
      this.showModal4 = false;
    },
    // 打开第五层弹窗
    openModal5() {
      this.showModal5 = true;
    },
    closeModal5() {
      this.showModal5 = false;
    },
    // 确认修改，处理数据提交等逻辑
    confirmChanges() {
      // 处理数据修改逻辑...

      // 关闭所有弹窗，回到初始状态
      this.closeModal1();
      this.closeModal2();
      this.closeModal3();
      this.closeModal4();
      this.closeModal5();
    },

    // 其他方法...
    handleCheckboxClick() {
      if (this.selectedItem.comics_status === "1") {
        if (this.isFirstClick) {
          this.openModal4();
        } else {
          this.openModal5();
        }
      } else {
        this.closeModals();
      }
    },

    closeModal4AndToggleFirstClick() {
      this.closeModal4();
      this.isFirstClick = true;
    },

    closeModal5AndToggleFirstClick() {
      this.closeModal5();
      this.isFirstClick = false;
    },

    closeModals() {
      this.closeModal4();
      this.closeModal5();
    },
    // ...其它方法...

    // 打开第一層弹窗，并设置选中的书籍索引
    openModal1(item, index) {
      this.selectedItemIndex = index;
      this.selectedItem = { ...item }; // 更新选中的书籍数据
      this.showModal1 = true;
    },

    // 切换预览模式和修改模式
    toggleEditMode(index) {
      this.editModes[index] = !this.editModes[index];
    },

    // 判断是否为预览模式
    isPreviewMode(index) {
      return this.editModes[index] || this.selectedItemIndex === null;
    },

    // 打开修改模式
    openModal2() {
      this.showModal1 = false; // 关闭预览模式
      this.showModal2 = true;
    },
  },
  mounted() {
    this.axios
      .get(`${this.$URL}/getComicInfoImg.php`)
      .then((res) => {
        console.log(res);
        this.dataList = res.data;
      })
      .catch((err) => {
        console.log(err);
      });
  },
};
</script>
