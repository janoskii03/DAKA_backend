<template>
    <div class="confirm_modal" v-show="showConfirmationModal">
        <h1>確定取書？</h1>
        <div class="confirm_buttons">
            <button @click="confirm">確定</button>
            <button @click="showConfirmationModal = false">取消</button>
        </div>
    </div>
</template>
<script>

export default{
  name:'modal',
  data(){
    return{

    }
  },
  methods:{

  },
  computed:{

  },
  components:{

  },
  mounted() {
    
  },
}
</script>