<template>
  <div>
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
        <table class="main_list">
          <tr>
            <th v-for="header in comics_id">{{ header }}</th>
          </tr>
          <tr
            v-for="(item, index) in searchResults"
            :key="index"
            @click="openModal1"
          >
            <td>{{ item.isbn }}</td>
            <td>{{ item.comics_no }}</td>
            <td class="col-md-3">{{ item.title + item.comics_index }}</td>
            <td>{{ item.comics_price }}</td>
            <td>{{ item.comics_status }}</td>
          </tr>
          



          <div class="comic_info">
            <!-- 第一層彈窗 -->
            <div class="modal_container" v-show="showModal1">
              <div class="modal_overlay" @click="closeModal1"></div>
              <div class="showModal1">
                <div class="titleare">
                  <p>修改書籍資料</p>
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
                          class="form-control border-0"
                          readonly
                          placeholder="請輸入 阿拉伯數字"
                        />
                      </div>
                      <div class="mt-3">
                        <input
                          type="text"
                          class="form-control border-0"
                          readonly
                          placeholder="請輸入 阿拉伯數字"
                        />
                      </div>
                      <div class="mt-4">
                        <input
                          type="text"
                          class="form-control border-0"
                          readonly
                          placeholder="請輸入 阿拉伯數字"
                        />
                      </div>
                      <div class="mt-3">
                        <input
                          type="text"
                          class="form-control border-0"
                          readonly
                          placeholder="請輸入 阿拉伯數字"
                        />
                      </div>
                      <div class="mt-3">
                        <input
                          type="text"
                          class="form-control border-0"
                          readonly
                          placeholder="請輸入 阿拉伯數字"
                        />
                      </div>
                      <div class="mt-3">
                        <input
                          type="text"
                          class="form-control border-0"
                          readonly
                          placeholder="請輸入 阿拉伯數字"
                        />
                      </div>
                      <div class="mt-3">
                        <select class="form-select" v-model="type" disabled>
                          <option value="0" disabled selected>請選擇</option>
                          <option value="1">冒險系列</option>
                          <option value="2">少男系列</option>
                          <option value="3">魔法系列</option>
                        </select>
                      </div>
                      <div class="mt-3">
                        <input
                          class="form-check-input checkbox"
                          type="checkbox"
                          value=""
                          id="comics_new"
                          disabled
                        />
                      </div>
                      <div class="mt-4">
                        <input
                          class="form-check-input checkbox"
                          type="checkbox"
                          value=""
                          id="comics_hot"
                          disabled
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
                          class="form-control border-0"
                          readonly
                          placeholder="請輸入 阿拉伯數字"
                        />
                      </div>
                      <div class="mt-3">
                        <select class="form-select" v-model="language" disabled>
                          <option value="0" disabled selected>請選擇</option>
                          <option value="1">繁體中文</option>
                          <option value="2">日語</option>
                        </select>
                      </div>
                      <div class="mt-3">
                        <input
                          type="text"
                          class="form-control border-0"
                          readonly
                          placeholder="請輸入 阿拉伯數字"
                        />
                      </div>
                      <div class="mt-3">
                        <input type="date" class="form-control" readonly />
                      </div>
                      <div class="mt-3">
                        <input class="form-control" type="file" disabled />
                      </div>
                      <div class="mt-3">
                        <input class="form-control" type="file" disabled />
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
                          type="checkbox"
                          value=""
                          id="comics_status"
                          disabled
                        />
                      </div>
                      <div class="mb-3">
                        <textarea
                          class="form-control border-0 mb-4"
                          id="exampleFormControlTextarea1"
                          rows="10"
                          v-model="intro"
                          @input="countWords"
                          maxlength="150"
                          readonly
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

            <!-- 第二層彈窗 -->
            <div class="modal_container" v-show="showModal2">
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
                          class="form-control border-0"
                          readonly
                          placeholder="請輸入 阿拉伯數字"
                        />
                      </div>
                      <div class="mt-3">
                        <input
                          type="text"
                          class="form-control border-0"
                          readonly
                          placeholder="請輸入 阿拉伯數字"
                        />
                      </div>
                      <div class="mt-4">
                        <input
                          type="text"
                          class="form-control border-0"
                          readonly
                          placeholder="請輸入 阿拉伯數字"
                        />
                      </div>
                      <div class="mt-3">
                        <input
                          type="text"
                          class="form-control border-0"
                          readonly
                          placeholder="請輸入 阿拉伯數字"
                        />
                      </div>
                      <div class="mt-3">
                        <input
                          type="text"
                          class="form-control border-0"
                          readonly
                          placeholder="請輸入 阿拉伯數字"
                        />
                      </div>
                      <div class="mt-3">
                        <input
                          type="text"
                          class="form-control border-0"
                          readonly
                          placeholder="請輸入 阿拉伯數字"
                        />
                      </div>
                      <div class="mt-3">
                        <select class="form-select" v-model="type" disabled>
                          <option value="0" disabled selected>請選擇</option>
                          <option value="1">冒險系列</option>
                          <option value="2">少男系列</option>
                          <option value="3">魔法系列</option>
                        </select>
                      </div>
                      <div class="mt-3">
                        <input
                          class="form-check-input checkbox"
                          type="checkbox"
                          value=""
                          id="comics_new"
                          disabled
                        />
                      </div>
                      <div class="mt-4">
                        <input
                          class="form-check-input checkbox"
                          type="checkbox"
                          value=""
                          id="comics_hot"
                          disabled
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
                          class="form-control border-0"
                          readonly
                          placeholder="請輸入 阿拉伯數字"
                        />
                      </div>
                      <div class="mt-3">
                        <select class="form-select" v-model="language" disabled>
                          <option value="0" disabled selected>請選擇</option>
                          <option value="1">繁體中文</option>
                          <option value="2">日語</option>
                        </select>
                      </div>
                      <div class="mt-3">
                        <input
                          type="text"
                          class="form-control border-0"
                          readonly
                          placeholder="請輸入 阿拉伯數字"
                        />
                      </div>
                      <div class="mt-3">
                        <input type="date" class="form-control" readonly />
                      </div>
                      <div class="mt-3">
                        <input class="form-control" type="file" disabled />
                      </div>
                      <div class="mt-3">
                        <input class="form-control" type="file" disabled />
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
                          type="checkbox"
                          value=""
                          id="comics_status"
                          disabled
                        />
                      </div>
                      <div class="mb-3">
                        <textarea
                          class="form-control border-0 mb-4"
                          id="exampleFormControlTextarea1"
                          rows="10"
                          v-model="intro"
                          @input="countWords"
                          maxlength="150"
                          readonly
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

            <!-- 第三層彈窗 -->
            <div class="showModal3" v-show="showModal3">
              <div class="modal_overlay" @click="closeModal3"></div>
              <div @click="closeModal3"></div>
              <div class="modal-content">
                <p>確定送出？</p>
                <div class="popup_btnarea">
                  <button class="com_info_btn" @click="confirmChanges">
                    確定
                  </button>
                  <button class="com_info_btn" @click="closeModal3">
                    取消
                  </button>
                </div>
              </div>
            </div>
          </div>
        </table>

        <!-- 搜尋 -->
        <div
            class="alert alert-warning"
            v-if="search && searchResults.length === 0"
          >查無此消息標題，請重新搜尋！
          </div>
      </template>
    </Form>
  </div>
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
      dataList: [
        {
          isbn: "9789861127224",
          comics_no: "CM0001",
          title: "ONE PIECE航海王",
          comics_index: "12",
          comics_price: "89元",
          comics_status: "已報銷",
        },
        {
          isbn: "9789861127224",
          comics_no: "CM0021",
          title: "ONE PIECE航海王",
          comics_index: "12",
          comics_price: "89元",
          comics_status: "可租借",
        },
        {
          isbn: "9784088816081",
          comics_no: "CM0006",
          title: "(日本版漫畫)咒術迴戰",
          comics_index: "2",
          comics_price: "207元",
          comics_status: "可租借",
        },
      ],
      searchOption: "0",
      searchInput: "",
      searchResults: [],
      search: false, // 控制是否执行搜索
      showModal1: false,
      showModal2: false,
      showModal3: false,
    };
  },
  methods: {
    performSearch() {
      this.search = true; // 设置为 true 表示执行搜索
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
    // 确认修改，处理数据提交等逻辑
    confirmChanges() {
      // 处理数据修改逻辑...

      // 关闭所有弹窗，回到初始状态
      this.closeModal1();
      this.closeModal2();
      this.closeModal3();
    },
    // 其他方法...
  },
};
</script>
