<template>
  <div class="seats_now_all row">
    <div class="seats_now_all_info col">
        <div class="seat_info">
          <div class="seat_info_title"><p>座位狀態</p></div>
          <div class="seat">大廳電競區A-05</div>
          <div class="seat_state input-group mb-3">
            <span class="input-group-text seat_now_input" id="seat_state">狀態</span>
            <input type="text" class="form-control" value="使用中" aria-label="使用中" aria-describedby="seat_state" disabled>
          </div>
          <div class="seat_user input-group mb-3">
            <span class="input-group-text seat_now_input" id="seat_user">使用者</span>
            <input type="text" class="form-control" value="王大明" aria-label="王大明" aria-describedby="seat_user" disabled>
          </div>
          <div class="seat_user_phone input-group mb-3">
            <span class="input-group-text seat_now_input" id="seat_user_phone">手機</span>
            <input type="text" class="form-control" value="0988123456" aria-label="0988123456" aria-describedby="seat_user_phone" disabled>
          </div>
          <div class="seat_start_time input-group mb-3">
            <span class="input-group-text seat_now_input" id="seat_start_time">開始時間</span>
            <input type="text" class="form-control" value="2023/07/30 PM02:00" aria-label="2023/07/30 PM02:00" aria-describedby="seat_start_time" disabled>
          </div>
          <div class="seat_end_time input-group mb-3">
            <span class="input-group-text seat_now_input" id="seat_end_time">結束時間</span>
            <input type="text" class="form-control" value="2023/07/30 PM08:00" aria-label="2023/07/30 PM08:00" aria-describedby="seat_end_time" disabled>
          </div>
        </div>
    </div>
    <div class="seats_now_map col-9"></div>
  </div>
</template>
<script>
export default {
  components: {},
  data() {
    return {};
  },
  methods: {}
};
</script>
