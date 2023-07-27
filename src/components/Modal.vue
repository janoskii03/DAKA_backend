<template>
    <div class="member_modal">
        <div class="member_modal_top">
            <p>黃金會員_黃曉明</p>
            <img src="@/assets/images/member/close.svg" alt="">
        </div>
        <div class="member_modal_value">
            <p>儲值金:5600元</p>
            <p>當年度累積消費金額 : 3670元</p>
        </div>
        <div class="modal_inner">
            <div class="modal_memberinfo">
                <h5>
                    會員資料

                </h5>
<div class="memberinfo_name">
    <label for="">姓名</label>
    <input type="text" placeholder="王大明" readonly>
    <label for="">電話</label>
    <input type="number" placeholder="0988-358888" readonly>
</div>
<div class="memberinfo_password">
    <label for="">密碼</label>
    <input type="text" placeholder="123456789" readonly>
    <label for="">生日</label>
    <input type="number" placeholder="2001-1-1" readonly>
</div>
<label for="">生日</label>
    <input type="number" placeholder="2001-1-1" readonly>

            </div>
            <div class="modal_memberinfo">
                <h5>

                    會員儲值金
                </h5>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.member_modal {
    width: 561px;
    height: 398px;
    background-color: rgba(207, 212, 217, 1);
}
</style>
<script>
export default {
    props: {
    },
    components: {

    },
    data() {
        return {

        }
    },
    computed: {

    },
    methods: {

    },
    watch: {

    },


}

</script>