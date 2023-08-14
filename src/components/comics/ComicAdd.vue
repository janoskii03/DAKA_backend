<template>
  <div>
    <Form>
      <template v-slot:form_query> </template>

      <template v-slot:form_table>
        <div class="com_add">
          <p>新增書籍資料</p>
          <div class="com_add_content">
            <div class="container">
              <div class="row">
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
                <div class="col-md-3">
                  <div class="mb-3">
                    <input type="text" class="form-control border-0" readonly />
                  </div>
                  <div class="mb-3">
                    <input
                      type="text"
                      class="form-control"
                      placeholder="請輸入 阿拉伯數字"
                      v-model="isbn"
                      @input="noChinese('isbn')"
                      maxlength="13"
                    />
                  </div>
                  <div class="mb-3">
                    <input
                      type="text"
                      class="form-control"
                      placeholder="請輸入 最多64字"
                      v-model="title"
                      maxlength="64"
                    />
                  </div>
                  <div class="mb-3">
                    <input
                      type="text"
                      class="form-control"
                      placeholder="請輸入 阿拉伯數字"
                      v-model="comics_index"
                      @input="noChinese('comics_index')"
                      maxlength="3"
                    />
                  </div>
                  <div class="mb-3">
                    <input
                      type="text"
                      class="form-control"
                      placeholder="請輸入 最多32字"
                      v-model="author"
                      maxlength="32"
                    />
                  </div>
                  <div class="mb-3">
                    <input
                      type="text"
                      class="form-control"
                      placeholder="請輸入 最多32字"
                      v-model="translator"
                      maxlength="32"
                    />
                  </div>
                  <div class="mb-3">
                    <select class="form-select" v-model="type">
                      <option value="0" disabled selected>請選擇</option>
                      <option value="1">冒險系列</option>
                      <option value="2">少男系列</option>
                      <option value="3">魔法系列</option>
                    </select>
                  </div>
                  <div class="mt-4">
                    <input
                      class="form-check-input checkbox"
                      type="checkbox"
                      value=""
                      id="comics_new"
                    />
                  </div>
                  <div class="mt-4">
                    <input
                      class="form-check-input checkbox"
                      type="checkbox"
                      value=""
                      id="comics_hot"
                    />
                  </div>
                </div>
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
                  <div class="mb-3">
                    <input
                      type="text"
                      class="form-control"
                      placeholder="請輸入 阿拉伯數字"
                      v-model="comics_price"
                      @input="noChinese('comics_price')"
                      maxlength="4"
                    />
                  </div>
                  <div class="mb-3">
                    <select class="form-select" v-model="language">
                      <option value="0" disabled selected>請選擇</option>
                      <option value="1">繁體中文</option>
                      <option value="2">日語</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <input
                      type="text"
                      class="form-control"
                      placeholder="請輸入 最多12字"
                      v-model="publisher"
                      maxlength="12"
                    />
                  </div>
                  <div class="form-row form-group">
                    <input
                      type="date"
                      class="form-control"
                      v-model="publication_date"
                    />
                  </div>
                  <div class="fileup">
                    <label for="formFileMultiple" class="form-label"></label>
                    <input
                      class="form-control"
                      type="file"
                      @change="handleImageUpload($event, 'img')"
                    />
                  </div>
                  <div class="mb-3 fileup">
                    <label for="formFile" class="form-label"></label>
                    <input
                      class="form-control"
                      type="file"
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
                      id="exampleFormControlTextarea1"
                      rows="10"
                      v-model="intro"
                      @input="countWords"
                      maxlength="150"
                    ></textarea>
                    <p class="showWordcount">{{ showWordcount }}/150</p>
                    <!-- 確認紐 -->
                    <div class="com_add_btncontent">
                      <button
                        type="button"
                        class="com_add_btn"
                        @click="openModal"
                        :disabled="!isFormValid"
                      >
                        送出
                      </button>
                    </div>
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
                <button class="com_add_btn" @click="submitData">確定</button>
                <button class="com_add_btn" @click="closeModal">取消</button>
              </div>
            </div>
          </div>
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
      isbn: "",
      title: "",
      comics_index: "",
      type: "0",
      author: "",
      translator: "",
      intro: "",
      publisher: "",
      publication_date: "",
      language: "0",
      comics_price: "",
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
    getImage(e) {
      const file = e.target.files.item(0);
      if(file.type !== 'image/jpeg' && file.type !== 'image/png' && file.type !== 'image/jpg') {
        alert('只能上傳圖檔');
        return;
      }
      const reader = new FileReader();
      reader.addEventListener('load', this.imageLoaded);
      reader.readAsDataURL(file);
    },
    imageLoaded(e) {
      this.member_img = e.target.result;
    },
    uploadImg() {
      console.log('触发上传');
      const formData = new FormData(document.getElementById('pic'));
      this.axios.post(`${this.$URL}/uploadMemberImg.php`, formData)
        .then(res => {
          console.log(res);
        })
        .catch(err => {
          console.log(err);
        });
    },
    getContent(title) {
      this.content = title;
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
  },
};
</script>
