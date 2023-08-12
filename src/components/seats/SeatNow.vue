<template>
  <div class="seats_now_all row">
    <div class="seats_now_all_info col">
      <div class="seat_info">
        <div class="seat_info_title"><p>座位狀態</p></div>
        <div class="seat">大廳電競區A-05</div>
        <div class="seat_state input-group mb-3">
          <span class="input-group-text seat_now_input" id="seat_state"
            >狀態</span
          >
          <input
            type="text"
            class="form-control"
            value="使用中"
            aria-label="使用中"
            aria-describedby="seat_state"
            disabled
          />
        </div>
        <div class="seat_user input-group mb-3">
          <span class="input-group-text seat_now_input" id="seat_user"
            >使用者</span
          >
          <input
            type="text"
            class="form-control"
            value="王大明"
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
            value="0988123456"
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
            value="2023/07/30 PM02:00"
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
            value="2023/07/30 PM08:00"
            aria-label="2023/07/30 PM08:00"
            aria-describedby="seat_end_time"
            disabled
          />
        </div>
      </div>
    </div>
    <div class="seats_now_map col-9">
      <Seat></Seat>
    </div>
  </div>
</template>

<script>
import Date from "@/components/seats/Date.vue";
import Seat from "@/components/seats/Seat.vue";
import axios from "axios";
import { mapMutations, mapActions, mapGetters, mapState } from "vuex";

export default {
  components: {
    Date,
    Seat
  },
  data() {
    return {
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

    toggleReserveSeat() {
      this.isReserveSeatVisible = !this.isReserveSeatVisible;
      if (this.isReserveSeatVisible) {
        this.isSeatInputsDisabled = true;
      }
    },
    resetReserveSeat() {
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
