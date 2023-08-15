<template>
    <div class="login_container">

        <div class="login">
            <form action="" class="login_form">
                <p>帳號登入</p>
                <input type="text" placeholder="帳號" v-model="addId">
                <input type="password" placeholder="密碼" v-model="addPsw">
                <input type="submit" value="登入" @click.prevent="checkLogin" class="login_btn">
            </form>
        </div>

    </div>
</template>

<script>
import axios from 'axios';
import { mapMutations, mapActions, mapGetters, mapState } from "vuex";


export default {
    props: {
    },
    components: {

    },
    data() {
        return {
            addId: '',
            addPsw: '',
            responseData: [],

        }
    },
    computed: {
        ...mapState(["isLoginOpen", "forgotPsw", 'login', 'member', 'keepLoginStatus', 'userTokenKey', 'loginModal'])
    },
    methods: {
        ...mapMutations(["toggleLogin"]),
        checkLogin() {

            const loginData = {
                admin_no: this.addId,
                password: this.addPsw,
            };

            axios.post(`${this.$URL}/login.php`, JSON.stringify(loginData), {
                headers: {
                    'Content-Type': 'application/json',
                    withCredentials: true
                }
            })
                .then(response => {
                    this.responseData = response.data;

                    //登入成功
                    if (responseData.admin_no) {
                        this.setInfo(this.responseData);
                        this.loginOk(true);
                        setTimeout(() => {
                            this.toggleLoginModal(false);
                        }, 3000);
                    } else {
                        this.errorMsg = "帳號密碼錯誤"; // 登入失敗
                    }


                })
                .catch(error => {
                    console.log(error);
                });
        }
    },
    watch: {

    },


}

</script>

<style lang="scss" scoped>
.login_container {
    width: 100%;
    max-width: 1920px;
    height: 100%;
    top: 0;
    position: fixed;
    z-index: 999;
    background-color: rgba(68, 68, 68, 0.5);

    .login {
        width: 600px;
        height: 400px;
        position: fixed;
        left: 50%;
        top: 50%;
        z-index: 999;
        transform: translate(-50%, -50%);
        margin: auto;
        display: flex;
        background-color: #fff;
        flex-direction: column;

        .login_form {
            display: flex;
            justify-content: center;
            padding: 30px 0;
            margin: 15px;
            flex-direction: column;
            gap: 30px;
            margin: auto;
            width: 50%;

            p {
                font-size: 2rem;
            }


            input {

                width: 300px;
                font-size: 1.2rem;
                margin-bottom: 20px;
                padding: 10px;
            }

            .login_btn {
                padding: 10px 0;
                align-self: center;
                width: 100px;
            }


        }
    }



}
</style>

