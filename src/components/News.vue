<template>
  <div>
    <Form>

      <template v-slot:form_query>
        <button class="btn btn-dark member_add" type="submit" @click="showModal">新增消息<img src="@/assets/images/member/plus.svg" alt="plus" class="member_plus">
        </button>
        <div class="col-md-2">
          <select class="form-select" v-model="selectedCategory" @change="filterDataList">
            <option value="" selected>請選擇類別</option>
            <option value="NEWS">NEWS</option>
            <option value="ACTIVITY">ACTIVITY</option>
          </select>
        </div>
        <div class="col-md-2">
          <div class="input-group">
            <input type="search" class="form-control" placeholder="請輸入標題關鍵字" aria-describedby="basic-addon1"
              v-model="search" @keyup.enter="searchNews" />
            <span class="input-group-text" id="basic-addon1" @click="searchNews">
              <img src="@/assets/images/search.svg" alt="search">
            </span>
          </div>
        </div>
      </template>
      <template v-slot:form_table>
        <table class="main_list">
          <tr>
            <!-- 資料表頭 -->
            <th v-for="column in columns" :key="column">{{ column }}</th>
          </tr>
          <!--  消息資料 -->
          <tr 
          v-for="item in filteredDataList" 
          :key="item.index" 
          @click="emitData(item,$event)"
          class="align-middle">
            <td>{{ item.news_title }}</td>
            <td>{{ item.news_category }}</td>
            <td>{{ item.news_status }}</td>
            <td>{{ item.news_date }}</td>
            <td>{{ item.ename }}</td>
            <td>{{ item.admin_id }}</td>
            <button class="btn btn-dark align-middle" type="submit">
              delete
            </button>
          </tr>
        </table>
        <div class="alert alert-warning" v-if="search && filteredDataList.length === 0">
          查無此消息標題，請重新搜尋！
        </div>

      </template>
    </Form>
    <NewsModal
    v-show="modalSwitch"
    @emit-modal="modalSwitch = false"
    :news="data"
    :title="title"
    :btn_text="btn_text"/>
  </div>
</template>
<script>
// import { GET } from '@/plugin/axios';
import Form from '@/components/Form.vue';
import { Step } from 'view-ui-plus';
import NewsModal from '@/components/NewsModal.vue';
export default {
  components: {
    Form, NewsModal,
  },
  data() {
    return {
      dataList: [],
      columns: [
        '標題',
        '類別',
        '狀態',
        '編輯日期',
        '編輯者',
        '員工編號',
      ],
      data: [],
      modalSwitch: false,
      filteredDataList: [],
      search: '',
      selectedCategory: '',
      title: '編輯消息',
      btn_text: '發佈送出',
    }
  },
  methods: {
    showModal(e){
      // console.log(e.target.textContent);
      if(e.target.textContent === '新增消息') {
        this.data = [];
        this.title = '新增消息';
        this.btn_text = '發佈送出'
        // this.modalSwitch = true;
        // return;
      } else {
        this.title = '編輯消息';
        this.btn_text = '儲存編輯';
      }
      this.modalSwitch = true;
    },
    emitData(data,e) {
      this.data = data;
      // console.log("emitData::e",e)
      this.showModal(e);
    },
    filterDataList() {
      let filteredData = this.dataList;
      const selectedCategoryText = this.selectedCategory;

      if (selectedCategoryText) {
        filteredData = filteredData.filter(item => item.news_category === selectedCategoryText);
      }

      if (this.search) {
        filteredData = filteredData.filter(item => item.news_title.includes(this.search));
      }

      this.filteredDataList = filteredData;

    },
    searchNews() {
      if (this.search === '') {
        // this.filteredDataList = this.dataList;
        // console.log(7778);
        alert('請輸入關鍵字');
        return;
        
      } else {
        this.filteredDataList = this.dataList.filter(item => {
          if(item.news_title.includes(this.search) && item.news_category === this.selectedCategory) {
            return this;
          }
        });
      }
    },

  },
  //   computed: {
  //   filteredDataList() {
  //     if (this.selectedCategory === '') {
  //       return this.dataList;
  //     } else {
  //       return this.dataList.filter(item => item.news_category === this.selectedCategory);
  //     }
  //   }
  // },
  mounted() {
    this.axios.get(`${this.$URL}/getAllNews.php`)
      .then(res => {
        console.log(res);
        this.dataList = res.data;
      })
      .catch(err => {
        console.log(err);
      })
  },
}
</script>

<style lang="scss" scoped>
[alt="plus"]{
  pointer-events: none;
}

</style>
