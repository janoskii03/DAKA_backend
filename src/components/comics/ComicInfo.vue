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
      <div class="scrollable-table" id="news_modal" method="post">
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
            <td>
              <span v-if="item.comics_status === '0'">已報銷</span>
              <span v-else-if="item.comics_status === '1'">在館</span>
            </td>
          </tr>

          <!-- 分頁按鈕 -->
          <nav
            class="container pagination_btn_position"
            v-if="searchResults.length > 0"
          >
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
        </table>

        <!-- 搜尋 -->
        <div
          class="alert alert-warning"
          v-if="search && searchResults.length === 0"
        >
          查無此消息標題，請重新搜尋！
        </div>

        <div class="comic_info">
          <div v-if="selectedItemIndex !== null">
            <!-- 第一層彈窗 -->
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
                        <div class="mb-3 mt-1">
                          <label class="col-form-label">建檔編號</label>
                        </div>
                        <div class="mb-4">
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
                            id="comics_no"
                          />
                        </div>
                        <div class="mt-3">
                          <input
                            type="text"
                            class="form-control"
                            disabled
                            :readonly="isPreviewMode(selectedItemIndex)"
                            v-model="selectedItem.isbn"
                            id="isbn"
                          />
                        </div>
                        <div class="mt-4">
                          <input
                            type="text"
                            class="form-control"
                            disabled
                            :readonly="isPreviewMode(selectedItemIndex)"
                            v-model="selectedItem.title"
                            id="title"
                          />
                        </div>
                        <div class="mt-3">
                          <input
                            type="text"
                            class="form-control"
                            disabled
                            :readonly="isPreviewMode(selectedItemIndex)"
                            v-model="selectedItem.comics_index"
                            id="selectedItem.comics_index"
                          />
                        </div>
                        <div class="mt-3">
                          <input
                            type="text"
                            class="form-control"
                            disabled
                            :readonly="isPreviewMode(selectedItemIndex)"
                            v-model="selectedItem.author"
                            id="author"
                          />
                        </div>
                        <div class="mt-3">
                          <input
                            type="text"
                            class="form-control"
                            disabled
                            :readonly="isPreviewMode(selectedItemIndex)"
                            v-model="selectedItem.translator"
                            id="translator"
                          />
                        </div>
                        <div class="mt-3">
                          <select
                            class="form-select"
                            v-model="selectedItem.type"
                            disabled
                            :readonly="isPreviewMode(selectedItemIndex)"
                            id="type"
                          >
                            <option value="0" disabled selected>請選擇</option>
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
                            id="comics_hot"
                          />
                        </div>
                        <div class="mt-4">
                          <input
                            class="form-check-input checkbox"
                            disabled
                            type="checkbox"
                            value=""
                            :disabled="isPreviewMode(selectedItemIndex)"
                            :checked="selectedItem.comics_new === '1'"
                            id="comics_new"
                          />
                        </div>
                      </div>
                      <!-- 資料題 -->
                      <div class="col-md-1">
                        <div class="mb-3 mt-1">
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
                        <div class="imgpreview">
                          <img
                            v-for="(url, index) in imageUrls.img"
                            :key="index"
                            :src="url"
                            alt="comics_coverimage"
                          />
                          <img
                            v-for="(url, index) in imageUrls.comics_readfirst"
                            :key="index"
                            :src="url"
                            alt="comics_readfirst"
                          />
                        </div>
                      </div>
                      <!-- 填寫區 -->
                      <div class="col-md-3">
                        <div class="mb-3 mt-1">
                          <input
                            type="text"
                            class="form-control"
                            disabled
                            :readonly="isPreviewMode(selectedItemIndex)"
                            v-model="selectedItem.comics_price"
                            id="comics_price"
                          />
                        </div>
                        <div class="mt-3">
                          <select
                            class="form-select"
                            v-model="selectedItem.language"
                            disabled
                            :readonly="isPreviewMode(selectedItemIndex)"
                            id="language"
                          >
                            <option value="0" disabled selected>請選擇</option>
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
                            id="publisher"
                          />
                        </div>
                        <div class="mt-3">
                          <input
                            type="date"
                            class="form-control"
                            v-model="selectedItem.publication_date"
                            disabled
                            :readonly="isPreviewMode(selectedItemIndex)"
                            id="publication_date"
                          />
                        </div>
                        <div class="mt-3">
                          <input
                            class="form-control"
                            type="file"
                            disabled
                            :readonly="isPreviewMode(selectedItemIndex)"
                            id="img"
                          />
                        </div>
                        <div class="mt-3">
                          <input
                            class="form-control"
                            type="file"
                            disabled
                            :readonly="isPreviewMode(selectedItemIndex)"
                            id="comics_readfirst"
                          />
                        </div>
                      </div>
                      <!-- 資料題 -->
                      <div class="col-md-1">
                        <div class="mb-3 mt-1">
                          <label class="col-form-label">報銷書籍</label>
                        </div>
                        <div class="mb-3">
                          <label class="col-form-label">書籍簡介</label>
                        </div>
                      </div>
                      <!-- 填寫區 -->
                      <div class="col-md-3 mt-1">
                        <!-- 報銷修改 -->
                        <input
                          class="form-check-input checkbox"
                          disabled
                          type="checkbox"
                          value=""
                          :disabled="isPreviewMode(selectedItemIndex)"
                          :checked="selectedItem.comics_status === '0'"
                          id="comics_status"
                        />
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
                            :id="intro"
                          ></textarea>
                        </div>
                        <div class="mb-4">
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

          <!-- 第二層彈窗 -->
          <div class="modal_container" v-show="showModal2">
            <div v-if="selectedItem">
              <div class="modal_overlay" @click="closeModal2"></div>
              <div class="showModal2">
                <div class="titleare">
                  <p>修改書籍資料</p>
                  <button class="com_x_btn" @click="closeModal2">
                    <i class="fa-solid fa-xmark"></i>
                  </button>
                </div>
                <div class="com_whiteinfo_content">
                  <div class="row">
                    <!-- 資料題 -->
                    <div class="col-md-1">
                      <div class="mb-3 mt-1">
                        <label class="col-form-label">建檔編號</label>
                      </div>
                      <div class="mb-4">
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
                          placeholder="請輸入 阿拉伯數字"
                          :value="selectedItem.comics_no"
                          id="comics_no"
                        />
                      </div>
                      <div class="mt-3">
                        <input
                          type="text"
                          class="form-control"
                          placeholder="請輸入 阿拉伯數字"
                          :value="selectedItem.isbn"
                          id="isbn"
                        />
                      </div>
                      <div class="mt-4">
                        <input
                          type="text"
                          class="form-control"
                          placeholder="請輸入 阿拉伯數字"
                          :value="selectedItem.title"
                          id="title"
                        />
                      </div>
                      <div class="mt-3">
                        <input
                          type="text"
                          class="form-control"
                          placeholder="請輸入 阿拉伯數字"
                          :value="selectedItem.comics_index"
                          id="comics_index"
                        />
                      </div>
                      <div class="mt-3">
                        <input
                          type="text"
                          class="form-control"
                          placeholder="請輸入 阿拉伯數字"
                          :value="selectedItem.author"
                          id="author"
                        />
                      </div>
                      <div class="mt-3">
                        <input
                          type="text"
                          class="form-control"
                          placeholder="請輸入 阿拉伯數字"
                          :value="selectedItem.translator"
                          id="translator"
                        />
                      </div>
                      <div class="mt-3">
                        <select
                          class="form-select"
                          id="type"
                          :value="selectedItem.type"
                        >
                          <option value="0" disabled selected>請選擇</option>
                          <option value="冒險系列">冒險系列</option>
                          <option value="少男系列">少男系列</option>
                          <option value="魔法系列">魔法系列</option>
                          <option value="格鬥系列">格鬥系列</option>
                        </select>
                      </div>
                      <div class="mt-3">
                        <input
                          class="form-check-input checkbox"
                          type="checkbox"
                          value=""
                          :value="selectedItem.author"
                          :checked="selectedItem.comics_hot === '1'"
                          id="comics_hot"
                        />
                      </div>
                      <div class="mt-4">
                        <input
                          class="form-check-input checkbox"
                          type="checkbox"
                          value=""
                          :value="selectedItem.author"
                          :checked="selectedItem.comics_new === '1'"
                          id="comics_new"
                        />
                      </div>
                    </div>
                    <!-- 資料題 -->
                    <div class="col-md-1">
                      <div class="mb-3 mt-1">
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
                      <div class="imgpreview">
                        <img
                          v-for="(url, index) in imageUrls.img"
                          :key="index"
                          :src="url"
                          alt="comics_coverimage"
                        />
                        <img
                          v-for="(url, index) in imageUrls.comics_readfirst"
                          :key="index"
                          :src="url"
                          alt="comics_readfirst"
                        />
                      </div>
                    </div>
                    <!-- 填寫區 -->
                    <div class="col-md-3">
                      <div class="mt-1">
                        <input
                          type="text"
                          class="form-control"
                          placeholder="請輸入 阿拉伯數字"
                          :value="selectedItem.comics_price"
                          id="comics_price"
                        />
                      </div>
                      <div class="mt-3">
                        <select
                          class="form-select"
                          :value="selectedItem.language"
                          id="language"
                        >
                          <option value="0" disabled selected>請選擇</option>
                          <option value="繁體中文">繁體中文</option>
                          <option value="日語">日語</option>
                        </select>
                      </div>
                      <div class="mt-3">
                        <input
                          type="text"
                          class="form-control"
                          placeholder="請輸入 阿拉伯數字"
                          :value="selectedItem.publisher"
                          id="publisher"
                        />
                      </div>
                      <div class="mt-3">
                        <input
                          type="date"
                          class="form-control"
                          :value="selectedItem.publication_date"
                          id="publication_date"
                        />
                      </div>
                      <div class="mt-3">
                        <!-- <input
                          class="form-control"
                          type="file"
                          id="img"
                          accept=".jpg, .png, .webp"
                          :disabled="isReadOnly"
                          @change="previewObjectURL"
                        /> -->
                        <input
                          class="form-control"
                          type="file"
                          id="img"
                          accept=".jpg, .png, .webp"
                          @change="handleImageUpload($event, 'img')"
                        />
                      </div>
                      <div class="mt-3">
                        <!-- <input
                          class="form-control"
                          type="file"
                          id="previewObjectURL"
                          accept=".jpg, .png, .webp"
                          :disabled="isReadOnly"
                          @change="previewObjectURL"
                        /> -->
                        <input
                          class="form-control"
                          type="file"
                          id="previewObjectURL"
                          accept=".jpg, .png, .webp"
                          @change="handleImageUpload($event, 'comics_readfirst')"
                        />
                      </div>
                    </div>
                    <!-- 資料題 -->
                    <div class="col-md-1">
                      <div class="mb-3 mt-1">
                        <label class="col-form-label">報銷書籍</label>
                      </div>
                      <div class="mb-3">
                        <label class="col-form-label">書籍簡介</label>
                      </div>
                    </div>
                    <!-- 填寫區 -->
                    <div class="col-md-3">
                      <div class="mt-1">
                        <!-- 報銷預覽 -->
                        <input
                          class="form-check-input checkbox"
                          type="checkbox"
                          :checked="selectedItem.comics_status === '0'"
                          :disabled="selectedItem.comics_status === '0'"
                          v-model="comics_checked"
                          @change="handleCheckboxChange"
                        />
                      </div>
                      <div class="mb-3">
                        <textarea
                          class="form-control mb-4"
                          id="exampleFormControlTextarea1"
                          rows="10"
                          @input="countWords"
                          maxlength="150"
                          :value="selectedItem.intro"
                        ></textarea>
                      </div>
                      <div class="com_info_top">
                        <button class="com_info_btn" @click="openModal3">
                          送出
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- 第三層彈窗 -->
          <div class="showModal3" v-if="showModal3">
            <div class="modal_overlay" @click="closeModal3"></div>
            <div @click="closeModal3"></div>
            <div class="modal-content">
              <p>確定送出？</p>
              <div class="popup_btnarea">
                <button class="com_info_btn" @click="confirmChanges">
                  確定
                </button>
                <button class="com_info_btn" @click="closeModal3">取消</button>
              </div>
            </div>
          </div>

          <!-- 第四層彈窗 -->
          <div class="showModal4" v-show="showModal4">
            <div class="modal_overlay" @click="closeModal4"></div>
            <div @click="closeModal4"></div>
            <div class="modal-content">
              <p>確定報銷？</p>
              <div class="popup_btnarea">
                <button
                  class="com_info_btn"
                  @click="closeModal4AndToggleFirstClick"
                >
                  確定
                </button>
                <button class="com_info_btn" @click="closeModal4">取消</button>
              </div>
            </div>
          </div>

          <!-- 第五層彈窗 -->
          <div class="showModal5" v-show="showModal5">
            <div class="modal_overlay" @click="closeModal5"></div>
            <div @click="closeModal5"></div>
            <div class="modal-content">
              <p>確定取消報銷？</p>
              <div class="popup_btnarea">
                <button
                  class="com_info_btn"
                  @click="closeModal5AndToggleFirstClick"
                >
                  確定
                </button>
                <button class="com_info_btn" @click="closeModal5">取消</button>
              </div>
            </div>
          </div>
        </div>
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
      comics_checked: false,
      showModal4: false,
      showModal5: false,
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
      showModal4Confirmed: false, // 记录 showModal4 是否已确认
      currentModal: null, // 记录当前显示的弹窗
      selectedItem: null, // 选中的数据项
      editModes: [],
      selectedItemIndex: 0,
      isFirstClick: true,
      currentPage: 1, // 当前页数
      itemsPerPage: 10, // 每页显示的项数
      imageUrls: {
        img: [],
        comics_readfirst: [],
      },
      comics_status: false,
    };
  },
  computed: {
    comics_status: {
      get() {
        if (this.selectedItem.comics_status === 0) {
          true;
          this.openModal4();
        } else {
          false;
          openModal();
        }
      },
      set(value) {
        console.log("aaa");
        if (value === true) {
          this.selectedItem.comics_status = 0;
        } else {
          this.selectedItem.comics_status = 1;
        }
      },
    },
    // isDisabled() {
    //   return this.mode === "preview" && this.dataList === 0;
    // },
    // 頁數
    paginatedResults() {
      const startIndex = (this.currentPage - 1) * this.itemsPerPage;
      const endIndex = startIndex + this.itemsPerPage;
      return this.searchResults.slice(startIndex, endIndex);
    },
    totalPages() {
      return Math.max(
        Math.ceil(this.searchResults.length / this.itemsPerPage),
        1
      );
    },
    // 判断是否为最后一页
    // isLastPage() {
    //   return this.currentPage === this.totalPages;
    // },
  },
  methods: {
    closeModal(e) {
            this.$emit('emit-modal');
            // this.updateNewsData();
            if (this.title === '新增消息' && e.target.textContent === '發佈送出') {
                // console.log(7778);
                this.isReadOnly = false;
                this.addNewsData();
            } else if(this.title === '編輯消息' && e.target.textContent === '儲存編輯'){
                // console.log('wuwu');
                this.isReadOnly = true;
                this.updateNewsData();
            }
            else if(this.title === '新增消息'){
                this.isReadOnly = false;
            } else {
                this.isReadOnly = true;
            }

            console.log(e.target.textContent);
            if(e.target.textContent === '儲存草稿') {
                this.updateNewsData();
            } 

            // 圖檔清空
            this.tempImg = '';
            const fileName = document.querySelector('input[type="file"]');
            fileName.value = '';

            // if(e.target.textContent === '發佈送出') {
            //     this.addNewsData();
            // }
        },
        previewObjectURL(e) {
            // let [file] = e.target.files;
            // console.log('previewDataURI', file);
            // this.objectURL = window.URL.createObjectURL(file);
            const file = e.target.files.item(0);
            const reader = new FileReader();
            reader.addEventListener('load', (e) => {
                this.tempImg = e.target.result;
                console.log(e.target.result);
            });
            reader.readAsDataURL(file);
        },
        updateNewsData() {
        console.log('觸發上傳');
        const formData = new FormData(document.getElementById('news_modal'));

        this.axios.post(`${this.$URL}/updateComicData.php`, formData)
        .then(res => {
            console.log(res);
            })
        .catch(err => {
            console.log(err);
            })
        },
        addNewsData() {
        console.log('觸發上傳');
        const formData = new FormData(document.getElementById('news_modal'));
        this.axios.post(`${this.$URL}/addComicData.php`, formData)
        .then(res => {
            console.log(res);
        })
        .catch(err => {
            console.log(err);
        })
        },
        watch: {
        title() {
            if (this.title === '新增消息') {
                this.isReadOnly = false;
            } else {
                this.isReadOnly = true;
            }
        }
    },
    computed: {},
    components: { Form },



    // 圖片
    handleImageUpload(event, imgType) {
      const files = event.target.files;
      const maxImages = 1;

      for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();
        reader.onload = () => {
          if (this.imageUrls[imgType].length === maxImages) {
            this.imageUrls[imgType].splice(0, 1);
          }
          this.imageUrls[imgType].push(reader.result);
        };
        if (file) {
          reader.readAsDataURL(file);
        }
      }
    },

    // getImage(e) {
    //   const file = e.target.files.item(0);
    //   if (
    //     file.type !== "image/jpeg" &&
    //     file.type !== "image/png" &&
    //     file.type !== "image/jpg"
    //   ) {
    //     alert("只能上傳圖檔");
    //     return;
    //   }
    //   const reader = new FileReader();
    //   reader.addEventListener("load", this.imageLoaded);
    //   reader.readAsDataURL(file);
    // },
    // imageLoaded(e) {
    //   this.member_img = e.target.result;
    // },
    // uploadImg() {
    //   console.log("触发上传");
    //   const formData = new FormData(document.getElementById("pic"));
    //   this.axios
    //     .post(`${this.$URL}/uploadMemberImg.php`, formData)
    //     .then((res) => {
    //       console.log(res);
    //     })
    //     .catch((err) => {
    //       console.log(err);
    //     });
    // },
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
      // this.imageUrls.img = [];
      // this.imageUrls.comics_readfirst = [];
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
      // this.selectedItem.comics_status = 1 - this.selectedItem.comics_status;
      console.log(this.selectedItem.comics_status); // Before
      this.openModal4();
      // if (this.selectedItem.comics_status === "1") {
      //   if (this.isFirstClick) {
      //     this.openModal4();
      //   } else {
      //     this.openModal5();
      //   }
      // } else {
      //   this.closeModals();
      // }
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

    // 控制報銷視窗
    handleCheckboxChange() {
      this.showModal4 = this.comics_checked;
      this.showModal5 = !this.comics_checked;
    },
    closeModal4() {
      this.showModal4 = false;
    },
    closeModal5() {
      this.showModal5 = false;
    },
  },

  // 匯入mysql資料
  mounted() {
    this.axios.get(`${this.$URL}/getComicInfoImg.php`)
      .then(res => {
        console.log(res);
        this.dataList = res.data;
      })
      .catch(err => {
        console.log(err);
      })
  },
};
</script>
