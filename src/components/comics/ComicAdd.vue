<template>
  <div>
    <Form action="" id="ComicAdd_modal" method="post">
      <template v-slot:form_query> </template>

      <template v-slot:form_table>
        <form class="com_add" id="comicForm">
          <p>新增書籍資料</p>
          <div class="com_add_content">
            <div class="container">
              <div class="row">
                <div class="col-md-1">
                  <div class="mb-2">
                    <label class="col-form-label">建檔編號</label>
                  </div>
                  <div class="mb-2">
                    <label class="col-form-label">I S B N號</label>
                  </div>
                  <div class="mb-2">
                    <label class="col-form-label">書籍名稱</label>
                  </div>
                  <div class="mb-2">
                    <label class="col-form-label">書籍集數</label>
                  </div>
                  <div class="mb-2">
                    <label class="col-form-label">書籍作者</label>
                  </div>
                  <div class="mb-2">
                    <label class="col-form-label">書籍譯者</label>
                  </div>
                  <div class="mb-2">
                    <label class="col-form-label">漫畫分類</label>
                  </div>
                  <div class="mb-2">
                    <label class="col-form-label">熱門書籍</label>
                  </div>
                  <div class="mb-2">
                    <label class="col-form-label">新書推薦</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="mb-2">
                    <input
                      type="text"
                      name="comics_id"
                      class="form-control border-0"
                      readonly
                    />
                  </div>
                  <div class="mb-2">
                    <input
                      type="text"
                      class="form-control"
                      placeholder="請輸入 阿拉伯數字"
                      v-model="isbn"
                      @input="noChinese('isbn')"
                      maxlength="13"
                      name="isbn"
                    />
                  </div>
                  <div class="mb-2">
                    <input
                      type="text"
                      class="form-control"
                      placeholder="請輸入 最多64字"
                      v-model="title"
                      maxlength="64"
                      name="title"
                    />
                  </div>
                  <div class="mb-2">
                    <input
                      type="text"
                      class="form-control"
                      placeholder="請輸入 阿拉伯數字"
                      v-model="comics_index"
                      @input="noChinese('comics_index')"
                      maxlength="3"
                      name="comics_index"
                    />
                  </div>
                  <div class="mb-2">
                    <input
                      type="text"
                      class="form-control"
                      placeholder="請輸入 最多32字"
                      v-model="author"
                      maxlength="32"
                      name="author"
                    />
                  </div>
                  <div class="mb-2">
                    <input
                      type="text"
                      class="form-control"
                      placeholder="請輸入 最多32字"
                      v-model="translator"
                      maxlength="32"
                      name="translator"
                    />
                  </div>
                  <div class="mb-3">
                    <select class="form-select" v-model="type" name="type">
                      <option value="請選擇" disabled selected>請選擇</option>
                      <option value="冒險系列">冒險系列</option>
                      <option value="少男系列">少男系列</option>
                      <option value="魔法系列">魔法系列</option>
                      <option value="格鬥系列">格鬥系列</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <input
                      class="form-check-input checkbox"
                      type="checkbox"
                      :value="comics_hot_chekced"
                      name="comics_hot"
                      id="comics_hot"
                    />
                  </div>
                  <div class="mt-4">
                    <input
                      class="form-check-input checkbox"
                      type="checkbox"
                      :value="comics_new_chekced"
                      name="comics_new"
                      id="comics_new"
                    />
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="mb-2">
                    <label class="col-form-label">進貨價格</label>
                  </div>
                  <div class="mb-2">
                    <label class="col-form-label">書籍語言</label>
                  </div>
                  <div class="mb-2">
                    <label class="col-form-label">出版社</label>
                  </div>
                  <div class="mb-2">
                    <label class="col-form-label">出版日期</label>
                  </div>
                  <div class="mb-2">
                    <label class="col-form-label">封面更新</label>
                  </div>
                  <div class="mb-2">
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
                <div class="col-md-3">
                  <div class="mb-2">
                    <input
                      type="text"
                      class="form-control"
                      placeholder="請輸入 阿拉伯數字"
                      v-model="comics_price"
                      @input="noChinese('comics_price')"
                      maxlength="4"
                      name="comics_price"
                    />
                  </div>
                  <div class="mb-2">
                    <select
                      class="form-select"
                      v-model="language"
                      name="language"
                    >
                      <option value="請選擇" disabled selected>請選擇</option>
                      <option value="繁體中文">繁體中文</option>
                      <option value="日語">日語</option>
                    </select>
                  </div>
                  <div class="mb-2">
                    <input
                      type="text"
                      class="form-control"
                      placeholder="請輸入 最多12字"
                      v-model="publisher"
                      maxlength="12"
                      name="publisher"
                    />
                  </div>
                  <div class="form-row form-group">
                    <input
                      type="date"
                      class="form-control"
                      v-model="publication_date"
                      name="publication_date"
                    />
                  </div>
                  <div class="fileup">
                    <label for="formFile" class="form-label"></label>
                    <input
                      class="form-control"
                      type="file"
                      name="img"
                      @change="handleImageUpload($event, 'img')"
                    />
                  </div>
                  <div class="fileup">
                    <label for="formFile" class="form-label"></label>
                    <!-- 試讀頁面 -->
                    <input
                      class="form-control"
                      type="file"
                      name="comics_readfirst"
                      @change="handleImageUpload($event, 'comics_readfirst')"
                    />
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="mt-2 mb-4">
                    <label for="ol-form-label">書籍簡介</label>
                  </div>
                  <div class="col-mb-4">
                    <textarea
                      class="form-control mb-5"
                      rows="10"
                      v-model="intro"
                      @input="countWords"
                      maxlength="150"
                      name="intro"
                    ></textarea>
                    <p class="showWordcount">{{ showWordcount }}/150</p>
                    <!-- 確認紐 -->
                    <div class="com_add_btncontent">
                      <button
                        type="button"
                        class="com_add_btn"
                        @click="submitForm"
                        :disabled="!isFormValid"
                      >
                        送出
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- 第一層彈窗 -->
            <div class="modal_container" v-show="showModal">
              <div class="modal_overlay" @click="closeModal"></div>
              <div class="modal-content">
                <p>確定新增？</p>
                <div class="popup_btnarea">
                  <button class="com_add_btn" @click="submit">確定</button>
                  <button class="com_add_btn" @click="closeModal">取消</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </template>
    </Form>
  </div>
</template>
<script>
import Form from "@/components/Form.vue";
import { stringifyQuery } from "vue-router";

export default {
  components: {
    Form,
  },
  data() {
    return {
      comics_no: "",
      title: "",
      comics_index: "",
      type: "0",
      isbn: "",
      author: "",
      translator: "",
      intro: "",
      publisher: "",
      publication_date: "",
      language: "0",
      comics_price: "",
      comics_status: 1,
      comics_hot_chekced: 0,
      comics_new_chekced: 0,
      imageUrls: {
        img: [],
        comics_readfirst: [],
      },
      showWordcount: 0,
      showModal: false,
    };
  },
  computed: {
    isFormValid() {
      return (
        this.isbn !== "" &&
        this.title !== "" &&
        this.comics_index !== "" &&
        this.type !== "0" &&
        this.author !== "" &&
        this.translator !== "" &&
        this.intro !== "" &&
        this.publisher !== "" &&
        this.publication_date !== "" &&
        this.language !== "0" &&
        this.comics_price !== "" &&
        this.imageUrls.img.length > 0 &&
        this.imageUrls.comics_readfirst.length > 0
      );
    },
  },
  methods: {
    submitForm() {
      if (!this.isFormValid) {
        alert("請填寫所有必填欄位");
        return;
      }

      // Open the confirmation modal
      this.showModal = true;
    },
    /*檢查輸入值是否是阿拉伯数字*/
    noChinese(inputType) {
      let inputValue = this[inputType];
      inputValue = inputValue.replace(/[^\d]/g, "");
      this[inputType] = inputValue;
    },
    /*圖片*/
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
    /*計算數字*/
    countWords() {
      this.showWordcount = this.intro.length;
    },
    /*視窗*/
    openModal() {
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
    },
    submitData() {
      this.closeModal();
    },
    // php新增
    submit(event) {
      console.log("觸發上傳");
      event.preventDefault(); //解決默認狀態
      const formData = new FormData(document.getElementById("comicForm"));

      // 添加图片文件
      const imgFile = this.imageUrls.img[0]; // 获取第一张图片
      formData.append("img", imgFile);

      const comicsReadFirstFile = this.imageUrls.comics_readfirst[0]; // 获取第一张漫画阅读首图
      formData.append("comics_readfirst", comicsReadFirstFile);

      this.axios
        .post(`${this.$URL}/addComicAdd.php`, formData)
        .then((res) => {
          console.log(res);
          this.closeModal(); // 關閉確認弹窗
          alert("書籍新增成功");
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  mounted() {
    const comics_hot = document.getElementById("comics_hot");
    const comics_new = document.getElementById("comics_new");
    comics_hot.addEventListener("input", () => {
      this.comics_hot_chekced = comics_hot.checked ? 1 : 0; // Change here
    });
    comics_new.addEventListener("input", () => {
      this.comics_new_chekced = comics_new.checked ? 1 : 0; // Change here
    });
  },
};
</script>
