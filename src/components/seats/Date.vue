<template>
  <Space size="large" wrap class="reservation_date_time">
    <DatePicker
      size="large"
      type="date"
      placeholder="Select date"
      v-model="selectedDate"
      @mouseleave="convertDate"
    />
    <TimePicker
      size="large"
      type="timerange"
      :steps="[1, 60, 60]"
      placement="bottom-end"
      placeholder="Select time"
      style="width: 168px"
      v-model="selectedTime"
      @mouseleave="convertTime"
    />
  </Space>
</template>
<style>
.reservation_date_time {
  display: flex;
  flex-direction: column;
  flex-wrap: wrap;
  width: 100%;
  justify-content: flex-start;
  gap: 10px !important;
}
.ivu-space-center{
  align-items: baseline !important;
}
</style>
<script>
export default {
  data() {
    return {
      selectedDate: "",
      selectedTime: ""
    };
  },
  computed() {},
  methods: {
    convertDate() {
      this.$emit("convert-date", this.selectedDate);
    },
    convertTime() {
      this.$emit("convert-time", this.selectedTime);
    }
  }
};
</script>
