<template>
  <div class="seats_now_all row">
    <div class="seats_now_all_info col">
      <div class="seat_info">
        <div class="seat_info_title">
          <p>座位狀態<br><span>{{ currentTime }}</span></p>
        </div>
        <div class="seat">
          {{
            selectedSeat.seat_area === "A"
            ? "大廳電競"
            : selectedSeat.seat_area === "B"
              ? "大廳一般"
              : selectedSeat.seat_area === "C"
                ? "單人包廂"
                : selectedSeat.seat_area === "D"
                  ? "雙人包廂"
                  : "請選擇座位"
          }}
          {{ selectedSeat.seat_area }}-{{ selectedSeat.seat_number }}
        </div>
        <div class="seat_state input-group mb-3">
          <span class="input-group-text seat_now_input" id="seat_state">狀態</span>
          <input type="text" class="form-control" :value="seatState" aria-label="使用中" aria-describedby="seat_state"
            disabled />
        </div>
        <div class="seat_user input-group mb-3">
          <span class="input-group-text seat_now_input" id="seat_user"
            >使用者</span
          >
          <input
            type="text"
            class="form-control"
            :value="selectedOrder.mname"
            aria-label="王大明"
            aria-describedby="seat_user"
            disabled
          />
        </div>
        <div class="seat_user_phone input-group mb-3">
          <span class="input-group-text seat_now_input" id="seat_user_phone"
            >手機</span
          >
          <input
            type="text"
            class="form-control"
            :value="selectedOrder.mobile"
            aria-label="0988123456"
            aria-describedby="seat_user_phone"
            disabled
          />
        </div>
        <div class="seat_start_time input-group mb-3">
          <span class="input-group-text seat_now_input" id="seat_start_time"
            >開始時間</span
          >
          <input
            type="text"
            class="form-control"
           :value="selectedOrder.seat_order_startdate"
            aria-label="2023/07/30 PM02:00"
            aria-describedby="seat_start_time"
            disabled
          />
        </div>
        <div class="seat_end_time input-group mb-3">
          <span class="input-group-text seat_now_input" id="seat_end_time"
            >結束時間</span
          >
          <input
            type="text"
            class="form-control"
            :value="selectedOrder.seat_order_enddate"
            aria-label="2023/07/30 PM08:00"
            aria-describedby="seat_end_time"
            disabled
          />
        </div>
      </div>
    </div>
    <div class="seats_now_map col-9">
      <section class="reservation_seat">
        <!-- <h2 class="reservation_text"><span>3</span> 選擇座位</h2> -->
        <div class="reservation_all_seat">
          <main class="tabs">
            <div class="tabs_list">
              <div class="seat_tabs_item" v-for="(item, key) in tabItems" :class="{ active: key == tabActive }"
                @click="updateTab(key)" :key="item.key">
                {{ item }}
              </div>
            </div>
            <div class="color_state_seat_group">
              <div class="color_vacancy_seat_group">
                <div class="color_G_vacancy_seat"></div>
                <p class="p_vacancy_seat">空位</p>
              </div>
              <div class="color_use_seat_group">
                <div class="color_G_use_seat"></div>
                <p class="p_use_seat">使用中</p>
              </div>
            </div>
            <div v-if="tabActive == 1" class="reservation_hall_seat">
              <div class="reservation_eSports_seat">
                <div class="eSports_seat_title">
                  <p>電競區</p>
                </div>
                <!-- `state-${item.state}`判定座位狀態 -->
                <button
                  v-for="item in seats_a"
                  :key="item.no"
                  :class="{
                    seat_btn: true,
                    eSports_seat: true,
                    [`state-${item.seat_status?.split('').slice(currentTime_hours, currentTime_hours+1).includes('1') ? 1 : 0}`]: true
                  }"
                  @click.prevent="seatSelected(item)"
                >
                  <div class="content">
                    <h4 class="text">
                      {{ item.seat_area }}
                      {{ item.seat_number }}
                    </h4>
                    <img class="chair" src="../../assets/images/seats/chair.svg" alt="" />
                  </div>
                </button>
              </div>
              <div class="reservation_general_seat">
                <div class="general_seat_title">
                  <p>一般區</p>
                </div>
                <!--狀態管理 class="`state-${item.state}`" -->
                <button
                  :class="{
                    seat_btn: true,
                    general_seat: true,
                    [`state-${item.seat_status?.split('').slice(currentTime_hours, currentTime_hours+1).includes('1') ? 1 : 0}`]: true
                  }"
                  v-for="item in seats_b"
                  :key="item.no"
                  @click.prevent="seatSelected(item)"
                >

                  <div class="content">
                    <h4>
                      {{ item.seat_area }}
                      {{ item.seat_number }}
                    </h4>
                    <img class="chair" src="../../assets/images/seats/chair.svg" alt="" />
                  </div>
                </button>
                <div class="counter">
                  <p>櫃台</p>
                </div>
              </div>
            </div>
            <div v-if="tabActive == 2" class="reservation_booth_seat">
              <div class="booth_seat_title">
                <div class="single_seat_title">
                  <p>單人包廂</p>
                </div>
                <div class="double_seat_title">
                  <p>雙人包廂</p>
                </div>
              </div>
              <!--狀態管理 :class="`state-${item.state}`" -->
              <div class="reservation_single_seat">
                <button
                  :class="{
                    seat_btn: true,
                    single_seat: true,
                    [`state-${item.seat_status?.split('').slice(currentTime_hours, currentTime_hours+1).includes('1') ? 1 : 0}`]: true
                  }"
                  v-for="item in seats_c"
                  :key="item.no"
                  @click.prevent="seatSelected(item)"
                >
                  <div class="content">
                    <h4>{{ item.seat_area }} {{ item.seat_number }}</h4>
                    <img class="chair" src="../../assets/images/seats/chair.svg" alt="" />
                  </div>
                </button>
              </div>
              <!-- 狀態管理:class="`state-${item.state}`" -->
              <div class="reservation_double_seat">
                <button
                  :class="{
                    seat_btn: true,
                    double_seat: true,
                    [`state-${item.seat_status?.split('').slice(currentTime_hours, currentTime_hours+1).includes('1') ? 1 : 0}`]: true
                  }"
                  v-for="item in seats_d"
                  :key="item.no"
                  @click.prevent="seatSelected(item)"
                >
                  <div class="content">
                    <h4>{{ item.seat_area }} {{ item.seat_number }}</h4>
                    <img class="chair" src="../../assets/images/seats/double_chair.svg" alt="" />
                    <!-- NOTE RWD手機板時只有顯示椅子圖，780px以上時跳轉成座位編號 -->
                  </div>
                </button>
              </div>
            </div>
          </main>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
// import Seat from "@/components/seats/Seat.vue";
import axios from "axios";
import { mapMutations, mapActions, mapGetters, mapState } from "vuex";
import { ref } from "vue";

export default {
  components: {},
  data() {
    return {
      siteNowStatus: [],
      seatOrder: [],
      selectedSeat: {},
      selectedOrder:[],
      isReserveSeatVisible: false,
      isReserveUserVisible: false,
      isSeatInputsDisabled: false,
      isUserInputsDisabled: false,
      title: "訂位預約",
      reservation: {
        startDate: "",
        startTime: "",
        endTime: "",
        startTimeNum: "",
        endTimeNum: ""
      },
      seats_a: [],
      seats_b: [],
      seats_c: [],
      seats_d: [],
      tabActive: 1,
      tabItems: {
        1: "大廳區",
        2: "包廂區"
      },
      currentTime: new Date().toLocaleString(),
      currentTime_hours: new Date().getHours(),
      timer: null,
    };
  },
  methods: {
    ...mapMutations(["toggleLogin", "toggleForgotPsw", "toggleRegister"]),

    // 切換tab
    updateTab(index) {
      this.tabActive = index;
    },

    fetchSeatData() {
      this.axios
        .get(`${this.$URL}/getSeatNowStatus.php`)
        .then((res) => {
          console.log(res);
          this.siteNowStatus = res.data;
          this.seats_a = this.siteNowStatus.filter(
            (item) => item.seat_id <= 30
          );
          this.seats_b = this.siteNowStatus.filter(
            (item) => 31 <= item.seat_id && item.seat_id <= 55
          );
          this.seats_c = this.siteNowStatus.filter(
            (item) => 56 <= item.seat_id && item.seat_id <= 65
          );
          this.seats_d = this.siteNowStatus.filter(
            (item) => 66 <= item.seat_id && item.seat_id <= 71
          );

          console.log("seats_a",this.seats_a)
          console.log("seats_b",this.seats_b)
          console.log("seats_c",this.seats_c)
          console.log("seats_d",this.seats_d)


        })
        .catch((err) => {
          console.log(err);
        });


    },
    seatSelected(item) {
      //1.撈取選擇的座位資料
      this.selectedSeat = item;
      console.log("selectedSeat",this.selectedSeat)
      //2.將座位及時間與訂單相對應資料比對找到目前此座位訂單

      const found = this.seatOrder.find((element) => {
        console.log('all', element)
        let includeCurrentTime = element.seat_order_startdate.substr(11, 2) < this.currentTime_hours && element.seat_order_enddate.substr(11, 2) > this.currentTime_hours ;
        let matchSeat = element.items.findIndex((item) => item.seat_id == this.selectedSeat.seat_id) !== -1;
        return matchSeat && includeCurrentTime;
      });
      
      console.log('found',found);
      //3.將訂單資料呈現到表格中
      if(found){
        this.selectedOrder = found;
      }else{
        this.selectedOrder = {};
      }
    }
    
  },
  computed: {
    ...mapState(["isLoginOpen", "forgotPsw", "login", "member"]),
    seatState() {
      if (this.selectedSeat.seat_status?.split('').slice(this.currentTime_hours, this.currentTime_hours+1).includes('1')) {
        return '使用中';
      }
      return '空位';
    }

  },
  mounted() {
    this.fetchSeatData();

    this.axios
      .get(`${this.$URL}/getSeatNowOrder.php`)
      .then((res) => {
        console.log(res);
        this.seatOrder = res.data;
      })
      .catch((err) => {
        console.log(err);
      });
      // let a=this.currentTime.substring(10,12)==='下午'?12:0;
      // let aa=this.currentTime.substring(12,14)
      // let b = +(aa.includes(':') ? aa.replace(':', '') : aa);
      // console.log("currentTime",this.currentTime)
      // console.log("a",a)
      // console.log("aa",aa)
      // console.log("b",b)
      // this.currentTime_hours=a+b;
      // console.log("currentTime_hours",this.currentTime_hours)


  },
  watch: {},
  created() {
    this.timer = setInterval(() => {
      this.currentTime = new Date().toLocaleString();
    }, 1000); // 每秒更新一次
  },
  beforeDestroy() {
    clearInterval(this.timer); // 清除計時器以避免記憶體洩漏
  }
};
</script>
