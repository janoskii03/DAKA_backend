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
                  <input
                    type="text"
                    class="form-control border-0"
                    id="name"
                    placeholder="流水號"
                    readonly
                  />
                </div>
                <div class="mb-3">
                  <input
                    type="text"
                    class="form-control"
                    id="name"
                    placeholder="請輸入"
                  />
                </div>
                <div class="mb-3">
                  <input
                    type="text"
                    class="form-control"
                    id="name"
                    placeholder="請輸入"
                  />
                </div>
                <div class="mb-3">
                  <input
                    type="text"
                    class="form-control"
                    id="name"
                    placeholder="請輸入 阿拉伯數字"
                  />
                </div>
                <div class="mb-3">
                  <input
                    type="text"
                    class="form-control"
                    id="name"
                    placeholder="請輸入"
                  />
                </div>
                <div class="mb-3">
                  <input
                    type="text"
                    class="form-control"
                    id="name"
                    placeholder="請輸入"
                  />
                </div>
                <div class="mb-3">
                  <select
                    class="form-select"
                    aria-label="Default select example"
                  >
                    <option selected>請選擇</option>
                    <option value="1">冒險系列</option>
                    <option value="2">少男系列</option>
                    <option value="3">魔法系列</option>
                  </select>
                </div>
                <div class="mt-4">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    value=""
                    id="defaultCheck1"
                  />
                </div>
                <div class="mt-4">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    value=""
                    id="defaultCheck1"
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
                  <label class="col-form-label">圖片更新</label>
                </div>
                <div class="mb-3">
                  <input
                    type="file"
                    class="form-control-file"
                    id="imageUpload"
                    name="imageUpload"
                  />
                </div>
              </div>
              <div class="col-md-3">
                <div class="mb-3">
                  <input
                    type="text"
                    class="form-control"
                    id="name"
                    placeholder="請輸入"
                  />
                </div>
                <div class="mb-3">
                  <select
                    class="form-select"
                    aria-label="Default select example"
                  >
                    <option selected>請選擇</option>
                    <option value="1">繁體中文</option>
                    <option value="2">日語</option>
                  </select>
                </div>
                <div class="mb-3">
                  <input
                    type="text"
                    class="form-control"
                    id="name"
                    placeholder="請輸入"
                  />
                </div>
                <div class="mb-3">
                  <input
                    type="text"
                    class="form-control"
                    id="name"
                    placeholder="請輸入 西元年/月/日 (****/**/**)"
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
                  ></textarea>
                  <div class="com_add_btncontent">
                    <button type="submit" class="btn btn-outline-secondary com_add_btn">
                      確認
                    </button>
                  </div>
                </div>
              </div>
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
    return {};
  },
  methods: {},
};
</script>
