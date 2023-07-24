<template>
    <div class="login_container">

        <div class="login">
            <form action="" class="login_form">
               <p>帳號登入</p>
                <input type="text" placeholder="帳號" v-model="account">
                <input type="text" placeholder="密碼" v-model="password">
                <input type="submit" value="登入" @click.prevent="login" class="login_btn">

            </form>
        </div>

    </div>
</template>

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
            
       p{
        font-size: 2rem;
       }

        
            input{

                width: 300px;
                font-size: 1.2rem;
                margin-bottom: 20px;
                padding: 10px;
            }
            .login_btn{
                padding: 10px 0;
                align-self: center;
                width: 100px;
            }

            
        }
    }



}
</style>
<script>
import axios from 'axios';
export default {
    props: {
    },
    components: {

    },
    data() {
        return {
            account: '',
            password: '',
            member: {}
        }
    },
    computed: {

    },
    methods: {
        login() {

            //抓後端資料比對
            // axios.get('https://fakestoreapi.com/products')
            //   .then((response) => { 
            //     this. member = response.data;
            //   })
            //   .catch((error) => { 
            //     console.error(error.message);
            //   })
            //   .finally(() => { 
            //     this.loading = false

            //   })
            // if (this.member.account === this.account && this.member.password === this.password) {
            //     this.$store.state.isLogging = true;
            // } else {
            //     this.account = this.password = '';
            // }
if((+this.account)===1111&&(+this.password===1111)){
    console.log(123);
    this.$store.state.isLogging=true;
    this.$router.push('/member')
}else{
    this.account=this.password='';
}
        }
    },
    watch: {

    },


}
</script>