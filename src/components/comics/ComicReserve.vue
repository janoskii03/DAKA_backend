<template>
  <div>
    <Form >
    <template v-slot:form_query>
      <div>
        <input type="search" id="searchInput" placeholder="預約取書請輸入電話">
        <button id="searchButton">
          <i class="bi bi-search"></i>
        </button>
      </div>
      <!-- <input type="search"> -->
    </template>
    <template v-slot:form_table >
      <table class="main_list">
        <tr>
          <th v-for="order in comics_order" :key="order">{{ order }}</th>
        </tr>
        <tr v-for="(item, index) in dataList" :key="index" @click="openModal(index)">
          <td >{{ item.comics_order_no }}</td>
          <td>{{ item.menno }}</td>
          <td>{{ item.comics_order_date }}</td>
          <td>{{ item.comics_borrow_date }}</td>
          <td>{{ item.comics_return_date }}</td>
          <td>{{ item.comics_borrow}}</td>
        </tr>
      </table>
      <div class="modal-backdrop" v-show="showModal"></div>
       <!-- 彈窗 -->
       <div v-show="showModal" class="com_reserve_modal">
            <div class="modal_title">
              <h5>預約明細</h5>
              <img src="@/assets/images/member/close.svg" alt="close" class="close_window" @click="closeModal"> 
            </div>
            <div class="com_reserve_box">
              <div class="com_reserve_container">
                <table>
                  <tr>
                    <td>
                      <p>會員電話</p>
                      <span class="detail_content">{{ selectedItem.menno }}</span>
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
                      <span class="detail_content"></span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <p>應還日期</p>
                      <span class="detail_content">{{ selectedItem.comics_return_date }}</span>
                    </td>
                    <td>
                      <p>歸還日期</p>
                      <span class="detail_content"></span>
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
                    <tr v-for="(book, index) in selectedItem.books" :key="index">
                      <td>{{ index + 1 }}</td>
                      <td>{{ book.comics_no }}</td>
                      <td>{{ book.title }}</td>
                      <td>{{ book.amount }}</td>
                    </tr>
                </table>
              </div>
              <div class="check_line">
                <div class="pickup_button">
                  <button type="submit" @click="closeModal">取書</button>
                </div>
                <div class="total_amount">
                  <tr>
                    <p>總金額</p>
                    <span>{{ countTotal() }}</span>
                  </tr>
                </div>
              </div>
            </div>
        </div>
    </template>    
    </Form>
  </div>
</template>
<script>
import Form from '@/components/Form.vue';

export default {
  components: {
    Form
  },
  data() {
    return {
      showModal:false,
      comics_order: [
        '訂單編號',
        '姓名',
        '預約日期',
        '取書日期',
        '應還日期',
        '租借狀態'
      ],
      dataList:[
        {
          comics_order_no: 'CB0001',
          menno:'忘記了',
          comics_order_date:'2023-05-01',
          comics_borrow_date:'2023-05-02',
          comics_return_date:'2023-05-05',
          comics_borrow: '已取書',
          books: [
          {
            comics_no: 'CM0001',
            title: 'ONE PIECE航海王12',
            amount: '$10',
          },
        ]
        },
        {
          comics_order_no: 'CB0002',
          menno:'忘記了',
          comics_order_date:'2023-05-04',
          comics_borrow_date:'2023-05-05',
          comics_return_date:'2023-05-07',
          comics_borrow: '已取書',
          books: [
          {
            comics_no: 'CM0002',
            title: 'ONE PIECE航海王12',
            amount: '$10',
          },
          {
            comics_no: 'CM0006',
            title: '(日本版漫畫)咒術迴戰',
            amount: '$10',
          },
          {
            comics_no: 'CM0009',
            title: '鬼滅之刃',
            amount: '$10',
          },
        ]
        },
        {
          comics_order_no: 'CB0003',
          menno:'忘記了',
          comics_order_date:'2023-05-05',
          comics_borrow_date:'2023-05-06',
          comics_return_date:'2023-05-08',
          comics_borrow: '已取書',
          books: [
          {
            comics_no: 'CM0003',
            title: 'ONE PIECE航海王12',
            amount: '$10',
          },
          {
            comics_no: 'CM0014',
            title: '庫洛魔法使 透明牌篇1',
            amount: '$10',
          },
          {
            comics_no: 'CM0019',
            title: '庫洛魔法使 透明牌篇6',
            amount: '$10',
          },
          {
            comics_no: 'CM0020',
            title: '庫洛魔法使 透明牌篇7',
            amount: '$10',
          },
          {
            comics_no: 'CM0013',
            title: '鬼滅之刃12',
            amount: '$10',
          },
        ]
        }
      ],
      selectedItem:{}
    }
  },
  methods: {

    openModal(index) {
      console.log(123);
      this.showModal=!this.showModal;
      this.selectedItem=this.dataList[index];
      console.log(this.selecteditem);
    },
    closeModal(){
      this.showModal=false;
    },
    countTotal() {
      let totalAmount = 0;
      if (this.selectedItem && this.selectedItem.books) {
        for (const book of this.selectedItem.books) {
          const amount = parseInt(book.amount.replace('$', ''), 10);
          if (!isNaN(amount)) {
            totalAmount += amount;
          }
        }
      }

      return `$${totalAmount}`;
    },
  }
}
</script>

