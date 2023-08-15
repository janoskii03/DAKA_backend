<template>
  <div class="seats_reserve row">
    <div class="seats_reserve_info col">
      <div class="reserve_info">
        <div class="reserve_info_time">設定時間區間</div>
        <div class="reserve_time_choose">
          <Date
            @convert-date="dateConvert"
            @convert-time="timeConvert"
            :disabled="isSeatInputsDisabled"
          ></Date>
        </div>
        <div class="reserve_time input-group input-group-sm mb-2">
          <span class="input-group-text" id="reserve_time">總時數</span>
          <input
            type="text"
            class="form-control reserve_time_input"
            value="6"
            aria-label="6"
            aria-describedby="reserve_time"
            :disabled="isSeatInputsDisabled"
          />
          小時
        </div>
        <div class="reserve_time_search_buttons">
          <button
            class="reserve_time_search btn btn-sm"
            type="submit"
            @click="toggleReserveSeat"
            :disabled="isSeatInputsDisabled"
            v-if="!isReserveSeatVisible"
          >
            可使用座位搜尋
          </button>
          <div               @mouseover="showWarningMessage"
              @mouseleave="hideWarningMessage">
            <button
              class="reserve_time_search_reset btn btn-sm"
              type="submit"
              @click="resetReserveSeat"
              v-if="isReserveSeatVisible"
              :disabled="isUserInputsDisabled"

            >
              重新選擇日期
            </button>
          </div>
          <div
            v-if="isUserInputsDisabled && showWarning"
            class="warning-message"
          >
            取消座位選取才能更換日期
          </div>
        </div>

        <div v-if="isReserveSeatVisible" class="reserve_seat">
          <hr />
          <div class="reserve_seat_title">選擇座位</div>
          <div class="reserve_seat_hint">上限:大廳區5位+包廂區2間</div>
          <div class="reserve_seat_text" :disabled="isUserInputsDisabled">
            大廳電競區A10<br />
            大廳一般區B25<br />
            包廂單人房C02<br />
            包廂雙人房D07<br />
          </div>
          <div class="reserve_seat_search_buttons">
            <button
              class="reserve_seat_search btn btn-sm"
              type="submit"
              @click="toggleReserveUser"
              :disabled="isUserInputsDisabled"
              v-if="!isReserveUserVisible"
            >
              確認選擇座位
            </button>
            <button
              class="reserve_seat_search_reset btn btn-sm"
              type="submit"
              @click="resetReserveUser"
              v-if="isReserveUserVisible"
            >
              重新選擇座位
            </button>
          </div>
        </div>

        <div v-if="isReserveUserVisible" class="reserve_user">
          <hr />
          <div class="reserve_user_title">設定使用者</div>
          <div class="reserve_user_phone input-group input-group-sm mb-2">
            <span class="input-group-text" id="reserve_user_phone">電話</span>
            <input
              type="text"
              class="form-control"
              value="輸入電話搜尋會員"
              aria-label=""
              aria-describedby="reserve_user_phone"
              disabled
            />
            <button
              class="reserve_user_phone_search btn btn-outline-secondary"
              type="button"
              id="button-addon2"
            >
              搜尋
            </button>
          </div>
          <div class="reserve_user_name input-group input-group-sm mb-2">
            <span class="input-group-text" id="reserve_user">姓名</span>
            <input
              type="text"
              class="form-control reserve_time_input"
              value="王大明"
              aria-label=""
              aria-describedby="reserve_user"
              disabled
            />
          </div>
          <div class="reserve_use_sum input-group input-group-sm mb-2">
            <span class="input-group-text" id="reserve_use_sum"
              >本次預約金額</span
            >
            <input
              type="text"
              class="form-control reserve_time_input"
              value="1320"
              aria-label=""
              aria-describedby="reserve_use_sum"
              disabled
            />
          </div>
          <div class="reserve_use_stored_value input-group input-group-sm mb-2">
            <span class="input-group-text" id="reserve_use_stored_value"
              >使用者儲值金</span
            >
            <input
              type="text"
              class="form-control reserve_time_input"
              value="2000"
              aria-label=""
              aria-describedby="reserve_use_stored_value"
              disabled
            />
          </div>
          <button class="reserve_user_search btn btn-sm" type="submit">
            儲存設定
          </button>
        </div>
      </div>
    </div>
    <div class="seats_reserve_map col-9">
      <section class="reservation_seat">
<!-- <h2 class="reservation_text"><span>3</span> 選擇座位</h2> -->
<div class="reservation_all_seat">
 <main class="tabs">
   <div class="tabs_list">
     <div
       class="seat_tabs_item"
       v-for="(item, key) in tabItems"
       :class="{ active: key == tabActive }"
       @click="updateTab(key)"
       :key="item.key"
     >
       {{ item }}
     </div>
   </div>
   <div class="color_state_seat_group">
     <div class="color_vacancy_seat_group">
       <div class="color_G_vacancy_seat"></div>
       <p class="p_vacancy_seat">可預約</p>
     </div>
     <div class="color_use_seat_group">
       <div class="color_G_use_seat"></div>
       <p class="p_use_seat">不可預約</p>
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
           selected: selectedSeats.some(
             (seat) => seat.seat_id === item.seat_id
           )
         }"
         @click.prevent="seatSelected(item)"
       >
         <div class="content">
           <h4 class="text">
             {{ item.seat_area }}
             {{ item.seat_no }}
           </h4>
           <img
             class="chair"
             src="../../assets/images/seats/chair.svg"
             alt=""
           />
           <!-- NOTE RWD手機板時只有顯示椅子圖，780px以上時跳轉成座位編號 -->
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
           selected: selectedSeats.some(
             (seat) => seat.seat_id === item.seat_id
           )
         }"
         v-for="item in seats_b"
         :key="item.no"
         @click.prevent="seatSelected(item)"
       >
         <div class="content">
           <h4>
             {{ item.seat_area }}
             {{ item.seat_no }}
           </h4>
           <img
             class="chair"
             src="../../assets/images/seats/chair.svg"
             alt=""
           />
           <!-- NOTE RWD手機板時只有顯示椅子圖，780px以上時跳轉成座位編號 -->
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
           selected: selectedSeats.some(
             (seat) => seat.seat_id === item.seat_id
           )
         }"
         v-for="item in seats_c"
         :key="item.no"
         @click.prevent="seatSelected(item)"
       >
         <div class="content">
           <h4>{{ item.seat_area }} {{ item.seat_no }}</h4>
           <img
             class="chair"
             src="../../assets/images/seats/chair.svg"
             alt=""
           />
           <!-- NOTE RWD手機板時只有顯示椅子圖，780px以上時跳轉成座位編號 -->
         </div>
       </button>
     </div>
     <!-- 狀態管理:class="`state-${item.state}`" -->
     <div class="reservation_double_seat">
       <button
         :class="{
           seat_btn: true,
           double_seat: true,
           selected: selectedSeats.some(
             (seat) => seat.seat_id === item.seat_id
           )
         }"
         v-for="item in seats_d"
         :key="item.no"
         @click.prevent="seatSelected(item)"
       >
         <div class="content">
           <h4>{{ item.seat_area }} {{ item.seat_no }}</h4>
           <img
             class="chair"
             src="../../assets/images/seats/double_chair.svg"
             alt=""
           />
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
import Date from "@/components/seats/Date.vue";
// import Seat from "@/components/seats/Seat.vue";
import axios from "axios";
import { mapMutations, mapActions, mapGetters, mapState } from "vuex";

export default {
  components: {
    Date,
  },
  data() {
    return {
      showWarning: false,
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
      selectedArea: "",
      selectedAreaWord: "",
      selectedSeats: [],
      seatData: [],
      modalSwitch: false,
      id: "",
      area: "",
      no: "",
      sal: "",
      totalSal: [],
      totalTime: 0,
      seatLobby: [],
      seatRoom: [],
      isSelected: false,
      maxAandB: 5,
      maxCandD: 2
    };
  },
  methods: {
    ...mapMutations(["toggleLogin", "toggleForgotPsw", "toggleRegister"]),

    showWarningMessage() {
      console.log('aaa')
      if (this.isUserInputsDisabled) {
        this.showWarning = true;
      }
    },
    hideWarningMessage() {
      this.showWarning = false;
    },

    toggleReserveSeat() {
      this.isReserveSeatVisible = !this.isReserveSeatVisible;
      if (this.isReserveSeatVisible) {
        this.isSeatInputsDisabled = true;
      }
    },
    resetReserveSeat() {
      console.log('bbbb')
      this.isReserveSeatVisible = false;
      this.isSeatInputsDisabled = false;
    },
    toggleReserveUser() {
      this.isReserveUserVisible = !this.isReserveUserVisible;
      if (this.isReserveUserVisible) {
        this.isUserInputsDisabled = true;
      }
    },
    resetReserveUser() {
      this.isReserveUserVisible = false;
      this.isUserInputsDisabled = false;
    },

    // 切換tab
    updateTab(index) {
      this.tabActive = index;
    },
    //轉換日期
    dateConvert(date) {
      this.reservation.startDate = date.toString().substr(4, 11);
    },
    //轉換時間
    timeConvert(time) {
      this.reservation.startTime = time.toString().substr(0, 5);
      this.reservation.endTime = time.toString().substr(9, 5);
      this.reservation.startTimeNum = time.toString().substr(0, 2);
      this.reservation.endTimeNum = time.toString().substr(9, 2);
    },

    seatSelected(item) {
      // let { seat_id, seat_area, seat_no, seat_sal } = item;

      this.totalTime =
        +this.reservation.endTimeNum - this.reservation.startTimeNum;
      // this.id = seat_id;
      // this.area = seat_area;
      // this.no = seat_no;
      // this.sal = seat_sal;

      const selectedAandB = this.selectedSeats.filter(
        (seat) => seat.seat_area === "A" || seat.seat_area === "B"
      );
      const selectedCandD = this.selectedSeats.filter(
        (seat) => seat.seat_area === "C" || seat.seat_area === "D"
      );
      const indexA = selectedAandB[0];
      const indexC = selectedCandD[0];
      //點一下選，再點一下取消

      if (this.selectedSeats.length < 7) {
        if (this.selectedSeats.includes(item)) {
          this.deselectSeat(item);
        } else {
          if (
            (item.seat_area === "A" || item.seat_area === "B") &&
            selectedAandB.length >= this.maxAandB
          ) {
            this.selectedSeats.splice(indexA, 1);
          } else if (
            (item.seat_area === "C" || item.seat_area === "D") &&
            selectedCandD.length >= this.maxCandD
          ) {
            this.selectedSeats.splice(indexC, 1);
          }
          this.selectSeat(item);
        }

        this.totalSal = this.selectedSeats.reduce(
          (total, seat) => total + seat.seat_sal * this.totalTime,
          0
        );
      }
    },
    selectSeat(item) {
      this.selectedSeats.push(item);
    },

    deselectSeat(item) {
      //原本選到的座位刪除
      const index = this.selectedSeats.findIndex(
        (seat) => seat.seat_id === item.seat_id
      );
      if (index !== -1) {
        this.selectedSeats.splice(index, 1);
      }
    },
    confirmReserve() {
      this.modalSwitch = true;
    },

    fetchSeatData() {
      axios
        .get("data/seat.json")
        .then((res) => {
          this.seatData = res.data;
          this.seats_a = this.seatData.filter((item) => item.seat_id <= 30);
          this.seats_b = this.seatData.filter(
            (item) => 31 <= item.seat_id && item.seat_id <= 55
          );
          this.seats_c = this.seatData.filter(
            (item) => 56 <= item.seat_id && item.seat_id <= 65
          );
          this.seats_d = this.seatData.filter(
            (item) => 66 <= item.seat_id && item.seat_id <= 71
          );
        })
        .catch((err) => {
          console.log(err);
        });
    },
    checkLogin() {
      if (!this.login) {
        this.toggleLogin();
      } else {
        return;
      }
    },
    goReservation() {
      this.$router.push("/member_center/member_seat_reservation");
      this.modalSwitch = false;
    }
  },
  computed: {
    ...mapState([
      "isLoginOpen",
      "forgotPsw",
      "login",
      "member",
      "keepLoginStatus",
      "userTokenKey"
    ]),
    // isSelected() {
    //   return this.seat_b.includes(this.seatNumber);
    // },
    convertWord() {
      return this.selectedSeat;
    }
  },
  watch: {},
  created() {
    this.fetchSeatData();
  }
};
</script>