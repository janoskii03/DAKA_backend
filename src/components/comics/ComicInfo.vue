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
                            placeholder="請輸入 阿拉伯數字"
                            :value="selectedItem.comics_no"
                          />
                        </div>
                        <div class="mt-3">
                          <input
                            type="text"
                            class="form-control"
                            placeholder="請輸入 阿拉伯數字"
                            :value="selectedItem.isbn"
                          />
                        </div>
                        <div class="mt-4">
                          <input
                            type="text"
                            class="form-control"
                            placeholder="請輸入 阿拉伯數字"
                            :value="selectedItem.title"
                          />
                        </div>
                        <div class="mt-3">
                          <input
                            type="text"
                            class="form-control"
                            placeholder="請輸入 阿拉伯數字"
                            :value="selectedItem.comics_index"
                          />
                        </div>
                        <div class="mt-3">
                          <input
                            type="text"
                            class="form-control"
                            placeholder="請輸入 阿拉伯數字"
                            :value="selectedItem.author"
                          />
                        </div>
                        <div class="mt-3">
                          <input
                            type="text"
                            class="form-control"
                            placeholder="請輸入 阿拉伯數字"
                            :value="selectedItem.translator"
                          />
                        </div>
                        <div class="mt-3">
                          <select
                            class="form-select"
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
                          />
                        </div>
                        <div class="mt-3">
                          <input
                            class="form-check-input checkbox"
                            type="checkbox"
                            value=""
                            :value="selectedItem.author"
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
                            placeholder="請輸入 阿拉伯數字"
                            :value="selectedItem.comics_price"
                          />
                        </div>
                        <div class="mt-3">
                          <select
                            class="form-select"
                            :value="selectedItem.language"
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
                          />
                        </div>
                        <div class="mt-3">
                          <input
                            type="date"
                            class="form-control"
                            :value="selectedItem.publication_date"
                          />
                        </div>
                        <div class="mt-3">
                          <input class="form-control" type="file" />
                        </div>
                        <div class="mt-3">
                          <input class="form-control" type="file" />
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
                            :value="selectedItem.comics_status"
                            :checked="selectedItem.comics_status === '0'"
        @click="handleCheckboxClick"
        :disabled="selectedItem.comics_status === '0'"
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

            <!-- 第四層彈窗 -->
            <div class="showModal4" v-show="showModal4">
              <div class="modal_overlay" @click="closeModal4"></div>
              <div @click="closeModal4"></div>
              <div class="modal-content">
                <p>確定報銷？</p>
                <div class="popup_btnarea">
                  <button class="com_info_btn" @click="closeModal4AndToggleFirstClick">
                    確定
                  </button>
                  <button class="com_info_btn" @click="closeModal4">
                    取消
                  </button>
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
                  <button class="com_info_btn" @click="closeModal5AndToggleFirstClick">
                    確定
                  </button>
                  <button class="com_info_btn" @click="closeModal5">
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
        >
          查無此消息標題，請重新搜尋！
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
          comics_id: "1",
          comics_no: "CM0001",
          title: "ONE PIECE航海王",
          comics_index: "12",
          type: "冒險系列",
          isbn: "9789861127224",
          author: "尾田榮一郎",
          translator: "張家銘",
          intro:
            "崇拜海賊的少年魯夫，因為誤食了惡魔的果實，成了身體能無限伸長的橡皮人，卻也使他一輩子無法游泳。但魯夫還是開始了他成為海賊王的冒險！",
          publisher: "東立",
          publication_date: "2003-10-07",
          language: "繁體中文",
          comics_price: "89",
          comics_status: "0",
          img: "comic/001.webp",
          comics_readfirst: "comic/RD001.webp",
          comics_new: "1",
          comics_hot: "0",
        },
        {
          comics_id: "6",
          comics_no: "CM0006",
          title: "(日本版漫畫)咒術迴戰",
          comics_index: "2",
          type: "少男系列",
          isbn: "9784088816081",
          author: "",
          translator: "張家銘",
          intro:
            "少年院内に、突如呪胎が発生。取り残された人間を救助する為、虎杖ら高専1年が派遣された! だが特級呪霊へ変態した呪胎に襲撃を受け、ピンチに陥る一行。虎杖は宿儺と入れ替わり、呪霊を倒そうと試みるが……!?",
          publisher: "集英社",
          publication_date: "2018-09-04",
          language: "日文",
          comics_price: "207",
          comics_status: "1",
          img: "comic/006.webp",
          comics_readfirst: "comic/RD006.webp",
          comics_new: "0",
          comics_hot: "0",
        },
        {
          comics_id: "13",
          comics_no: "CM0013",
          title: "鬼滅之刃",
          comics_index: "12",
          type: "格鬥系列",
          isbn: "9789572617151",
          author: "吾峠呼世晴",
          translator: "林志昌",
          intro:
            "相隔113年又有上弦之鬼犧牲，憤怒的無慘對剩下的上弦之鬼們下達進一步的命令！另一方面，鋼鐵塚因為炭治郎跟妓夫太郎戰鬥造成刀子捲刃而相當憤怒。為了得到全新的刀，炭治郎造訪了鋼鐵塚所在的刀匠故鄉…？",
          publisher: "東立",
          publication_date: "2019-11-18",
          language: "繁體中文",
          comics_price: "93",
          comics_status: "1",
          img: "comic/012.webp",
          comics_readfirst: "comic/RD012.webp",
          comics_new: "0",
          comics_hot: "1",
        },
        {
          comics_id: "20",
          comics_no: "CM0020",
          title: "庫洛魔法使 透明牌篇",
          comics_index: "7",
          type: "魔法系列",
          isbn: "9789572641422",
          author: "CLAMP",
          translator: "陳姿君",
          intro:
            "小櫻等人換穿夏季制服了。某一天在上課時，出現巨大的剪刀攻擊教室！每次發生事件，都會出現新的卡牌，小櫻終於察覺「透明牌」的祕密。然後，小狼對她說出一個真相…？另一方面，來自英國的那個人出現在雪兔家？",
          publisher: "東立",
          publication_date: "2020-03-27",
          language: "繁體中文",
          comics_price: "204",
          comics_status: "1",
          img: "comic/020.webp",
          comics_readfirst: "comic/RD020.webp",
          comics_new: "0",
          comics_hot: "0",
        },
      ],
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
    };
  },
  computed: {
    isDisabled() {
      return this.mode === "preview" && this.dataList === 0;
    },
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
      if (this.selectedItem.comics_status === '1') {
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
